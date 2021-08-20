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
    
    public function turno(){           
    
        //return $this->hasMany('App\Turno','trnid_estudent','idnumber');
        return $this->hasOne('App\Turno', 'trnid_estudent', 'idnumber');

    }

    public function notas()
    {
        return $this->hasMany(NotaExt::class, 'estidnumber', 'idnumber');
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
        dd($casos_solicitados[0]->asignacion_estudiante);
        
    }

    }


