<?php

namespace App\Http\Controllers;

use App\Conciliacion;
use App\ConciliacionEstado;
use App\ConciliacionPdfTemporal;
use App\ConciliacionReporte;
use App\Mail\Firma;
use App\PdfReporte;
use App\User;
use App\PdfReporteDestino;
use App\Traits\PdfReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConciliacionesReportesController extends Controller
{
 use PdfReport;

   
    public function getPdfReportesConciliacion(Request $request){
        $reportes = PdfReporteDestino::with('reporte')
    //    ->with('users')
        ->where($request->except(['_','conciliacion_id']))->get();
        
       $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view('myforms.conciliaciones.componentes.pdf_report_list',compact('reportes','conciliacion'))->render();
        $response = [
            'data'=>$reportes,
            'view'=> $view
        ];
        return response()->json($response);
    }
    public function getFirmantes(Request $request){
        $reporte_de = PdfReporteDestino::find($request->id);
        $reporte_de->reporte;
        $ids = [] ;
        $tipos = [];
        $tipos_estados = [];
        $all_firmas = true;
        foreach ($reporte_de->users as $key => $user) {
           $ids[] = $user->id;
           $tipos[$user->id] =  $user->pivot->tipo_usuario_id;
           $tipos_estados[$user->id] =  $user->pivot->firmado;
            if($user->pivot->tipo_usuario_id == 209 and $user->pivot->firmado == 0) $all_firmas = false;
        }
        //return response()->json($estados);
        $conciliacion = Conciliacion::find($request->conciliacion_id);
       // dd(array_key_exists(11220, $estados));

        $view = view('myforms.conciliaciones.componentes.pdf_report_list_firmantes',
        compact('ids','reporte_de','conciliacion','tipos','tipos_estados','all_firmas'))->render();
        
      


        $response = [
            'data'=>$reporte_de,
            'view'=> $view,
            'tipos'=> $tipos,
            'tipos_estados'=>$tipos_estados,
            'all_firmas'=>$all_firmas
        ];
        return response()->json($response);
    }
    function reenviarMails(Request $request){
        $users = DB::table("pdf_reportes_users")
        ->whereIn('user_id',$request->email_user_id)
        ->where(['conciliacion_id'=>$request->conciliacion_id,
                'pdf_reporte_id'=>$request->estado_id
        ])->get();
        foreach ($users as $key => $us) {
            $user = User::find($us->user_id);
            $user->token = $us->token;
            $user->codigo = $us->codigo;
            Mail::to($user)->send(new Firma($user));
            return response()->json($user);
        }
        return response()->json($users);
    }

    function setFirmantes(Request $request){
       
        //return response()->json($request->all());
        $pdf_rpd = PdfReporteDestino::find($request->estado_id);
        if($request->delete_users_id){
            $query = DB::table("pdf_reportes_users")
            ->whereIn('user_id',$request->delete_users_id)
            ->where(['conciliacion_id'=>$request->conciliacion_id,
            'pdf_reporte_id'=>$request->estado_id,
           ])->delete();
        }
        
    if($request->user_id){
        foreach ($request->user_id as $key => $id) {
            $user = DB::table("pdf_reportes_users")
            ->where('user_id',$id)
            ->where(['conciliacion_id'=>$request->conciliacion_id,
                    'pdf_reporte_id'=>$request->estado_id
            ])->first();

            if ( !$user ) {          
                $token = str_replace ('/', '', bcrypt(time())); ;
                $codigo = Str::random(5);
                $user =  $pdf_rpd->users()->attach($id,[
                    'tipo_usuario_id'=>$request->tipo_firmante[$key],
                    'tipo_firma_id'=>$request->tipo_firmante[$key],
                    'conciliacion_id'=>$request->conciliacion_id,
                    'token'=>$token,
                    'codigo'=>$codigo
                ]);
                if($request->has("user_email_id") and in_array($id,$request->user_email_id)){                   
                    $user = User::find($id);
                    $user->token = $token;
                    $user->codigo = $codigo;
                    Mail::to($user)->send(new Firma($user));
                }
      
           
            }else{
                //return response()->json($user);
                if($user->tipo_usuario_id != $request->tipo_firmante[$key] and $request->tipo_firmante[$key] == 209 ){
                    $us = User::find($id);
                    $us->token = $user->token;
                    $us->codigo = $user->codigo;
                    Mail::to($us)->send(new Firma($us));
                }
                $user =  $pdf_rpd->users()->updateExistingPivot($id,[
                    'tipo_usuario_id'=>$request->tipo_firmante[$key],
                    'conciliacion_id'=>$request->conciliacion_id ,
                                 
                ]);

               return response()->json($user);
            }

         
            
        }
    }
        
        
        return response()->json($request->all());
    }
    public function create(){
        $conciliaciones = Conciliacion::all();
        $reportes = PdfReporte::all();
        return view('myforms.conciliaciones.reportes.edit',compact('conciliaciones','reportes'));
        //return view('myforms.conciliaciones.reportes.edit');
    }
    public function store(Request $request){
    //    return response()->json($request->all());
        //$request['pdf_reporte_id']=$request->id;
        $config = $this->setConfig($request);
        $request['configuraciones'] = json_encode($config);
        $co_reporte = PdfReporte::create($request->except(['tipo_papel','is_temp']));
        $co_pdf = ConciliacionPdfTemporal::create([
            'reporte_pdf_id'=>$co_reporte->id,
            'status_id'=>$request->status_id,
            'parent_reporte_pdf_id'=>$request->id,
            'conciliacion_id'=>$request->conciliacion_id
        ]);
        $reporte_ant = PdfReporte::find($request->id);
        if($request->file('encabezado_file')!=''){  
            $configuracion = json_encode($this->setEncaConfig($request)); 
            //$request['configuraciones'] = json_encode($configuracion);     
            $file = $co_reporte->uploadFile($request->file('encabezado_file'),'/pdf_reportes_'.$co_reporte->id);
            $co_reporte->files()->attach($file,[
                'seccion'=>'encabezado' ,
                'configuracion'=>$configuracion          
                ]);                    
		}else{
           
            $file_en = $reporte_ant->files()->where('seccion','encabezado')->first();
            $co_reporte->files()->attach($file_en,[
                'seccion'=>'encabezado' ,
                'configuracion'=>$file_en->pivot->configuracion          
                ]);
        }
        if($request->file('pie_file')!=''){     
            $configuracion = json_encode($this->setPieConfig($request));        
            $file = $co_reporte->uploadFile($request->file('pie_file'),'/pdf_reportes_'.$co_reporte->id);
            $co_reporte->files()->attach($file,[
                'seccion'=>'pie',
                'configuracion'=>$configuracion                  
                ]);                   
		}else{
            $file_pie = $reporte_ant->files()->where('seccion','pie')->first();
            $co_reporte->files()->attach($file_pie,[
                'seccion'=>'pie' ,
                'configuracion'=>$file_pie->pivot->configuracion          
                ]);
        }

        return response()->json($co_reporte);
    }

    public function update(Request $request,$id){
        //return response()->json($request->all());
        $config = $this->setConfig($request);
        $request['configuraciones'] = json_encode($config);
        $co_reporte = PdfReporte::find($id);
        $co_reporte->fill($request->all());
        $co_reporte->save();
        $file_en = $co_reporte->files()->where('seccion','encabezado')->first();
       
        if($file_en){
            $configuracion = json_encode($this->setEncaConfig($request));
            $file_en->pivot->configuracion =  $configuracion ;
            $file_en->pivot->save();
        }        
        if($request->file('encabezado_file')!=''){          
           if($file_en and $file_en->path!=''){
            Storage::delete("public/".$file_en->path);
            }
        $file = $file_en->delete();                            
            $file = $co_reporte->uploadFile($request->file('encabezado_file'),'/pdf_reportes_'.$co_reporte->id);
            $co_reporte->files()->attach($file,[
                'seccion'=>'encabezado',
                'configuracion'=>$configuracion          
                ]);                    
		}
        $file_pie = $co_reporte->files()->where('seccion','pie')->first();
        
        if($file_pie){
            $configuracion = json_encode($this->setPieConfig($request));
            $file_pie->pivot->configuracion =  $configuracion ;
            $file_pie->pivot->save();
        }   
          
        if($request->file('pie_file')!=''){              
            if($file_pie and $file_pie->path!=''){
             Storage::delete("public/".$file_pie->path);                  
         }
         $file = $file_pie->delete();                  
            $file = $co_reporte->uploadFile($request->file('pie_file'),'/pdf_reportes_'.$co_reporte->id);
            $co_reporte->files()->attach($file,[
                'seccion'=>'pie',
                'configuracion'=>$configuracion                  
                ]);                   
		}
        return response()->json($co_reporte);
    }

    public function destroy($id){
      // return $id;
    $pdf_temp = ConciliacionPdfTemporal::where(['reporte_pdf_id'=>$id])->first();
    $co_reporte = PdfReporte::find($id);     
        if(!$pdf_temp){
            $file_en = $co_reporte->files()->where('seccion','encabezado')->first();
            if($file_en and $file_en->path!=''){
                Storage::delete("public/".$file_en->path);        }
            $file_pie = $co_reporte->files()->where('seccion','pie')->first();
            if($file_pie and $file_pie->path!=''){
                Storage::delete("public/".$file_pie->path);                  
            }
        }
        $co_reporte->delete();       
        return response()->json($co_reporte);
    }

    public function editReporteTemporal($id,$conciliacion,$estado){
       // dd($id);
        $pdf_temp = ConciliacionPdfTemporal::where([
            'conciliacion_id'=>$conciliacion,'status_id'=>$estado,
            'parent_reporte_pdf_id'=>$id
        ])->first();
        if($pdf_temp){
            $reporte =  $pdf_temp->reporte_child;
            $reporte->is_temp = true;
        }else{
            $reporte = PdfReporte::find($id); 
        }
        
        $conciliacion = Conciliacion::find($conciliacion);
        $ocultar_menu = true;
        return view('myforms.conciliaciones.reportes.edit_temporal',compact('reporte','ocultar_menu','conciliacion','estado'));
    }

    public function getAllPdf(Request $request){
        // 
           $conciliacion = Conciliacion::find($request->conciliacion_id);
           $conciliacion->estados->each(function($estado){
            $estado->files;
           });


          // dd($conciliacion->estados);
         //$ocultar_menu = true;
         return response()->json($conciliacion);
     }
}
