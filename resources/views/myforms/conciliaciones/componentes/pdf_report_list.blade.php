@foreach($reportes as $key => $reporte)
<tr> 
   
    <td>
    <i class="fa fa-file-pdf-o"> </i>

    {{$reporte->reporte->nombre_reporte}}
    </td>
    <td>
   <a class="btn btn-warning btn-sm pull-right" target="_blank" href="/pdf/reportes/generate/{{$conciliacion->id}}/{{$reporte->reporte->id}}/{{ $reporte->status_id}}">
    Vista previa </a> 
    </td>
    @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
    || ((currentUserInConciliacion($conciliacion->id,['autor','conciliador','asistente']))))
    <td>
    <a href="/pdf/reportes/editar/temporal/{{$reporte->reporte->id}}/{{$conciliacion->id}}/{{ $reporte->status_id}}" class="btn_edit_con_pdf btn btn-primary btn-sm pull-right " data-id="45" id="btn_edcpdf_45">Editar</a>
    </td> 
    @endif
    <td>        
    </td>
    <td colspan="3">
        <button  data-estado_id="{{$reporte->id}}" class="btn btn-success btn-sm  btn_asignar_firmantes"> Asignar firmantes</button>
    </td>
    {{-- <td>
        <button  data-estado_id="{{$reporte->id}}" class="btn btn-danger btn-sm  btn_asignar_firmantes"> Asignar firmantes</button>
 
    </td> --}}
    </tr>
@endforeach

