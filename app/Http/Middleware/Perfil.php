<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Hash;


class Perfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = \Auth::user();
        $user->role;
        if ($user->role[0]['name']=='estudiante') {

            if (!$user->active) { 
                \Auth::logout();
              Session::flash('message-danger', 'Tu cuenta no esta activa, comunicate con el administrador del sistema.');
              return redirect()->back();
            } 
            $correo=explode("@", $user->email);
          if(isset($correo[1])){
            if (($user->tel1=='' and $user->tel2 =='') || $user->tipodoc_id=='1' || $user->idnumber=='' || $user->name =='' || $user->lastname=='' || $user->fechanacimien=='' || $user->address==''  || $correo[1]=='mail.com' || $user->cursando_id=='1'  ) {
            Session::flash('message-danger', 'Recuerda! Primero necesitamos que actualices tu información personal, Correo, contraseña y curso.');
            return redirect('users/'.$user->id.'/edit');
                       
           }elseif(Hash::check('udenarcj',$user->password)){
           Session::flash('message-danger', 'Recuerda! Falta actualizar la contraseña.');
             return redirect('users/'.$user->id.'/edit');             
           }
          } else {
            Session::flash('message-danger', 'Error! Recuerda escribir un correo electrónico valido, ya que se enviará una confirmación.');
            return redirect('users/'.$user->id.'/edit');
          }
        }
        return $next($request);
       
        

        
    }
}
