@foreach($conciliacion->usuarios as $key => $user)
                    <tr>
  
                        <td>{{$user->name}} {{$user->lastname}}</td>
                        <td>{{$user->tipo_conciliacion()->where('tipo_usuario_id',$user->pivot->tipo_usuario_id)->first()->ref_nombre}}</td>
                        <td>

                            <select @if(array_key_exists($user->id, $tipos_estados)  and $tipos_estados[$user->id] == 1 ) disabled   @endif data-oldnew="{{ in_array($user->id,$ids) ? "old" : "new"}}" class="form-control select_type_firma" data-userid="{{$user->id}}">
                                <option value="">No asignado</option>
                            @foreach($types_firma_users as $key_id => $type_firma_user)
                                <option   @if(array_key_exists($user->id, $tipos)  and $tipos[$user->id] == $key_id ) selected   @endif value="{{$key_id }}">{{$type_firma_user}} </option>
                            @endforeach
                            </select>   
                            
                            @if(array_key_exists($user->id, $tipos_estados)  and $tipos_estados[$user->id] == 1 ) <small>
                           <i>
                            Ya se firmó el documento 
                               </i>    
                            </small>   @endif
                        </td>
                        <td>
                            <input type="hidden" disabled id="input_selustipofirm-{{$user->id}}" name="tipo_firmante[]">
                            <input type="hidden" disabled id="input_selusfirm-{{$user->id}}" name="user_id[]">
                            <input @if(array_key_exists($user->id, $tipos_estados)  and $tipos_estados[$user->id] == 1 ) disabled   @endif {{ (in_array($user->id,$ids) and (array_key_exists($user->id, $tipos)  and $tipos[$user->id] == 216 ))  ? "checked" : "disabled"}} data-userid="{{$user->id}}" id="check_selusfirm-{{$user->id}}" class="check_selusfirm" data-oldnew="{{ in_array($user->id,$ids) ? "old" : "new"}}" value="{{$user->id}}" type="checkbox" name="user_email_id[]">

                        </td>
                        <td style="display: none" class="volver_enviar_mail">
                            <input class="check_selusvolverfirm" {{ (in_array($user->id,$ids) and (array_key_exists($user->id, $tipos)  and $tipos[$user->id] == 216 ))? "checked" : "disabled"}} data-oldnew="{{ in_array($user->id,$ids) ? "old" : "new"}}" value="{{$user->id}}" type="checkbox" name="email_user_id[]">
                        </td>
                        
        </tr>
@endforeach