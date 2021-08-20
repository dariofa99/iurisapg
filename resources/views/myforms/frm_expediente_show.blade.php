@extends('layouts.dashboard')

@section('titulo_general')

@if(!currentUser()->hasRole("solicitante"))
Expediente
	@include('myforms.components_exp.frm_datos_docente')
@else
Caso
	@include('myforms.components_exp.frm_datos_estudiante_caso_solicitante')
@endif
@endsection

@section('titulo_area')

Ver

@endsection

@section('area_buttons')
<div class="pull-right" style="float: right !important;">
	<a href="#" class="btn-atrasexed pull-right btn bg-gray" style="color:#777"><i class="fa fa-backward"></i> Atrás</a>
</div>
@endsection
 

@section('area_forms') 

@include('msg.success') 


@php
 if(!currentUser()->hasRole("estudiante")){
	$disabled = 'disabled';

 }else{
 	 	if($expediente->expestado_id =='1' OR $expediente->expestado_id =='3'){
			$disabled = '';
 		}else{
			$disabled = 'disabled';
 		}

 }

 @endphp
 
 <div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
		@if(!currentUser()->hasRole("solicitante"))
		  <li class="active"><a href="#tab_1" data-toggle="tab">Datos del caso</a></li>
		  @if($expediente->exptipoproce_id == 2)
		  <li><a href="#tab_2" class="tab-btn-show-notas" data-toggle="tab">Actuaciones</a></li>
		  <li><a href="#tab_3" class="tab-btn-show-notas" data-toggle="tab">Cita o req. a solicitante</a></li> 
		  @endif
		  <li><a href="#tab_4" class="tab-btn-show-notas" data-toggle="tab">Cierre de caso</a></li>
		  <li><a href="#tab_5" class="tab-btn-show-notas"  data-toggle="tab">Calificaciones</a>
		  </li>
		  @if( (count($expediente->asignaciones)>1 || (currentUser()->hasRole('amatai') or currentUser()->hasRole('diradmin') or currentUser()->hasRole('coordprac') or currentUser()->hasRole('dirgral'))) and $expediente->expestado_id!=2)
		  <li>
			  <a href="#tab_6" class="tab-btn-show-notas" data-toggle="tab">Reasignar Caso</a>
		  </li>
		  @endif
		   <li><a href="#tab_7" data-toggle="tab">Citaciones</a>
		  </li>
		  @endif
		  @if(currentUser()->hasRole("solicitante"))
		   <li class="active"><a href="#tab_8" data-toggle="tab">Caso</a><li>
 			@endif
		   <li><a href="#tab_9" data-toggle="tab">Quejas</a>
		  </li>
		</ul> 
		<!--Tab contnent-->
		<div class="tab-content">
	@if(!currentUser()->hasRole("solicitante"))
		<!--Tab pane tab_1-->
		  <div class="tab-pane active" id="tab_1">
		  
			@include("myforms.components_exp.frm_datos_caso")
			
			@include("myforms.components_exp.frm_asesorias_caso")
			
			@include("myforms.components_exp.frm_notas_caso")
		
		  </div>
		<!--Tab pane tab_1-->
		<!--Tab pane tab_2-->
		<div class="tab-pane" id="tab_2">
				<div class="row">
						<div class="col-md-12">	
						@if($expediente->exptipoproce_id=='2') 
							<div id="frm_actuacion_create">
							@include('myforms.frm_actuacion_create') 
							@include('myforms.frm_actuacion_list')
							</div>						
						@else
							<div id="frm_actuacion_create">
							Opción inactiva para Consulta simple
							</div>						
						@endif
	
							
	
						</div> <!-- /.md12-->              
				</div> <!-- /.row -->	
		</div>
			<!--Tab pane tab_2-->
			<!--Tab pane tab_3-->
		<div class="tab-pane" id="tab_3">
				<div class="row">
						<div class="col-md-12">	
								@if($expediente->exptipoproce_id=='2')
								@include('myforms.frm_requerimiento_create')								
							@else
								Opción inactiva para Consulta simple
							@endif							
	
						</div> <!-- /.md12-->              
				</div> <!-- /.row -->	
		</div>
			<!--Tab pane tab_3-->

			<!--Tab pane tab_4-->
		<div class="tab-pane" id="tab_4">
				<div class="row">
						<div class="col-md-12">	
								@include('myforms.frm_expediente_cierre_caso')
						</div> <!-- /.md12-->              
				</div>
				 <!-- /.row -->	
		</div>
			<!--Tab pane tab_4-->
			<!--Tab pane tab_5-->
		<div class="tab-pane" id="tab_5">
				<div class="row">
						<div class="col-md-12">	
							@include('myforms.frm_calificacion_create')	
							
						{{-- @if($expediente->exptipoproce_id == 4)				
							@include('myforms.frm_calificacion_show')  
						@else
							@include('myforms.frm_calificacion_create')						
						@endif --}}
						</div> <!-- /.md12-->              
				</div>
				 <!-- /.row -->	 
		</div>
			<!--Tab pane tab_5-->

				<!--Tab pane tab_6-->
		<div class="tab-pane" id="tab_6">
				<div class="row">
						<div class="col-md-12">	
								@include('myforms.components_exp.frm_reasignar_caso')	
						</div> <!-- /.md12-->              
				</div>
				 <!-- /.row -->	
		</div>
			<!--Tab pane tab_6-->

						<!--Tab pane tab_7-->
		<div class="tab-pane" id="tab_7">
				<div class="row">
						<div class="col-md-12">	
								@include('myforms.components_exp.frm_citaciones_estudiante')
						</div> <!-- /.md12-->              
				</div>
				 <!-- /.row -->	
		</div>
			<!--Tab pane tab_7-->
	@endif	
					<!--Tab pane tab_8-->
	@if(currentUser()->hasRole("solicitante"))
		<div class="tab-pane active" id="tab_8">
				<div class="row">
						<div class="col-md-12">	
								@include('myforms.components_exp.frm_caso_solicitante')
						</div> <!-- /.md12-->              
				</div>
				 <!-- /.row -->	
		</div>
			<!--Tab pane tab_8-->
	@endif
			<!--Tab pane tab_9-->
		<div class="tab-pane" id="tab_9">
				<div class="row">
						<div class="col-md-12">	
								@include('myforms.components_exp.frm_quejas_caso')
						</div> <!-- /.md12-->              
				</div>
				 <!-- /.row -->	
		</div>
			<!--Tab pane tab_9-->

		</div><!--Tab contnent-->
		
 </div><!--nav-tabs-custom-->
 @include('myforms.frm_add_nota_final_expedientes')
 @include('myforms.frm_calificacion_edit')
 @include('myforms.frm_modal_cambiar_docente_exp')




 





@stop
