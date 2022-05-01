@foreach($conciliacion->hechos_pretensiones()->where('tipo_id',$tipo_id)->get() as $key => $hecho)
<div class="content_he_pret">
  <textarea disabled @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
    disabled 
    class="form-control"
    @else 
        class="form-control "
    @endif rows="4" data-name="hechos"  required>{{$hecho->descripcion}}</textarea>

    <div class="btn-group" style="display: block">
      &nbsp; &nbsp;
      @if($tipo_id=='194')
      <a href="#" data-id="{{$hecho->id}}" data-estado_id="{{$hecho->estado_id}}"  class="btn_estado_hepr pull-right btn_hepr"> Estado </a>
      @endif
      <a href="#"  data-id="{{$hecho->id}}" class="btn_editar_hepr pull-right btn_hepr"> Editar </a> 
      <a href="#" data-id="{{$hecho->id}}" class="btn_eliminar_hepr pull-right btn_hepr"> Eliminar</a>
    
       {{--  <a style="cursor: pointer;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Editar <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#" data-id="{{$hecho->id}}" class="btn_editar_hepr">Editar</a></li>
          <li><a href="#" data-id="{{$hecho->id}}" class="btn_eliminar_hepr">Eliminar</a></li>      
        </ul> --}}
      </div>
</div>
       
@endforeach 