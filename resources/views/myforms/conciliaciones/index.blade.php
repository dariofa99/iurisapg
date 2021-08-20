@extends('layouts.dashboard')
@section('titulo_area')

<a href="/conciliaciones/create" class="btn btn-success">Nueva conciliación</a>
            
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
        Estado
    </th>
    <th>
        Tipo
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
            {{$conciliacion->id}}
        </td>
        <td>
            {{$conciliacion->estado->ref_nombre}}
        </td>
        <td>
            {{$conciliacion->categoria->ref_nombre}}
        </td>
        <td>
            {{$conciliacion->created_at}}
        </td>
        <td>
            <a href="/conciliaciones/{{$conciliacion->id}}/edit" class="btn btn-primary">Editar</a>
        </td>
    </tr>
    @endforeach
   
</tbody>
</table>

</div>
</div>

              @stop