@php
    $user = $conciliacion->getUser(195);
@endphp
<div class="row">
    <div class="col-md-12">
        <h4 >
            Representante Legal (Diligenciar solo para personas jurídicas, o naturales incapaces)
       

            @if($user->idnumber!=null) 
            <button type="button" data-user="{{$user->idnumber}}" data-pivot="{{$user->pivot->id}}" class="btn btn-danger btn-sm btn_delete_usuario_conciliacion pull-right">  
                <i class="fa fa-trash"> </i>
            </button>
           @endif

           @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
            || ((currentUserInConciliacion($conciliacion->id,['autor']))))
           <button type="button" @if($user->idnumber!=null) data-user="{{$user->idnumber}}" @endif data-section="rep_legal_solicitante" data-type="195" class="btn btn-primary btn-sm btn_asinar_usuario_conciliacion pull-right">  
                <i class="fa fa-plus"> </i> {{$user->idnumber!=null ? 'Actualizar' : 'Agregar'}} 
               </button>
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


    @foreach($conciliacion->getUserForm('rep_legal_solicitante','datos_personales') as $key => $question)
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

 {{--    <div class="col-md-3">
        <div class="form-group">
			<label >
                Dirección para notificaciones</label>
                <input data-name="direccion_notificaciones"  data-section="{{$section}}" required  type="text"
                @if($user->getDataValWShort('direccion_notificaciones'))
                value="{{$user->getDataValWShort('direccion_notificaciones')->value}} " @endif
                @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                 disabled 
                 class="form-control form-control-sm"
                @else 
                class="form-control form-control-sm insert_adv"
                 @endif>

		</div>
    </div> --}}
</div>
