<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Traits\AsigTurno;
use App\Traits\AsigDocEst;
use App\Traits\ColorTurnos;
use App\Traits\AsigNotasExt;

use App\Notifications\MyResetPassword;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable,AsigNotasExt; 
    use EntrustUserTrait; // add this trait to your user model
    use AsigTurno;
    use AsigDocEst;
    use ColorTurnos;
   // use MyResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    //protected $origen;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'active',
    'tipodoc_id',
    'idnumber',
    'name',
    'lastname',
    'email',
    'password',
    'accesofvir',
    'description',
    'institution',
    'tel1',
    'tel2',
    //'idrol',
    'address',
    'genero_id',
    'estrato_id',
    'estadocivil_id',
    'cursando_id',
    'fechanacimien',
    'pbesena',
    'pbepersondiscap',
    'pbevictimconflic',
    'pbeadultomayor',
    'pbeminoetnica',
    'pbemadrecomuni',
    'pbecabezaflia',
    'pbeninguna',
    'usercreated',
    'confirm_token',
    'active_asignacion',
    'userupdated',
    'datecreated'
           ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token','confirm_token'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    } 
    public function tipo_conciliacion()
    {
       return $this->belongsToMany(TablaReferencia::class,'conciliacion_has_user','user_id','tipo_usuario_id')
       ->withPivot('user_id','tipo_usuario_id','conciliacion_id')->withTimestamps();
    } 
    public function tipo_pdf_firmante()
    {
       return $this->belongsToMany(TablaReferencia::class,'pdf_reportes_users','user_id','tipo_usuario_id')
       ->withPivot('user_id','tipo_usuario_id','conciliacion_id','token','codigo')->withTimestamps();
    }  
    public function conciliaciones()
    {
       return $this->belongsToMany(Conciliacion::class,'conciliacion_has_user','user_id','conciliacion_id')
       ->withPivot('user_id','tipo_usuario_id','conciliacion_id')->withTimestamps();
    } 

    public function estado_civil()
    {
       return $this->belongsTo(TablaReferencia::class,'estadocivil_id');
    } 

    public function turno(){           
    
        //return $this->hasMany('App\Turno','trnid_estudent','idnumber');
        return $this->hasOne('App\Turno', 'trnid_estudent', 'idnumber');

    }

    public function notas()
    {
        return $this->hasMany(Nota::class, 'estidnumber', 'idnumber');
    }

    public function aditional_data()
    {
        return $this->hasMany(UserAditionalData::class, 'user_id', 'id');
    }

    public function docente_asignado(){           
    
       // return $this->hasMany('App\Asigna_docen_est','asgedidnumberest','idnumber');
        return $this->hasOne(Asigna_docen_est::class, 'asgedidnumberest', 'idnumber');

    }

    public function casos(){           
    
       // return $this->hasMany('App\Asigna_docen_est','asgedidnumberest','idnumber');
        return $this->hasMany(AsigDocenteCaso::class, 'docidnumber', 'idnumber');

    }

    public function casos_solicitados(){           
    
       // return $this->hasMany('App\Asigna_docen_est','asgedidnumberest','idnumber');
        return $this->hasMany(AsigDocenteCaso::class, 'cambio_docidnumber', 'idnumber');

    }
 
    public function curso(){           
    
       // return $this->hasMany('App\Turno','trnid_estudent','idnumber');
        return $this->hasOne('App\TablaReferencia', 'id', 'cursando_id');

    }

    public function expedientes()
    {
        return $this->hasMany(Expediente::class,'expidnumberest','idnumber');
    }

    public function asig_caso()
    {
        return $this->hasMany(AsignacionCaso::class,'asigest_id','idnumber');
    }

    public function oficinas()
    {
       return $this->belongsToMany(Oficina::class,'oficina_usuarios')
       ->withPivot('user_id','oficina_id')->withTimestamps();
    }  
 
    public function role()
    {
       return $this->belongsToMany('App\Role','role_user')->withPivot('user_id','role_id');
    }

    public function ramas_derecho()
    {
       return $this->belongsToMany('App\RamaDerecho','user_has_ramasderecho','user_id','ramaderecho_id')->withPivot('user_id','ramaderecho_id');
    }  

    public function sedes(){
        return $this->belongsToMany(Sede::class,'sede_usuarios','user_id','sede_id')
        ->withPivot('id','sede_id','user_id')->withTimestamps(); 
     }

    public function setPasswordAttribute($valor){

        if(!empty($valor)){
            $this->attributes['password']=bcrypt($valor);
        }
    }



    public function scopeCriterio($query, $data,$criterio)
    {            
           if (trim($data) != '')
        {
 
           

            switch ($criterio) { 
                case 'idnumber':
                return $query->where('users.idnumber',$data); 
                break;
                case 'name':
                return $query->orwhere(function($queryor) use ($data){
                $queryor->orwhere('users.name','like','%'.$data)
                ->orwhere('users.lastname','like','%'.$data);   
                }); 
                    break;
                case 'rol':

                   return $query->where('role_user.role_id',$data); 
                    break;    
                
            }         
            //dd($criterio);
            //$query->where('expid', $criterio);
             /*$query->where(function ($queryor)use ($data,$criterio) {
                $queryor->where($criterio,'=', $data);
                      ->where('users.name','=', $criterio)
                      ->orwhere('role_user.role_id','<>',$data);
            });*/

            // return $query;
            
        }  
    }

     public function asignaciones_docente()
    {            
       return $this->hasMany('App\Asigna_docen_est','asgedidnumberdocen','idnumber'); 
    }

     public function asignacionesEstudiante()
    {            
       return $this->hasMany('App\Asigna_docen_est','asgedidnumberest','idnumber'); 
    }

    public function solicitudes()
    {  
        //return $sol = \App\Solicitud::where('idnumber',currentUser()->idnumber)->get();          
       return $this->hasMany('App\Solicitud','idnumber','idnumber'); 
    }


    public function getDataVal($ref_id,$ref_option){
        $ref_data = $this->aditional_data()       
        ->where([ 'reference_data_id'=>$ref_id,
                'reference_data_option_id'=>$ref_option])->first();
               
        if($ref_data){
            return $ref_data;
        }
       return false;
    }

    public function getDataValWShort($short_name){
        $ref_data = $this->aditional_data()
        ->join('references_data','references_data.id','user_aditional_data.reference_data_id')
       // ->join('referencias_tablas','referencias_tablas.id','estadocivil_id')
        ->where(['short_name'=>$short_name])->first();
           //dd($ref_data)     ;
        if($ref_data){
            return $ref_data;
        }

       return false;
    }

    public function getNotificaciones($item=''){        
        switch ($item) {
            case 'casos_solicitados':
            $casos_solicitados = $this->casos_solicitados()->where('activo',1)->get();
                return $casos_solicitados;
                break;
            
            default:
              return [];
                break;
        }
      ///  dd($casos_solicitados[0]->asignacion_estudiante);
        
    }

    public function getNotas($request){
        $notas = $this->notas()
        ->whereDate('notas.created_at','>','2021-10-17')
        ->where(function($query) use ($request){
                if($request->has('segid') and $request->segid != ''){
                        return $query->where('segid',$request->segid);
                }
        })
   
        ->orderBy('notas.created_at','desc')
       // ->orderBy('notas.orgntsid','desc')
       // ->orderBy('notas.cptnotaid','asc')
        
        ->get();


      //  dd($notas);



        $response=[];
        $origen = [];
        if(count($notas)>0){
         
            foreach ($notas as $key => $nota) { 
                if(!isset($origen[$nota->tbl_org_id])){
                    $origen[$nota->tbl_org_id] = [                
                       // "tabla"=>$nota->tbl_org_id,
                        
                    ]; 
                }
               
               

                 $data = [
                       'id'=> $nota->id,
                       'nota'=>$nota->nota,
                       'expediente'=> $nota->expidnumber,
                       'tipo'=>$nota->tipo_nota->tpntnombre,
                       'tipo_id'=>$nota->tipo_nota->id,
                       'concepto_nota'=>$nota->concepto->cpntnombre,
                       'concepto_nota_id'=>$nota->concepto->id,
                       'origen_nota'=>$nota->origen->orgntsnombre,
                       'docidnumber'=>$nota->docidnumber, 
                       'docevname'=>$nota->docente_eva->name.' '.$nota->docente_eva->lastname, 
                       'estidnumber'=>$nota->estidnumber,
                       'periodo'=>$nota->periodo->prddes_periodo,
                       'segmento'=>$nota->segmento->segnombre, 
                       'segmento_id'=>$nota->segmento->id,  
                       'created_at'=>Carbon::parse($nota->created_at), 
                      'updated_at'=>Carbon::parse($nota->updated_at),                 
                     ];
   
                 if ($nota->cptnotaid==1){
                       $n_conocimiento[] = $data;
                       ($origen[$nota->tbl_org_id][] = [
                        'id'=>$data['id'],
                        'nota'=>$data['nota'],
                        'expediente'=>$data['expediente'],
                        'tipo'=>$data['tipo'],
                        'tipo_id'=>$data['tipo_id'],
                        'concepto_nota'=>$data['concepto_nota'],
                        'concepto_nota_id'=>$data['concepto_nota_id'],
                        'origen_nota'=>$data['origen_nota'],
                        'docidnumber'=>$data['docidnumber'], 
                        'docevname'=>$data['docevname'], 
                        'estidnumber'=>$data['estidnumber'],
                        'periodo'=>$data['periodo'],
                        'segmento'=>$data['segmento'],
                        'segmento_id'=>$data['segmento_id'], 
                        'created_at'=>$data['created_at'], 
                        'updated_at'=>$data['updated_at'],           
                       ]
                    );
               
                 } 
                  if ($nota->cptnotaid==2){
                   $n_aplicacion[] =  $data;
                   $origen[$nota->tbl_org_id][] = [
                    'nota'=>$data['nota'],
                    'id'=>$data['id'],
                    'expediente'=>$data['expediente'],
                    'tipo'=>$data['tipo'],
                    'tipo_id'=>$data['tipo_id'],
                    'concepto_nota'=>$data['concepto_nota'],
                    'concepto_nota_id'=>$data['concepto_nota_id'],
                    'origen_nota'=>$data['origen_nota'],
                    'docidnumber'=>$data['docidnumber'],
                    'docevname'=>$data['docevname'],
                    'estidnumber'=>$data['estidnumber'],
                    'periodo'=>$data['periodo'],
                    'segmento'=>$data['segmento'],  
                    'segmento_id'=>$data['segmento_id'], 
                    'created_at'=>$data['created_at'], 
                    'updated_at'=>$data['updated_at'], 
    
                   ];
         

                
                  } 
                  if ($nota->cptnotaid==3){
                   $n_etica[] =  $data;
                   if($nota->orgntsid == 3){
                       $ind = 0;
                   }else{
                    $ind = 2;
                   }
                   $origen[$nota->tbl_org_id][] = [
                        'nota'=>$data['nota'],
                        'id'=>$data['id'],
                        'expediente'=>$data['expediente'],
                        'tipo'=>$data['tipo'],
                        'tipo_id'=>$data['tipo_id'],
                        'concepto_nota'=>$data['concepto_nota'],
                        'concepto_nota_id'=>$data['concepto_nota_id'],
                        'origen_nota'=>$data['origen_nota'],
                        'docidnumber'=>$data['docidnumber'],
                        'docevname'=>$data['docevname'],
                        'estidnumber'=>$data['estidnumber'],
                        'periodo'=>$data['periodo'],
                        'segmento'=>$data['segmento'], 
                        'segmento_id'=>$data['segmento_id'], 
                        'created_at'=>$data['created_at'], 
                        'updated_at'=>$data['updated_at'],
                    ];

             
                  
                  }
                  if ($nota->cptnotaid==4){
                   $n_concepto[] =  $data;
                   if($nota->orgntsid == 3){
                    $ind = 1;
                }else{
                 $ind = 3;
                }
                $origen[$nota->tbl_org_id][]  = [
                        'nota'=>$data['nota'],
                        'id'=>$data['id'],
                        'expediente'=>$data['expediente'],
                        'tipo'=>$data['tipo'],
                        'tipo_id'=>$data['tipo_id'],
                        'concepto_nota'=>$data['concepto_nota'],
                        'concepto_nota_id'=>$data['concepto_nota_id'],
                        'origen_nota'=>$data['origen_nota'],
                        'docidnumber'=>$data['docidnumber'],
                        'docevname'=>$data['docevname'],
                        'estidnumber'=>$data['estidnumber'],
                        'periodo'=>$data['periodo'],
                        'segmento'=>$data['segmento'], 
                        'segmento_id'=>$data['segmento_id'], 
                        'created_at'=>$data['created_at'], 
                        'updated_at'=>$data['updated_at'],
                ];

                
              
            } 
            
           }
        }
          return $origen;

    }


    }


