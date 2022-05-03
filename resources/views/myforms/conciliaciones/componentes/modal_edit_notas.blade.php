
@component('components.modal')
	
@slot('trigger')
	myModal_edit_nota_conciliaciones
@endslot

@slot('title')
	Agregando Nota:: <h5>
		@if($periodo and $segmento)
		<label class="label bg-blue" style="font-size: 16px;">{{ $periodo->prddes_periodo }}</label>

		<label class="label bg-blue" style="font-size: 16px;">{{ $segmento->segnombre }}</label>
		@else
		<div class="alert alert-warning">
			<i class="fa fa-info"> </i> Asegurese que esten activos el periodo y el segmento de corte!
		</div>
		@endif
	</h5>	
@endslot


@slot('body')
@section('msg-contenido')
Registrado
@endsection
@include('msg.ajax.success')
{!!Form::open([ 'id'=>'myform_edit_nota_ext'])!!}
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">




<div>
<div class="row">
<div class="col-md-4">

{!!Form::hidden('orgntsid',5, ['class' => 'form-control required','id'=>'orgntsid' ]); !!}
{!!Form::hidden('tpntid',1, ['class' => 'form-control required','id'=>'tpntid' ]); !!} 
{!!Form::hidden('oficina_id',$conciliacion->id, ['class' => 'form-control required']); !!} 
{!!Form::hidden('typesub','store', ['class' => 'form-control']); !!} 
{!!Form::hidden('estidnumber',null, ['class' => 'form-control required']); !!} 
@if($periodo and $segmento)
{!!Form::hidden('segid',$segmento->segmento_id, ['class' => 'form-control required','id'=>'segid' ]); !!}
{!!Form::hidden('perid',$periodo->periodo_id, ['class' => 'form-control required','id'=>'perid' ]); !!}	
@endif
					<div class="form-group">
						{!!Form::label('Nota conocimiento') !!}
                        <input type="hidden" name="nota_conocimientoid">                        
                        {!!Form::text('nota_conocimiento',  null , ['class' => 'form-control required','id'=>'ntaconocimiento', 'data-inputmask'=>"'mask': ['9.9']", 'data-mask'=>"" ]); !!}
					</div>
				</div>


				<div class="col-md-4">
					<div class="form-group">
						{!!Form::label('Nota aplicación') !!}
                        <input type="hidden" name="nota_aplicacionid"> 
						{!!Form::text('nota_aplicacion',  null , ['class' => 'form-control required','id'=>'ntaaplicacion', 'data-inputmask'=>"'mask': ['9.9']", 'data-mask'=>""]); !!}
					</div>
				</div>


				<div class="col-md-4">
					<div class="form-group">
						{!!Form::label('Nota Ética') !!}
                        <input type="hidden" name="nota_eticaid"> 
						{!!Form::text('nota_etica',  null , ['class' => 'form-control required','id'=>'ntaetica', 'data-inputmask'=>"'mask': ['9.9']", 'data-mask'=>"" ]); !!}
					</div> 
				</div>
</div>
<div class="row">
<div class="col-md-12">
					<div class="form-group">
						{!!Form::label('Concepto nota: ') !!}
                        <input type="hidden" name="nota_conceptoid"> 
						{!!Form::textarea('nota_concepto',  null , ['class' => 'form-control required','maxlength'=>'100000','id'=>'ntaconcepto' ]); !!}
					</div>
</div>
</div>
@if($periodo and $segmento)
<div class="row">
<div class="col-md-6">
	@if(((currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai'))))
    
	<input type="submit" class="btn btn-primary "value="Actualizar">
	@endif
</div>
</div>
@endif
</div>



{!!Form::close()!!}


@endslot
@endcomponent
<!-- /modal -->










