<?php

namespace App\Http\Controllers;

use App\Conciliacion;
use App\ConciliacionEstado;
use App\ConciliacionPdfTemporal;
use App\ConciliacionReporte;
use App\Mail\ConfirmarFirma;
use App\PdfReporte;
use App\User;
use App\PdfReporteDestino;
use App\Traits\PdfReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Redirect;


class ConciliacionesFirmasController extends Controller
{
 use PdfReport;

   
    public function firmaVerify(Request $request,$token){  
        $user = DB::table('pdf_reportes_users')       
        ->where('pdf_reportes_users.token',$token)
        ->first();
         if($user){
            if($user->firmado == 1)  return view("myforms.conciliaciones_firmas.firmar_firmado");
            return view("myforms.conciliaciones_firmas.verificar_codigo",compact('token'));
        }
        abort(404);
       // $user->sedes;
        //dd($user->sedes[0]->id_sede);
        
    }

    public function tokenVerify (Request $request){
       // dd($request->all());
        $user = User::with('tipo_pdf_firmante')
        ->where('users.idnumber',$request->idnumber)
        ->whereHas('tipo_pdf_firmante', function($query) use ($request) {
            $query->where('pdf_reportes_users.token',$request->token_firma)
            ->where('pdf_reportes_users.codigo',$request->codigo);
        })        
        ->first();
        if($user){
            return Redirect::route('firmar.accept',['token_firma'=>$request->token_firma,
            'codigo'=>$request->codigo]);            
        }
        return Redirect::back()->with('message-danger','No existe el registro')
        ->withInput($request->input());  
       // return view("myforms.conciliaciones_firmas.verificar_codigo",compact('token','user'));
        
    }

    public function showFirmaAccept (Request $request){
        
      //  dd($request->all()); 
        $user = DB::table('pdf_reportes_users')      
        ->where('pdf_reportes_users.codigo',$request->codigo)
        ->where('pdf_reportes_users.token',$request->token_firma)
        ->first();
       
        if($user){
            if($user->firmado == 1)  return view("myforms.conciliaciones_firmas.firmar_firmado");
            $pdf_report = PdfReporteDestino::find($user->pdf_reporte_id);   
            //dd($user);           
            return view("myforms.conciliaciones_firmas.firmar_documento",compact('pdf_report','user'));
        }
        abort(404);
        return view("myforms.conciliaciones_firmas.verificar_codigo",compact('token','user'));
        
    }

    public function firmaAccept (Request $request){
        
        // dd($request->all());
 
         $user = User::with('tipo_pdf_firmante')
         ->where('users.email',$request->email)
         ->whereHas('tipo_pdf_firmante', function($query) use ($request) {
             $query->where('pdf_reportes_users.token',$request->token_firma)
             ->where('pdf_reportes_users.codigo',$request->codigo);
         })        
         ->first();
         //dd($user);
         if($user){
            $user->token = $request->token_firma;
            $user->codigo = $request->codigo;
            Mail::to($user)->send(new ConfirmarFirma($user));
            return response()->json(['user'=> $user ], 200, ['Acept']);
             
         }
         return response()->json(['user'=> $user ], 404, ['Acept'=>'HttpResponse']);
       
         
     }

     public function firmaConfirm (Request $request,$token,$codigo){
        
        //dd($request->all());
 
        $user = DB::table('pdf_reportes_users')      
        ->where('pdf_reportes_users.codigo',$codigo)
        ->where('pdf_reportes_users.token',$token)
        ->first();
        if($user){
            $user = DB::table('pdf_reportes_users')      
            ->where('pdf_reportes_users.codigo',$codigo)
            ->where('pdf_reportes_users.token',$token)
            ->update(['firmado'=>1]);     
            return view("myforms.conciliaciones_firmas.firmar_firmado");
             
         }
         abort(404);
       
         
     }
 
}
