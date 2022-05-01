@foreach($conciliacion->usuarios as $key => $user)
<tr>
  
    <td>{{$user->name}} {{$user->lastname}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->tipo_conciliacion()->where('tipo_usuario_id',$user->pivot->tipo_usuario_id)->first()->ref_nombre}}</td>
    <td>{{getSmallDateWithHour($user->pivot->created_at)}}</td>
    <td>
        @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai'))))
         
        <button type="button" data-user="{{$user->idnumber}}" data-pivot="{{$user->pivot->id}}" class="btn btn-danger btn-sm btn_delete_usuario_conciliacion">  
        Eliminar
        </button> 
@endif
        @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
    || ((currentUserInConciliacion($conciliacion->id,['autor','conciliador','asistente']))))
         <button type="button" data-type="{{$user->pivot->tipo_usuario_id}}" data-user="{{$user->idnumber}}"  data-section="general" class="btn btn-primary btn-sm btn_asinar_usuario_conciliacion">  
           Actualizar
           </button>
@endif
           <button type="button" data-type="{{$user->pivot->tipo_usuario_id}}" data-user="{{$user->idnumber}}"  data-section="general" class="btn btn-success btn-sm btn_detalles_us_con">  
            Detalles
            </button>
    </td>
</tr>
@endforeach