<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use Illuminate\Support\Facades\Crypt;
use Facades\App\Facades\NewPush;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user()->expedientes);
        return view('front.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $user->unreadNotifications->markAsRead();
        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('$conciliaciones' )     ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function conciliaciones(Request $request)
    {
        $conciliaciones = \App\Conciliacion::where(function($query){
            
                //$query->on('conciliaciones.id', '=', 'conciliacion_has_user.conciliacion_id');
            if(!currentUser()->can('ver_conciliaciones')){                
                return $query->where('user_id',currentUser()->id);
            }
        }) 
        
        ->orderBy('conciliaciones.created_at','desc')->paginate(10);  
      //  dd($conciliaciones)     ;
        return view('front.conciliaciones.index',compact('conciliaciones'));
    }

    public function conciliacion_edit(Request $request,$id)
    {
        $conciliacion= \App\Conciliacion::find($id);  
        //dd($conciliacion)     ;
        return view('front.conciliaciones.edit',compact('conciliacion'));
    }

    public function solicitud_show($id)
    {   
        $solicitud = Solicitud::find($id);   
        if($solicitud and $solicitud->user->id == currentUser()->id){
            if($solicitud and $solicitud->type_status_id==171){
                $solicitud->type_status_id = 165;
                $solicitud->save();
                NewPush::channel('solicitudes_coord')
                ->message(['solicitud_id'=>$id,'type_status_id'=>$solicitud->type_status_id,
                'type_status'=>$solicitud->estado->ref_nombre])->publish();
            }
        $tur_aten=  Solicitud::whereIn('type_status_id',[155,156])
        ->whereDate('created_at',date('Y-m-d'))
        ->orderBy("turno", 'desc')->first();
        return view('front.solicitudes.frm_edit_solicitud',compact('solicitud','tur_aten'));
       }
       return view('errors.error'); 
   
    }

}
 