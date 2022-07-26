@if(count($conciliacion->expedientes)>0)
<div class="row">
    <div class="col-md-12">
        <h6><i>Número de expediente: 
           <a href="/expedientes/{{$conciliacion->expedientes[0]->expid}}/edit">
             {{$conciliacion->expedientes[0]->expid}}
           </a></i></h6>
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12" id="content_conciliaciones">    
    <form id="myForm">
        <input type="hidden" id="conciliacion_id" value="{{$conciliacion->id}}">
        <input type="hidden" id="older_value">
    <div class="row">
        <div class="col-md-12">
            <h5>INFORMACIÓN DE LAS PARTES</h5>
        </div>
    </div>
    <div class="box_section">
        @include('myforms.conciliaciones.componentes.parte_solicitante',[     
            'section'=>'parte_solicitante'
        ])
    
    @include('myforms.conciliaciones.componentes.parte_solicitante_rep_legal',[     
        'section'=>'representante_legal_solicitante'
    ])
    
    </div>
    
    
   
    
    <div class="box_section">
        @include('myforms.conciliaciones.componentes.apoderado_solicitante',[     
        'section'=>'apoderado_solicitante'
    ])
    </div>
    
    <div class="box_section">
        @include('myforms.conciliaciones.componentes.parte_solicitada',[     
        'section'=>'parte_solicitada'
    ])
    @include('myforms.conciliaciones.componentes.parte_solicitada_rep_legal',[     
        'section'=>'representante_legal_solicitada'
    ])
    </div>
    
    <div class="box_section">
        @include('myforms.conciliaciones.componentes.elementos_juridicos',[     
            'section'=>'elementos_juridicos' 
        ])
      
    </div>
    <div class="box_section">
        @include('myforms.conciliaciones.componentes.anexos',[     
            'section'=>'anexos'
        ])
    </div>
    
    </form>
    
    </div>
    </div>