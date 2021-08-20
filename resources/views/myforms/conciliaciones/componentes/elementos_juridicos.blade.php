<div class="row" align="center">
    <div class="col-md-12">
        <h4> <strong>ELEMENTOS JURÍDICOS</strong>   </h4>
       
    </div>
</div>

{{-- {{dd($conciliacion->getStaticDataVal('fecha',$section))}} --}}
<div class="row">
<div class="col-md-5">
    <div class="form-group">
        <label >  
            @if($conciliacion->getStaticDataLabel('cuantia_indeterminada_determinada',$section))
            {{$conciliacion->getStaticDataLabel('cuantia_indeterminada_determinada',$section)->display_name}}
            @endif</label>
        <input  data-name="cuantia_indeterminada_determinada"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('cuantia_indeterminada_determinada',$section)) value="{{$conciliacion->getStaticDataVal('cuantia_indeterminada_determinada',$section)->value}}" @endif
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
<div class="col-md-12">
    <div class="form-group">
        <label >@if($conciliacion->getStaticDataLabel('hechos',$section))
            {{$conciliacion->getStaticDataLabel('hechos',$section)->display_name}}
            @endif
        </label>
        <textarea @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif rows="7" data-name="hechos"  data-section="{{$section}}" required> @if($conciliacion->getStaticDataVal('hechos',$section)){{$conciliacion->getStaticDataVal('hechos',$section)->value}}@endif</textarea>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label >@if($conciliacion->getStaticDataLabel('pretensiones',$section))
                {{$conciliacion->getStaticDataLabel('pretensiones',$section)->display_name}}
                @endif
            </label>
            <textarea @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                disabled 
                class="form-control"
                @else 
                    class="form-control  insert_adv"
                @endif rows="7" data-name="pretensiones"  data-section="{{$section}}" required> @if($conciliacion->getStaticDataVal('pretensiones',$section)){{$conciliacion->getStaticDataVal('pretensiones',$section)->value}}@endif</textarea>
        </div>
    </div>
</div>
