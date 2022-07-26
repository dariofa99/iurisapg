@php
$user = $conciliacion->getUser(196);
@endphp
<div class="row">
    <div class="col-md-12">
        <h4 align="center">
            <strong>APODERADO DE LA PARTE SOLICITANTE</strong>
          
           @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
           || ((currentUserInConciliacion($conciliacion->id,['autor','auxiliar','conciliador'])))) 
          @if(($conciliacion->estado_id==174 || $conciliacion->estado_id==176 || $conciliacion->estado_id==194))
                <button type="button" @if($user->idnumber!=null) data-user="{{$user->idnumber}}" @endif data-section="apoderado_solicitante" data-type="196" class="btn btn-primary btn-sm btn_asinar_usuario_conciliacion pull-right">  
                    <i class="fa fa-plus"> </i> {{$user->idnumber!=null ? 'Actualizar' : 'Agregar'}} 
                </button>

                @if($user->idnumber!=null) 
                <button type="button" data-user="{{$user->idnumber}}" data-pivot="{{$user->pivot->id}}" class="btn btn-danger btn-sm btn_delete_usuario_conciliacion pull-right">  
                    <i class="fa fa-trash"> </i>
                </button>
               @endif
           @endif    
            @endif
        </h4>

    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
			<label >  
                Nombre</label>
            <input disabled data-name="nombre"  data-section="{{$section}}" required  type="text"
            value="{{$user->name}} {{$user->lastname}}" 
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
			<label>
               No. Documento
            </label>
            <input disabled data-name="cc_nit"  data-section="{{$section}}" required  type="text"
            value="{{$user->idnumber}}"
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
			<label >Teléfono
            </label>
            <input disabled data-name="tel1"  data-section="{{$section}}" required  type="text"
            value="{{$user->tel1}}"
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                disabled 
                class="form-control form-control-sm"
                @else 
                class="form-control form-control-sm insert_adv"
                @endif>

		</div> 
    </div>

    @foreach($conciliacion->getUserForm('apoderado_solicitante','sin_seccion') as $key => $question)
    <div class="col-md-3">
        <div class="form-group">
            <label > {{$question->name}}</label>
            <input disabled data-name="{{$question->short_name}}"  data-section="{{$question->section}}" required  type="text"
            @if($user->getDataValWShort($question->short_name))
            value="{{$user->getDataValWShort($question->short_name)->value}}" @endif
            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
             disabled 
             class="form-control form-control-sm"
            @else 
            class="form-control form-control-sm insert_adv"
             @endif>
    
        </div>
    </div>
    @endforeach

</div>
