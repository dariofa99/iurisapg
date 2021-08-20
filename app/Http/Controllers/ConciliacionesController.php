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
use Storage;

class ConciliacionesController extends Controller
{
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

        /* 
    		$cursando = TablaReferencia::where(['categoria'=>'cursando','tabla_ref'=>'turnos'])->pluck('ref_nombre','id');
    		$ref_color = TablaReferencia::where(['categoria'=>'color','tabla_ref'=>'turnos'])->pluck('ref_nombre','id');
    		$ref_horarios = TablaReferencia::where(['categoria'=>'horario','tabla_ref'=>'turnos'])->pluck('ref_nombre','id');
           // $oficinas = Oficina::pluck('nombre','id');
            $dias = TablaReferencia::where(['categoria'=>'dias_turno','tabla_ref'=>'turnos'])->pluck('ref_nombre','id');
            
            $estudiantes = $this->getEstudiantes();
 

    		$turnos = Turno::orderBy('trnid_color','asc')->get();
    		$data_search='';

    		if (isset($request->data_search) and !$request->ajax()) {
    		    $data_search = $request->data_search;
 
    		$colores = DB::table('turnos')
    		->join('users','users.idnumber','=','turnos.trnid_estudent')
    		->select(
    			DB::raw('SUM(if(trnid_color = "105", 1, 0)) AS amarillo'),
    			DB::raw('SUM(if(trnid_color = "106", 1, 0)) AS azul'),
    			DB::raw('SUM(if(trnid_color = "107", 1, 0)) AS verde'),
    			DB::raw('SUM(if(trnid_color = "108", 1, 0)) AS gris'),
    			DB::raw('SUM(if(trnid_color = "109", 1, 0)) AS rojo'),
                DB::raw('SUM(if(trnid_color = "120", 1, 0)) AS morado')
    		)
            ->where('users.cursando_id',$request->data_search)->get();
            
            $colores = (object)$colores;

//dd($turnos);
    		}elseif(!$request->ajax()){
                $colores = DB::table('turnos')
            ->join('users','users.idnumber','=','turnos.trnid_estudent')
            ->select(
                DB::raw('SUM(if(trnid_color = "105", 1, 0)) AS amarillo'),
                DB::raw('SUM(if(trnid_color = "106", 1, 0)) AS azul'),
                DB::raw('SUM(if(trnid_color = "107", 1, 0)) AS verde'),
                DB::raw('SUM(if(trnid_color = "108", 1, 0)) AS gris'),
                DB::raw('SUM(if(trnid_color = "109", 1, 0)) AS rojo'),
                DB::raw('SUM(if(trnid_color = "120", 1, 0)) AS morado')
            )->get();
            }

        if ($request->ajax()) {
            if ($request->data_search!='all' and !empty($request->data_search)) {
            $estudiantes = $this->getEstudiante($request);
            }
//return response()->json($estudiantes);
           /*  return view('myforms.frm_turnos_students_list_ajax',compact('estudiantes'))->render(); 
        }

    	 


        $conciliaciones = Conciliacion::orderBy('created_at','asc')->paginate(10);
    		/* return  view('myforms.conciliaciones.frm_list_turnos',[
                'dias'=>$dias,
                'oficinas'=>$oficinas,
                'ref_horarios'=>$ref_horarios,
                'ref_color'=>$ref_color,'turnos'=>$turnos,
                'cursando'=>$cursando,'colores'=>$colores,
                'data_search'=>$data_search,'estudiantes'=>$estudiantes,
                'conciliaciones'=>$conciliaciones]); 
    
            */
        $conciliaciones = Conciliacion::all();
        return view('myforms.conciliaciones.index',compact('conciliaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd('puta');
        $conciliacion = Conciliacion::create([
            'fecha_cita'=>date('Y-m-d'),
            'hora_inicio'=>'10:00',
            'categoria_id'=>175,
            'estado_id'=>177,  
           
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
    public function edit($id)
    {
        $conciliacion = Conciliacion::find($id);
        return view('myforms.conciliaciones.edit',compact('conciliacion'));
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
       
        $request['user_id'] = \Auth::user()->id;       
        $comentario = ConciliacionEstado::create($request->all());
        $conciliacion = Conciliacion::find($request->conciliacion_id);
        $conciliacion->estado_id = $request->type_status_id;
        $conciliacion->save();
        $view = view('myforms.conciliaciones.componentes.solicitud_estados_ajax',compact('conciliacion'))->render();
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
        
        $view = view('myforms.conciliaciones.componentes.solicitud_estados_ajax',compact('conciliacion'))->render();
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
       
} 
