@foreach($conciliacion->estados as $key => $estado)
<tr>
   <td>{{$estado->type_status->ref_nombre}}</td>
   <td>{{$estado->concepto}}</td>
   <td>{{$estado->user->name}} {{$estado->user->lastname}}</td>
   <td>{{$estado->created_at}}</td>
   <td>
        <button class="btn btn-danger btn-sm btn_delete_est_con" data-id="{{$estado->id}}">Eliminar</button>
        <button class="btn btn-primary btn-sm btn_edit_est_con" data-id="{{$estado->id}}">Editar</button>
    </td>
</tr>
@endforeach