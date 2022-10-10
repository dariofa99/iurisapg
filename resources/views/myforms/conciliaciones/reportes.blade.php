<div class="row">
    <div class="col-md-9">
        <form id="{{ ($myForm) }}" enctype="multipart/form-data">
            <input name="reporte" type="hidden">
   
            @if(isset($conciliacion))
            <input name="conciliacion_id" value="{{$conciliacion->id}}" type="hidden">
            <input name="status_id" value="{{ isset($estado) ? $estado : $conciliacion->status_id}}" type="hidden">
            @endif
            <input name="report_keys" id="report_keys" value="" type="hidden">

<div class="row">
   
   <div class="col-md-4">
    <label> Nombre del formato </label>
    <input type="text" required class="form-control"  name="nombre_reporte"
     @if($view and ($view=='update') and isset($reportes) and count($reportes)>0)
      value="{{$reportes[count($reportes)-1]->nombre_reporte}}"
     @elseif($view and $view=='update_temp' and $reporte)
     value="{{$reporte->nombre_reporte}}"
     @endif >

    </div>
    <div class="col-md-4">
        @if($view and $view=='update')  
        @if(isset($reportes))
        <label>Seleccionar otro formato</label>
        <select name="id" id="sel_reporte_id" class="form-control">              
            @forelse($reportes as $key => $reporte)
                <option selected value="{{$reporte->id}}">{{$reporte->nombre_reporte}}</option>
            @empty
            <option value="">Sin reportes</option>
            @endforelse                        
        </select>
  
        @endif 

        @elseif($view and $view=='update_temp')
        
        <div id="cont_temp">
            @if($reporte->is_temp)
            <input type="hidden" name="is_temp" value="{{$reporte->id}}">
            <input type="hidden" name="id" value="{{$reporte->pdf_reporte_id}}">
            @else
            <input type="hidden" name="id" value="{{$reporte->id}}">
        @endif
        </div>       
        @endif
        </div>
   
