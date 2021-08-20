

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label >Anexos</label>

</div>
    </div>
    <div class="col-md-3">
        @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
             @else 
            <button type="button" id="btn_create_document" class="btn btn-success btn-sm">Agregar anexo</button>
            @endif
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table" id="table_anexos_list">
            <thead>
                <th>
                    Concepto
                </th>
                <th>
                    Archivo
                </th>
                <th>
                    Acciones
                </th>
            </thead>
            <tbody>
                @include('myforms.conciliaciones.componentes.anexos_ajax')
            </tbody>
        </table>
    </div>
</div>