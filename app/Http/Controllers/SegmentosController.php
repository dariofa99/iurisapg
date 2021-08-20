<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expediente;
use DB;
use Session;
use App\Segmento;
use App\Actuacion;
use App\Requerimiento;
use App\Periodo;
use App\AsigDocenteCaso;
use Carbon\Carbon;
use App\Nota;
use App\HistorialDatosCaso;

class SegmentosController extends Controller
{

	function getSegmentos(){
			$segmentos = Segmento::join('periodo','periodo.id','=','segmentos.perid')
			->join('sede_segmentos as sg','sg.segmento_id','=','segmentos.id')			
			->where('sg.sede_id',session('sede')->id_sede)
			->select('segmentos.id','segmentos.segnombre','segmentos.act_fc','fecha_inicio','fecha_fin','segmentos.estado','periodo.prddes_periodo','segmentos.est_evaluado')
			->where('periodo.estado',true)->get();

			return $segmentos;


	}
		function getSegmento($request){
			$segmentos = Segmento::join('periodo','periodo.id','=','segmentos.perid')
			->join('sede_segmentos as sg','sg.segmento_id','=','segmentos.id')
			->where('sg.sede_id',session('sede')->id_sede)
			->where('periodo.estado',true)			
			->select('segmentos.id','segmentos.segnombre','segmentos.act_fc','fecha_inicio','fecha_fin','segmentos.estado','periodo.prddes_periodo')
			->Criterio($request->data_search,$request->datatype)->get();

			return $segmentos;


	}

    public function index(Request $request){

    		$segmentos = $this->getSegmentos();
    		$periodo = Periodo::join('sede_periodos as sp','sp.periodo_id','=','periodo.id')
			->where('sp.sede_id',session('sede')->id_sede)
			->where('estado',true)->first();
    		$active_config = 'active';

    		if ($request->ajax()) {
    			if ($request->data_search and $request->datatype) {
    				$segmentos = $this->getSegmento($request);
    			}
    			if ($request->data_search and $request->data_search=='all') {
    				$segmentos = $this->getSegmentos();
    			}
    			return view('myforms.frm_segmentos_list_ajax',compact('segmentos'))->render();
    		}else{
    			if ($request->data_search and $request->datatype) {
    				$segmentos = $this->getSegmento($request);
    			}else{
    				$segmentos = $this->getSegmentos();
    			}
    		}

			//dd($periodo);
    		return  view('myforms.frm_segmentos_list',compact('segmentos','periodo','active_config'));
	}

	public function store(Request $request){
		$segmento = new Segmento($request->all());
		//$regmento->segusercreated = \Auth::user()->idnumber;
		//$regmento->seguserupdated = \Auth::user()->idnumber;		
		$segmento->save();
		if(session('sede')){
			$segmento->sedes()->attach(session('sede')->id_sede);
		}
		$segmentos = $this->getSegmentos();
		return view('myforms.frm_segmentos_list_ajax',compact('segmentos'))->render();
		//return response()->json($segmento);
	} 


	public function show($id){
		$segmento =  Segmento::find($id);
		return response()->json($segmento);

	}

	public function update(Request $request,$id){
		$segmento =  Segmento::find($id);
		$segmento->fill($request->all());
		$segmento->save();
		$segmentos = $this->getSegmentos();
		return view('myforms.frm_segmentos_list_ajax',compact('segmentos'))->render();
		
	}

	public function destroy($id){
		$segmento =  Segmento::find($id);
		$segmento->delete();
		$segmentos = $this->getSegmentos();
		return view('myforms.frm_segmentos_list_ajax',compact('segmentos'))->render();
	}

	public function changeState($id){

		$users= DB::table('segmentos')
		->join('sede_segmentos as sg','sg.segmento_id','=','segmentos.id')			
		->where('sg.sede_id',session('sede')->id_sede)
		->update(['estado'=>false,'act_fc'=>false]);           
		$segmento = Segmento::find($id);		
		$segmento->estado = true;
		$segmento->save();


		$segmentos = $this->getSegmentos();
		return view('myforms.frm_segmentos_list_ajax',compact('segmentos'))->render();

		
	}

