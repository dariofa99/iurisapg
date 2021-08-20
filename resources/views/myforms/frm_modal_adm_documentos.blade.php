@component('components.modal')
	
	@slot('trigger')
		myModal_adm_documentos
	@endslot

	@slot('title')
		Documentos
	@endslot

 
	@slot('body')



@section('msg-contenido')
Registrado
@endsection
@include('msg.ajax.success')
<div id="cont_adm_docs">


	<ul class="nav nav-tabs">
        @if(currentUser()->can('crear_docs_oficina_virtual'))
        <li class="active" id="li_tab_create"><a href="#tab_create" id="a_tab_create" data-toggle="tab">
        Nuevo</a></li>
	@endif
	<li  @if(!currentUser()->can('crear_docs_oficina_virtual')) class="active" @endif >
        <a id="a_tab_recibidos" href="#tab_recibidos" data-toggle="tab">Recibidos</a>
        </li>
        
        <li><a href="#tab_enviados" id="a_tab_enviados" data-toggle="tab">Enviados</a></li>
        
		
		</ul>
<!--Tab contnent-->
		<div class="tab-content">
			<!--Tab pane tab_3-->
            <div @if(!currentUser()->can('crear_docs_oficina_virtual')) class="tab-pane active" @else class="tab-pane" @endif  id="tab_recibidos">
                    <div class="row">
                            <div class="col-md-12">	
                             @if(count($expediente->solicitudes)>0)
                                 @include('myforms.components_exp.frm_list_documents',[
                                        'type_category_id'=>163,
                                        'solicitud'=>$expediente->solicitudes[0]
                                 ])
                            @endif
                            </div> <!-- /.md12-->              
                    </div> <!-- /.row -->	
            </div>
                <!--Tab pane tab_3-->

                <!--Tab pane tab_3-->
            <div class="tab-pane" id="tab_enviados">
                    <div class="row">
                            <div class="col-md-12">	
                               <div id="content_solicitudes_files">
                                @if(count($expediente->solicitudes)>0)
                                        @include('myforms.components_exp.frm_list_documents',[
                                         'type_category_id'=>164,
                                         'solicitud'=>$expediente->solicitudes[0]
                                 ])
                                @endif
                             
                               
                               </div>   
                            </div> <!-- /.md12-->              
                    </div> <!-- /.row -->	
            </div>
                <!--Tab pane tab_3-->

                
                <!--Tab pane tab_3-->
            <div @if(currentUser()->can('crear_docs_oficina_virtual')) class="tab-pane active" @else class="tab-pane"  @endif id="tab_create">
                    <div class="row">
                            <div class="col-md-10 col-md-offset-1">	
                                   <form method="POST" class="form_store" accept-charset="UTF-8" id="myformCreateSoliDocumento" enctype="multipart/form-data">
                                    {{csrf_field()}}
                          <input type="hidden" name="id" id="log_id"> 
                <input type="hidden" value="164" name="type_category_id">
                 @if(count($expediente->solicitudes)>0) <input type="hidden" id="solicitud_id" value="{{$expediente->solicitudes[0]->id}}" name="solicitud_id"> @endif    <input type="hidden" value="student" name="view">
           
           
               <div class="form-group">
                                <label for="description">Concepto</label>
                               <input type="text" class="form-control " required name="concept" id="concept_id">
               </div>

                         {{--   <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea required class="form-control " name="description" id="description"  rows="3"></textarea> 
                            </div> --}}
                        
                            <div class="form-group">
                            <div class="custom-file">
                                    <input required type="file" name="solicitud_file" class="custom-file-input" id="logFile" >
                                    <label class="custom-file-label" for="customFile"></label>
                            </div>
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
                            </div> <!-- /.md12-->              
                    </div> <!-- /.row -->	
            </div>
                <!--Tab pane tab_3-->


        </div>




</div>
	@endslot
@endcomponent
<!-- /modal -->










