@extends('layouts.dashboard')
@section('titulo_area')

@if(currentuser()->can('crear_conciliaciones'))
<a href="/conciliaciones/create" class="btn btn-success">Nueva conciliación</a>
@endif          
@endsection
@section('area_forms')

@include('msg.success')

<div class="row">
<div class="col-md-12 table-responsive no-padding">

<table class="table">
<thead>
    <th>
        Número
    </th>
    <th>
        Solicitante
    </th>
   
    <th>
        Tipo
    </th>
    <th>
        Estado
    </th>
    <th>
        Fecha
    </th>
    <th>
        Acciones
    </th>
</thead>
<tbody>
    @foreach($conciliaciones as $key => $conciliacion)
    <tr>
        <td>
            {{$conciliacion->num_conciliacion}}
        </td>
        <td>
            @if(count($conciliacion->usuarios()->where('tipo_usuario_id',185)->get())>0)
            {{$conciliacion->usuarios()->where('tipo_usuario_id',185)->first()->name}}
            @else
            Sin usuarios
            @endif
        </td>
      
        <td>
            {{$conciliacion->categoria->ref_nombre}}
        </td>
        <td>
            <span class="badge bg-{{$conciliacion->estado->color}}">{{$conciliacion->estado->ref_nombre}}</span> 
        </td>
        
        <td>
            {{getSmallDateWithHour($conciliacion->created_at)}}
        </td>
        <td>
            <a href="/conciliaciones/{{$conciliacion->id}}/edit" class="btn btn-primary">Editar</a>
        </td>
    </tr>
    @endforeach
   
</tbody>
</table>

{{ $conciliaciones->appends(request()->query())->links() }}
</div>
</div>

              @stop