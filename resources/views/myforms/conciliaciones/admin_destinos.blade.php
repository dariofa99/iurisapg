<form id="myFormAsigReporte">
<div class="row">
    <div class="col-md-4">
     <label> Módulo</label>
     <select name="tabla_destino" required class="form-control select">
        <option value="">Seleccione un módulo</option>
         <option value="conciliaciones">Conciliaciones</option>
         <option value="conciliaciones_email">Email Conciliaciones</option>
     </select>
     
     <select name="categoria" required class="form-control select">
         <option value="">Seleccione categoria</option>
         <option value="mensaje_sol_conciliador">Modelo mensaje solicitud estudiante conciliador</option>
         <option value="mensaje_sol_asistente">Modelo mensaje solicitud estudiante asistente</option>
         <option value="mensaje_radicado">Modelo mensaje radicado</option>
         <option value="mensaje_rec_conciliador">Modelo mensaje recomendaciones conciliadores</option>
         <option value="mensaje_rec_asistente">Modelo mensaje recomendaciones asistentes</option>
         <option value="mensaje_notificarse">Modelo mensaje notificarse (Aceptar)</option>
         <option value="mensaje_notificarse_cancelar">Modelo mensaje notificarse (No Aceptar)</option>
     </select>

     <select name="status_id" required class="form-control select">
        <option value="">Seleccione un estado</option>
        @foreach($types_status as $key => $type_status)
        <option value="{{$key}}">{{$type_status}}</option>
        @endforeach
    </select>

    </div>
     <div class="col-md-4">
     @if(isset($reportes))
     <label>Seleccionar formatos</label>     
     <ul>               
         @forelse($reportes as $key => $reporte)
        <li>
            <input class="checks_reportes" type="checkbox" id="chk_reporte_{{$reporte->id}}" value="{{$reporte->id}}" name="reporte_id[]" > {{$reporte->nombre_reporte}}
        </li>                     
         @empty
       <label> Sin formatos</label> 
         @endforelse                        
        </ul>   
     @endif  
    </div>
</div>
<div class="row">
<div class="col-md-12">
    <button class="btn btn-primary" type="submit">Guardar</button>
</div>
</div>
</form>