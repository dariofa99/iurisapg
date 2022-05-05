@php
    $user = $conciliacion->getUser(197);
@endphp
<div class="row" >
    <div class="col-md-12">
        <h4> <strong> PARTE SOLICITADA</strong>
           
               @if($user->idnumber!=null) 
               <button type="button" data-user="{{$user->idnumber}}" data-pivot="{{$user->pivot->id}}" class="btn btn-danger btn-sm btn_delete_usuario_conciliacion pull-right">  
                   <i class="fa fa-trash"> </i>
               </button>
              @endif
              @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
              || ((currentUserInConciliacion($conciliacion->id,['autor']))))     <button type="button" @if($user->idnumber!=null) data-user="{{$user->idnumber}}" @endif data-section="solicitada" data-type="197" class="btn btn-primary btn-sm btn_asinar_usuario_conciliacion pull-right">  
                   <i class="fa fa-plus"> </i> {{$user->idnumber!=null ? 'Actualizar' : 'Agregar'}} 
                  </button>

               @endif   
               </h4>
       
    </div>
</div>

{{-- {{dd($conciliacion->getStaticDataVal('fecha',$section))}} --}}

    

<div class="row">
<div class="col-md-6">
    <div class="form-group">
        <label >  
            Nombre</label>
        <input disabled  data-name="nombre"  data-section="{{$section}}" required  type="text"
         value="{{$user->name}} {{$user->lastname}}" 
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
         disabled 
         class="form-control form-control-sm"
        @else 
        class="form-control form-control-sm insert_adv"
         @endif
        >

    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label>
           No. Identificación
        </label>
        
        <input disabled data-name="idnumber"  data-section="{{$section}}" required  type="text"
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
        <input disabled data-name="telefono"  data-section="{{$section}}" required  type="text"
        value="{{$user->tel1}}" 
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
        <label > Correo electrónico
            </label>
        <input disabled data-name="correo_electronico"  data-section="{{$section}}" required  type="text"
        value="{{$user->email}}"
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
         disabled 
         class="form-control form-control-sm"
        @else 
        class="form-control form-control-sm insert_adv"
         @endif>

    </div>
</div>



@foreach($conciliacion->getUserForm('solicitada','datos_personales') as $key => $question)
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

@foreach($conciliacion->getUserForm('solicitada','discapacidad') as $key => $question)
<div class="col-md-3">
    <div class="form-group">
        <label > {{$question->name}}</label>
        <input disabled data-name="{{$question->short_name}}"  data-section="{{$question->section}}" required  type="text"
        @if($user->getDataValWShort($question->short_name))
        value="{{$user->getDataValWShort($question->short_name)->value}} {{$user->getDataValWShort($question->short_name)->value_is_other}}" @endif
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

<div class="row">
<div class="col-md-3">
    <div class="form-group">
        <label >
            @if($conciliacion->getStaticDataLabel('desde_cuando_comenzo_conflicto',$section))
            {{$conciliacion->getStaticDataLabel('desde_cuando_comenzo_conflicto',$section)->display_name}}
            @endif</label>
        <input class="form-control form-control-sm insert_adv" data-name="desde_cuando_comenzo_conflicto"  data-section="{{$section}}" required  type="text"
        @if($conciliacion->getStaticDataVal('desde_cuando_comenzo_conflicto',$section)) value="{{$conciliacion->getStaticDataVal('desde_cuando_comenzo_conflicto',$section)->value}}" @endif
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
         disabled 
         class="form-control form-control-sm"
        @else 
        class="form-control form-control-sm insert_adv"
         @endif>

    </div>
</div>    
</div>