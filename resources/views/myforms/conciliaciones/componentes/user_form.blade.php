
{!!Form::open([ 'id'=>(isset($user)) ? 'myformEditConciliacionUser' : 'myformCreateConciliacionUser' ,'method'=>'post'])!!}
@if(isset($conciliacion))
<input type="hidden" id="conciliciacion" name="conciliacion_id" value="{{$conciliacion->id}}">

@endif
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
<input type="hidden" id="usercreated" name="usercreated" value="{{currentUser()->idnumber}}">
<input type="hidden" id="userupdated" name="userupdated" value="{{currentUser()->idnumber}}">
<input type="hidden" name='cursando_id' value="1">
<input type="hidden" name="genero_id" value="9">
<input type="hidden" name="estadocivil_id" value="9">
<input type="hidden" name="estrato_id" value="9">
{!!Form::hidden('id', (isset($user)) ? $user->id : ''  , ['class' => 'form-control', 'readonly', 'id'=>'id' ]); !!}


<div class="row">
    <input type="hidden" name="active" id="active_text" value="0">
    
    @include('myforms.conciliaciones.componentes.inputs_form_user.generales')
    @if(Request::has('section') and (Request::get('section')=='solicitante' || Request::get('section')=='solicitada' || Request::get('section')=='general'  ))
    @include('myforms.conciliaciones.componentes.inputs_form_user.email')     
    @endif
    @if(Request::has('section') and Request::get('section')=='solicitante')
    @include('myforms.conciliaciones.componentes.inputs_solicitante')     
    @endif

 


<div id="content_aditional_data">    
     @include('myforms.conciliaciones.componentes.aditional_user_data',[
         'section'=> Request::has('section') ? Request::get('section') : 'solicitante'
     ]
     ) 
</div>

@if(Request::has('section') and Request::get('section')=='general')
<div class="col-md-6">
    <div class="form-group">
        {!!Form::label('Tipo de usuario') !!}
        <select {{(isset($user) and Request::get('data_type') )? 'disabled' : ''}}  name="tipo_usuario_id" class="form-control required" required>
            <option value="">Seleccione...</option>
            @foreach($types_users as $key => $type)
            <option {{Request::get('data_type') == $key ? 'selected': ''}}  value="{{$key}}">{{$type}}</option>
            @endforeach
        </select>
    </div>
</div>   

@endif 



<div class="col-md-12" align="right">
    <div class="form-group">
        <br>
        <button type="submit" class="btn btn-primary btn-block"> {{isset($user) ? 'Actualizar' : 'Crear nuevo'}} </button>
      {{--   <button type="button" id="btn_exp_user_create" class="btn btn-primary btn-block">Crear</button>
 --}}
        {{-- {!! link_to('#', 'Crear', $attributes = array('id'=>'btn_exp_user_create', 'type'=>'button', 'class'=>'btn-block btn btn-primary'), $secure=null)!!}
 --}}
    </div>
</div>

<div class="col-md-12" align="right" id="cont_btn_cnu" style="display:none">
    <div class="form-group">
        <br>
    </div>
</div>

</div>
{!!Form::close()!!}
