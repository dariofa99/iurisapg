<div class="row">
    <div class="col-md-4">
        <h4 class="box-title">
        <label>
            Fecha Audiencia
        </label>
        @if ($audiencia != "")
        <span class="edit_audiencia_existe">
            <h4>{{ \Carbon\Carbon::parse($audiencia->fecha)->dayName }}, {{ \Carbon\Carbon::parse($audiencia->fecha)->format("d") }} de {{ \Carbon\Carbon::parse($audiencia->fecha)->monthName }} {{ \Carbon\Carbon::parse($audiencia->fecha)->format("Y") }}</h4>
        </span>
        @endif
            <input id="audiencia_fecha" class="form-control form-control-sm edit_audiencia" data-name="fecha" required="" type="date" min="{{date('Y-m-d')}}" style="max-width:180px; @if ($audiencia != '') display:none; @endif ">
        </h4>
    </div>

    <div class="col-md-3">
        <h4 class="box-title">
        <label>
            Hora audiencia
        </label>
        @if ($audiencia != "")
        <span class="edit_audiencia_existe">
            <h4>{{$audiencia->hora}}</h4>
        </span>
        @endif
        <div class="bootstrap-timepicker edit_audiencia" style="min-width:118px;max-width:118px; @if ($audiencia != '') display:none; @endif">
            <div class="form-group">
				<div class="input-group">
					<input type="text" id="audiencia_hora" class="form-control timepicker" value="${h_i}">
					<div class="input-group-addon">
						<i class="fa fa-clock-o"></i>
				    </div>
				</div>
                <!-- /.input group -->
            </div>
            <!-- /.form group -->
        </div>
        </h4>
    </div>

    <div class="col-md-3">
        <h4 class="box-title edit_audiencia" style="@if ($audiencia != '') display:none @endif">
        <label>
            Color día
        </label>
        <div>
            <label id="audiencia_label_color_day" class="label dis-block color-amarillo" style="background-color: #ffffff"></label>
        </div>
        </h4>
    </div>
    <div class="col-md-2">
        <h4 class="box-title">
            <label >
            &nbsp;
            </label>
            @if ($audiencia != "")
            <input type="button" value="Editar" class="btn btn-warning btn-block btn-sm" id="btm_edit_date_audiencia" data-id="{{$conciliacion->id}}">
            @endif
            @if(((currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai'))))
             
            <input type="button" value="Guardar" class="btn btn-primary btn-block btn-sm edit_audiencia" id="btm_save_date_audiencia" data-id="{{$conciliacion->id}}" style="@if ($audiencia != '') display:none @endif">
           @endif
            <input type="button" value="Cancelar" class="btn btn-danger btn-block btn-sm edit_audiencia" id="btm_cancel_date_audiencia" data-id="{{$conciliacion->id}}" style="display:none">
        </h5>
    </div>
</div>
<hr>
<div class="edit_audiencia" style="@if ($audiencia != '') display:none @endif" >
    <div class="row" >
        <div class="col-md-6">
            <h4 class="box-title">
                <label>
                    Estudiantes
                </label>
            </h4>
            <table class="normal-table">
                <tr>
                    <td>
                        Busqueda
                    </td>
                    <td>

                    </td>
                    <td>
                        {!!Form::select('data_search',$cursando,null,['class' => 'form-control input-search  selectpicker input-select', 'data-live-search'=>'true', 'required' => 'required','id'=>'select_data_cursando_est_conciliacion'] ); !!}
                    </td>
                    <td>
                        <input class="btn btn-success" id="search_data_cursando_est_conciliacion" type="button" data-id="{{$conciliacion->id}}" name="buscar" value="Buscar">
                        <input class="btn btn-default" id="view_all_data_cursando_est_conciliacion" type="button" data-id="{{$conciliacion->id}}" name="vertodo" value="Ver todo">
                    </td>
                </tr>
            </table>

        </div>

    </div>
    <hr>
    <div class="row"  style="height: 300px; overflow-x: auto;" id="list_turno_estudiantes_conciliacion">
        @include('myforms.conciliaciones.componentes.list_turno_estudiante')
    </div>
<hr>
</div>
@if ($audiencia != "")
<div class="row" >
    <div class="input-group margin" id="content-text-stream-audiencia">
        <input type="text" id="text-stream-audiencia" class="form-control"  value="{{URL::to('/')}}/audiencia/{{$audiencia->access_code}}" readonly>
        <span class="input-group-btn">
            <button type="button" id="copy-stream-audiencia" class="btn btn-info btn-flat" data-frame="{{URL::to('/')}}/audiencia/{{$audiencia->access_code}}">Copiar link</button>
        </span>
    </div>
</div>
<div class="row" >
    <div class="col-md-2">
        <input type="button" value="Iniciar videollamada" class="btn btn-primary btn-block btn-sm" id="btn_iniciar_videollamada">
    </div>
    <div class="col-md-2">
        <input type="button" value="Crear salas alternas" class="btn btn-primary btn-block btn-sm" id="btn_invitacion_sala_alterna"  data-id="{{$conciliacion->id}}">
    </div>
    <div class="col-md-2">
        <input type="button" value="Acceder a sala alterna" class="btn btn-primary btn-block btn-sm" id="btm_access_room_alter{{ $conciliacion->id }}" @if($sala_alterna_url == "") style="display:none" @else onclick="openPopUpSalas('{{ $sala_alterna_url }}');" @endif>
    </div>

</div>

<div class="row">
    <div class="col-md-12">

        <div id='joinMsg'></div>
        <div id="stamby_audiencia" style="height: 620px;width: 100%;background-color: rgba(25, 25, 25, 0.93);text-align: -webkit-center;padding-top: 100px; margin-bottom: 10px; display:none;">
            <button id="btnvolver_audiencia" title="Volver a la audiencia" class="btn btn-primary btn-block btn-sm" style="width: 150px;">Volver a la audiencia</button>
        </div>
        <div id='container-meet' class="container-meet" style="display:none;">
            <div id='jitsi-meet-conf-container'></div>
            <div id="toolbox" class="toolbox" style="display:none;">
                <button id='btnCustomMic' class="boton-redondo jitsi-mic" ><i class="fa fa-microphone" aria-hidden="true"></i></button>
                <button id='btnCustomCamera' class="boton-redondo jitsi-cam">Cam</button>
                <button id='btnCustomTileView' class="boton-redondo"  title="Cambiar vista"><i class="fa fa-th-large" aria-hidden="true"></i></button>
                <button id='btnScreenShareCustom' class="boton-redondo" title="Compartir pantalla"><i class="fa fa-desktop" aria-hidden="true"></i></button>
                <button id='btnHangup' class="boton-redondo jitsi-exit" title="Colgar">Colgar</button>
            </div>

        </div>
    </div>
</div>

<div class="row iniciar_videollamada" style="display:none;">
    <div class="col-md-12">
        <div class="form-group form_store">
            <label for="description">Chat</label>
            <select class="form-control input-select" name="select" id="chatroomconciliacion" data-id="60" style="display: block;">
                <option value="conciliacion-{{$conciliacion->id}}">Todos</option>
                @foreach($conciliacion->usuarios as $key => $user)
                <option value="conciliacion-{{$conciliacion->id}}{{$user->idnumber}}">{{$user->name}} {{$user->lastname}}</option>
                @endforeach
            </select>
            <input type="hidden" id="tokenc" value="">
            <div class="embed-responsive embed-responsive-4by3" style=" height: 400px; " id="chat-conciliacion">
                @include('myforms.conciliaciones.componentes.chat_room_ajax',['chatroom'=>'conciliacion-'.$conciliacion->id])
            </div> 
        </div>
    </div>
</div>
@endif