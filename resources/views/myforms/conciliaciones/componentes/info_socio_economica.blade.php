<div class="row">
    <div class="col-md-12">
        <h4 align="center">
            <strong>INFORMACIÓN SOCIOECONÓMICA</strong>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
			<label>
                @if($conciliacion->getStaticDataLabel('estado_civil',$section))
                {{$conciliacion->getStaticDataLabel('estado_civil',$section)->display_name}}
                @endif
            </label>
           
                @if($conciliacion->getStaticDataLabel('estado_civil',$section))               
                    <select data-name="estado_civil"  data-section="{{$section}}" @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                        disabled 
                        class="form-control"
                        @else 
                            class="form-control  insert_adv"
                        @endif>
                        <option value="">Seleccione...</option>
                        @foreach($conciliacion->getStaticDataLabel('estado_civil',$section)->options as $key => $value)
                            <option data-option_id="{{$value->id}}" @if($conciliacion->getStaticDataVal('estado_civil',$section,$value->id) and $conciliacion->getStaticDataVal('estado_civil',$section,$value->id)->reference_data_option_id == $value->id) selected @endif value="{{$value->value}}">{{$value->value}}</option>
                        @endforeach
                    </select>
                @endif
            
		</div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
			<label>
                @if($conciliacion->getStaticDataLabel('numero_personas_cargo',$section))
                {{$conciliacion->getStaticDataLabel('numero_personas_cargo',$section)->display_name}}
                @endif
            </label>
           
                @if($conciliacion->getStaticDataLabel('numero_personas_cargo',$section))               
                    <select data-name="numero_personas_cargo"  data-section="{{$section}}" @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                        disabled 
                        class="form-control"
                        @else 
                            class="form-control  insert_adv"
                        @endif>
                        <option value="">Seleccione...</option>
                        @foreach($conciliacion->getStaticDataLabel('numero_personas_cargo',$section)->options as $key => $value)
                            <option data-option_id="{{$value->id}}" @if($conciliacion->getStaticDataVal('numero_personas_cargo',$section,$value->id) and $conciliacion->getStaticDataVal('numero_personas_cargo',$section,$value->id)->reference_data_option_id == $value->id) selected @endif value="{{$value->value}}">{{$value->value}}</option>
                        @endforeach
                    </select>
                @endif
            
		</div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label >
                @if($conciliacion->getStaticDataLabel('estrato',$section))
                {{$conciliacion->getStaticDataLabel('estrato',$section)->display_name}}
                @endif</label>
            <input  data-name="estrato"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('estrato',$section)) value="{{$conciliacion->getStaticDataVal('estrato',$section)->value}}" @endif
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
                @if($conciliacion->getStaticDataLabel('afiliado_regimen_subsidiado_salud',$section))
                {{$conciliacion->getStaticDataLabel('afiliado_regimen_subsidiado_salud',$section)->display_name}}
                @endif
            </label>
           
                @if($conciliacion->getStaticDataLabel('afiliado_regimen_subsidiado_salud',$section))               
                    <select data-name="afiliado_regimen_subsidiado_salud"  data-section="{{$section}}" @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                        disabled 
                        class="form-control"
                        @else 
                            class="form-control  insert_adv"
                        @endif>
                        <option value="">Seleccione...</option>
                        @foreach($conciliacion->getStaticDataLabel('afiliado_regimen_subsidiado_salud',$section)->options as $key => $value)
                            <option data-option_id="{{$value->id}}" @if($conciliacion->getStaticDataVal('afiliado_regimen_subsidiado_salud',$section,$value->id) and $conciliacion->getStaticDataVal('afiliado_regimen_subsidiado_salud',$section,$value->id)->reference_data_option_id == $value->id) selected @endif value="{{$value->value}}">{{$value->value}}</option>
                        @endforeach
                    </select>
                @endif
            
		</div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
			<label >
                @if($conciliacion->getStaticDataLabel('ingresos_mensuales',$section))
                {{$conciliacion->getStaticDataLabel('ingresos_mensuales',$section)->display_name}}
                @endif</label>
            <input  data-name="ingresos_mensuales"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('ingresos_mensuales',$section)) value="{{$conciliacion->getStaticDataVal('ingresos_mensuales',$section)->value}}" @endif
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
                @if($conciliacion->getStaticDataLabel('egresos_mensuales',$section))
                {{$conciliacion->getStaticDataLabel('egresos_mensuales',$section)->display_name}}
                @endif</label>
            <input data-name="egresos_mensuales"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('egresos_mensuales',$section)) value="{{$conciliacion->getStaticDataVal('egresos_mensuales',$section)->value}}" @endif
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
                @if($conciliacion->getStaticDataLabel('tipo_vivienda',$section))
                {{$conciliacion->getStaticDataLabel('tipo_vivienda',$section)->display_name}}
                @endif
            </label>
           
                @if($conciliacion->getStaticDataLabel('tipo_vivienda',$section))               
                    <select data-name="tipo_vivienda"  data-section="{{$section}}" @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                        disabled 
                        class="form-control"
                        @else 
                            class="form-control  insert_adv"
                        @endif>
                        <option value="">Seleccione...</option>
                        @foreach($conciliacion->getStaticDataLabel('tipo_vivienda',$section)->options as $key => $value)
                            <option data-option_id="{{$value->id}}" @if($conciliacion->getStaticDataVal('tipo_vivienda',$section,$value->id) and $conciliacion->getStaticDataVal('tipo_vivienda',$section,$value->id)->reference_data_option_id == $value->id) selected @endif value="{{$value->value}}">{{$value->value}}</option>
                        @endforeach
                    </select>
                @endif
            
		</div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label >
                @if($conciliacion->getStaticDataLabel('nivel_escolaridad',$section))
                {{$conciliacion->getStaticDataLabel('nivel_escolaridad',$section)->display_name}}
                @endif</label>
            <input data-name="nivel_escolaridad"  data-section="{{$section}}" required  type="text"
            @if($conciliacion->getStaticDataVal('nivel_escolaridad',$section)) value="{{$conciliacion->getStaticDataVal('nivel_escolaridad',$section)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
            disabled 
            class="form-control"
            @else 
                class="form-control  insert_adv"
            @endif>

		</div>
    </div>
</div>