<?php
namespace App\Repositories;

use App\Services\UsersService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersRepository extends BaseRepository implements UsersService{
   
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getUsersByRoleName($role) : Array {

        $user = $this->model->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
        ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
        ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
        ->leftjoin('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
        ->leftjoin('referencias_tablas' , 'referencias_tablas.id','=','users.cursando_id')
        ->where ('roles.name', $role)
        ->where ('users.active', true)
        ->where('sedes.id_sede',session('sede')->id_sede)
        ->select('users.active','users.id','ref_nombre','users.idnumber',
          DB::raw('CONCAT(users.name," ",users.lastname) as full_name')
          ,'role_user.role_id', 'roles.display_name')
          ->orderBy('users.created_at', 'desc')->get();

        return $user->toArray();
    }

    
    public function getUsersByPermissionName($permission) : Collection{

      $users = User::join('role_user as ru', 'users.id','=', 'ru.user_id')
        ->join('roles','roles.id','=','ru.role_id')
        ->join('permission_role','permission_role.role_id','=','roles.id')
        ->join('permissions','permissions.id','=','permission_role.permission_id')
        //->where('users.type_status_id','<>',15)
        ->where('permissions.name',$permission)
        ->select("users.id",'users.email','users.name')
        ->get();

        return $users;
    }

    public function getDocentes(): array
    {
         $users = DB::table('users')
         ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
         ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
         ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
         ->leftjoin('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
         ->leftjoin('referencias_tablas' , 'referencias_tablas.id','=','users.cursando_id')
         ->where ('role_id', '4' )
         ->where ('users.active', true)
         ->where('sedes.id_sede',session('sede')->id_sede)
         ->select('users.active','users.id','ref_nombre','users.idnumber',
           DB::raw('CONCAT(users.name," ",users.lastname) as full_name')
           ,'role_user.role_id', 'roles.display_name')
           ->orderBy('users.created_at', 'desc')->get();

        return $users->toArray();
    }

    public function getEstudiantes(): array
    {
        $users = DB::table('users')
        ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
        ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
        ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
        ->leftjoin('sedes','sedes.id_sede','=','sede_usuarios.sede_id')
        ->leftjoin('referencias_tablas' , 'referencias_tablas.id','=','users.cursando_id')
        ->where ('role_id', '6' )
        ->where ('users.active', true)
        ->where('sedes.id_sede',session('sede')->id_sede)
        ->select('users.active','users.id','ref_nombre','users.idnumber',
          DB::raw('CONCAT(users.name," ",users.lastname) as full_name')
          ,'role_user.role_id', 'roles.display_name')
         ->orderBy('users.created_at', 'desc')
         ->get();
         return $users->toArray(); 
    }

    public function getDocentesByRama($rama): Array {
      $doceWithRama = DB::table('users')
       ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
       ->leftjoin('roles' , 'role_user.role_id','=','roles.id')
       ->leftjoin('user_has_ramasderecho' , 'user_has_ramasderecho.user_id','=','users.id')
       ->leftjoin('rama_derecho' , 'rama_derecho.id','=','ramaderecho_id')
       ->leftjoin('sede_usuarios','sede_usuarios.user_id','=','users.id')
       ->where ('role_id', '4' )
       ->where ('rama_derecho.subrama', $rama )
       ->where ('users.active', true)
       ->where ('users.active_asignacion', true)
       ->where('sede_usuarios.sede_id',session('sede')->id_sede)
       ->select('users.id','users.idnumber')
        ->orderBy('users.created_at', 'desc')->get()->toArray();
        return $doceWithRama;
    }
}




