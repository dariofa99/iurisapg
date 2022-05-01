@foreach($conciliacion->comentarios as $key => $comentario)
<tr>
   <td>{{$comentario->comentario}}</td>
   <td>{{$comentario->user->name}} {{$comentario->user->lastname}}</td>
   <td>{{$comentario->created_at}}</td>
   <td>
       @if(currentUser()->hasRole('diradmin'))
       <button class="btn btn-danger btn-sm btn_delete_com_con" data-id="{{$comentario->id}}">Eliminar</button>
       
       @endif
        @if(currentUserInConciliacion($conciliacion->id,['autor']))
        <button class="btn btn-primary btn-sm btn_edit_com_con" data-id="{{$comentario->id}}">Editar</button>

        @endif
           </td>
</tr>
@endforeach