@extends('layouts.dashboard')

@section('titulo_general')
Categorias

@endsection

@section('titulo_area')
<div class="pull-left" style="float: left !important;">
    <button class="btn btn-primary btn-sm" id="btn_new_static_category">Nueva categoría</button>
    </div>
@endsection

@section('area_buttons')

@endsection
 

@section('area_forms') 
 
@include('msg.success') 
<div class="row">
    <div class="col-md-12 table-responsive no-padding" id="content_categories_list">
        @include('myforms.static_categories.partials.ajax.index')
    </div>
</div>


@include('myforms.static_categories.partials.modals.create')

@stop
