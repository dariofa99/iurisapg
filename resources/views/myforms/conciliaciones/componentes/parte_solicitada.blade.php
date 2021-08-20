<div class="row" align="center">
    <div class="col-md-12">
        <h4> <strong> PARTE SOLICITADA</strong>   </h4>
       
    </div>
</div>

{{-- {{dd($conciliacion->getStaticDataVal('fecha',$section))}} --}}
<div class="row">
<div class="col-md-6">
    <div class="form-group">
        <label >  
            @if($conciliacion->getStaticDataLabel('nombre',$section))
            {{$conciliacion->getStaticDataLabel('nombre',$section)->display_name}}
            @endif</label>
        <input data-name="nombre"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('nombre',$section)) value="{{$conciliacion->getStaticDataVal('nombre',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                disabled 
                class="form-control "
            @else 
                class="form-control  insert_adv"
            @endif>

    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label > 
              @if($conciliacion->getStaticDataLabel('edad',$section))
            {{$conciliacion->getStaticDataLabel('edad',$section)->display_name}}
            @endif</label>
        <input  data-name="edad"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('edad',$section)) value="{{$conciliacion->getStaticDataVal('edad',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
    @else 
        class="form-control insert_adv"
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
        <input data-name="cc_nit"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('cc_nit',$section)) value="{{$conciliacion->getStaticDataVal('cc_nit',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
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
        <input  data-name="telefono"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('telefono',$section)) value="{{$conciliacion->getStaticDataVal('telefono',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
        @else 
            class="form-control  insert_adv"
        @endif>

    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label >
            @if($conciliacion->getStaticDataLabel('direccion_notificaciones',$section))
            {{$conciliacion->getStaticDataLabel('direccion_notificaciones',$section)->display_name}}
            @endif</label>
        <input  data-name="direccion_notificaciones"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('direccion_notificaciones',$section)) value="{{$conciliacion->getStaticDataVal('direccion_notificaciones',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
        @else 
            class="form-control  insert_adv"
        @endif>

    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label >
            @if($conciliacion->getStaticDataLabel('correo_electronico',$section))
            {{$conciliacion->getStaticDataLabel('correo_electronico',$section)->display_name}}
            @endif</label>
        <input  data-name="correo_electronico"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('correo_electronico',$section)) value="{{$conciliacion->getStaticDataVal('correo_electronico',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
        @else 
            class="form-control  insert_adv"
        @endif>

    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label >
            @if($conciliacion->getStaticDataLabel('discapacidad',$section))
            {{$conciliacion->getStaticDataLabel('discapacidad',$section)->display_name}}
            @endif</label>
        <input  data-name="discapacidad"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('discapacidad',$section)) value="{{$conciliacion->getStaticDataVal('discapacidad',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
        @else 
            class="form-control  insert_adv"
        @endif>

    </div>
</div>
</div>

<div class="row">
<div class="col-md-3">
    <div class="form-group">
        <label >
            @if($conciliacion->getStaticDataLabel('desde_cuando_comenzo_conflicto',$section))
            {{$conciliacion->getStaticDataLabel('desde_cuando_comenzo_conflicto',$section)->display_name}}
            @endif</label>
        <input data-name="desde_cuando_comenzo_conflicto"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('desde_cuando_comenzo_conflicto',$section)) value="{{$conciliacion->getStaticDataVal('desde_cuando_comenzo_conflicto',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
        @else 
            class="form-control  insert_adv"
        @endif>

    </div>
</div> 
<div class="col-md-3">
    <div class="form-group">
        <label >
            @if($conciliacion->getStaticDataLabel('nivel_escolaridad',$section))
            {{$conciliacion->getStaticDataLabel('nivel_escolaridad',$section)->display_name}}
            @endif</label>
        <input class="form-control insert_adv" data-name="nivel_escolaridad"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('nivel_escolaridad',$section)) value="{{$conciliacion->getStaticDataVal('nivel_escolaridad',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
        disabled 
        class="form-control "
        @else 
            class="form-control  insert_adv"
        @endif>
    </div>
</div>   
</div>