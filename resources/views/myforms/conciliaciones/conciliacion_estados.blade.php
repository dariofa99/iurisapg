<div class="row" >
    <div class="col-md-2">
     @if(currentUserInConciliacion($conciliacion->id,['autor','conciliador','asistente']) ||
     currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('secretaria') || currentUser()->hasRole('docente') || currentUser()->hasRole('amatai'))
        <input type="button" value="Cambiar estado" class="btn btn-primary btn-block btn-sm" id="btn_cambiar_estado">
       
     @endif 
    </div>
<div class="col-md-7">

</div>
    <div class="col-md-3">
        <input type="button" value="Descargar todos los documentos" class="btn btn-primary btn-block btn-sm" id="btn_download_all_pfd">
    </div>
</div>

<div class="row">
    <div class="col-md-12 table-responsive no-padding">
        <table class="table" id="table_list_estados">
            <thead>
                
                <th>
                    Estado
                </th>
                <th>
                    Descripción
                </th>
                <th>
                    Creado por
                </th>
                <th>
                    Fecha creación
                </th>
                <th>
                    Documentos
                </th>
                <th>
                    Acciones
                </th>
            </thead>
            <tbody>
               @include('myforms.conciliaciones.componentes.conciliacion_estados_ajax')
            </tbody>
        </table>
    </div>
</div>