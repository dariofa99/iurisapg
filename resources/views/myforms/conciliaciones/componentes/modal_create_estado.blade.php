@component('components.modal')
	
	@slot('trigger')
		myModal_create_estado
	@endslot

	@slot('title')
		Cambiando estado
	@endslot
	@slot('body')
	<div class="row">
		<div class="col-md-12">   
            <form method="POST" class="form_store" accept-charset="UTF-8" id="myformCreateEstado">
                <input type="hidden" name="estado_id">
                <div class="form-group">
                    <label for="description">Estado</label>
                    <select name="type_status_id" class="form-control" required>
                       <option value="">Seleccione</option>
                       @foreach($types_status as $key => $type_status)
                       @if($key!=$conciliacion->estado_id)<option value="{{$key}}">{{$type_status}}</option>@endif
                       @endforeach
                    </select>                   
                </div>
                <div class="form-group">
                    <label for="description">Concepto</label>
                    <textarea name="concepto" class="form-control"  rows="5"></textarea>                        
                </div> 
                     
                <div class="col-md-12">
                    <div class="form-group">
                            <br>
                    <button type="submit" class="btn btn-block btn-primary btn-sm">
                        Guardar
                    </button>
                    <button type="button" style="display:none" id="btn_cancel_upsoldoc" class="btn btn-block btn-default btn-sm">
                        Cancelar
                    </button>                            
                    </div>
                </div>
                </form>
		</div>		
	</div>
@endslot
@endcomponent
<!-- /modal -->










