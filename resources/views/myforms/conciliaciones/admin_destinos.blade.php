<form id="myFormAsigReporte">
<div class="row">
    <div class="col-md-4">
     <label> Módulo</label>
     <select name="tabla_destino" required class="form-control select">
        <option value="">Seleccione un módulo</option>
         <option value="conciliaciones">Conciliaciones</option>
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