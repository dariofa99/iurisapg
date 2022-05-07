<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Nota;
use App\Expediente;
use App\Requerimiento;
use DB;
use App\User;
use App\AsignacionCaso;
use App\Actuacion;
use App\Periodo;
use App\Segmento;
use Excel; 
use App\Exports\NotasExport;
class NotaController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   /*      $request->id = 3030;
        $request->corte = 1;
        $request->periodo = 0;

        $notas = DB::table('notas')->where(['estidnumber'=>$request->id,'segid'=>1])->get();
        $not_exp = [];
        $not_act = [];
        $not_req = [];

        $nota_conocimiento = [];
        $nota_aplicacion = [];
        $nota_etica = [];
        
        
        foreach ($notas as $key => $nota) {


            if($nota->cptnotaid=='1') $nota_conocimiento[]=$nota;
            if($nota->cptnotaid=='2') $nota_aplicacion[]=$nota;
        }


      // dd($nota_conocimiento);












      /*  $asignaciones = AsignacionCaso::join('users','users.idnumber','=','asignacion_caso.asigest_id')
        ->where(['asignacion_caso.asigest_id'=>$request->id])
        ->groupBy('asignacion_caso.asigexp_id')
        ->select('asignacion_caso.asigexp_id')
        ->get();
        $expedientes=[];
        $notas=[];
        foreach ($asignaciones as $key => $asignacion) {            
            $notas_act=[];
            $notas_req=[];
            foreach ($asignacion->expediente->actuacion()
            ->where(['actidnumberest'=>$request->id,'actestado_id'=>104])
            ->get() as $key_2 => $act) {
               $notas_act[] = $act->get_nota_corte('etica'); 
            }
           // $notas['notas_act'] =  $notas_act; 
            foreach ($asignacion->expediente->requerimientos()->where('reqidest',$request->id)->get() as $key_2 => $req) {
                $notas_req[] = $req->get_nota_corte('etica');
             }
            // $notas['notas_req'] =  $notas_req;
             $notas [$asignacion->expediente->expid] = [
                 'notas_caso'=>$asignacion->expediente->get_notas_caso(),
                 'notas_req'=>$notas_req,
                 'notas_act'=>$notas_act,                  
             ];
           //dd($asignacion->expediente->actuacion[0]->get_nota_corte('etica'));
        }
    
        dd($notas);

        foreach ($notas as $expediente => $notas) {
         dd($notas);
        }*/ 
       // dd("wordpress-258963147");
        $periodos = Periodo::all();
        
        return view('report.notas.frm_notas_list',compact('periodos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notas_ver(Request $request)
    {
        $user = User::where('idnumber',auth()->user()->idnumber)->first();
        if(currentUser()->hasRole("estudiante")){
            $user = User::where('idnumber',auth()->user()->idnumber)->first();
        }elseif(currentUser()->can("ver_notas_estudiante")){
            if($request->has('idnumber')){
                $user = User::where('idnumber',$request->idnumber)->first();
            }
            
        }

        $notas = $user->getNotas($request);
      
       return view("myforms.notas_ver.index",compact('user','notas'));

       
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
        $response = 0;

    //return response()->json($request->all());

          $expediente  = Expediente::where('expid',$request->expid)->first();
          $expediente->estudiante;
          $docente_id = \Auth::user()->idnumber;
          $estudiante_id = $expediente->estudiante->idnumber;
          if(count($expediente->get_nota_corte('etica'))>0
           and $expediente->get_nota_corte('etica')['nota'] == 0 
           and $expediente->get_nota_corte('etica')['id'] == 0){
            $data = [
                'ntaaplicacion'=>$request->ntaaplicacion,
                'ntaconocimiento'=>$request->ntaconocimiento,
                'ntaetica'=>$request->ntaetica,
                'ntaconcepto'=>$request->ntaconcepto,
                'orgntsid'=>$request->orgntsid,
                'segid'=>$request->segid,
                'perid'=>$request->perid,
                'tpntid'=>$request->tpntid,
                'expidnumber'=>$request->expid,
                'estidnumber'=>$estudiante_id,
                'docidnumber'=>$docente_id, 
                'tbl_org_id'=>$expediente->id,
              ];
            $expediente->asignarNotas($data);
            $response = 1;
          }      
         
        return response()->json($response);
       }     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchNotas(Request $request)
    {
        ob_end_clean(); // this
        ob_start();
        if(!$request->ajax()){
      /*   $notas = DB::table('notas')
        ->join('cptonotas as cp','cp.id','=','notas.cptnotaid')
        ->join('segmentos','segmentos.id','=','notas.segid')
        ->join('periodo','periodo.id','=','notas.perid')
        ->select(
            'notas.nota','notas.cptnotaid','notas.segid','notas.perid','notas.estidnumber',
            'cp.cpntnombre as concepto','segmentos.segnombre as segmento','periodo.prddes_periodo'
            )
        ->where([
            'estidnumber'=>$request->idnumber,
           // 'segid'=>$request->segmento_id,
            'notas.perid'=>$request->periodo_id        
        ])->get(); */

        /* $notas = DB::select(DB::raw("SELECT notas.estidnumber, UPPER(users.name) as nombre,
         UPPER(users.lastname) as apellido, referencias_tablas.ref_nombre as curso,
         AVG(if(cptnotaid='1',nota,null)) AS nota_conocimiento, 
         AVG(if(cptnotaid='2',nota,null)) AS nota_aplicacion, 
         AVG(if(cptnotaid='3',nota,null)) AS nota_etica,
         (ROUND(((AVG(if(cptnotaid='1',nota,null))+AVG(if(cptnotaid='2',nota,null))+AVG(if(cptnotaid='3',nota,null)))/3),1)) notafinal
         FROM notas, expedientes, users, referencias_tablas
         WHERE segid = $request->segmento_id AND exptipoproce_id!='3' AND notas.`expidnumber`=`expedientes`.`expid`
         AND notas.`estidnumber`=`users`.`idnumber` AND users.`cursando_id`=`referencias_tablas`.`id`
         GROUP BY estidnumber"));

    $notas= json_decode( json_encode($notas), true); */
   // return response()->json($request->all());
    $notas = $this->notas_download($request);
    // dd($notas);
//return response()->json($notas);
$segmento = Segmento::find($request->segmento_id);
$periodo = Periodo::find($request->periodo_id);

if($request->segmento_id){
   $header =  ['cedula','nombres','curso','casos','defensas','conciliaciones','otros','final'];
   return Excel::download(new NotasExport($notas,$header,null,'Notas_'.$periodo->prddes_periodo),'Reporte.xlsx');
  /*   
   Excel::create('Notas_'.$periodo->prddes_periodo, function($excel) use($notas,$segmento,$periodo) {
        
        $excel->sheet('Not_'.$segmento->segnombre."_".$periodo->prddes_periodo, function($sheet) use($notas) {
           $sheet->row(1,['cedula','nombres','curso','casos','defensas','conciliaciones','otros','final']);
           $sheet->fromArray($notas,null,'A2',false,false);           
        });
        })->store('xlsx','exports/',true);  */ 
}else{
    $segmentos = Segmento::join('sede_segmentos as sg','sg.segmento_id','=','segmentos.id')
    ->where('sg.sede_id',session('sede')->id_sede)
    ->where('perid',$request->periodo_id)
    ->get();
    $header = ['cedula','nombres','curso'];
    $segme = ['Datos del estudiante'];   
    foreach ($segmentos as $key => $segmento) {
        $header[] = 'casos';
        $header[] = 'defensas';
        $header[] = 'conciliaciones';
        $header[] = 'otros';
        $header[] = 'final';               
    }     
    $header[] = 'final periodo';
   return Excel::download(new NotasExport($notas,$header,$segmentos,'Notas_'.$periodo->prddes_periodo),'Reporte.xlsx');
    /* Excel::create('Notas_'.$periodo->prddes_periodo, function($excel) use($notas,$header,$segmentos,$periodo) {
        $cells = ['D1:H1','I1:M1','N1:R1','S1:W1'];  
        $cells_v = ['D1','I1','N1','S1']; 
        $excel->sheet('Notas_'.$periodo->prddes_periodo, function($sheet) use($notas,$header,$segmentos,$cells,$cells_v) {     
            foreach ($segmentos as $key => $segmento) {
                $sheet->mergeCells($cells[$key]);
                $sheet->setCellValue($cells_v[$key], $segmento->segnombre);
                $header[] = 'casos';
                $header[] = 'defensas';
                $header[] = 'conciliaciones';
                $header[] = 'otros';
                $header[] = 'final';               
            }     
            $header[] = 'final periodo';       
            $sheet->row(2,$header);
            $sheet->fromArray($notas,null,'A3',false,false); 
            //$sheet->loadView('myforms.reportes.notas')    ;      
           });  
        })->store('xlsx','exports/',true); */  
}
    $data = [
            'success' => true,
            'path'=>'/exports/Notas_'.$periodo->prddes_periodo.'.xlsx'
    ];

return response()->json($data); 





        $segmentos = Segmento::where('perid',$request->periodo_id)->get();    
         


        $not_exp = [];
        $not_act = [];
        $not_req = [];

        $nota_conocimiento = [];
        $nota_aplicacion = [];
        $nota_etica = [];
        $notasR=[];
         
         foreach ($segmentos as $key => $segmento) {
                $not = [];
                foreach ($notas as $key_1 => $nota) {
                 if($segmento->id == $nota->segid and $nota->cptnotaid!=4)  $not[] = $nota;
                }
            $notasR[$segmento->segnombre]=$not;
           
        }
       // return response()->json($notasR); 
        $notas = [];
        foreach ($notasR as $key => $notaR) {
          
            if(count($notaR)>0){
                foreach ($notaR as $key_2 => $nota) {
                    if($nota->cptnotaid==1)  $nota_conocimiento[] = $nota->nota;
                    if($nota->cptnotaid==2)  $nota_aplicacion[] = $nota->nota;
                    if($nota->cptnotaid==3)  $nota_etica[] = $nota->nota;
                 } 
                 $notas[$key] = [
                    'conocimiento'=>$nota_conocimiento,
                    'etica'=>$nota_etica,
                    'aplicacion'=>$nota_aplicacion,
        
                   ];
            }else{
                $notas[$key] = [
                    'conocimiento'=>[],
                    'etica'=>[],
                    'aplicacion'=>[],        
                   ];
            }
           

           
        }

            return response()->json($notas);
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $notas=[];
        if($request->origen == 2){
            $actuacion = Actuacion::find($id);
            $notas = $actuacion->get_notas();          
           
        }
        if($request->origen == 1){
            $expediente = Expediente::find($id); 
            //return response()->json($expediente);
            if(count($expediente->get_has_nota_final())>0){ 
                $nota_final = $expediente->get_has_nota_final(); 
                $can_edit = false;
                if($expediente->getDocenteAsig()->idnumber == currentUser()->idnumber || currentUser()->hasRole('amatai') || currentUser()->hasRole('dirgral') || currentUser()->hasRole('diradmin')) $can_edit = true;
              
                $notas = [
                    "nota_conocimiento"=> number_format($nota_final['nota_conocimiento']['nota'],1,'.','.'),
                    "nota_conocimientoid"=>$nota_final['nota_conocimiento']['id'],
                    "nota_etica"=>number_format($nota_final['nota_etica']['nota'],1,'.','.'),
                    'nota_eticaid'=>$nota_final['nota_etica']['id'],
                    "nota_aplicacion"=>number_format($nota_final['nota_aplicacion']['nota'],1,'.','.'),
                    "nota_aplicacionid"=>$nota_final['nota_aplicacion']['id'],
                    'nota_concepto'=>$nota_final['nota_concepto']['nota'],
                    'nota_conceptoid'=>$nota_final['nota_concepto']['id'],
                    "nota_final"=>number_format($nota_final['nota_final']['nota'],1,'.','.'),
                    "can_edit"=>$can_edit, 
                    "encontrado"=>true,
                    "segmento"=>$nota_final['segmento'],
                    "periodo"=>$nota_final['nota_aplicacion']['periodo'],
                    "tipo"=>$nota_final['nota_aplicacion']['tipo'],
                    "tipo_id"=>$nota_final['nota_aplicacion']['tipo_id'],
                    "segmento_id"=>$nota_final['segmento_id'],
                    "docevname"=>$nota_final['nota_conocimiento']['docevname']
                ];

                  //  $nota_final['nota_etica']['docidnumber'] == \Auth::user()->idnumber ? $notas["can_edit"] = true:'';


            }else{
                $notas = $expediente->get_notas();  
                if($expediente->getDocenteAsig()->idnumber == currentUser()->idnumber) $notas["can_edit"] = true;
            }
        }
        if($request->origen == 3){
            $req = Requerimiento::find($id);
            $notas = $req->get_notas(); 
            //return response()->json($req);
            } 
       
    return response()->json($notas);
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
        return response()->json($request->all());

        if ($request->ajax()) {
            
            $nota = Nota::find($id);
            $nota->nota = $request->new_nota;
            $nota->save(); 

            $expediente = Expediente::where('expid',$request->expid)->first();
            $final = $nota->getNotaFinal($expediente->notas);

            return response()->json($final);
        }
    }

    public function updateNota(Request $request)
    {
        
       // return response()->json($request->all());
        
        if ($request->ajax()) {
            $expediente = Expediente::find($request->exp_id);
            foreach ($request->nota as $key_1 => $nota_r) {
                foreach ($request->nota_id as $key_2 => $nota_id) {
                    if($key_1==$key_2){                      
                        $nota = Nota::find($nota_id);
                        $nota->nota = $nota_r;
                        $nota->docidnumber = \Auth::user()->idnumber;
                        $nota->tpntid = $request->tipo_nota_id;
                        if($nota->tbl_org_id==null) $nota->tbl_org_id = $request->tbl_org_id;

                        $nota->save();
                        $ex_id = $nota->expidnumber;
                    }
                }
                
            }    
            $final = number_format($expediente->get_nota_corte('final')['nota'],1,'.','.');

            $response = [
                "nota_final"=>$final,
                'user_name'=>\Auth::user()->name,
                "notas_caso"=>view("myforms.frm_calificacion_create_ajax_ln",compact('expediente'))->render(),
            ];

            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        /* $nota = DB::table('notas')
            ->where('notas.expidnumber',$id)
            ->delete(); */
            if ($request->ajax()) {
                $expediente = Expediente::find($request->exp_id);
                foreach ($request->nota as $key_1 => $nota_r) {
                    foreach ($request->nota_id as $key_2 => $nota_id) {
                        if($key_1==$key_2){                      
                            $nota = Nota::find($nota_id);
                            $nota->delete();                            
                        }
                    }
                    
                }    
                
    
                return response()->json($nota);
            }    


        return response()->json($request->all());
    }

    public function notas_download($request)
    {
      /* $periodo = Periodo::where('estado',1)->first();
      $segmento = Segmento::where('perid',$periodo->id)->first(); */
        if($request->idnumber){
            $users = DB::table('users')
            ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
            ->leftjoin('referencias_tablas' , 'referencias_tablas.id','=','users.cursando_id')
            ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
            ->leftjoin('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
            ->where ('role_id', '6' ) 
            ->where ('users.active', true)
            ->where ('users.idnumber', $request->idnumber)
            ->where('sedes.id_sede',session('sede')->id_sede)
            ->select('users.active','users.id','ref_nombre','users.idnumber',
              DB::raw('CONCAT(users.name," ",users.lastname) as full_name')
              ,'role_user.role_id', 'roles.display_name')
             ->orderBy('users.created_at', 'desc')
             ->get();
        }else{
            $users = DB::table('users')
            ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
            ->leftjoin('referencias_tablas' , 'referencias_tablas.id','=','users.cursando_id')
            ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
            ->leftjoin('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
            ->where ('role_id', '6' )
            ->where ('users.active', true)
            ->where('sedes.id_sede',session('sede')->id_sede)
            ->select('users.active','users.id','ref_nombre','users.idnumber',
              DB::raw('CONCAT(users.name," ",users.lastname) as full_name')
              ,'role_user.role_id', 'roles.display_name')
             ->orderBy('users.created_at', 'desc')
             ->get();
        }
     
       $notas_periodo = [];
       if($request->segmento_id){
        foreach ($users as $key_2 => $user) {
            //if($user->idnumber=="1004133867"){
                //  dd($nota_caso);
              
            $to_excel = []; 
            $to_excel[] = $user->idnumber;
            $to_excel[] = $user->full_name;
            $to_excel[] = $user->ref_nombre;
            $nota_us = $this->getNotas($user,$request->segmento_id);
            foreach ($nota_us as $key_3 => $not) {
                $to_excel[]=$not;
            }
            $notas_periodo[] = $to_excel;
        //}      
    }  
        return $notas_periodo;
       }else{
        $segmentos = Segmento::join('sede_segmentos as sg','sg.segmento_id','=','segmentos.id')
        ->where('sg.sede_id',session('sede')->id_sede)
        ->where('perid',$request->periodo_id)->get();
            foreach ($users as $key_2 => $user) {
              //  if($user->idnumber=="1004133867"){
                    $final = 0;
                    $to_excel = []; 
                    $to_excel[] = $user->idnumber;
                    $to_excel[] = $user->full_name;
                    $to_excel[] = $user->ref_nombre;
                    foreach ($segmentos as $key => $segmento) {
                        $nota_us = $this->getNotas($user,$segmento->id);
                        foreach ($nota_us as $key_3 => $not) {
                            $to_excel[]=$not;
                        }
                        if(is_numeric($nota_us[4]) and is_numeric($final)){
                            $final =  ($final + $nota_us[4]);
                        }else{
                            $final = "N/A";
                        }
                        //$final = 
                        
                    }
                    if(is_numeric($final)){
                        $to_excel[]= round($final / count($segmentos),1);
                    }else{
                        $to_excel[]= $final;
                    }
                    $notas_periodo[] = $to_excel;   

               // }

                }
                
                /*  */
        
        return $notas_periodo;
       }
     
    }

    private function getNotas($user,$segmento){

        

//dd( $nota_ofi );
                    $nota_caso = DB::select(
                        DB::raw("SELECT `estidnumber`, AVG(`nota`) as nota
                        FROM `notas` JOIN expedientes on notas.expidnumber=expedientes.expid        
                        WHERE `segid` = $segmento AND `cptnotaid` != 4 AND expedientes.exptipoproce_id != '3'
                      and estidnumber = $user->idnumber
                        GROUP BY `estidnumber`"));

                    $nota_defensas = DB::select(DB::raw(
                        "SELECT `estidnumber`, AVG(`nota`)  as nota FROM `notas`
                        JOIN expedientes on notas.expidnumber=expedientes.expid 
                        WHERE `segid` = $segmento AND `cptnotaid` != 4 AND expedientes.exptipoproce_id = '3'
                        and estidnumber = $user->idnumber
                        GROUP BY `estidnumber`"));

                    $notas_oficina = DB::select(DB::raw(
                        "SELECT `estidnumber`, AVG(`nota`) as nota FROM `notas_ext`       
                        WHERE `segid` = $segmento AND `cptnotaid` != 4  
                        and estidnumber = $user->idnumber
                        GROUP BY `estidnumber`"));
        
          $data_user = [];
          
          $has_ncaso=false;
          $nota_final = 0;
         
          if(count($nota_caso)>0) $has_ncaso = (array_search($user->idnumber, array_column($nota_caso, 'estidnumber')));
          //dd(($has_ncaso));
            if(is_numeric($has_ncaso)){               
              $nota_c = round($nota_caso[$has_ncaso]->nota,1);
              $nota_final += ($nota_c * 0.4);
            }else{
              $nota_c = "N/A";              
              
            }
            
           
            $has_ndefensa=false;
            if(count($nota_defensas)>0) $has_ndefensa = array_search($user->idnumber, array_column($nota_defensas, 'estidnumber'));
            if(is_numeric($has_ndefensa)){
              $nota_d = round($nota_defensas[$has_ndefensa]->nota,1); 
              $nota_final += ($nota_d * 0.2);
            }else{
              $nota_d = "N/A";
              if(is_numeric($nota_c))$nota_final += ($nota_c * 0.2);
            }

            $nota_con = "N/A";
           // $percent_nota_caso += 20;
            if(is_numeric($nota_c))$nota_final += ($nota_c * 0.2);


            $has_nota_ofi = false;
            if(count($notas_oficina)>0) $has_nota_ofi = array_search($user->idnumber, array_column($notas_oficina, 'estidnumber'));
            if(is_numeric($has_nota_ofi)){
              $nota_ofi = round($notas_oficina[$has_nota_ofi]->nota,1);
              $nota_final += ($nota_ofi * 0.2);
            }else{
              $nota_ofi = "N/A";
              if(is_numeric($nota_c))$nota_final += ($nota_c * 0.2);
            }

           // $final = ()
           //$ncp = ($percent_nota_caso/100);
           $data_user[] = $nota_c;
           $data_user[] = $nota_d;
           $data_user[] = $nota_con;
           $data_user[] = $nota_ofi;
           $data_user[] = is_numeric($nota_c) ? round($nota_final,1) : "N/A";
     
         return $data_user;
    }

}
