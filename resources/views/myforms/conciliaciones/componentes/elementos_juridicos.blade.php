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
<hr>
<div class="row">
<div class="col-md-12">
    <div class="form-group">  
        <label style="display: block; margin-bottom:10px"> Hechos   
    @if(($conciliacion->getUser(183)->hasRole('estudiante') and (currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
            || (!$conciliacion->getUser(183)->hasRole('estudiante') and (currentUserInConciliacion($conciliacion->id,['autor']) || currentUser()->hasRole('amatai'))))
         <button type="button" data-tipo="193" class="btn btn-primary btn-sm pull-right btn_add_conc_he_con">Agregar hecho</button>
    @endif
    </label>
    <div id="content_hechos_pretensiones-193" class="content_hechos_pretensiones">
        @include('myforms.conciliaciones.componentes.hechos_pretenciones_ajax',[
            'tipo_id'=>193
        ]) 
    </div>
    </div>
</div> 
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group" >
            <label style="display: block; margin-bottom:10px">Pretensiones
                @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
            || ((currentUserInConciliacion($conciliacion->id,['autor']))))
                <button type="button" data-tipo="194" class="btn btn-primary btn-sm pull-right btn_add_conc_he_con"> Agregar pretensión</button>       
            @endif
            
            </label>
            <div id="content_hechos_pretensiones-194" class="content_hechos_pretensiones">
                @include('myforms.conciliaciones.componentes.hechos_pretenciones_ajax',[
                    'tipo_id'=>194
                ]) 
            </div>
           
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group" >
            <label style="display: block; margin-bottom:10px">Acuerdos
                @if(($conciliacion->getUser(183)->hasRole('estudiante') and (currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
            || (!$conciliacion->getUser(183)->hasRole('estudiante') and (currentUserInConciliacion($conciliacion->id,['autor']) || currentUser()->hasRole('amatai'))))
                <button type="button" data-tipo="200" class="btn btn-primary btn-sm pull-right btn_add_conc_he_con"> Agregar Acuerdo</button>       
            @endif
            </label>
            <div id="content_hechos_pretensiones-200" class="content_hechos_pretensiones">
                @include('myforms.conciliaciones.componentes.hechos_pretenciones_ajax',[
                    'tipo_id'=>200
                ]) 
            </div>
           
        </div>
    </div>
</div>
