<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Actuacion;
use App\Expediente;
use DB;
use Storage;
use Carbon\Carbon;
use App\Segmento;
use App\Notifications\UserNotification;

class ActuacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    

    public function actpdfdownload($id,$user_doc)
    {
                array_map('unlink', glob(public_path('act_temp/'.currentUser()->id.'___*')));//elimina los archivos que el 
     
                $actuacion= Actuacion::find($id);
                if ($user_doc =='docente') {
                  $url = 'app/files_actuaciones/'.$actuacion->actdocnomgen_docente;
                  $rutaDeArchivo = storage_path($url);
                  $filename = currentUser()->id.'___'.$actuacion->actdocnomgen_docente;
                  $filedes=$actuacion->actdocnompropio_docente;
                }
                if ($user_doc=='estudiante') {
                   $url = 'app/files_actuaciones/'.$actuacion->actdocnomgen;
                   $rutaDeArchivo = storage_path($url);
                   $filename = currentUser()->id.'___'.$actuacion->actdocnomgen;
                   $filedes=$actuacion->actdocnompropio;
                }
               //dd($rutaDeArchivo);
                 copy( $rutaDeArchivo, public_path("act_temp/".$filedes));

                return redirect("act_temp/".$filedes); 


/*
                $actuacion= Actuacion::find($id);
                



                $url = 'app/files_actuaciones/'.$actuacion->actdocnomgen;
                $rutaDeArchivo = storage_path($url);

                $headers = array(
                  'Content-Type'=> 'application/pdf'
                );


                return response()->download($rutaDeArchivo, $actuacion->actdocnomgen, $headers);
*/  
  }   





    public function index(Request $request) {
      
      $expediente = Expediente::where('expid',$request->id_control_list)->first();
     //
      $expediente->setNotActLimit();
      $actuaciones = $this->getActuacionesExp($request->id_control_list,0);

      return response()->json($actuaciones); 
    }

    public function get_act_ant(Request $request){

        $actuaciones = $this->getActuacionesExp($request->id_control_list,1);
       return response()->json($actuaciones);
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $expediente = Expediente::where('expid','2019B-11')->first();
      $actuaciones = $expediente->setNotActLimit();
      
      //dd($actuaciones);
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

      //return response()->json($request->all()); 
        if($request->ajax()){
       

        $expediente_id= $request->id_control_list;
        if(isset($request->actexpid)){          // dd($request->actdocnomgen);
            if($request->file('actdocnomgen')!=''){
                $docum= $request->file('actdocnomgen');
                $nombre_arch=$docum->getClientOriginalName();
                $nombre_arch = htmlentities($nombre_arch);
                $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
                $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
                $actdocnompropio= $file_name;    
                $extencion=$request->file('actdocnomgen')->extension();
                $file_name = md5($file_name).'.'.$extencion;
                $file_route = time()."_".$file_name;               
                Storage::disk('files_actuaciones')->put($file_route, file_get_contents($docum->getRealPath() ) );
                $actdocnomgen = $file_route;
                $actdocruta =Storage::disk('files_actuaciones')->url($file_route);

                //$actdocruta = public_path($url);                             
            }else{
                $actdocnomgen ='';
                $actdocnompropio ='';
                $actdocruta ='';                  
            }                 
                $expediente = Expediente::where("expid",$request['actexpid'])->first();
                $actuacion = New Actuacion();
                $actuacion->actexpid = $request['actexpid'];
                $actuacion->actnombre = $request['actnombre'];
                $actuacion->actidnumberest = $request['actnombre'];
                $actuacion->actdescrip = $request['actdescrip'];
                $actuacion->actfecha = $request['actfecha'];
                $actuacion->fecha_limit = $request['fecha_limit'];
                $actuacion->actestado_id = $request['actestado_id'];
                $actuacion->actdocnomgen = $actdocnomgen;
                $actuacion->actdocnompropio = $actdocnompropio;
                $actuacion->actidnumberest = $expediente->expidnumberest;
                $actuacion->actdocruta = $actdocruta;
                $actuacion->actusercreated = currentUser()->idnumber;
                $actuacion->actuserupdated = currentUser()->idnumber;
                $actuacion->save();

                if ($request->has('parent_actuacion_id')) {
                    $actuacion->revisionesExp()->attach($actuacion->id,[
                                'rev_actexpid'=>$request['actexpid'],
                                'parent_rev_actid'=>$request->parent_actuacion_id,
                                //'rev_actid'=>$actuacion->id,
                                ]); 
                }else{
                    $actuacion->revisionesExp()->attach($actuacion->id,[
                                'rev_actexpid'=>$request['actexpid'],
                                'parent_rev_actid'=>$actuacion->id,
                                //'rev_actid'=>$actuacion->id,
                                ]); 
                }
 
             


            }
            if ($actuacion->actestado_id == 140) {
              $user = $expediente->estudiante;
              $user->notification = 'Nueva notificación de caso';
              $user->link_to = '/expedientes/'.$expediente->expid.'/edit';
              $user->mensaje = 'Se ha asignado una nueva actuación. Exp: '.$expediente->expid;     
              $user->notify(new UserNotification($user));
            }
          //  $actuaciones = $this->getActuacionesExp($request['actexpid'],0);

            

                return response()->json($request->all()); 
          }

  
    }

  private function getActuacionesExp($expediente_id,$bandera){
   
       $user_id = \Auth::user()->id;
        $userSession =DB::table('users as u')
        ->join('role_user as ru','ru.user_id','=','u.id')
        ->join('roles as r','r.id','=','ru.role_id')       
        ->where('u.id', '=',$user_id)
        ->select('r.name','u.idnumber')        
        ->first();
        $userSession->volver_correcciones = \Auth::user()->can('volver_correcciones_actuacion');
        $expediente = Expediente::where('expid',$expediente_id)->first();
       // dd($expediente->getDocenteAsig()->idnumber);
        $expediente->getDocenteAsig()->idnumber==\Auth::user()->idnumber ? $can_edit = true : $can_edit = false ;
        //$userSession->role;
        $actuaciones = DB::table('actuacions as a')
                  ->join('revisiones_actuacion as rv','rv.rev_actid','=','a.id')    
                  ->join('referencias_tablas as r','r.id','=','a.actestado_id')  
                   ->where(function($query) use ($expediente,$bandera) {
                    $bandera == 0 ? $query->where('a.actidnumberest',$expediente->expidnumberest) : $query->where('a.actidnumberest','<>',$expediente->expidnumberest) ;
                  }) 
                  ->where('rv.rev_actexpid', '=',$expediente_id)
                  //->where('a.actidnumberest',$expediente->expidnumberest)
                  ->select('rv.parent_rev_actid','r.ref_nombre')
                  ->groupBy('rv.parent_rev_actid')
                  ->get();

                 foreach ($actuaciones as $key => $act) {                        
                     $actuaciones2 = DB::table('actuacions as a')
                      ->join('revisiones_actuacion as rv','rv.rev_actid','=','a.id')   
                      ->join('referencias_tablas as r','r.id','=','a.actestado_id') 
                      ->where('rv.parent_rev_actid', '=',$act->parent_rev_actid)
                      ->where('rv.rev_actid', '<>',$act->parent_rev_actid)
                      ->select(
                        'rv.parent_rev_actid',
                        'rv.rev_actid',
                        'a.id',
                        'a.actnombre',
                        'a.actfecha',
                        'a.fecha_limit',
                        'a.actdocenrecomendac',
                        'a.actestado_id',
                        'r.ref_nombre',
                        'a.actdocnomgen', 'a.actdocnompropio',
                        'a.actdocruta', 'a.actusercreated', 'a.actuserupdated',
                        'a.actdescrip'
                      )
                      ->orderBy('a.created_at','desc')
                      ->get();
                    $parent = Actuacion::find($act->parent_rev_actid);  
                    $act->parent = $parent;
                    $act->user =  $userSession;
                    $act->children = $actuaciones2;
                    $act->docenteasig = $can_edit;
                    
              }

                return $actuaciones;
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
    public function edit($id)
    {
      $userSession = \Auth::user()->id_number;
        $actuacion= Actuacion::find($id);
        
        $parentId = DB::table('revisiones_actuacion')
        ->select('parent_rev_actid','rev_actid')
        ->where('rev_actid',$id)->first();
        $actuacion->parent = $parentId;
        $actuacion->notas_f = $actuacion->get_notas(); 
        $actuacion->docente_update; 
        $actuacion->user_created; 
        $actuacion->estudiante;     
          
            return response()->json(
            $actuacion->toArray()
        ); 
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
     // return response()->json($request->all()); 
        if($request->ajax()){ 
        $actuacion= Actuacion::find($id);
        $actuacion-> fill($request->all());
        $actuacion->actuserupdated = currentUser()->idnumber;
          

        if($request->file('actdocnomgen')!=''){
           if ($actuacion->actdocruta!='') {
            Storage::delete($actuacion->actdocruta);            
          }
          $docum=$request->file('actdocnomgen');
          $nombre_arch=$docum->getClientOriginalName();
                $nombre_arch = htmlentities($nombre_arch);
                $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
                $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
                $actdocnompropio= $file_name;    
            $file_name = md5($file_name).'.'.$request->file('actdocnomgen')->extension();
            $file_route = time()."_".$file_name; 
            //$file_route= time()."_".$docum->getClientOriginalName();
            Storage::disk('files_actuaciones')
            ->put($file_route, file_get_contents($docum->getRealPath() ) );
            $actdocnomgen =$file_route;
            $actdocruta =Storage::disk('files_actuaciones')->url($file_route);

            $actuacion->actdocnomgen = $actdocnomgen;
            $actuacion->actdocnompropio = $actdocnompropio;
            $actuacion->actdocruta = $actdocruta;
  
        }
        $actuacion-> save();  
          /*  if (currentUser()->hasRole("docente")){
                        //$actuacion= Actuacion::find($id);
                        $actuacion-> fill(['actdocenrevisa'=>currentUser()->idnumber]);
                        $actuacion-> save();
            } */
         
        return response()->json($request->all()); 
        return response()->json(
            $actuacion->toArray()
        ); 

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $del='';

        $buscaParent = DB::table('revisiones_actuacion')->where('parent_rev_actid',$id)->get();
        if (count($buscaParent)>0) {         
          foreach ($buscaParent as $key => $parentId) {
            $actuacion = Actuacion::find($parentId->rev_actid);
                if ($actuacion->actdocruta!='') {
                   Storage::delete($actuacion->actdocruta);
                }

                if ($actuacion->actdocruta_docente!='') {
                    Storage::delete($actuacion->actdocruta_docente);
                }
              $actuacion->delete();
          }

        }else{
          $actuacion = Actuacion::find($id);
          if ($actuacion->actdocruta!='') {
                   Storage::delete($actuacion->actdocruta);
          }
          if ($actuacion->actdocruta_docente!='') {
                    Storage::delete($actuacion->actdocruta_docente);
          }
              $actuacion->delete();
        }      

        return response()->json(($actuacion));
    }

    public function updoc(Request $request,$id){
      
        //dd($id);
        $actuacion= Actuacion::find($id);
        if($request->file('actdocnomgen')!=''){
           $actuacion= Actuacion::find($id);        
            if ($actuacion->actdocruta!='') {
            Storage::delete($actuacion->actdocruta);
            }

            $docum=$request->file('actdocnomgen');
            $nombre_arch=$docum->getClientOriginalName();
                $nombre_arch = htmlentities($nombre_arch);
                $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
                $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
                $actdocnompropio= $file_name;    
            
            $file_name = md5($file_name).'.'.$request->file('actdocnomgen')->extension();
            $file_route = time()."_".$file_name; 
            $file_route= time()."_".$docum->getClientOriginalName();
            Storage::disk('files_actuaciones')->put($file_route, file_get_contents($docum->getRealPath() ) );
            $actdocnomgen =$file_route;
            
            $actdocruta =Storage::disk('files_actuaciones')->url($file_route);

        
        $actuacion->actdocnomgen = $actdocnomgen;
        $actuacion->actdocnompropio= $actdocompropio;                          
        $actuacion->actdocruta= $actdocruta;
        $actuacion-> save();
               
                             
        }  

        return response()->json($actuacion);


    }


    public function storeRevision(Request $request){

        
        $actuacion =  Actuacion::find($request['idact']);
        //eturn response()->json($actuacion->id);

        if($request->file('actdocnomgen')!=''){
             if ($actuacion->actdocruta_docente!='') {
               Storage::delete($actuacion->actdocruta_docente);
          }

          $docum=$request->file('actdocnomgen');
          $nombre_arch=$docum->getClientOriginalName();
                $nombre_arch = htmlentities($nombre_arch);
                $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
                $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
                $actdocnompropio= $file_name;    
          
          $file_name = md5($file_name).'.'.$request->file('actdocnomgen')->extension();
          $file_route = time()."_".$file_name; 
          //$file_route= time()."_".$docum->getClientOriginalName();
          Storage::disk('files_actuaciones')->put($file_route, file_get_contents($docum->getRealPath() ) );
          $actdocnomgen =$file_route;
          $actdocruta =Storage::disk('files_actuaciones')->url($file_route);
          
               
                             
                }else{

                $actdocnomgen ='';
                $actdocnompropio ='';
                $actdocruta ='';                  
              }                      
                $actuacion->actestado_id = $request['actestado_id'];
                $actuacion->actdocenrecomendac = $request['actdocenrecomendac'];
                $actuacion->actdocnomgen_docente = $actdocnomgen;
                $actuacion->actdocnompropio_docente = $actdocnompropio;
                $actuacion->actdocruta_docente = $actdocruta;
               if($request['fecha_limit_doc']!='') $actuacion->fecha_limit = $request['fecha_limit_doc'];
                $actuacion->actuserupdated = currentUser()->idnumber;
                $actuacion->actdocenfechamod = date("Y-m-d H:i:s");
                $expediente  = Expediente::where('expid',$request->actexpid)->first();      
        if ($request->ntaaplicacion) {
        
          //$expediente->estudiante;
          $docente_id = \Auth::user()->idnumber;
          $estudiante_id = $expediente->estudiante->idnumber;  
                $data = [
                  'ntaaplicacion'=>$request->ntaaplicacion,
                  'ntaconocimiento'=>$request->ntaconocimiento,
                  'ntaetica'=>$request->ntaetica,
                  'ntaconcepto'=>$request->ntaconcepto,
                  'orgntsid'=>$request->orgntsid,
                  'segid'=>$request->segid,
                  'perid'=>$request->perid,
                  'tpntid'=>$request->tpntid,
                  'expidnumber'=>$request->actexpid,
                  'estidnumber'=>$estudiante_id,
                  'docidnumber'=>$docente_id,
                  'tbl_org_id'=>$request['idact'],
                ];
                 $actuacion->asignarNotas($data);

              //$actuacion->notas = json_encode($data);
          }      
          $actuacion->save();
          if ($actuacion->actestado_id == 102) {
            $user = $expediente->estudiante;
            $user->notification = 'Nueva notificación de caso';
            $user->link_to = '/expedientes/'.$expediente->expid.'/edit';
            $user->mensaje = 'Se ha solicitado una correción a una actuación. Exp: '.$expediente->expid;     
            $user->notify(new UserNotification($user));
          }
         return response()->json($actuacion->toArray());
    }


    public function revisiones(Request $request,$id){

      $actuacion = Actuacion::find($id);
     switch ($actuacion->actestado_id){
       case 136:
        $actuacion->actestado_id = 138;
         break;
        case 139:
        $actuacion->actestado_id = 102;
        $today = Carbon::now();
        $new_limit = $today->addDays(10);
        $actuacion->fecha_limit =  $new_limit;
        $notas = DB::table('notas')->where('tbl_org_id',$actuacion->id)->delete();
         break;
      case 138:
        $actuacion->actestado_id = 136;
         break;  
      case 137:
        $actuacion->actestado_id = 139;
         break; 
      case 139:
        $actuacion->actestado_id = 137;
        break;        
     }
     $actuacion->actuserupdated = currentUser()->idnumber;
    
     $actuacion->save(); 

      return response()->json($actuacion->actestado_id);

    }


  
}
