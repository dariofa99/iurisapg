<div class="row">
    <div class="col-md-12">
        <h4 align="center">
            Representante Legal (Diligenciar solo para personas jurídicas, o naturales incapaces)
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
                class="form-control form-control-sm"
                @else 
                class="form-control form-control-sm insert_adv"
                @endif>

		</div>
    </div>
  
  

 
    <div class="col-md-3">
        <div class="form-group">
			<label >
                @if($conciliacion->getStaticDataLabel('direccion_notificaciones',$section))
                {{$conciliacion->getStaticDataLabel('direccion_notificaciones',$section)->display_name}}
                @endif</label>
            <input data-name="direccion_notificaciones"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('direccion_notificaciones',$section)) value="{{$conciliacion->getStaticDataVal('direccion_notificaciones',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                disabled 
                class="form-control form-control-sm"
            @else 
                class="form-control form-control-sm insert_adv"
            @endif>

		</div>
    </div>
</div>