@component('components.modal_dynamic_cols')
	
	@slot('trigger')
		myModal_reportes_pdf_estados
	@endslot

	@slot('title')
		Reportes 
	@endslot

    @slot('cols')
		col-md-6 col-md-offset-3
	@endslot 
	@slot('body')
	<div class="row" id="content_user_pdf_list" >
		<div class="col-md-12">               
            <table class="table" id="myReportPdfList">
                <thead>
                    <th>
                        Nombre 
                    </th>
                    <th>
                        Descargar
                    </th>
                 </thead>
                <tbody>
                    
                </tbody>
            </table>
                   
		</div>		
	</div>
    <div class="row" id="content_user_pdf_firmas" style="display: none">
        <form id="myFormAsigFirmaPdf">
            <input type="hidden" name="estado_id">
            <div class="col-md-12">
                <h4>
                    Documento: <label id="lbl_pfd_report_name">Citacion en</label>
                </h4> 
            </div>
            <div class="col-md-9">
               
                <button type="submit" id="btn_enviar_email"  class="btn btn-primary btn-sm">Enviar y Guardar</button>
           
                <button type="button" id="btn_cancelar_asig_user" class="btn btn-default btn-sm ">Cancelar</button>
               
                
              

           
               
            
               
                <button type="button" id="btn_gene_pdf" class="btn btn-success btn-sm ">Generar documentos</button>
              

            </div>
            <div class="col-md-3">
                <button type="button" id="btn_select_volver_enviar_email" class="btn btn-warning btn-sm">Volver a envíar E-mail</button>
                <button type="button" style="display: none" id="btn_volver_enviar_email"  class="btn btn-primary btn-sm">
                    Reenviar emails</button>

            </div>
            <div class="col-md-12">
                
                <table class="table" id="table_list_pdf_users">
                    <thead>
                        <th>
                            Nombre 
                        </th>
                        <th>
                            Tipo
                        </th>
                        <th>
                            Tipo de firma
                        </th>
                        <th>
                            Envíar E-mail
                        </th>
                        <th class="volver_enviar_mail" style="display: none">
                          Envíar E-mail
                        </th>
                     </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </form>
       
    </div>
@endslot
@endcomponent
<!-- /modal -->