	public function change_state_segfc(Request $request){
		$segmentoact = Segmento:: join('sede_segmentos as sg','sg.segmento_id','=','segmentos.id')			
		->where('sg.sede_id',session('sede')->id_sede)
		->where('estado',true)->first();
		if (empty($segmentoact)) {
			$response = [
				'success'=>false,
				'msj'=>'No hay un segmento de corte activo'
			];
		}else{
			if ($segmentoact->act_fc) {
				$segmentoact->act_fc = 0;
				$segmentoact->fecha_corte = null;
			}else{
				$segmentoact->act_fc = 1;
				$segmentoact->fecha_corte = date('Y-m-d');
			}
			
			$segmentoact->save();

			$response = [
				'success'=>true,
				'msj'=>'Correcto',
				'statusfc'=>$segmentoact->act_fc,
				'seg'=>$segmentoact->id
			];

		}


		return response()->json($response);

	}

	public function closeSegmento($id){

	
//-revisar los casos desde agosto hasta el 6 de febrero -> inicio corte hasta 15 dias antes del final del corte
//-un cero a los casos que no tengan docente asignado
//-un cero a los casos que no tengan informacion  en hechos o respuesta del estudiante
//-un cero a los casos de seguimiento que no tengan ninguna actuacion o anexo mayor al inicio del corte
//colocar cerro si de demoro mas de ocho dias en subir una actuacion o un anexo
// para los casos de seguimiento deben tener una actuacion o anexo 1 vez por mes
//revisar cuantos dias pasaron para llenar hechos y respuesta colocar cero si se demoro más de 5 dias
//revisar los casos de asesoria que estan abiertos pero requieren ser cerrados por el sistema
		
		$segmento = Segmento::find($id);
		
		if($segmento->fecha_corte == null) {
			Session::flash('message-danger', 'Atención..! No hay una fecha de corte activa');
			return response()->json(['saved'=>false]);
		}
		//dd($segmento);
		$date = Carbon::parse($segmento->fecha_fin);
		$date = $date->subDays(8);//comentar por ser un caso especial()
		$datesql = $date->format('Y-m-d 23:59:59');

		$meses = [$segmento->fecha_inicio,$datesql];
		$mess = $this->verMeses($meses);
		
		
			/*
		$expedientes = DB::select(DB::Raw("Select asignacion_caso.fecha_asig,
		 expedientes.id , expid , expedientes.expidnumberest, if(expedientes.exphechos!='',1,0) as exphechos, if(expedientes.exprtaest!='',1,0) as exprtaest, asignacion_caso.id as asig_caso_id, exptipoproce_id from expedientes
		 join asignacion_caso on asignacion_caso.asigexp_id = expedientes.expid
		 where expedientes.expidnumberest = asignacion_caso.asigest_id and (expestado_id != 5 and expestado_id != 2) and fecha_asig <= '".$datesql."'"));
        */


		 $expedientes = DB::select(DB::Raw("Select asignacion_caso.fecha_asig,
		 expedientes.id , expid , expedientes.expidnumberest, if(expedientes.exphechos!='',1,0) as exphechos, if(expedientes.exprtaest!='',1,0) as exprtaest, asignacion_caso.id as asig_caso_id, exptipoproce_id, expestado_id from expedientes
		 join asignacion_caso on asignacion_caso.asigexp_id = expedientes.expid join `users` on expedientes.expidnumberest = users.idnumber join sede_expedientes on expedientes.id = sede_expedientes.expediente_id
		 where expedientes.expidnumberest = asignacion_caso.asigest_id and (expestado_id != 5 and expestado_id != 2) and fecha_asig <= '".$datesql."' and sede_expedientes.sede_id=".session('sede')->id_sede ));
		 
		
		 $docente_id = \Auth::user()->idnumber;
		 $exps=[];
		 
		foreach ($expedientes as $key => $expediente) {

			
			if ($expediente->exphechos == 0 || $expediente->exprtaest == 0 ) {
				// se registra un cero cuando no tierne informacion en datos del caso

				$data = [ 
					'ntaaplicacion'=>0,
					'ntaconocimiento'=>0,
					'ntaetica'=>0,   
					'ntaconcepto'=>'Sin información de hechos o respuesta del caso  '.date('Y-m-d'),
					'orgntsid'=>4,
					'segid'=>$segmento->id,
					'perid'=>$segmento->perid,
					'tpntid'=>2,
					'expidnumber'=>$expediente->expid,
					'estidnumber'=>$expediente->expidnumberest,
					'docidnumber'=>$docente_id,
					'tbl_org_id'=>$expediente->id,
				  ]; 

				 $this->Asignotasnewdatos($data);
			} else {
				//cuanto tiempo paso al llenar la informacion desde asignado el caso
				$historial = HistorialDatosCaso::where('hisdc_expidnumber',$expediente->expid)
				->join('users', 'users.idnumber','=','historial_datos_casos.hisdc_idnumberest_id')
				->join('asignacion_caso', 'asignacion_caso.asigexp_id','=','historial_datos_casos.hisdc_expidnumber')
				->select('historial_datos_casos.created_at','fecha_asig')
				->whereDate('fecha_asig', '>=', $segmento->fecha_inicio)
				->orderBy('historial_datos_casos.created_at', 'ASC')
				->first();
				if ($historial) {
					$datehistor=Carbon::parse($historial->created_at);
					$dateasig=Carbon::parse($historial->fecha_asig);
					if ($dateasig->diffInDays($datehistor) > 5) {
						$data = [ 
							'ntaaplicacion'=>0,
							'ntaconocimiento'=>0,
							'ntaetica'=>0,   
							'ntaconcepto'=>'Demora en colocar información en datos del caso  '.date('Y-m-d'),
							'orgntsid'=>4,
							'segid'=>$segmento->id,
							'perid'=>$segmento->perid,
							'tpntid'=>2,
							'expidnumber'=>$expediente->expid,
							'estidnumber'=>$expediente->expidnumberest,
							'docidnumber'=>$docente_id,
							'tbl_org_id'=>$expediente->id,
						  ]; 
		
						 $this->Asignotasnewdatos($data);
						
					}
				}

			}
			$asigdocencaso=AsigDocenteCaso::where(['asig_caso_id'=> $expediente->asig_caso_id, 'activo'=>'1'])->first();
			if(!$asigdocencaso){
				$data = [ 
					'ntaaplicacion'=>0,
					'ntaconocimiento'=>0,
					'ntaetica'=>0,   
					'ntaconcepto'=>'No tiene docente asignado '.date('Y-m-d'),
					'orgntsid'=>4,
					'segid'=>$segmento->id,
					'perid'=>$segmento->perid,
					'tpntid'=>2,
					'expidnumber'=>$expediente->expid,
					'estidnumber'=>$expediente->expidnumberest,
					'docidnumber'=>$docente_id,
					'tbl_org_id'=>$expediente->id,
				  ]; 

				 $this->Asignotasnewdatos($data);
				
			}
			if($expediente->exptipoproce_id != '1'){
				$actuaciones = Actuacion::where([
					['actexpid',$expediente->expid],
					['created_at','>',$segmento->fecha_inicio]
					])->get() ;
			
					if(count($actuaciones)<=0){
						$data = [ 
							'ntaaplicacion'=>0,
							'ntaconocimiento'=>0,
							'ntaetica'=>0,   
							'ntaconcepto'=>'No tiene actuaciones '.date('Y-m-d'),
							'orgntsid'=>4,
							'segid'=>$segmento->id,
							'perid'=>$segmento->perid,
							'tpntid'=>2,
							'expidnumber'=>$expediente->expid,
							'estidnumber'=>$expediente->expidnumberest,
							'docidnumber'=>$docente_id,
							'tbl_org_id'=>$expediente->id,
						  ]; 
		
						 $this->Asignotasnewdatos($data);
						
					} else {
						//tiene actuaciones por cada mes?
						$actuacionsmes = DB::select(DB::Raw("SELECT MONTH(created_at) FROM actuacions WHERE actexpid = '".$expediente->expid."' AND created_at >= '$segmento->fecha_inicio' GROUP BY 1"));
						if(count($actuacionsmes) < count($mess)){
							$data = [ 
								'ntaaplicacion'=>0,
								'ntaconocimiento'=>0,
								'ntaetica'=>0,   
								'ntaconcepto'=>'No tiene actuaciones o anexos requeridos a lo largo del corte '.date('Y-m-d'),
								'orgntsid'=>4,
								'segid'=>$segmento->id,
								'perid'=>$segmento->perid,
								'tpntid'=>2,
								'expidnumber'=>$expediente->expid,
								'estidnumber'=>$expediente->expidnumberest,
								'docidnumber'=>$docente_id,
								'tbl_org_id'=>$expediente->id,
							  ]; 
			
							 $this->Asignotasnewdatos($data);
							
						}
					
						//cuanto se demoro al subir la primera actuacion o anexo
						$actuacions = Actuacion::where('actexpid',$expediente->expid)
						->join('users', 'users.idnumber','=','actidnumberest')
						->join('asignacion_caso', 'asignacion_caso.asigexp_id','=','actuacions.actexpid')
						->select('actuacions.created_at','fecha_asig')
						->whereDate('fecha_asig', '>=', $segmento->fecha_inicio)
						->orderBy('actuacions.created_at', 'ASC')
						->first();
						if ($actuacions) {
							$dateactua=Carbon::parse($actuacions->created_at);
							$dateasig=Carbon::parse($actuacions->fecha_asig);
							if ($dateasig->diffInDays($dateactua) > 8) {
								$data = [ 
									'ntaaplicacion'=>0,
									'ntaconocimiento'=>0,
									'ntaetica'=>0,   
									'ntaconcepto'=>'Demora de más de 30 dias en realizar una actuación o anexo '.date('Y-m-d'),
									'orgntsid'=>4,
									'segid'=>$segmento->id,
									'perid'=>$segmento->perid,
									'tpntid'=>2,
									'expidnumber'=>$expediente->expid,
									'estidnumber'=>$expediente->expidnumberest,
									'docidnumber'=>$docente_id,
									'tbl_org_id'=>$expediente->id,
								  ]; 
				
								 $this->Asignotasnewdatos($data);
								
							}
						}
		
					
		
					}
					



			} 

			if($expediente->exptipoproce_id ==  1) {
				$expedientemodel=Expediente::where('expid', $expediente->expid)->first();
				$days = $expedientemodel->getDaysOrColorForClose('dias',true);
			  
				if($days<=0 || $days===true) {   
				 
				  if($expedientemodel->expestado_id != 5 AND $expedientemodel->expestado_id != 2){
				$notas =  $expedientemodel->get_has_nota_final();
			   
				if (count($notas) <= 0) {
				  $data = [
						  'ntaaplicacion'=>0,
						  'ntaconocimiento'=>0,
						  'ntaetica'=>0,
						  'ntaconcepto'=>'Evaluado por el sistema - Tiempo 30 días agotado',
						  'orgntsid'=>'4',
						  'segid'=>$segmento->id,
						  'perid'=>$segmento->perid,
						  'tpntid'=>'1',
						  'expidnumber'=>$expedientemodel->expid,
						  'estidnumber'=>$expedientemodel->expidnumberest,
						  'docidnumber'=>\Auth::user()->idnumber, 
						  'tbl_org_id'=>$expedientemodel->id, 
						]; 
						$expedientemodel->asignarNotas($data);
						$expedientemodel->expestado_id = 5;
						$expedientemodel->save();
				}
				}
			  }
		
		
		
			  }


		}
		

			$segmento->est_evaluado = 1;
      $segmento->save();

			$segmentos = $this->getSegmentos();
			$view = view('myforms.frm_segmentos_list_ajax',compact('segmentos'))->render();

			return response()->json(['saved'=>true,'view'=>$view]);
		//return redirect()->back();

	}

	private function verMeses($a){

		$f1 = new \DateTime( $a[0] );
		$f2 = new \DateTime( $a[1] );	 	 
		// obtener la diferencia de fechas
		$d = $f1->diff($f2);
		$difmes =  $d->format('%m');
		$fechas = [];	 
		$impf = $f1;
		for($i = 1; $i <= $difmes; $i++){
			// despliega los meses
			$impf->add(new \DateInterval('P1M'));
			$fechas[] =  $impf->format('d-m-Y');
		}
		return $fechas;
	 }
	 private function Asignotasnew($request){

		Nota::create([
                                    
			'nota'=>$request['ntaetica'], //cotrte1
			'cptnotaid'=>3, //competencia
			'orgntsid'=> $request['orgntsid'], //expedientes
			'segid'=> $request['segid'],//id tabla asignaciones
			'tpntid'=> $request['tpntid'],
			'perid'=> $request['perid'],//id tabla procedencia
		 'estidnumber'=> $request['estidnumber'],                                    
			'expidnumber'=> $request['expidnumber'],
			'docidnumber'=> $request['docidnumber'],
			'tbl_org_id'=> $request['tbl_org_id'],
		 ]);
Nota::create([
			
			'nota'=>$request['ntaconcepto'], //cotrte1
			'cptnotaid'=>4, //competencia
			'orgntsid'=> $request['orgntsid'], //expedientes
			'segid'=> $request['segid'],//id tabla asignaciones
			'tpntid'=> $request['tpntid'],
			'perid'=> $request['perid'],//id tabla procedencia
			'estidnumber'=> $request['estidnumber'],                                    
			'expidnumber'=> $request['expidnumber'],
			'docidnumber'=> $request['docidnumber'],
			'tbl_org_id'=> $request['tbl_org_id'],
		 ]);
	 } 
	 private function Asignotasnewdatos($request){
		Nota::create([
                                    
			'nota'=>$request['ntaconocimiento'], //cotrte1
			'cptnotaid'=>1, //competencia
			'orgntsid'=> $request['orgntsid'], //expedientes
			'segid'=> $request['segid'],//id tabla asignaciones
			'tpntid'=> $request['tpntid'],
			'perid'=> $request['perid'],//id tabla procedencia
		 'estidnumber'=> $request['estidnumber'],                                    
			'expidnumber'=> $request['expidnumber'],
			'docidnumber'=> $request['docidnumber'],
			'tbl_org_id'=> $request['tbl_org_id'],
		 ]);
		Nota::create([
                                    
			'nota'=>$request['ntaaplicacion'], //cotrte1
			'cptnotaid'=>2, //competencia
			'orgntsid'=> $request['orgntsid'], //expedientes
			'segid'=> $request['segid'],//id tabla asignaciones
			'tpntid'=> $request['tpntid'],
			'perid'=> $request['perid'],//id tabla procedencia
		 'estidnumber'=> $request['estidnumber'],                                    
			'expidnumber'=> $request['expidnumber'],
			'docidnumber'=> $request['docidnumber'],
			'tbl_org_id'=> $request['tbl_org_id'],
		 ]);

		 Nota::create([
                                    
			'nota'=>$request['ntaetica'], //cotrte1
			'cptnotaid'=>3, //competencia
			'orgntsid'=> $request['orgntsid'], //expedientes
			'segid'=> $request['segid'],//id tabla asignaciones
			'tpntid'=> $request['tpntid'],
			'perid'=> $request['perid'],//id tabla procedencia
		 'estidnumber'=> $request['estidnumber'],                                    
			'expidnumber'=> $request['expidnumber'],
			'docidnumber'=> $request['docidnumber'],
			'tbl_org_id'=> $request['tbl_org_id'],
		 ]);
Nota::create([
			
			'nota'=>$request['ntaconcepto'], //cotrte1
			'cptnotaid'=>4, //competencia
			'orgntsid'=> $request['orgntsid'], //expedientes
			'segid'=> $request['segid'],//id tabla asignaciones
			'tpntid'=> $request['tpntid'],
			'perid'=> $request['perid'],//id tabla procedencia
			'estidnumber'=> $request['estidnumber'],                                    
			'expidnumber'=> $request['expidnumber'],
			'docidnumber'=> $request['docidnumber'],
			'tbl_org_id'=> $request['tbl_org_id'],
		 ]);
	 } 
	 


}
