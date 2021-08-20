@extends('layouts.dashboard')
@section('titulo_area')

            <label >
                @if($conciliacion->getStaticDataLabel('fecha','parte_solicitante'))
                {{$conciliacion->getStaticDataLabel('fecha','parte_solicitante')->display_name}}
                @endif
            </label>
         
            <input class="form-control form-control-sm insert_adv_change" data-section="parte_solicitante" data-name="fecha" required  type="date"
            @if($conciliacion->getStaticDataVal('fecha','parte_solicitante')) value="{{$conciliacion->getStaticDataVal('fecha','parte_solicitante')->value}}" @endif>
    
@endsection
@section('area_forms')

@include('msg.success')
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Información de Solicitud</a></li>
            <li><a data-toggle="tab" href="#menu1">Comentarios</a></li>
            <li><a data-toggle="tab" href="#menu2">Estado de la solicitud</a></li>
            <li><a data-toggle="tab" href="#menu3">Asignaciones</a></li>
          </ul>
          
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              @include('myforms.conciliaciones.solicitud_form')
            </div>
            <div id="menu1" class="tab-pane fade">
                @include('myforms.conciliaciones.solicitud_comentarios')
            </div>
            <div id="menu2" class="tab-pane fade">
                @include('myforms.conciliaciones.solicitud_estados')
            </div>
            <div id="menu3" class="tab-pane fade">
              @include('myforms.conciliaciones.solicitud_asignaciones')
          </div>
          </div>
    </div>
</div>

@include('myforms.conciliaciones.componentes.modal_create_document')
@include('myforms.conciliaciones.componentes.modal_create_estado')
@include('myforms.conciliaciones.componentes.modal_create_comentario')
@stop