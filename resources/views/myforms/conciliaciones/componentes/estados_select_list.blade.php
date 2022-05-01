<select name="type_status_id" class="form-control" required>
    <option value="">Seleccione</option>

    @if($conciliacion->getUser(183)->hasRole('estudiante'))
    @if(currentUser()->hasRole('estudiante') )
    @if($conciliacion->estado_id==177 || $conciliacion->estado_id==214)
    <option value="213"> Enviar a revisión </option>
    @endif
    @endif

    @if(auth()->user()->hasRole('docente') || currentUser()->hasRole('diradmin') || currentUser()->hasRole('amatai'))
    @if($conciliacion->estado_id==213)
    <option value="214"> Corregir </option>
    <option value="215"> Aprobado por docente </option>
    @endif
    @endif



    @else

    @if(($conciliacion->getUser(183)->hasRole('estudiante') and currentUser()->hasRole('diradmin'))
    || !$conciliacion->getUser(183)->hasRole('estudiante') and currentUserInConciliacion($conciliacion->id,['autor']))
    @if($conciliacion->estado_id==177 || $conciliacion->estado_id==179 )
    <option value="178"> Radicar </option>
    @endif
    @endif

    @if(currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai'))
    @if($conciliacion->estado_id==178 || $conciliacion->estado_id==179)
    @if($conciliacion->estado_id!=179)
    <option value="181"> Inadmitida. Asunto no conciliable </option>
    @endif

    <option value="182"> Inadmitir-anular </option>

    @if($conciliacion->estado_id!=179) <option value="179"> Inadmitida Solicitud de correcciones </option>@endif
    @if($conciliacion->estado_id!=179) <option value="180"> Admitida </option>@endif
    @endif
    @endif

    @if($conciliacion->estado_id==180 || $conciliacion->estado_id==190 || $conciliacion->estado_id==211)
    @if(currentUserInConciliacion($conciliacion->id,['autor','solicitante']))
    <option value="210"> Solicitud de aplazamiento </option>
    <option value="191"> Solicitud de desistimiento </option>
    @endif
    @if($conciliacion->estado_id!=190)
    @if(currentUser()->hasRole('coord_centro_conciliacion') ||
    currentUserInConciliacion($conciliacion->id,['conciliador','asistente']))
    <option value="190"> Suspendida </option>
    @endif
    @endif
   
    @if(currentUser()->hasRole('coord_centro_conciliacion') ||
    currentUserInConciliacion($conciliacion->id,['conciliador','asistente']))
    <option value="205"> Acuerdo </option>
    <option value="206"> Acuerdo parcial </option>
    <option value="207"> No acuerdo </option>
    <option value="208">No acuerdo parcial </option>
    <option value="209">Informe no asistencia </option>
    @endif  
    @endif

    @if(currentUser()->hasRole('coord_centro_conciliacion'))
    @if($conciliacion->estado_id==210)
    <option value="211">Aplazada</option>
    @endif
    @if($conciliacion->estado_id==191)
    <option value="192">Informe de archivo desistimiento</option>
    @endif
    @endif
    @if(currentUser()->hasRole('secretaria') || currentUser()->hasRole('diradmin'))
    @if($conciliacion->estado_id==205 || $conciliacion->estado_id==206 ||
    $conciliacion->estado_id==207 || $conciliacion->estado_id==208 || $conciliacion->estado_id==204)
    <option value="203">Registrado en SICAB</option>
    @endif
    @endif
    @if(currentUser()->hasRole('coord_centro_conciliacion'))
    @if($conciliacion->estado_id==209)
    <option value="204">Constancia no asistencia</option>
    @endif
    @endif

    @endif
</select>