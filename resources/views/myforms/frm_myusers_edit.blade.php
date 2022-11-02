@extends('layouts.dashboard')
@section('area_forms')
Rol: {{$user->roles[0]->name}}
@include('msg.alerts')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{!!Form::model($user, ['route'=>['users.update', $user->id], 'method'=>'PUT', 'files' => 'true','id'=>'myformUserEdit'])!!}

	 	<div class="col-md-9">
		@if((currentUser()->hasRole('amatai') || currentUser()->hasRole('diradmin')) AND $user->hasRole('docente') )
		<div class="form-group" align="right">			
            {!! Form::hidden('active_asignacion', '0') !!}		
            {!! Form::checkbox('active_asignacion', '1') !!}
            {!!Form::label('Asignación casos ') !!}                 
        </div> 
        @endif
     </div>   

	<div class="col-md-3">
		@if(currentUser()->hasRole('amatai') || currentUser()->hasRole('diradmin')  )
		<div class="form-group" align="right">			
            {!! Form::hidden('active', '0') !!}		
            {!! Form::checkbox('active', '1') !!}
            {!!Form::label('Usuario Activo ') !!}                 
        </div> 
        @endif
     </div>    


<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Tipo de documento ') !!} 
			{!!Form::select('tipodoc_id',$tipodoc,$user->tipodoc_id, ['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}
		</div>
	</div>



	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Número de Identificación: ') !!}
			{!!Form::text('idnumber', $user->idnumber, ['class' => 'form-control onlynumber', 'disabled' => 'disabled'] ); !!}
		</div>
	</div>



	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Nombres: ') !!}
			{!!Form::text('name', null, ['class' => 'form-control']); !!}
		</div>
	</div>
</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				{!!Form::label('Apellidos:') !!}
				{!!Form::text('lastname', null, ['class' => 'form-control']); !!}
			</div>
		</div>
	
	
		<div class="col-md-4">
			<div class="form-group">
				{!!Form::label('Contraseña: ') !!}
				  <div class="input-group">
			  <div class="input-group-addon" style="cursor: pointer;" onmousedown="showPassword('password')" onmouseup="showPassword('password')">
				<i class="fa fa-eye"></i>
			  </div>
			  {!!Form::password('password', ['class' => 'form-control','id'=>'password']); !!}
			  </div>
	
			</div>
		</div>
	
		<div class="col-md-4">
			<div class="form-group">
				{!!Form::label('Correo Principal: ') !!}
				{!!Form::text('email', null, ['class' => 'form-control']); !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				{!!Form::label('Tel. Celular: ') !!}
				{!!Form::text('tel1', null, ['class' => 'form-control']); !!}
			</div>
		</div>
	
	
		<div class="col-md-4">
			<div class="form-group">
				{!!Form::label('Telefóno Fijo u otro: ') !!}
				{!!Form::text('tel2', null, ['class' => 'form-control']); !!}
			</div>
		</div>
	
	 
	
	
		<div class="col-md-4">
			<div class="form-group">
				{!!Form::label('Fecha Nacimiento: ') !!}
			 <div class="input-group">
			  <div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			  </div>
			  {!!Form::text('fechanacimien', null, ['class' => 'form-control', 'required' => 'required','data-inputmask'=>"'alias': 'yyyy/mm/dd'" , 'data-mask'] ); !!}
			</div>
			<!-- /.input group -->
			</div>
		</div>
	</div>

	


<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Estrato ') !!}
			{!!Form::select('estrato_id',$estrato,$user->estrato_id,['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}
		</div>
	</div>

	@if(!currentUser()->hasRole("estudiante"))





	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Orientación Sexual') !!}
			{!!Form::select('genero_id',$genero,$user->genero_id, ['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}
		</div> 
	</div>


	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Estado Civil') !!}
			{!!Form::select('estadocivil_id',$estcivil,$user->estadocivil_id, ['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}
		</div>
	</div>

@endif	
</div>


 	








	
	
<!-- 	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Acceso a Oficina Virtual ') !!}
			{!!Form::select('accesofvir', [

										'0' => '.',
										'1' => 'Si',
										'0' => 'No',
																		],

			 null, ['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}
		</div>
	</div>


		<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Institucion ') !!}
			{!!Form::select('institution', [

										'1' => 'Universidad de Nariño',
										'2' => 'Universidad Mariana',
										'3' => 'Corporación Universitaria Cesmag',
																		],

			 null, ['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}
		</div>
	</div> -->


<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Dirección: ') !!}
			{!!Form::text('address', null, ['class' => 'form-control']); !!}
		</div>
	</div>




	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Descripción: ') !!}
			{!!Form::text('description', null, ['class' => 'form-control']); !!} 
		</div>
	</div>

	@if (currentUser()->hasRole('estudiante') and !$user->turno and !$user->docente_asignado)
<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Año Cursando ') !!}
			{!!Form::select('cursando_id',$cursando,null,['placeholder' => 'Selecciona...', 'class' => 'form-control', 'required' => 'required' ]); !!}  
		</div>
	</div>
@else
@if (currentUser()->hasRole('estudiante'))
	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Año Cursando') !!}
			{!!Form::select('cursando_id',$cursando,null,['placeholder' => 'Selecciona...', 'class' => 'form-control', 'disabled' => 'disabled' ]); !!}  
		</div>
	</div>
@endif	
@endif

</div>

	
<div class="row">
	@if(count($user->role)>0)
	@if ((currentUser()->hasRole('amatai') || currentUser()->hasRole('coordprac') || currentUser()->hasRole('diradmin') || currentUser()->hasRole('dirgral')))
		<div class="col-md-4 col-lg-4">
			<div class="form-group">
				{!!Form::label('Rol de Usuario: ') !!}
				
				<select class="form-control select2_ramas" multiple name="id_rol[]">
					@foreach($roles as $id => $role)
						@php
							$selected = ""; 
							foreach ($user->role as $key => $rol) {
								if($rol->id == $id) $selected = "selected";
							}
						@endphp
						<option {{$selected}} value="{{$id}}">{{$role}}</option>
					@endforeach
				</select>
		 
		</div>
		</div>
	@endif
	@endif
	@if(currentUser()->can('cambiar_sede'))
	<div class="col-md-4">
		<div class="form-group">
			{!!Form::label('Sede') !!}		
			<select class="form-control" name="sede_id">
				@foreach($sedes as $id => $sede)				
					<option @if((count($user->sedes)>0 and ($sede->id == $user->sedes()->first()->id)) || (session('sede')->id == $sede->id)) selected  @endif value="{{$sede->id}}">{{$sede->nombre}}</option>
				@endforeach
			</select> 
	</div>
	</div>
	@endif

	<div class="col-md-4">
		<div class="form-group">
			{!! form::label('image','Imagen de perfil')!!}
			{!! form::file('image',null,['class' => 'form-control']) !!}
		</div>
		</div>

</div>




	
@if($user->hasRole('docente') || (currentUser()->hasRole('amatai') || currentUser()->hasRole('diradmin') || currentUser()->hasRole('dirgral')))
<div class="row">
	<div class="col-md-8 col-lg-8" align="left">
		{!! form::label('ramaderecho_id','Ramas de derecho')!!}
			   <div class="form-group">		
				   <select class="form-control select2_ramas" multiple name="ramaderecho_id[]" id="ramaderecho_id"> 
						 @foreach ($ramas_derecho as $id => $rama  )
						  @php
						  $selected = ''
						   @endphp
						 @foreach ($user->ramas_derecho as $key => $usrama )
							 @php                     
							 if($id==$usrama->pivot->ramaderecho_id) $selected = 'selected'; 
							 @endphp
						 @endforeach
						 <option {{ $selected}} value="{{$id}}">{{$rama}}</option>	                    
						 @endforeach
	   
	   
				   
				   </select>
				   
			   </div>
		   </div>
</div>

 @endif
	<div class="col-md-12" align="right">
		<div class="form-group">
			<br>
			@if (($user->cursando_id==1 and currentUser()->hasRole('estudiante')) and (($user->turno) || ($user->docente_asignado)))
			<div class="alert alert-warning">
				El sistema a detectado un cambio inusual en el registro, para corregir por favor comunicarse con el administrador.
			</div>			
			@else
			<button class="btn btn-primary">Enviar</button>			
			@endif
		</div>
	</div>

{!!Form::close()!!}

@stop
