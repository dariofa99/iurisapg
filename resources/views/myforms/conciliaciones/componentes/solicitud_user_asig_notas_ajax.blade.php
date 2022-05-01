@foreach($conciliacion->usuarios as $key => $user)
@if($user->hasRole("estudiante"))
<tr>
  
    <td>{{$user->name}} {{$user->lastname}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->tipo_conciliacion()->where('tipo_usuario_id',$user->pivot->tipo_usuario_id)->first()->ref_nombre}}</td>
    <td>{{getSmallDateWithHour($user->pivot->created_at)}}</td>
    <td>
      @if(((currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai'))))
      
        <button type="button" data-user="{{$user->idnumber}}" data-pivot="{{$user->pivot->id}}" class="btn btn-sm {{count($user->notas()->where('tbl_org_id',$conciliacion->id)->get()) > 0 ? 'btn_edit_notas btn-warning' : 'btn_add_usuario_notas btn-primary'}} ">  
          {{count($user->notas()->where('tbl_org_id',$conciliacion->id)->get()) > 0 ? 'Ver notas' : ' Agregar notas'}} 
        </button> 
     
            @if(count($user->notas()->where('tbl_org_id',$conciliacion->id)->get()) > 0)
           <button type="button" data-user="{{$user->idnumber}}" data-pivot="{{$user->pivot->id}}"  data-section="general" class="btn btn-danger btn-sm btn_delete_notas_con">  
            Eliminar
            </button>
            @endif
      @endif   
    </td>
</tr>
@endif
@endforeach