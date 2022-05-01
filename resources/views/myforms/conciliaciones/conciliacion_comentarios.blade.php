<div class="row" >
    <div class="col-md-2">
        @if(auth()->user()->can('crea_com_conciliacion') || ((currentUserInConciliacion($conciliacion->id,['autor']))))
        <input type="button" id="btn_agregar_comentario" value="Agregar comentario" class="btn btn-primary btn-sm btn-block">
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12 table-responsive no-padding">
        <table class="table" id="table_list_comentarios">
            <thead>
                <th>
                    Comentario
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
               @include('myforms.conciliaciones.componentes.solicitud_comentarios_ajax')
            </tbody>
        </table>
    </div>
</div>