</div>    

   <div class="row">
       <div class="col-md-12">
        <div class="content_s">
            <div id="{{$mySummernote}}" class="summernote">
                @if(isset($reporte)) 
                    {!! $reporte->reporte !!}
                @endif
            </div>
        </div> 
       </div>
   </div>
    <div class="row">
        <div class="col-md-7">
    <br>

    @if($view and $view!='update_temp')

            <button type="submit" class="btn btn-primary btn-sm" style="margin: 2px"><i class="fa fa-save"> </i> 
                @if($view and $view=='store')
                Guardar 
                @elseif($view=='update') 
                Actualizar 
                @endif
            </button> 
    @endif
            @if($view and $view=='update_temp')
            <button type="button" id="btnGuardarPdfTemp" class="btn btn-success btn-sm" style="margin: 2px"><i class="fa fa-save"> </i> 
                 Guardar cambios 
            </button>
            
           
           
            <button type="button" id="btnCancelPdfTemp" class="btn btn-default btn-sm" style="margin: 2px"><i class="fa fa-close"> </i> 
              Cerrar
           </button> 
            @endif

            @if($view=='update')
            <button type="button" @if(isset($reporte) and !$reporte->is_temp and $view=='update_temp') style="display:none"  @endif id="btnDeletePdfTemp" class="btn btn-danger btn-sm" style="margin: 2px"><i class="fa fa-trash"> </i> 
                Eliminar
             </button>
            @endif


              </div>
       <div class="col-md-5">
      <br>
       <div class="input-group pull-right">
        <span class="input-group-addon bg-orange" id="basic-addon1">
            <a href="#" style="color: black" data-summernote="{{$mySummernote}}" data-form="{{$myForm}}" id="{{($myForm)}}" class="btn_generate_pdf_preview" style="margin: 2px">
                <i class="fa fa-file-pdf-o"> </i>
                 Vista previa</a>
        
        </span>
            <select required name="tipo_papel" class="form-control ">
                <option @if(isset($reporte) and $reporte->getConfig()->tipo_papel == 'a4') selected @endif value="a4">Tamaño Carta</option>
                <option @if(isset($reporte) and $reporte->getConfig()->tipo_papel == 'a3') selected @endif value="a3">Tamaño Oficio</option>              
            </select>
           
        </div>
        <a href="#" data-modal="myModal_configuraciones_pdf_{{$view}}" class="but_mar selec_confi_av">Margenes</a>
        <a href="#" data-modal="myModal_configuraciones_formato_pdf_{{$view}}" class="but_mar selec_confi_av">Formato</a>
       </div>
    </div>
    @include('myforms.conciliaciones.componentes.modal_configuraciones_pdf',[
        'id'=>"myModal_configuraciones_pdf_".$view,
        'configuraciones'=> (isset($reporte) and  $reporte!=null) ? $reporte->getConfig() : false,
        
    ])
   
    @include('myforms.conciliaciones.componentes.modal_configuraciones_formato_pdf',[
        'id'=>"myModal_configuraciones_formato_pdf_".$view,
        'config_encab'=> (isset($reporte) and  $reporte!=null) ? $reporte->getPdfConfig('encabezado') : null,
        'config_pie'=> (isset($reporte) and  $reporte!=null) ? $reporte->getPdfConfig('pie') : null,
          
    ])

    </form>


   
    </div>
    <div class="col-md-3" id="inputs">
        
    
    <div class="my-fixed-item" id="my-fixed-item">
        <div class="row" >
            <div class="col-md-12">
               <select id="select_values_{{$view}}" data-view="{{$view}}" class="form-control select_values">
                   <option value="solicitante_{{$view}}">Parte solicitante</option>
                   <option value="rep_legal_solicitante_{{$view}}">Rep. Legal parte solicitante</option>               
                   <option value="apoderado_solicitante_{{$view}}">Apoderado parte solicitante</option>
                   <option value="solicitada_{{$view}}">Parte solicitada</option>
                   <option value="rep_legal_solicitada_{{$view}}">Rep. Legal parte solicitada</option>
                   <option value="hechos_pretensiones_{{$view}}">Hechos - Pretensiones</option>
                   <option value="audiencia_{{$view}}">Audiencia</option>
                   <option value="personalizado_{{$view}}">Personalizado</option>
               </select>
               
            </div>
        </div>
            <div class="content_values_{{$view}}" style="display: block" id="solicitante_{{$view}}">
                @include('myforms.conciliaciones.componentes.reportes_values',[
                    'tipo_usuario_id'=>205,
                    'parte'=>'solicitante',
                    'view'=>"solicitante_values",
                    'mySummernote'=>$mySummernote,
                    
                ]) 
            </div>

            <div class="content_values_{{$view}}" style="display: none" id="rep_legal_solicitante_{{$view}}">
                @include('myforms.conciliaciones.componentes.reportes_values',[
                    'tipo_usuario_id'=>195,
                    'parte'=>'rep_legal_solicitante',
                    'view'=>"solicitante_rep_legal_values",
                    'mySummernote'=>$mySummernote,
                    //'section'=>'rep_legal_solicitante'
                    
                ])
            </div>
            <div class="content_values_{{$view}}" style="display: none" id="apoderado_solicitante_{{$view}}">
                @include('myforms.conciliaciones.componentes.reportes_values',[
                    'tipo_usuario_id'=>196,
                    'parte'=>'apoderado_solicitante',
                    'view'=>"solicitante_rep_legal_values",
                    'mySummernote'=>$mySummernote,                    
                    
                ])
            </div>

            <div class="content_values_{{$view}}" style="display: none" id="solicitada_{{$view}}">
                @include('myforms.conciliaciones.componentes.reportes_values',[
                    'tipo_usuario_id'=>197,
                    'parte'=>'solicitada',
                    'view'=>"solicitante_values",
                    'mySummernote'=>$mySummernote,                
                ])
            </div>

            <div class="content_values_{{$view}}" style="display: none" id="rep_legal_solicitada_{{$view}}">
                @include('myforms.conciliaciones.componentes.reportes_values',[
                    'tipo_usuario_id'=>198,
                    'parte'=>'rep_legal_solicitada',
                    'view'=>"solicitante_rep_legal_values",
                    'mySummernote'=>$mySummernote,                    
                ])
            </div>

            <div class="content_values_{{$view}}" style="display: none; margin-top:3px" id="hechos_pretensiones_{{$view}}">
                <div class="col-md-12">
                    <div class="form-group item_value">
                        <small data-table="conc_hechos_preten"  data-summernote="{{$mySummernote}}"  data-short_name="hechos" class="item_con" user-type="hepr" data-name="hechos">Hechos</small> 
                    </div>
                </div>                 
                <div class="col-md-12">
                    <div class="form-group item_value">
                        <small data-table="conc_hechos_preten" data-summernote="{{$mySummernote}}"   data-short_name="pretensiones" class="item_con" user-type="hepr" data-name="pretensiones">Pretensiones</small> 
                </div>
                </div>
            </div>

            <div class="content_values_{{$view}}" style="display: none;margin-top:3px" id="audiencia_{{$view}}">
                         
                <div class="col-md-12">
                    <div class="form-group item_value">
                        <small data-table="conciliacion_audiencias" data-summernote="{{$mySummernote}}"   data-short_name="fecha_audiencia" class="item_con" user-type="general" data-name="fecha_audiencia">Fecha y hora de audiencia</small> 
                </div>
                </div>
            </div>
                

    </div>

      
    
    </div>
    </div>