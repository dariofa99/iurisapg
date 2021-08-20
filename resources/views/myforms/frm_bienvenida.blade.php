@extends('layouts.dashboard')


@section('titulo_general')
Inicio
@endsection

@section('titulo_area')
Pantalla Bienvenida
@endsection


@section('area_forms')

<h2>Hola!!  {{  currentUser()->name  }}  bienvenido a <strong>Iuris </strong>!! </h2>
@if((count($sedes)>=2 and count(Auth::user()->sedes)<=0) || auth()->user()->can('cambiar_sede'))
@if(!auth()->user()->can('cambiar_sede'))
  <div class="row">
    <div class="col-md-12">
      <h3>Selecciona una sede, recuerda que este registro solo lo podras hacer una vez. <br>
      Para realizar el cambio deberás comunicarte con el administrador.</h3>
    </div>
  </div>
@endif
<div class="row">
    @foreach($sedes as $key => $sede)
    <div class="col-md-3">
        <form id="myFormCambiarSede-{{$sede->id}}" action="{{url('/change/sedes')}}" method="GET">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">{{$sede->nombre}}</div>
                <div class="panel-body">
                    <input type="hidden" name="sede_id" value="{{$sede->id}}">
                  <p>{{$sede->ubicacion}}</p>
                </div>
              <div class="panel-footer">
                  <button data-id="{{$sede->id}}" {{(session()->has('sede') and session()->get('sede')->id == $sede->id) ? 'disabled' : ''}} type="button" class="btn btn-success btn_change_sede">
                    Seleccionar
                </button>
              </div>
            </div>
        </form>      
    </div>     
    @endforeach
</div>
@elseif(count($sedes)<=0)
<div class="col-md-12">       
  <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Atención!</strong> No hay sedes disponibles..! <a href="{{route('sedes.index')}}">Crear una sede</a>
      @if(auth()->user()->can('cambiar_sede'))
<a href="{{route('sedes.index')}}">Crear una sede</a>
      @endif
    </div> 
</div>
@endif
@stop
