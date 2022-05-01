<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conciliacion;
use App\Turno;
use DB;
use App\File;
use App\TablaReferencia;
use App\User;
use App\ConciliationAditionalStaticData;
use App\ReferencesStaticData;
use App\ConciliacionComentario;
use App\ConciliacionEstado;
use App\ConciliacionPdfTemporal;
use App\ConciliacionReporte;
use App\AudienciaConciliacion;
use App\PdfReporte;
use App\PdfReporteDestino;
use App\Periodo;
use App\Traits\PdfReport as TraitPdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\DB as FacadesDB;
use PDF;
use Str;
use Storage;
use App\SalasAlternasConciliacion;
use Carbon\Carbon;

class ConciliacionesController extends Controller
{
    use TraitPdf;
    public function __construct()
    {
      $this->middleware('permission:ver_conciliaciones',   ['only' => ['index']]);
     // $this->middleware('permission:sustituir_casos',   ['only' => ['replacecaso']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $conciliaciones = Conciliacion::orderBy('created_at','desc')->paginate(10);
       // $reporte = ConciliacionReporte::find(5);
        return view('myforms.conciliaciones.index',compact('conciliaciones'));
    }

    public function audiencias(Request $request)
    {
        $conciliaciones = Conciliacion::orderBy(DB::raw("FIELD(estado_id,'182')"),'desc')->paginate(10);
        return view('myforms.conciliaciones.audiencias',compact('conciliaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periodo = Periodo::where('estado','1')->first();
        $conciliacion = Conciliacion::create([
            'fecha_radicado'=>date('Y-m-d'),
            'num_conciliacion'=>"0000-00",
            'categoria_id'=>175,
            'estado_id'=>177,
            'periodo_id'=> $periodo->id,
            'user_id'=>auth()->user()->id
        ]);

        $conciliacion->usuarios()->attach(auth()->user()->id,[
            'tipo_usuario_id'=>183
        ]);

        return redirect('/conciliaciones/'.$conciliacion->id.'/edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {


    //---------------------------------------

    $cursando = TablaReferencia::where(['categoria'=>'cursando','tabla_ref'=>'turnos'])->pluck('ref_nombre','id');
    
    $estudiantes = $this->getEstudiantes();
        $turnos = Turno::join('users','users.idnumber','=','turnos.trnid_estudent')
        ->join('sede_usuarios','sede_usuarios.user_id','=','users.id')
        ->join('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
        ->join('referencias_tablas as rc','rc.id','=','turnos.trnid_color')
        ->join('referencias_tablas as rh','rh.id','=','turnos.trnid_horario')
        ->join('referencias_tablas as cursos','cursos.id','=','users.cursando_id')
        ->join('referencias_tablas as rd','rd.id','=','turnos.trnid_dia')
        ->where('sedes.id_sede',session('sede')->id_sede)
        ->select("turnos.id as id",'users.idnumber','users.cursando_id','users.id as estudiante_id','users.name','users.lastname',
        'trnid_color','rc.ref_value as color_ref_value','rc.ref_nombre as color_nombre','cursos.id as curso_id',
        'cursos.ref_nombre as curso_nombre','rh.ref_nombre as horario_nombre','trnid_horario','rd.ref_nombre as dia_nombre','trnid_dia')
        ->orderBy('trnid_color','asc')->get();

    		/*SELECT SUM(if(trnid_color = '105', 1, 0)) AS amarillo, SUM(if(trnid_color = '106', 1, 0)) AS Azul, SUM(if(trnid_color = '107', 1, 0)) AS verde, SUM(if(trnid_color = '108', 1, 0)) AS gris, SUM(if(trnid_color = '108', 1, 0)) AS rojo FROM users, turnos WHERE trnid_estudent`=idnumber` AND `cursando_id`='116'*/

//dd($colores[0]->amarillo);
//dd($estudiantes);



    //-------------------------------------


    $conciliacion = Conciliacion::find($id);

    

    if($conciliacion->estado_id==179){
        $estado = $conciliacion->estados()->where('type_status_id',$conciliacion->estado_id)->orderBy("created_at","desc")->first();
        $today =   Carbon::now();     
        $estadoFecha = Carbon::parse($estado->created_at);    
        $diferencia = $today->diffInDays($estadoFecha);
        //dd($diferencia)  ;
        if($diferencia>5){
            $pdfs =  PdfReporteDestino::with('reporte')->where('status_id',182)            
             ->get(); 
            $estado = ConciliacionEstado::create([
                "concepto"=>"Dias vencidos",
                "type_status_id"=>182,
                "user_id"=>auth()->user()->id,
                "conciliacion_id"=>$conciliacion->id,
            ]);
            $conciliacion->estado_id = 182;
            $conciliacion->save();
            if(count($pdfs)>1000000){                   
                foreach ($pdfs as $key_1 => $pdf_repor) {
                    //obtengo el pdf temporal
                    $reporte_t = ConciliacionPdfTemporal::where('parent_reporte_pdf_id',$pdf_repor->reporte_id)->first();
                   //dd($reporte_t);
                    if($reporte_t){  
                        $reporte =     $reporte_t->reporte_child;          
                        $bodytag = $this->getBody($reporte->report_keys,$reporte->reporte,$conciliacion);
                        $reporte->delete();
                        $name = $reporte->nombre_reporte;
                        $config = json_decode($reporte->configuraciones); 
                    }else{                            
                        $bodytag = $this->getBody($pdf_repor->reporte->report_keys,$pdf_repor->reporte->reporte,$conciliacion);
                        $name = $pdf_repor->reporte->nombre_reporte;
                        $config = json_decode($pdf_repor->reporte->configuraciones); 
                    }
                    if($pdf_repor){
                        $file_pie = $pdf_repor->reporte->files()->where('seccion','pie')->first();
                        $pie_conf = $file_pie != null ? json_decode($file_pie->pivot->configuracion) : null;          
                        $file_enc = $pdf_repor->reporte->files()->where('seccion','encabezado')->first();
                        $encab_conf = $file_enc != null ? json_decode($file_enc->pivot->configuracion) : null;      
                    }
                  $pdf = PDF::loadView('pdf.conciliacion', 
                        [
                        'is_preview'=>false,
                        'pdf'=> $bodytag,
                        'margin'=>$config->margin_string, 
                        'pie'=>$file_pie, 
                        'pie_conf'=>$pie_conf,
                        'encabezado'=>$file_enc,
                        'encab_conf'=>$encab_conf
                        ])
                    ->setPaper($config->tipo_papel);
                    $path = storage_path('app/conciliaciones_pdf');        
                    $fileName =  time().'_'.md5($name).'.'. 'pdf' ;
                    $pdf->save($path . '/' . $fileName);
                    $path =   'app/conciliaciones_pdf';  
                    $file = new \App\File();
                    $file->original_name = $name ;   
                    $file->encrypt_name = $fileName;  
                    $file->path = $path . '/' . $fileName; 
                    $file->size = '0000';             
                    $file->save();
                    $estado->files()->attach($file,[
                        'conciliacion_id'=>$conciliacion->id
                    ]);
                }
            }
        }
    }
  
    $numusers=$conciliacion->usuarios->count();
    $audiencia = AudienciaConciliacion::where('id_conciliacion',$conciliacion->id)->first();
    $salaalterna = SalasAlternasConciliacion::where(['idnumber'=>\Auth::user()->idnumber,"id_conciliacion"=>$conciliacion->id])->first();
    $sala_alterna_url = "";
    if ($salaalterna) {
        $sala_alterna_url=$request->root()."/audiencia"."/salaalaterna"."/".$salaalterna->token_access;
    }
        if (!$audiencia) {  //si no existe lo crea
            $audiencia="";
        }
       return  view('myforms.conciliaciones.edit',[
        'cursando'=>$cursando,
        'turnos'=>$turnos,
        'estudiantes'=>$estudiantes,
        'conciliacion'=>$conciliacion,
        'cont'=>'1',
        'audiencia'=>$audiencia,
        'numusers'=>$numusers,
        'sala_alterna_url'=>$sala_alterna_url]);


       // return view('myforms.conciliaciones.edit',compact('conciliacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
     



    public function insertEstado(Request $request){
       // return response()->json($request->all());
       $request['user_id'] = \Auth::user()->id;       
       $estado = ConciliacionEstado::create($request->all());
       $conciliacion = Conciliacion::find($request->conciliacion_id);
       $conciliacion->estado_id = $request->type_status_id;
       if($request->type_status_id == 180 )  $conciliacion->auto_admisorio = intval($conciliacion->auto_admisorio)+1;
        if($request->type_status_id == 178 ){
            $periodo = Periodo::where('estado','1')->first();      
            $year = Date('Y');
            $month = Date('m');       
            $con_ul = Conciliacion::where('periodo_id',$periodo->id)
            ->where('num_conciliacion','<>','0000-00')
            ->orderBy('created_at','desc')->first();
           
            if($con_ul==null){
                $id_num ='01';
            }else{
                $id_num =  explode('-',$con_ul->num_conciliacion)[1] + 1;
                if($id_num<10)  $id_num =  '0'.$id_num;
            }
           // dd($id_num);
            if($conciliacion->num_conciliacion=='0000-00')$conciliacion->num_conciliacion = $year."".$month."-".$id_num;
            if($conciliacion->fecha_radicado=='0000-00-00')$conciliacion->fecha_radicado = date('Y-m-d');
        }
       $conciliacion->save();   
       if($request->rpdf_id == 'no aplica'){          
        $pdfs =  PdfReporteDestino::with('reporte')->where('status_id',$request->type_status_id)
        ->whereIn('reporte_id',$request->rpdf_id)
        ->get();       
        foreach ($pdfs as $key_1 => $pdf_repor) {
            //obtengo el pdf temporal
            $reporte_t = ConciliacionPdfTemporal::where('parent_reporte_pdf_id',$pdf_repor->reporte_id)
            ->first();
           //dd($reporte_t);
            if($reporte_t){  
                $reporte =     $reporte_t->reporte_child;          
                $bodytag = $this->getBody($reporte->report_keys,$reporte->reporte,$conciliacion);
                $reporte->delete();
                $name = $reporte->nombre_reporte;
                $config = json_decode($reporte->configuraciones); 
            }else{                            
                $bodytag = $this->getBody($pdf_repor->reporte->report_keys,$pdf_repor->reporte->reporte,$conciliacion);
                $name = $pdf_repor->reporte->nombre_reporte;
                $config = json_decode($pdf_repor->reporte->configuraciones); 
            }
            if($pdf_repor){
                $file_pie = $pdf_repor->reporte->files()->where('seccion','pie')->first();
                $pie_conf = $file_pie != null ? json_decode($file_pie->pivot->configuracion) : null;          
                $file_enc = $pdf_repor->reporte->files()->where('seccion','encabezado')->first();
                $encab_conf = $file_enc != null ? json_decode($file_enc->pivot->configuracion) : null;      
            }
          $pdf = PDF::loadView('pdf.conciliacion', 
                [
                    'is_preview'=>false,
                    'pdf'=> $bodytag,
                    'margin'=>$config->margin_string,
                    'pie'=>$file_pie, 
                    'pie_conf'=>$pie_conf,
                    'encabezado'=>$file_enc,
                    'encab_conf'=>$encab_conf
                ])
            ->setPaper($config->tipo_papel);
            $path = storage_path('app/conciliaciones_pdf');        
            $fileName =  time().'_'.md5($name).'.'. 'pdf' ;
            $pdf->save($path . '/' . $fileName);
            $path =   'app/conciliaciones_pdf';  
            $file = new \App\File();
            $file->original_name = $name ;   
            $file->encrypt_name = $fileName;  
            $file->path = $path . '/' . $fileName; 
            $file->size = '0000';             
            $file->save();
            $estado->files()->attach($file,[
                'conciliacion_id'=>$conciliacion->id
            ]);
        }
     }
    if($request->has("status_file")){
        $file = $estado->uploadFile($request->file('status_file'),'/concilacion_'.$conciliacion->id.'/status_'.$estado->id);
        $estado->files()->attach($file,['conciliacion_id'=>$conciliacion->id]);   

    }
        $view = view('myforms.conciliaciones.componentes.conciliacion_estados_ajax',compact('conciliacion'))->render();
        return response()->json([
            'view'=>$view
        ]);
        return response()->json($request->all());
    }


    public function insertComentario(Request $request){
        $request['user_id'] = \Auth::user()->id;       
        $comentario = ConciliacionComentario::create($request->all());
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view('myforms.conciliaciones.componentes.solicitud_comentarios_ajax',compact('conciliacion'))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

    public function deleteComentario(Request $request){
       
        $comentario = ConciliacionComentario::find($request->comentario_id)->delete();
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view('myforms.conciliaciones.componentes.solicitud_comentarios_ajax',compact('conciliacion'))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

    public function deleteEstado(Request $request){       
        $comentario = ConciliacionEstado::find($request->estado_id)->delete();
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view('myforms.conciliaciones.componentes.solicitud_estados_ajax',compact('conciliacion'))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

    public function editComentario(Request $request){       
        $comentario = ConciliacionComentario::find($request->comentario_id);
        return response()->json($comentario);
    }

    public function editEstado(Request $request){       
        $estado = ConciliacionEstado::find($request->estado_id);
        return response()->json($estado);
    }

    public function updateComentario(Request $request){
          
        $comentario = ConciliacionComentario::find($request->comentario_id);
        $comentario->fill($request->all());
        $comentario->save();
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view('myforms.conciliaciones.componentes.solicitud_comentarios_ajax',compact('conciliacion'))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

    public function updateEstado(Request $request){          
        $comentario = ConciliacionEstado::find($request->estado_id);
        $comentario->fill($request->all());
        $comentario->save();
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        
        $view = view('myforms.conciliaciones.componentes.conciliacion_estados_ajax',compact('conciliacion'))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

    public function insertData(Request $request){

        $ref_data = ReferencesStaticData::where(['name'=>$request->name,'section'=>$request->section])->first();
      //  return response()->json($request->all());
       if($ref_data) {  
           
            $data = ConciliationAditionalStaticData::where([
                'reference_data_id'=>$ref_data->id,                
                'conciliacion_id'=>$request->conciliacion_id
                ])->first();           
        

            if($data){
                $data->fill([                    
                    'value'=>$request->value,
                    'reference_data_option_id'=>$request->has('reference_data_option_id') ? $request->reference_data_option_id : $ref_data->options[0]->id,
                    'value_is_other'=>$request->value_is_other,
                ]);
                $data->save();
            }else{
                $data = ConciliationAditionalStaticData::create([
                    'reference_data_id'=>$ref_data->id,
                    'reference_data_option_id'=>$request->has('reference_data_option_id') ? $request->reference_data_option_id : $ref_data->options[0]->id,
                    'conciliacion_id'=>$request->conciliacion_id,
                    'value'=>$request->value,
                    'value_is_other'=>$request->value_is_other,
                ]);
            }
       }else{
        return response()->json(['error'=>'El atributo no existe']);
       }
        return response()->json($request->all());
    }

    public function storeAnexo(Request $request){
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        if($request->file('conciliacion_file')!=''){          
            $file = $conciliacion->uploadFile($request->file('conciliacion_file'),'/conciliacion_'.$conciliacion->id);
            $conciliacion->files()->attach($file,['type_status_id'=>1,'concepto'=>$request->concept]);                   
		}
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view("myforms.conciliaciones.componentes.anexos_ajax",compact("conciliacion"))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

    public function deleteAnexo(Request $request){
        //return response()->json($request->all());
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $file = File::find($request->file_id);
        if ($file->path!='') {
            Storage::delete("conciliacion_files/conciliacion_".$request->conciliacion_id."/".$file->encrypt_name);  
            $file->delete();          
        }        
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view("myforms.conciliaciones.componentes.anexos_ajax",compact("conciliacion"))->render();
        return response()->json([
            'view'=>$view
        ]);
    }


    public function updateAnexo(Request $request){
        //return response()->json($request->all());
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $file = File::find($request->file_id);
        if($request->file('conciliacion_file')!=''){    
            if ($file->path!='') {
                Storage::delete("conciliacion_files/conciliacion_".$request->conciliacion_id."/".$file->encrypt_name);  
                //return response()->json("conciliacion_files/conciliacion_".$request->conciliacion_id."/".$file->encrypt_name);
                $file->delete();          
            }      
            $file = $conciliacion->uploadFile($request->file('conciliacion_file'),'/conciliacion_'.$conciliacion->id);             
           $conciliacion->files()->attach($file,['type_status_id'=>1,'concepto'=>$request->concept]);                   
		}else{
           $file = $conciliacion->files()->where('file_id',$request->file_id)->first();
           $file->pivot->concepto = $request->concept;
           $file->pivot->save();
        }
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $view = view("myforms.conciliaciones.componentes.anexos_ajax",compact("conciliacion"))->render();
        return response()->json([
            'view'=>$view
        ]);
    }


    public function downloadFile($file_id){
		array_map('unlink', glob(public_path('act_temp/'.auth()->user()->id.'___*')));//elimina los archivos que el 
		$file= File::find($file_id);
		if ($file) {
			$rutaDeArchivo = storage_path($file->path);
			$filename = auth()->user()->id.'___'.$file->original_name;			
			copy( $rutaDeArchivo, public_path("act_temp/".$filename));
			
			return redirect("act_temp/".$filename); 
		}
	}

    public function getEstadosReportesPdf(Request $request)
    {
        $estado = ConciliacionEstado::find($request->estado_id);
        $estado->files = $estado->files()->where('conciliacion_id',$request->conciliacion_id)->get();
        return response()->json($estado);
    }

    public function getUser(Request $request,$idnumber)
    {
       // return $request->all();
        $user =User::where(['idnumber'=>$idnumber])->first();
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        if($user){       
          $user->roles;       
          $view = view('myforms.conciliaciones.componentes.user_form',compact('conciliacion','user'))->render();
          //$viewD = view('myforms.conciliaciones.componentes.user_detalles_form',compact('conciliacion','user'))->render();
           return response()->json(['encontrado'=>true,'user'=>$user,'view'=>$view]);   
        } 
        $view = view('myforms.conciliaciones.componentes.user_form',compact('conciliacion'))->render();
          
          return  response()->json(['encontrado'=>false,'view'=>$view]);
    }
    public function getDetallesUser(Request $request,$idnumber)
    {
       // return $request->all();
        $user =User::where(['idnumber'=>$idnumber])->first();       
        if($user){       
            $conciliacion = Conciliacion::find($request->conciliacion_id);
          $user->roles;             
          $view = view('myforms.conciliaciones.componentes.user_detalles_form',compact('user','conciliacion'))->render();
           return response()->json(['encontrado'=>true,'user'=>$user,'view'=>$view]);   
        } 
        //$view = view('myforms.conciliaciones.componentes.user_detalles_form',compact('user'))->render();
          
         return  response()->json(['encontrado'=>false]);
    }

    public function deleteUser(Request $request){       
        $user = DB::table('conciliacion_has_user')
        ->where('id',$request->pivot)->delete();
        return response()->json([
            'user'=>$user
        ]);
    }

    public function getEstudiantes(){

        $users = DB::table('users')
       ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
       ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
       ->leftjoin('turnos' , 'turnos.trnid_estudent','=','users.idnumber')
       ->leftjoin('referencias_tablas' , 'referencias_tablas.id','=','users.cursando_id')
       ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
       ->leftjoin('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
       ->where ('turnos.trnid_estudent','=',null)
       ->where ('role_id', '6' ) 
       ->where ('users.active', true)
       ->where('sedes.id_sede',session('sede')->id_sede)
       ->select('referencias_tablas.ref_nombre as cursando','users.active','users.id','users.idnumber',
         DB::raw('CONCAT(users.name," ",users.lastname) as full_name')
         ,'role_user.role_id', 'roles.display_name')->orderBy('users.created_at', 'desc')->get();

  return ($users);
 }

} 
