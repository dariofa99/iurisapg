<div class="row"  >
    <div class="col-md-12" align="center">
        <label>Enfoque diferencial</label>		   
    </div>
    <div id="content_efqdiferencial_component">
    @include('myforms.components_user.aditional_data',
    [
        "data"=>$rdata_enf_dif
    ])
    </div>
</div>

<div class="row" >
    <div class="col-md-12" align="center">
        <label>Discapacidad</label>		   
    </div>

    <div id="content_disc_component">
        @include('myforms.components_user.aditional_data',
        [
            "data"=>$rdata_discap
        ])
    </div>
</div>
<div class="row"  >
    <div class="col-md-12" align="center">
        <label>Grupo étnico</label>		   
    </div>
    <div id="content_gpetnico_component">
        @include('myforms.components_user.aditional_data',
        [
            "data"=>$rdata_gretnc
        ])
    </div>

</div>