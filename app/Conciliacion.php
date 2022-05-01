<?php

namespace App;

use App\Http\Controllers\ConcHechosPretencionesController;
use Illuminate\Database\Eloquent\Model;
use App\ReferencesStaticData;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\DB;

class Conciliacion extends Model
{
    use UploadFile;

    public $disk = 'conciliacion_files';
    protected $table = 'conciliaciones';

    protected $fillable = [
        'fecha_cita',
        'num_conciliacion',
        'auto_admisorio',
        'estado_id',
        'categoria_id',
        'periodo_id',
        'user_id'
        
    ];

    public function usuarios()
    {
       return $this->belongsToMany(User::class,'conciliacion_has_user','conciliacion_id')
       ->withPivot('user_id','tipo_usuario_id','conciliacion_id','id')->withTimestamps();
    } 

    public function user()
    {
       return $this->belongsTo(User::class,'user_id');
    } 
    
    public function aditional_static_data()
    {
        return $this->hasMany(ConciliationAditionalStaticData::class, 'conciliacion_id', 'id');
    }
    public function estados()
    {
        return $this->hasMany(ConciliacionEstado::class, 'conciliacion_id', 'id');
    }

    public function comentarios()
    {
        return $this->hasMany(ConciliacionComentario::class, 'conciliacion_id', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(TablaReferencia::class, 'estado_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(TablaReferencia::class, 'categoria_id', 'id');
    }
 
    public function hechos_pretensiones()
    {
        return $this->hasMany(ConcHechosPretenciones::class, 'conciliacion_id', 'id');
    }

    public function getUserForm($parte,$section)
    {
        $referece_data = DB::table('conciliacion_user_form')
        ->join('references_data as rd','rd.id','=','conciliacion_user_form.reference_data_id')
        ->join('referencias_tablas as rt','rt.id','=','rd.type_data_id')
        ->where('parte',$parte)
        ->where('section',$section)
        ->get();
      // dd( $referece_data);

       return $referece_data ;
    }

    public function getUserQueForm($parte,$section)
    {
        //$referece_data = DB::table('conciliacion_user_form')
        $referece_data = ReferencesData::join('conciliacion_user_form  as rd','rd.reference_data_id','=','references_data.id')
        ->join('referencias_tablas as rt','rt.id','=','references_data.type_data_id')
        ->select('references_data.id as id','references_data.name as name','references_data.type_data_id as type_data_id'
        ,'references_data.type_data_id as type_data_id','short_name')
        ->where('parte',$parte)
        ->where('section',$section) 
        ->get();

      /*   $referece_data = ReferencesData::where([
			'section' => 'datos_personales', 
			'table'=>'conciliaciones'
			])->get();  */

        /* foreach ($referece_data as $key => $value) {
            echo $value->options;
        }
       dd( $referece_data); */

       return $referece_data ;
    }
    
    public function files(){
        return $this->belongsToMany(File::class,'conciliacion_has_files','conciliacion_id')
        ->withPivot('id','concepto','file_id','type_status_id')->withTimestamps(); 
     }  



    public function getStaticDataVal($name,$section,$option_id=null){
        $ref_data = ReferencesStaticData::where(['name'=>$name,'section'=>$section])->first();
    //  dd( $ref_data);
        if ($ref_data) {           
            $data = $this->aditional_static_data()
            ->where([
                'reference_data_id'=>$ref_data->id,
                'reference_data_option_id'=>$option_id == null ? $ref_data->options[0]->id : $option_id
                    ])->first();
                    
                   // dd( $data);
            if($data){
                return $data;
            }
        }
        ;
       return false;
    }

    public function getStaticDataLabel($name,$section){
        $ref_data = ReferencesStaticData::where(['name'=>$name,'section'=>$section])->first();
      //dd( $ref_data->options[0]);
        if ($ref_data) {       
                return $ref_data;            
        }
       return false;
    }

    public function getUser($tipo_usuario){
      $user =  $this->usuarios()->where('tipo_usuario_id',$tipo_usuario)->first();
    //  dd($user);
        if(!$user){ 
            $user = new User();
        }
      
    return $user;

    }
}
