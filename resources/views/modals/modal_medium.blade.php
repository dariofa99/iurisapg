
<!-- Trigger the modal with a button -->





<div @yield('id') class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar</h4>
      </div>
      <div class="modal-body">                        

		
     <div>
			
			<div class="row">
				<div class="col-md-12">
                    
						@yield('contenido-modal-medium')

        </div>
			</div>

      </div>


      <div class="modal-footer">
       {{--  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> --}}
      </div>
    </div>

  </div>
</div>

</div>

