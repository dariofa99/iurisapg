<div class="row">
    <div class="col-md-12">
        <h4 align="center">
            <strong>APODERADO DE LA PARTE SOLICITANTE</strong>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label >  
                @if($conciliacion->getStaticDataLabel('nombre',$section))
                {{$conciliacion->getStaticDataLabel('nombre',$section)->display_name}}
                @endif</label>
            <input  data-name="nombre"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('nombre',$section)) value="{{$conciliacion->getStaticDataVal('nombre',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>
  
    <div class="col-md-3">
        <div class="form-group">
			<label>
                @if($conciliacion->getStaticDataLabel('cc_nit',$section))
                {{$conciliacion->getStaticDataLabel('cc_nit',$section)->display_name}}
                @endif
            </label>
            <input  data-name="cc_nit"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('cc_nit',$section)) value="{{$conciliacion->getStaticDataVal('cc_nit',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label >@if($conciliacion->getStaticDataLabel('tp_carne',$section))
                {{$conciliacion->getStaticDataLabel('tp_carne',$section)->display_name}}
                @endif
            </label>
            <input data-name="tp_carne"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('tp_carne',$section)) value="{{$conciliacion->getStaticDataVal('tp_carne',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>
  
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
			<label >@if($conciliacion->getStaticDataLabel('telefono',$section))
                {{$conciliacion->getStaticDataLabel('telefono',$section)->display_name}}
                @endif
            </label>
            <input data-name="telefono"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('telefono',$section)) value="{{$conciliacion->getStaticDataVal('telefono',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label >
                @if($conciliacion->getStaticDataLabel('anio',$section))
                {{$conciliacion->getStaticDataLabel('anio',$section)->display_name}}
                @endif</label>
            <input  data-name="anio"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('anio',$section)) value="{{$conciliacion->getStaticDataVal('anio',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                disabled 
                class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
			<label >@if($conciliacion->getStaticDataLabel('jornada',$section))
                {{$conciliacion->getStaticDataLabel('jornada',$section)->display_name}}
                @endif
            </label>
            <input  data-name="jornada"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('jornada',$section)) value="{{$conciliacion->getStaticDataVal('jornada',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>
</div>