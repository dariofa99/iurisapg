<div class="row" >
    <div class="col-md-2">
        <input type="button" value="Cambiar estado" class="btn btn-primary btn-block btn-sm" id="btn_cambiar_estado">
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
                    Creado por
                </th>
                <th>
                    Fecha creación
                </th>
                <th>
                    Acciones
                </th>
            </thead>
            <tbody>
               @include('myforms.conciliaciones.componentes.solicitud_estados_ajax')
            </tbody>
        </table>
    </div>
</div>