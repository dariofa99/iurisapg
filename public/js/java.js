$(document).ready(function(){
    //detecta url y activa el tab correspondiente
    var url = window.location.href;
    var activeTab = url.substring(url.indexOf("#") + 1);
    $('a[href="#'+ activeTab +'"]').tab('show')
    //carga el tab seleccionado en la url sin recargar la pagina
    $(".urlactive").on("click", function(){
        let stateObj = {
            foo: "nav",
        }
        history.pushState(stateObj, "menu", "edit"+$(this).attr("href"))
    });



});

$("#wait").css("display", "block");
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});

$(document).ready(function (e) {
    var summernote = $(".summernote");
    items_delete = [];
    summernote.summernote({
        /* toolbar: [
            // [groupName, [list of button]]
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["strikethrough", "superscript", "subscript"]],

            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["fontname", ["fontname"]],
            ["picture", ["picture"]],
            ["table", ["table"]],
        ], */
        height: 427,
        popover: {
            image: [
                [
                    "image",
                    ["resizeFull", "resizeHalf", "resizeQuarter", "resizeNone"],
                ],
                ["float", ["floatLeft", "floatRight", "floatNone"]],
                ["remove", ["removeMedia"]],
            ],
            link: [["link", ["linkDialogShow", "unlink"]]],
            table: [
                [
                    "add",
                    ["addRowDown", "addRowUp", "addColLeft", "addColRight"],
                ],
                ["delete", ["deleteRow", "deleteCol", "deleteTable"]],
            ],
            air: [
                ["color", ["color"]],
                ["font", ["bold", "underline", "clear"]],
                ["para", ["ul", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link", "picture"]],
            ],
        },
        // maxHeight:460
    });
    $(".item_con").on("mousedown", function (params) {
        var space = "&nbsp;";
        var mySummernote = $(this).attr("data-summernote");
        var clasehechopre ='';
        var salto ='';
        if($(this).attr("user-type")=='hepr') clasehechopre = 'hecho_pret'; salto = '<br>'
        $("#" + mySummernote).summernote(
            "pasteHTML",
            `<span data-table="${$(this).attr(
                "data-table"
            )}" data-short_name="${$(this).attr(
                "data-short_name"
            )}" user-type="${$(this).attr("user-type")}" data-name="[-${$(
                this
            ).attr("data-name")}-]" class="item_sp ${clasehechopre}">[-` +
                $(this).attr("data-name") +
                `-]</span>${space}`   
        );
       
        //  $('.note-editable').trigger('focus');
        //  summernote.summernote('focus');
        //$(".note-editable p").focus()
        //  $(".item_sp").prop('disabled',true).css('color','blue')
        //document.getElementById("dcalc").disabled = true;
    });
    $(".item_con").on("click", function (params) {
        //$('.note-editable').trigger('focus');
        //  summernote.summernote('focus');
        //$(".note-editable p").focus()
    });

    $("#reporte").on("click", ".item_sp", function () {
        if ($(this).attr("data-name") != $(this).text()) {
            $(this).remove();
        }
    });

    //////
    $(".data_value").show();
    //$(".data_name").text("")
    ////////////////
    $("#myModal_videollamadas").on(
        "click",
        "#newtab-stream-cases",
        function (e) {
            $("#myModal_videollamadas").modal("hide");
            $("#text-stream-cases").val("");

            $("#iframe-stream-cases").attr("src", "");
        }
    );
    $("#myModal_videollamadas").on("hidden.bs.modal", function (e) {
        $("#newtab-stream-cases").attr("href", "");
        $("#text-stream-cases").val("");
        $("#iframe-stream-cases").attr("src", "");
    });
    $("#myModal_videollamadas").on("click", "#ask-stream-cases", function (e) {
        var route =
            "/expediente/sharestream/" + $("#ask-stream-cases").attr("data-id");
        $.ajax({
            url: route,
            type: "GET",
            datatype: "json",
            data: {},
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            success: function (res) {
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor, consulte con el administrador"
                );
                $("#wait").css("display", "none");
            },
        });
    });

    $("#myModal_videollamadas").on("click", "#copy-stream-cases", function (e) {
        copiarAlPortapapeles("content-text-stream-cases");
    });

    alertify.defaults = {
        glossary: {
            // dialogs default title
            title: "Alerta",
            // ok button text
            ok: "Confirmar",
            // cancel button text
            cancel: "Cancelar",
        },

        // theme settings
        theme: {
            // class name attached to prompt dialog input textbox.
            input: "ajs-input",
            // class name attached to ok button
            ok: "btn btn-primary",
            // class name attached to cancel button
            cancel: "btn btn-default",
        },
        notifier: {
            // auto-dismiss wait time (in seconds)
            delay: 5,
            // default position
            position: "bottom-right",
            // adds a close button to notifier messages
            closeButton: false,
        },
    };

    comprDato("form_expediente_user_edit");
    var currentUrl = window.location.pathname;
    $(".select2_ramas").select2();
    // if(currentUrl=='/expedientes')  searchExpedientes();

    $("#table_list_model").on("click", ".pagination a", function (e) {
        e.preventDefault();
        page = $(this).attr("href");
        index_page(page);
        window.history.pushState(null, "", page);
    });

    $("#content_list_solicitudesh").on("click", ".pagination a", function (e) {
        e.preventDefault();
        page = $(this).attr("href");
        index_pageSol(page);
        window.history.pushState(null, "", page);
    });

    $("#myFormSearch").submit(function () {
        page = $(this).attr("action");
        var data = $(this).serialize();
        index_page(page, data);
        window.history.pushState(null, "", page + "?" + data);
        return false;
    });

    $("#myFormSearchEstudiante").submit(function () {
        page = $(this).attr("action");
        var data = $(this).serialize();
        index_page(page, data);
        window.history.pushState(null, "", page + "?" + data);
        return false;
    });

    /*$('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ]
    });*/
    /*$(".datepicker").datepicker({
  prevText: '<<',
  nextText: '>>' ,
  maxDate: 'today',  
  minDate: '1900-01-01',
  dateFormat: 'yy-mm-dd',
  changeMonth: true,  
  changeYear: true,
  yearRange: "1900:today", 
  showOptions: { direction: "up" },
  locale: 'es',
  //showButtonPanel: true
 // navigationAsDateFormat:true,
});*/
    $(".datepicker").datetimepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
        },
        //daysOfWeekDisabled: [7],
        allowInputToggle: true,
        dayViewHeaderFormat: "DD MMMM YYYY",
        showTodayButton: true,
        locale: "es",
        format: "YYYY-MM-DD",
        //autoclose:true
        //debug:true,
        //disabledHours:true,
        // enabledHours:true
        //defaultDate:'YYYY-MM-DD',''
    });

    /*$(".datetime").datepicker({
  prevText: '<<',
  nextText: '>>' ,
  maxDate: 'today', 
  minDate: '1900-01-01',
  dateFormat: 'yy-mm-dd',
  changeMonth: true,
  changeYear: true,
  yearRange: "1900:today",
  showOptions: { direction: "up" },
  //showButtonPanel: true
 // navigationAsDateFormat:true,
}); */
    /*.mouseenter(function(e) {
       $(this).animate({'opacity' : 0.9}, 1000,
        'easeOutElastic'
                );
       $(this).children().children().animate({'width' : '99%'}, 1000, 
                'easeOutElastic');
   })
   .mouseleave(function(e) {
        $(this).animate({'opacity' : 1}, 400, 
                'easeInCirc');
       $(this).children().children().animate({'width' : '100%'}, 400, 
                'easeInCirc');
    });*/

    //////////////

    $("#table_list_model").on("click", ".btn_switch_estdoc", function (e) {
        e.preventDefault();
        id = $(this).attr("id");
        changeStateUser(id);
    });

    $("#table_list_model").on("click", ".btn_edit_per", function () {
        var id = getIdAttr($(this).attr("id"), "-", 1);
        searchPeriodo(id);
        $("#myModal_edit_periodo").modal("show");
    });

    $("#table_list_model").on("click", ".btn_edit_seg", function () {
        var id = getIdAttr($(this).attr("id"), "-", 1);
        searchSegmento(id);
        $("#myModal_edit_segmento").modal("show");
    });

    $("#form_expediente_user_edit").submit(function () {
        errors = validateForm("form_expediente_user_edit");
        if (errors <= 0) {
            return true;
        } else {
            return false;
        }
    });

    reloadSearchExp();
    //Select que busca en expedientes
    $("#tipo_busqueda").change(function () {
        var value = $(this).val();
        changeSelectSearchExp(value);
    });

    $("#btnEditar").click(function () {
        showElement("btnActualizar");
        showElement("btnCancelar");
        hideElement("btnEditar");
        enabledInput("disabled", "class");
        $(".disabled-fun3").prop("disabled", false);
        $(".disabled-fun3").selectpicker("refresh");
        if ($("#oldexpidnumberest").val() == "") {
            $("#oldexpidnumberest").val($("#expidnumberest").val());
        }
    });

    $(".tab-btn-show-notas").click(function () {
        if ($(this).attr("id")) {
            showElement("btn-tools-notas");
        } else {
            hideElement("btn-tools-notas");
        }
    });

    $("#btnCancelar").click(function () {
        hideElement("btnActualizar");
        hideElement("btnCancelar");
        showElement("btnEditar");
        disabledInput("disabled", "class");
        $(".disabled-fun3").prop("disabled", true);
        $(".disabled-fun3").selectpicker("refresh");
    });

    $("#btnActualizar").click(function () {
        var expediente_id = $("#expediente_id").val();
        var expidnumberest = $("#expidnumberest").val();
        var expramaderecho_id = $("#expramaderecho_id").val();
        var expestado = $("#expestado").val();
        var exptipoproce_id = $("#exptipoproce_id").val();
        var oldexpidnumberest = $("#oldexpidnumberest").val();
        //errors = validateForm('form_expediente_user_edit');
        if (
            expediente_id != "" &&
            expidnumberest != "" &&
            expramaderecho_id != "" &&
            expestado != "" &&
            exptipoproce_id != ""
        ) {
            // var token = $("#token").val();
            var route = "/expedientes/coordinador/update/" + expediente_id;
            $.ajax({
                url: route,
                headers: { "X-CSRF-TOKEN": token },
                type: "POST",
                datatype: "json",
                data: {
                    expidnumberest: expidnumberest,
                    expramaderecho_id: expramaderecho_id,
                    expestado: expestado,
                    exptipoproce_id: exptipoproce_id,
                    oldexpidnumberest: oldexpidnumberest,
                },
                cache: false,
                beforeSend: function (xhr) {
                    $("#wait").css("display", "block");
                    xhr.setRequestHeader(
                        "X-CSRF-TOKEN",
                        $("#token").attr("content")
                    );
                },
                /*muestra div con mensaje de 'regristrado'*/
                success: function (res) {
                    //console.log(res.exptipoproce);
                    $("#wait").css("display", "none");
                    hideElement("btnActualizar");
                    hideElement("btnCancelar");
                    showElement("btnEditar");
                    disabledInput("disabled", "class");
                    location.reload(true);
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(
                        "Hubo un error con el servidor ERROR::" + thrownError,
                        textStatus
                    );
                },
            });
        } else {
            alert("Hay campos que son obligatorios..");
        }
    });

    ////////////////////////

    $(".btn_detalles_horario").on("click", function () {
        var idnumber = getIdAttr($(this).attr("id"), "-");
        searchEstudAsignados(idnumber);
    });

    $("#table_list_model").on("click", ".btn_asig_doc_est", function (e) {
        e.preventDefault();
        var idnumber = getIdAttr($(this).attr("id"), "_");
        $("#label_idnumber_estToAsig").text(idnumber);
        $("#est_idnumber").val(idnumber);
        $("#myModal_asig_docente_estudiante").modal("show");
    });

    $("#docente_to_asig_id").on("change", function (e) {
        e.preventDefault();
        searchHorasDocente($(this).val());
    });

    $("#btn_asig_est_doc").click(asigDocenteEstu);

    $("#table_list_est_asig_doc").on(
        "click",
        ".btn_deleteasignacionaoc",
        function (e) {
            e.preventDefault();
            id = getIdAttr($(this).attr("id"), "_");
            deleteAsignacion(id);
        }
    );

    $("#btn_del_hor_doc").click(deleteAllHorarioDocentes);

    $("#btn_conf_asig_doc").click(confAsigDoc);

    $(".btn_updatecolor").click(function (e) {
        e.preventDefault();
        turno_id = getIdAttr($(this).attr("id"), "_");
        updateAsigTurno(turno_id);
    });

    $("#btn_del_all_turnos").click(deleteAllTurnos);

    $("#table_list_model").on("click", ".btn_asig_turno", function (e) {
        e.preventDefault();
        var idnumber = getIdAttr($(this).attr("id"), "_");
        $("#label_idnumber_estToAsig").text(idnumber);
        $("#est_idnumber").val(idnumber);
        $("#myModal_asig_turno_estudiante").modal("show");
    });

    $("#btn_asig_turno_est").click(asigTurnoEst);

    $("#btn_toggle_active").click(function (e) {
        clase = $(this).attr("class");
        var n = clase.search("switch-on");
        if (n != -1) {
            $("#tbl_users input[type='text']").each(function () {
                $(this).val(0);
                $("#tbl_users input[type='checkbox']").prop("checked", false);
                $("#btn_toggle_active")
                    .removeClass("switch-on")
                    .addClass("switch-off");
            });
        } else {
            $("#tbl_users input[type='text']").each(function () {
                $(this).val(1);
                $("#btn_toggle_active")
                    .removeClass("switch-off")
                    .addClass("switch-on");
                $("#tbl_users input[type='checkbox']").prop("checked", true);
            });
        }
    });

    $(".checkbox_usac").click(function () {
        var id = getIdAttr($(this).attr("id"), "_");

        if ($(this).is(":checked")) {
            $("#inputusac_" + id).val(1);
        } else {
            $("#inputusac_" + id).val(0);
        }
    });

    $("#myForm_empty_curso").on("submit", function (e) {
        $("#curso_selected").val($("#sel_cur_search option:selected").val());
    });

    $("#btn_buscantest").click(anteriorEstudiante);
    $("#table_lisestant_exp").on("click", ".btn_asgicasest", function (e) {
        idnumber = $(this).attr("id");
        searchExpAsig(idnumber);
    });

    $("#criterio").on("change", function () {
        var valor = $(this).val();
        $(".disabled-fun").selectpicker("refresh");
        switch (valor) {
            case "name":
                showElement("documento");
                $("#data_search").prop("disabled", false);
                $("#data_search_users").prop("disabled", true);
                hideElement("users");
                $("#rol").prop("disabled", true);
                hideElement("roles");
                $(".disabled-fun").selectpicker("refresh");
                break;
            case "idnumber":
                showElement("documento");
                $("#data_search").prop("disabled", false);
                $("#data_search_users").prop("disabled", true);
                hideElement("users");
                $("#rol").prop("disabled", true);
                hideElement("roles");
                $(".disabled-fun").selectpicker("refresh");
                break;
            case "rol":
                hideElement("users");
                $("#data_search_users").prop("disabled", true);
                hideElement("documento");
                $("#data_search").prop("disabled", true);
                $("#rol").prop("disabled", false);
                showElement("roles");
                $(".disabled-fun").selectpicker("refresh");
                break;
        }
    });

    $("#btn_seeall").on("click", function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        var data = {
            data_search: "all",
        };
        index_page(url, data);
        window.history.pushState(null, "", url);
        $("#data_search_users").selectpicker("refresh");
    });

    $("#myFormDownExcel").submit(function () {
        $("#wait").show();
        $("#wait").hide();
    });

    $("#actestado").on("change", function () {
        if ($(this).val() == "104") {
            showElement("addNotasAct", "class");
            $(".addNotasAct .required").prop("disabled", false);

            $("#myform_act_edit_docente #fecha_limit_doc").prop(
                "disabled",
                true
            );
        }else if ($(this).val() == "212") {
            hideElement("addNotasAct", "class");
            $("#myform_act_edit_docente #fecha_limit_doc").prop(
                "disabled",
                true
            );
        } else {
            hideElement("addNotasAct", "class");
            $(".addNotasAct .required").prop("disabled", true);
            $("#myform_act_edit_docente #fecha_limit_doc").prop(
                "disabled",
                false
            );
            
        }
        if ($(this).val() == "") {
            hideElement("addNotasAct", "class");
            $(".addNotasAct .required").prop("disabled", true);
            $("#myform_act_edit_docente #fecha_limit_doc").prop(
                "disabled",
                true
            );
        }
    });

    $(".add_nota_expedientes").on("click", function () {
        $("#myform_add_nota_final_expedientes #tpntid").val($(this).attr("id"));
        // alert($(this).attr('id'));
    });

    $("#btn_add_nota").on("click", function () {
        ingresarNotas();
    });

    $("#btn_create_segmento").on("click", function () {
        $("#myModal_create_segmento").modal("show");
    });

    $("#btn_create_periodo").on("click", function () {
        $("#myModal_create_periodo").modal("show");
    });

    $("#myform_create_periodo").on("submit", function () {
        errors = validateForm("myform_create_periodo");
        if (errors.length <= 0) {
            var data = $(this).serialize();
            create_periodo(data);
        }

        return false;
    });

    $("#myform_create_segmento").on("submit", function () {
        errors = validateForm("myform_create_segmento");
        if (errors.length <= 0) {
            var data = $(this).serialize();
            create_segmento(data);
        }

        return false;
    });

    $("#table_list_model").on("change", ".radio_state_periodo", function () {
        var id = getIdAttr($(this).attr("id"), "-", 1);
        url = "/periodos/change/state/" + id;
        change_state_periodo(url);
    });

    $("#table_list_model").on("change", ".radio_state_segmento", function () {
        var id = getIdAttr($(this).attr("id"), "-", 1);
        url = "/segmentos/change/state/" + id;
        change_state_periodo(url);
    });

    $("#switch_act_fc").on("click", function () {
        if ($(this).attr("dataset") == "1") {
            msj = confirm(
                "¿Esta seguro de desactivar el cierre de corte?\nRecuerde que antes debe cerrar el corte."
            );
            if (msj) change_state_segfc();
        } else {
            change_state_segfc();
        }
    });

    $("#btns_edit_notas").on("click", "#btn_cambiar_notas", function (e) {
        e.preventDefault();
        openCamNotas();
    });

    $("#myform_edit_periodo").submit(function () {
        errors = validateForm("myform_edit_periodo");
        if (errors.length <= 0) {
            var data = $(this).serialize();
            //window.history.pushState( {} , '/periodos', 'periodos/' );
            updatePeriodo(data);
        }
        return false;
    });

    $("#myform_edit_segmento").submit(function () {
        errors = validateForm("myform_edit_segmento");
        if (errors.length <= 0) {
            var data = $(this).serialize();
            //window.history.pushState( {} , '/periodos', 'periodos/' );
            updateSegmento(data);
        }
        return false;
    });

    $("#table_list_model").on("click", ".btn_del_per", function () {
        var msj = confirm("¿Está seguro de eliminar el registro?");
        if (msj) {
            var id = getIdAttr($(this).attr("id"), "-", 1);
            //url = '/segmentos/change/state/'+id;
            deletePeriodo(id);
        }
    });

    $("#table_list_model").on("click", ".btn_del_seg", function () {
        var msj = confirm("¿Está seguro de eliminar el registro?");
        if (msj) {
            var id = getIdAttr($(this).attr("id"), "-", 1);
            //url = '/segmentos/change/state/'+id;
            deleteSegmento(id);
        }
    });

    $("#myFormSearchPeriodo #datatype").on("change", function () {
        var val = $(this).val();
        switch (val) {
            case "name":
                placeholder = "Ingrese el nombre";
                type = "text";
                $("#myFormSearchPeriodo #data_search").val("");
                break;
            case "fecha_ini" || "fecha_fin":
                placeholder = "";
                type = "date";
                break;
        }
        $("#myFormSearchPeriodo #data_search").attr("placeholder", placeholder);
        $("#myFormSearchPeriodo #data_search").attr("type", type);
    });

    $("#myFormSearchPeriodo").submit(function () {
        errors = validateForm("myFormSearchPeriodo");
        if (errors.length <= 0) {
            page = $(this).attr("action");
            var data = $(this).serialize();
            index_page(page, data);
            window.history.pushState(null, "", page + "?" + data);
            //return false;
        }
        return false;
    });

    $("#myformExpFilter").submit(function (e) {
        e.preventDefault();
        errors = validateForm("myformExpFilter");
        if (errors.length <= 0) {
            page = $(this).attr("action");
            var data = $(this).serialize();
            index_page(page, data);
            window.history.pushState(null, "", page + "?" + data);
            //return false;
        }
        return false;
    });

    $(".btn_cambiar_docente").on("click", function () {
        var id = getIdAttr($(this).attr("id"), "-");
        showElement("btns_act-" + id);
        hideElement("btns_edit-" + id);
        showElement("select_docentes_div-" + id);
        hideElement("lbl_nombres_docente-" + id);
    });

    $(".btn_cancel_edit").on("click", function () {
        var id = getIdAttr($(this).attr("id"), "-");
        hideElement("btns_act-" + id);
        showElement("btns_edit-" + id);
        hideElement("select_docentes_div-" + id);
        showElement("lbl_nombres_docente-" + id);
    });

    $(".btn_actualizar_docente").on("click", function () {
        var id = getIdAttr($(this).attr("id"), "-");
        var new_docente = $("#select_docentes-" + id).val();
        updateDocenteAsignado(id, new_docente);
    });

    $(".btn_delete_turno").on("click", function () {
        var mjs = confirm("¿Está seguro de eliminar el registro?");
        if (mjs) {
            var id = getIdAttr($(this).attr("id"), "-");
            deleteTurno(id);
        }
    });

    $("#tbl_ajax").on("click", ".btn_change_status", function () {
        var id = $(this).val();
        var estado = $(this).attr("id");

        if (estado == 139) {
            var msj = alertify.confirm(
                "¿Esta seguro de cambiar el estado?\nSe eliminaran las notas"
            );
            msj.set("onok", function () {
                changeStateActuacion(id);
            });

            return false;
        } else {
            changeStateActuacion(id);
        }
    });

    $(".btn_new_act").on("click", function () {
        $("#actestado_id").val(101);
        $("#lbl_title_fract").text("Crear Actuación");
        $("#lbl_type_actuacion").text($(this).attr("data-titulo_modal"));
        $("#myformCreateAct input[name=fecha_limit]")
            .prop("disabled", false)
            .show();
        if ($(this).attr("id") == "btn_new_anex") {
            $("#actestado_id").val(136);
            $("#myformCreateAct input[name=fecha_limit]")
                .prop("disabled", true)
                .hide();
            $("#lbl_title_fract").text("Crear Anexo");
            $("#lbl_type_actuacion").text($(this).attr("data-titulo_modal"));
        }
        if ($(this).attr("id") == "btn_new_act_doct") {
            $("#actestado_id").val(140);
            $("#lbl_title_fract").text("Crear Actuación Docente");
            $("#lbl_type_actuacion").text($(this).attr("data-titulo_modal"));
        }
    });

    $("#myform_update_notas").submit(function (e) {
        //alert('alert')
        e.preventDefault();
        var data = $(this).serialize();
        updateNota(data);

        return false;
    });

    $("#btn_cancelar_notas").on("click", hideEditNotas);

    $("#btn_cam_nt_act").on("click", function () {
        $("#myModal_act_details").modal("hide");
        //$("#myModal_edit_notas").modal("show");
        var actuacion_id = $("#actuacion_id").val();
        get_notas(actuacion_id, 2);
    });

    $("#btn_cam_nt_req").on("click", function () {
        $("#myModal_req_details").modal("hide");
        //$("#myModal_edit_notas").modal("show");
        var actuacion_id = $("#req_id_det").val();
        get_notas(actuacion_id, 3);
    });
    $("#btn_edit_nt_exp").on("click", function () {
        // $("#myModal_req_details").modal('hide');
        //$("#myModal_edit_notas").modal("show");
        var actuacion_id = $("#form_expediente_edit #expediente_id").val();
        get_notas(actuacion_id, 1);
    });

    $(".btn_cancelEdhor").on("click", function () {
        var id = getIdAttr($(this).attr("id"), "-");
        hideEditHorario(id);
        //  alert(id);
    });

    $("#btn_buscar_nota").on("click", function () {
        var idnumber = "";
    });

    $("#myFormNotasSearch select[name=periodo_id]").on("change", function () {
        var periodo_id = $(this).val();
        if (periodo_id != "") {
            searchSegmentos(periodo_id, "gen");
        }
    });
    $("#myFormNotasSearchInd select[name=periodo_id]").on(
        "change",
        function () {
            var periodo_id = $(this).val();
            if (periodo_id != "") {
                searchSegmentos(periodo_id, "ind");
            }
        }
    );

    /* $("#myFormNotasSearch").on('submit',function(e){
  errors = validateForm('myFormNotasSearch');
  if (errors.length<=0) {
    var data = $(this).serialize();
    searchNotas(data);
  }  
e.preventDefault();
return false;
});
$("#myFormNotasSearchInd").on('submit',function(e){
  errors = validateForm('myFormNotasSearchInd');
  if (errors.length<=0) {
    var data = $(this).serialize();
    searchNotas(data);
  }  
e.preventDefault();
return false;
}); */

    $("#myFormNotasSearch input[name=type_repor]").on("change", function (e) {
        console.log($(this).val());
        if ($(this).val() == "periodo") {
            $("#myFormNotasSearch select[name=segmento_id]").prop(
                "disabled",
                true
            );
        } else {
            $("#myFormNotasSearch select[name=segmento_id]").prop(
                "disabled",
                false
            );
        }
    });

    $("#myFormNotasSearchInd input[name=type_repor]").on(
        "change",
        function (e) {
            console.log($(this).val());
            if ($(this).val() == "periodo") {
                $("#myFormNotasSearchInd select[name=segmento_id]").prop(
                    "disabled",
                    true
                );
            } else {
                $("#myFormNotasSearchInd select[name=segmento_id]").prop(
                    "disabled",
                    false
                );
            }
        }
    );

    $("#btns_edit_notas").on("click", "#btn_delete_notas", function () {
        deleteNotas();
    });

    $("#search_previous_act").on("click", function () {
        //alert('')
        if ($("#search_previous_act i").attr("class") == "fa fa-plus") {
            get_act_ant();
            $("#search_previous_act i").attr("class", "fa fa-minus");
        } else {
            $("#search_previous_act i").attr("class", "fa fa-plus");
            $(".cont_act_prev").toggle();
        }
    });

    $("#table_list_model").on("click", ".btn_cerrar_seg", function (e) {
        e.preventDefault();
        var msj = confirm(
            "Se asignaran notas con valor a 0 (cero) a los Expedientes sin evaluar.\n(No aplica para Expedientes abiertos en los ultimos 10 días, de acuerdo a la fecha final del corte)\n¿Está seguro de cerrar el corte?"
        );
        if (msj) {
            var id = getIdAttr($(this).attr("id"), "-");

            closeSegmento(id);
        }
    });

    $(".btn_detalles_nota").on("click", function (e) {
        var id = $(this).attr("id");
        var docente = $("#docenteEva_" + id).val();
        var concepto = $("#conceptoNota_" + id).val();
        $("#lblnamedocente").text(docente);
        $("#lblconceptonota").text(concepto);

        $("#myModal_details_not_caso").modal("show");
    });

    $("#btns_edit_notas").on("click", "#btn_tipo_nota_update", function () {
        var msj = confirm("¿Esta seguro de cambiar las notas");
        if (msj) {
            $("#tipo_nota_id").attr("disabled", false);
            $("#tipo_nota_id").val(
                $("#btn_tipo_nota_update").attr("data-value")
            );
            $("#myModal_edit_notas").modal("hide");
            openCamNotas();
            var data = $("#myform_update_notas").serialize();
            updateNota(data, "refresh");

            // console.log('hola', data);
        }
    });

    $("#btnTomarCaso").on("click", function (e) {
        //cabecera = '<h1><i class="fa fa-info"> </i> Atención </h1>';

        var confirm = alertify.confirm(
            "¿Esta seguro que quiere tomar el caso?",
            null,
            null
        );

        confirm.set("onok", function () {
            form = setFormToObject("form_expediente_edit");
            data = {
                exp_idnumberest: form.exp_idnumberest,
                expid: form.expid,
            };
            tomarCasoDocente(data);
        });

        e.preventDefault();
    });

    $("#search_onlyMy_exp").on("change", function () {
        searchExpedientes();
    });

    $(".btn_search_color").on("click", function (e) {
        var request = {
            tipo_busqueda: "color",
            data: $(this).attr("id"),
            search_onlyMy_exp: "on",
        };
        var route =
            "/expedientes?search_onlyMy_exp=on&tipo_busqueda=" +
            request.tipo_busqueda +
            "&data=" +
            request.data;
        index_page(route, request);
        window.history.pushState(null, "", route);
    });

    $("#btn_change_doc_exp").on("click", function (e) {
        e.preventDefault();
        $("#titulo_modal").text("Cambiando docente");
        $("#myform_change_docente_exp>#tipo_cambio").val(1);
        var name = $(this).attr("data-name");
        var lastname = $(this).attr("data-lastname");
        var idnumber = $(this).attr("data-idnumber");
        var option =
            '<option value="' +
            idnumber +
            '">' +
            name.toUpperCase() +
            " " +
            lastname.toUpperCase() +
            "</option>";

        searchDocentes(option);
    });
    $("#btn_send_exp_change").on("click", function (e) {
        e.preventDefault();
        $("#titulo_modal").text("Solicitando cambio");
        $("#myform_change_docente_exp>#tipo_cambio").val(0);
        searchDocentes();
    });

    $("#btn_asig_exp_doc").on("click", function (e) {
        e.preventDefault();
        $("#titulo_modal").text("Asignando docente");
        $("#myform_change_docente_exp>#tipo_cambio").val(4);
        var name = $(this).attr("data-name");
        var lastname = $(this).attr("data-lastname");
        var idnumber = $(this).attr("data-idnumber");
        var option =
            '<option value="' +
            idnumber +
            '">' +
            name.toUpperCase() +
            " " +
            lastname.toUpperCase() +
            "</option>";
        searchDocentes(option);

        /* form = setFormToObject('form_expediente_edit');
            data = {
              'exp_idnumberest': form.exp_idnumberest,
              'expid': form.expid
            };
         
            tomarCasoDocente(data); */
    });

    $("#btn_cancel_change_doc_exp").on("click", function (e) {
        e.preventDefault();
        var confirm = alertify.confirm(
            "¿Está seguro de <b>Cancelar</b> la solicitud de cambio?"
        );
        confirm.set("onok", function () {
            var data = { tipo_cambio: 2 };
            var exp_id = $("#expediente_id").val();
            changeDocenteExp(data, exp_id);
        });
    });

    $("#btn_delete_doc_exp").on("click", function (e) {
        e.preventDefault();
        var confirm = alertify.confirm(
            "¿Está seguro de <b>Eliminar</b> la asignación docente?"
        );
        confirm.set("onok", function () {
            var data = { tipo_cambio: 5 };
            var exp_id = $("#expediente_id").val();
            changeDocenteExp(data, exp_id);
        });
    });

    $("#btn_accept_change_doc_exp").on("click", function (e) {
        e.preventDefault();
        var confirm = alertify.confirm(
            "¿Está seguro de <b>Aceptar</b> la solicitud de cambio?"
        );
        confirm.set("onok", function () {
            var data = { tipo_cambio: 3 };
            var exp_id = $("#expediente_id").val();
            changeDocenteExp(data, exp_id);
        });
    });

    $("#myform_change_docente_exp").on("submit", function (e) {
        var data = $(this).serialize();
        var exp_id = $("#expediente_id").val();
        $("#myform_change_docente_exp input[type='submit]").prop(
            "disabled",
            true
        );
        changeDocenteExp(data, exp_id);
        $("#myModal_change_docente_exp").hide();
        e.preventDefault();
    });

    $("#ct_forcitaest").on("submit", "#myformCitarEstudiante", function (e) {
        var data = setFormToObject("myformCitarEstudiante");
        var fecha_l = setFechaToHumans(data.fecha);
        data.fecha_corta = data.fecha;
        data.fecha = fecha_l;
        data.exp_id = $("#expid").val();
        data.docente_fullname = $("#doc_full_name").val();

        sendCitacionEstudiante(data);
        return false;
        e.preventDefault();
    });

    $("#btn_nueva_cita").on("click", function (e) {
        e.preventDefault();
        $("#mymodalNuevaCitacion").modal("show");
    });

    $("#menu-notification").on(
        "click",
        "#btn_read_notifications",
        function (e) {
            e.preventDefault();
            changeNotifications();
        }
    );

    $("#myformUserEdit").submit(function (e) {
        $("#wait").show();
    });

    $("#myformCitarEstudiante").on("change", "#fecha", function () {
        searchCitasForDay($(this).val());
    });

    $("#table_list_citaciones").on("click", ".btn_edit_citacion", function () {
        var id = $(this).attr("id");
        editCitacionEstudiante(id);
    });

    $("#ct_forcitaest").on(
        "submit",
        "#myformCitarEstudianteEdit",
        function (e) {
            var data = setFormToObject("myformCitarEstudianteEdit");
            var exp_id = $("#expid").val();
            var fecha_l = setFechaToHumans(data.fecha);
            data.fecha_corta = data.fecha;
            data.fecha = fecha_l;
            data.exp_id = $("#expid").val();
            data.docente_fullname = $("#doc_full_name").val();
            data.exp_id = exp_id;
            updateCitacionEstudiante(data, data.id);
            e.preventDefault();
            return false;
        }
    );

    $("#btn_mod_expfecha_res").on("click", function (e) {
        data = {
            expfecha_res: $("#expfecha_res").val(),
            exp_id: $("#expid").val(),
            expediente_id: $("#expediente_id").val(),
        };
        updateExpediente(data);
        e.preventDefault();
    });

    $("#myform_exp_edit_cierre_caso select[name=new_expestado]").on(
        "change",
        function (e) {
            console.log(this.value);
            if ($(this).val() == "5") {
                $("#lbl_msj_nf")
                    .html("El caso se evaluará con notas finales en <b>0</b>")
                    .show();
            } else {
                $("#lbl_msj_nf").html("").hide();
            }
        }
    );

    $("#btn_nueva_autorizacion").on("click", function () {
        $("#myformEditAutorizacion").attr("id", "myformCreateAutorizacion");
        $("#myformCreateAutorizacion button")
            .removeClass("btn-warning")
            .addClass("btn-primary")
            .text("Crear");

        $("#mymodalCreateAutorizacion").modal("show");
    });

    $("#mymodalCreateAutorizacion").on(
        "submit",
        "#myformCreateAutorizacion",
        function (e) {
            var request = $(this).serialize() + "&exp_id=" + $("#expid").val();
            storeAutorizacion(request);
            e.preventDefault();
            return false;
        }
    );

    $("#table_list_autorizaciones").on(
        "click",
        ".btn_editar_autorizacion",
        function (e) {
            var id = $(this).attr("data-id");
            editAutorizacion(id);
        }
    );

    $("#mymodalCreateAutorizacion").on(
        "submit",
        "#myformEditAutorizacion",
        function (e) {
            var request = $(this).serialize();
            var id = $("#myformEditAutorizacion input[name=id]").val();
            updateAutorizacion(request, id);
            e.preventDefault();
        }
    );

    $("#table_list_autorizaciones").on(
        "click",
        ".btn_eliminar_autorizacion",
        function (e) {
            var id = $(this).attr("data-id");

            var msj = alertify.confirm(
                "¿Esta seguro de eliminar la autorización?\nNo podrá revertir los cambios"
            );
            msj.set("onok", function () {
                deleteAutorizacion(id);
            });
        }
    );

    $("#content_list_autorizaciones").on(
        "click",
        ".btn_change_estado_autorizacion",
        function (e) {
            var id = $(this).attr("data-id");

            if ($(this).attr("data-estado") == 0) {
                var request = { estado: 1, vista: "autorizaciones" };
            } else {
                var request = { estado: 0, vista: "autorizaciones" };
            }
            changeStatusAutorizacion(request, id);
        }
    );

    $("#table_list_autorizaciones").on(
        "click",
        ".btn_change_estado_autorizacion",
        function (e) {
            var id = $(this).attr("data-id");
            if ($(this).attr("data-estado") == 0) {
                var request = { estado: 1, vista: "expedientes" };
            } else {
                var request = { estado: 0, vista: "expedientes" };
            }
            changeStatusAutorizacion(request, id);
        }
    );

    $("#myformSearchAutorizaciones").submit(function (e) {
        errors = validateForm("myformSearchAutorizaciones");
        if (errors.length <= 0) {
            page = $(this).attr("action");
            var data = $(this).serialize();
            index_autorizaciones(page, data);
            window.history.pushState(null, "", page + "?" + data);
            //return false;
        }
        e.preventDefault();
        return false;
    });
    $("#btn_ver_todo_autorizaciones").on("click", function (e) {
        page = $("#myformSearchAutorizaciones").attr("action");
        var request = {};
        index_autorizaciones(page, request);
        window.history.pushState(null, "", page);
    });

    $("#content_list_oficinas").on("click", ".btn_asig_usuarios", function (e) {
        $("#myformUserStore input[name=oficina_id]").val(
            $(this).attr("data-id")
        );
        $("#myModal_asig_user_oficina").modal("show");
    });

    $("#content_list_oficinas").on("click", ".btn_ver_usuarios", function (e) {
        var request = { oficina_id: $(this).attr("data-id") };

        oficinaGetUsers(request);
    });

    $("#content_list_oficinas").on("click", ".btn_edit_oficina", function (e) {
        var request = { oficina_id: $(this).attr("data-id") };
        oficinaEdit(request);
    });

    $("#content_list_oficinas").on(
        "click",
        ".btn_delete_oficina",
        function (e) {
            var request = { oficina_id: $(this).attr("data-id") };
            var msj = alertify.confirm(
                "¿Esta seguro de eliminar la oficina, se eliminaran todos los registros asociados.\nNo podrá recuperar los datos!"
            );
            msj.set("onok", function () {
                oficinaDelete(request);
            });
        }
    );

    $("#myformUserStore").on("submit", function (e) {
        var request = $(this).serialize();
        userStore(request);
        e.preventDefault();
    });

    $("#myformUserStore").on("blur", ".data_user", function (e) {
        if (
            this.value != "" &&
            $("#myformUserStore select[name=tipodoc_id]").val() != ""
        ) {
            var request = {
                idnumber: $(this).val(),
                tipodoc_id: $("#myformUserStore select[name=tipodoc_id]").val(),
            };
            findUser(request);
        }
    });
    $("#myformUserStore select[name=tipodoc_id]").on("change", function (e) {
        if (
            this.value != "" &&
            $("#myformUserStore input[name=idnumber]").val() != ""
        ) {
            var request = {
                tipodoc_id: $(this).val(),
                idnumber: $("#myformUserStore input[name=idnumber]").val(),
            };
            findUser(request);
        }
    });
    $("#btn_create_oficina").on("click", function (e) {
        $("#myformEditOficina").attr("id", "myformCreateOficina");
        $("#myformCreateOficina")[0].reset();
        $("#myformCreateOficina input[type=submit]").text("Guardar");
        $("#myModal_oficina_create").modal("show");
    });

    $("#contcreateof").on("submit", "#myformCreateOficina", function (e) {
        var request = $(this).serialize();
        oficinaStore(request);
        e.preventDefault();
    });
    $("#contcreateof").on("submit", "#myformEditOficina", function (e) {
        var request = $(this).serialize();
        var oficina_id = $("#myformEditOficina input[name=id]").val();
        oficinaUpdate(request, oficina_id);
        e.preventDefault();
    });

    $("#list_students_oficinas").on(
        "click",
        ".btn_asig_notas_ext",
        function (e) {
            $("#myform_asig_nota_ext input[name=estidnumber]").val(
                $(this).attr("data-id")
            );
            var request = {
                idnumber: $(this).attr("data-id"),
                oficina_id: $("#oficina_id").val(),
                origen: 5,
            };
            findNotas(request);
        }
    );

    $("#myform_asig_nota_ext").on("submit", function (e) {
        var request = $(this).serialize();
       
        if ($("#myform_asig_nota_ext input[name=typesub]").val() == "store") {
            storeNotaExt(request);
        }
        if ($("#myform_asig_nota_ext input[name=typesub]").val() == "update") {
            var id = $("#myform_asig_nota_ext input[name=estidnumber]").val();
            oficinaUpdateNota(request, id);
        }
        e.preventDefault();
    });

    $("#myform_asig_nota_ext").on("change", "#chk_change_nota", function (e) {
        /* if($("#myform_asig_nota_ext input[name=typesub]").val()=='update'){
    if($(this).is(":checked")){
      $("#myform_asig_nota_ext input[type=submit]").prop('disabled',false).show(); 
      $("#myform_asig_nota_ext input[name=ntaconocimiento]").prop('disabled',false);
      $("#myform_asig_nota_ext textarea[name=ntaconcepto]").prop('disabled',false);                    
    }else{
      $("#myform_asig_nota_ext input[type=submit]").prop('disabled',true).hide(); 
      $("#myform_asig_nota_ext input[name=ntaconocimiento]").prop('disabled',true)
      $("#myform_asig_nota_ext textarea[name=ntaconcepto]").prop('disabled',true)
              
    } 
  } */
    });

    $("#table_list_oficina_usuarios").on(
        "click",
        ".btn_delete_userof",
        function (e) {
            var request = {
                user_id: $(this).attr("data-id"),
                oficina_id: $("#oficina_id").val(),
            };
            var msj = alertify.confirm(
                "¿Esta seguro de eliminar el usuario.\nNo podrá recuperar los datos!"
            );
            msj.set("onok", function () {
                oficinaUserDelete(request);
            });
        }
    );

    $("#btn_crear_conciliacion").on("click", function () {
        $("#myModal_conciliacion_create").modal("show");
    });

    $("#content_oficina_virtual").on(
        "click",
        "#btn_adm_documentos",
        function (e) {
            $("#myModal_adm_documentos").modal("show");
        }
    );

    $("#content_oficina_virtual").on(
        "click",
        "#btn_adm_notificaciones",
        function (e) {
            var type_log_id = $(this).attr("data-type");
            $("#myformCreateDocumento input[name=type_log_id]").val(
                type_log_id
            );
            $("#myModal_notificacion").modal("show");
        }
    );

    $(".content_oficina_virtual").on(
        "click",
        "#btn_videollamada",
        function (e) {
            var type_log_id = $(this).attr("data-type");
            var route = "/expediente/createstream/" + type_log_id;
            $.ajax({
                url: route,
                type: "GET",
                datatype: "json",
                data: {},
                cache: false,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        "X-CSRF-TOKEN",
                        $("#token").attr("content")
                    );
                    $("#wait").css("display", "block");
                },
                success: function (res) {
                    var url = "https://videochat.udenar.edu.co/";
                    $("#newtab-stream-cases").attr(
                        "href",
                        url + res.room + "?jwt=" + res.jwt
                    );
                    $("#copy-stream-cases").attr(
                        "data-frame",
                        url + res.room + "?jwt=" + res.jwt
                    );
                    $("#text-stream-cases").val(url + res.room);
                    $("#iframe-stream-cases").attr(
                        "src",
                        url + res.room + "?jwt=" + res.jwt
                    );
                    $("#myModal_videollamadas").modal("show");

                    $("#wait").css("display", "none");
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(
                        "Hubo un error con el servidor, consulte con el administrador"
                    );
                    $("#wait").css("display", "none");
                },
            });
        }
    );

    $("#content_create_notificacion").on(
        "submit",
        "#myformCreateNotificacion",
        function (e) {
            // var request = $(this).serialize()+"&exp_id="+$("#expediente_id").val();
            var request = new FormData($(this)[0]);
            request.append("exp_id", $("#expediente_id").val());
            storeDocumentos(request);
            e.preventDefault();
        }
    );

    $("#cont_adm_docs").on("submit", "#myformEditDocumento", function (e) {
        var id = $("#myformEditDocumento input[name=id]").val();
        var request = new FormData($(this)[0]);
        request.append("exp_id", $("#expediente_id").val());
        updateDocumentos(request, id);
        console.log(request);
        e.preventDefault();
    });

    $("#content_docs_files").on("click", ".btn_log_edit", function (e) {
        var id = $(this).attr("data-id");
        editDocumentos(id);
    });

    $("#content_docs_files").on("click", ".btn_log_delete", function (e) {
        var id = $(this).attr("data-id");
        Swal.fire({
            title: "Esta seguro de eliminar el documento?",
            text: "Los cambios no podrán ser revertidos!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                deleteDocumentos(id);
            }
        });
    });

    $("#btn_cancel_upddoc").on("click", function (e) {
        resetFormCDoc();
    });

    $("#btn_cancel_upsoldoc").on("click", function (e) {
        resetFormSoliDoc();
    });

    $("#myformAceptSolicitud input[type=checkbox]").on("change", function (e) {
        if ($(this).is(":checked")) {
            $("#cont_ites").show();
            $("#cont_ites input").prop("disabled", false);
        } else {
            $("#cont_ites").hide();
            $("#cont_ites input").prop("disabled", true);
        }
    });

    $("#btn_acept_solicitud").on("click", function (e) {
        var id = $(this).attr("data-id");
        $("#myModal_solicitud_acept").modal("show");
        /* Swal.fire({
      title: 'Esta seguro de aceptar la solicitud?',
      text: "Se habilitará la sala de chat!",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, aceptar!',
      cancelButtonText: 'No, cancelar'
    }).then((result) => {
      if (result.value) {
        var d = new Date().toLocaleString();
          let request = {'type_status_id':156}
          updateSolicitud(request,id)            
      }
    });  */
    });
    $("#myformAceptSolicitud").on("submit", function (e) {
        var request =
            $(this).serialize() +
            "&solicitud_id=" +
            $("#solicitud_id").val() +
            "&type_status_id=156";
        $("#soli_type_status_id").val(156);
        updateSolicitud(request, $("#solicitud_id").val());
        e.preventDefault();
    });

    $("#btn_aprob_solicitud").on("click", function (e) {
        var id = $(this).attr("data-id");
        Swal.fire({
            title: "Esta seguro de aprobar la solicitud?",
            text: "Podrá asignarle un expediente!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, aprobar!",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (result.value) {
                var d = new Date().toLocaleString();
                let request = { type_status_id: 162 };
                updateSolicitud(request, id);
            }
        });
    });

    $("#btn_active_reguser").on("click", function (e) {
        var id = $(this).attr("data-id");
        Swal.fire({
            title: "Esta seguro de habilitar el registro?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, aprobar!",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (result.value) {
                var d = new Date().toLocaleString();
                let request = { type_status_id: 171 };
                updateSolicitud(request, id);
            }
        });
    });

    $(".btn_change_sede").on("click", function (e) {
        var id = $(this).attr("data-id");
        Swal.fire({
            title: "Esta seguro de seleccionar esta sede?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, seleccionar!",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (!result.value) {
                e.preventDefault();
                return false;
            } else {
                $("#myFormCambiarSede-" + id).submit();
            }
        });
    });

    $(".btn_cambiar_sede").on("click", function (e) {
        var id = $(this).attr("data-id");
        $("#myFormCambiarSede input[name=sede_id]").val(id);
        $("#myFormCambiarSede").submit();
    });

    $("#btn_denied_solicitud").on("click", function (e) {
        var id = $(this).attr("data-id");
        $("#myModal_solicitud_denied").modal("show");
    });

    $("#myformDeniedSolicitud").on("submit", function (e) {
        var request =
            $(this).serialize() +
            "&solicitud_id=" +
            $("#solicitud_id").val() +
            "&type_status_id=157";
        updateSolicitud(request, $("#solicitud_id").val());
        e.preventDefault();
    });

    $("#cont_adm_docs").on(
        "submit",
        "#myformCreateSoliDocumento",
        function (e) {
            // var request = $(this).serialize()+"&exp_id="+$("#expediente_id").val();
            var request = new FormData($(this)[0]);
            request.append("solicitud_id", $("#solicitud_id").val());
            storeSoliDocumentos(request);
            e.preventDefault();
        }
    );

    $("#content_solicitudes_files").on("click", ".btn_doc_edit", function (e) {
        var id = $(this).attr("data-id");
        let request = { solicitud_id: $("#solicitud_id").val() };
        editSoliDocumentos(request, id);
    });

    $("#cont_adm_docs").on("submit", "#myformEditSoliDocumento", function (e) {
        var id = $("#myformEditSoliDocumento input[name=id]").val();
        var request = new FormData($(this)[0]);
        request.append("solicitud_id", $("#solicitud_id").val());
        updateSoliDocumentos(request, id);
        console.log(request);
        e.preventDefault();
    });

    $("#content_solicitudes_files").on(
        "click",
        ".btn_doc_delete",
        function (e) {
            var id = $(this).attr("data-id");
            let request = { solicitud_id: $("#solicitud_id").val() };
            Swal.fire({
                title: "Esta seguro de eliminar el documento?",
                text: "Los cambios no podrán ser revertidos!",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, cancelar",
            }).then((result) => {
                if (result.value) {
                    deleteSoliDocumentos(request, id);
                }
            });
        }
    );

    $("#myFormAsigExpe").on("submit", function (e) {
        let request =
            $("#myFormAsigExpe").serialize() +
            "&solicitud_id=" +
            $("#solicitud_id").val();
        asignarExpediente(request);
        e.preventDefault();
    });
    $("#active_password").on("change", function (e) {
        if (!$(this).is(":checked")) {
            $("#cont_new_pass input").prop("disabled", true);
            $("#cont_new_pass").hide();
        } else {
            $("#cont_new_pass input").prop("disabled", false);
            $("#cont_new_pass").show();
        }
    });

    $("#btn_new_category").on("click", function (e) {
        $("#myformEditRCategory").attr("id", "myformCreateCategory");
        $("#myformCreateCategory")[0].reset();
        $("#aditional_options_table tbody").html("");
        $("#content_aditional_options").hide();
        $("#myformCreateCategory button[type=submit]")
            .text("Guardar")
            .removeClass("btn-warning")
            .addClass("btn-primary");
       $(".select2").select2();
        $("#lbl_modal_title").text("Creando categoria");
        $("#myModal_create_category").modal("show");
    });

    $("#btn_new_static_category").on("click", function (e) {
        $("#myformEditRStaticCategory").attr(
            "id",
            "myformCreateStaticCategory"
        );
        $("#myformCreateStaticCategory")[0].reset();
        $("#aditional_options_table tbody").html("");
        $("#content_aditional_options").hide();
        $("#myformCreateStaticCategory button[type=submit]")
            .text("Guardar")
            .removeClass("btn-warning")
            .addClass("btn-primary");
        $("#lbl_modal_title").text("Creando categoria");
        $("#myModal_create_static_category").modal("show");
    });

    $("#myformCreateCategory select[name=type_data_id]").on(
        "change",
        function (e) {
            if ($(this).val() == "169" || $(this).val() == "170") {
                var item = $(".option_row").length;
                if (item == 0) {
                    addOptionTable(item);
                }
                $("#content_aditional_options").show();
                $("#content_aditional_options input").prop("disabled", false);
            } else {
                $("#content_aditional_options").hide();
                $("#content_aditional_options input").prop("disabled", true);
            }
        }
    );

    $("#myformCreateStaticCategory select[name=type_data_id]").on(
        "change",
        function (e) {
            if ($(this).val() == "169" || $(this).val() == "170") {
                var item = $(".option_row").length;
                if (item == 0) {
                    addOptionTable(item);
                }
                $("#content_aditional_options").show();
                $("#content_aditional_options input").prop("disabled", false);
            } else {
                $("#content_aditional_options").hide();
                $("#content_aditional_options input").prop("disabled", true);
            }
        }
    );

    $(".btn_add_field").on("click", function (e) {
        var item = $(".option_row").length;
        addOptionTable(item);
    });

    $("#content_aditional_options").on(
        "click",
        ".btn_delete_option_row",
        function (e) {
            var older_row = $(this).attr("data-item");
            items_delete.push({ id: $(this).attr("data-id") });
            $("#option_row-" + older_row).remove();
            $(".option_row").each((row, obj) => {
                var current_row = $(obj).attr("data-item") - 1;
                if (current_row == older_row) {
                    $(obj).attr("data-item", older_row);
                    $(obj).attr("id", "option_row-" + older_row);
                    $(obj).find("button").attr("data-item", older_row);
                    $(obj)
                        .find("button")
                        .attr("id", "option_row-" + older_row);
                    older_row = parseInt(older_row) + 1;
                    $(obj)
                        .find("input[id=active_other_input-" + older_row + "]")
                        .attr("id", "active_other_input-" + current_row);
                    $(obj)
                        .find("input[id=active-" + older_row + "]")
                        .attr("id", "active-" + current_row);
                }
            });
            if (older_row <= 0) {
                $("#chk_add_option").prop("checked", false);
                $(".adoptions").hide();
                $("#type_data_id").val(26);
            }
        }
    );

    $("#content_aditional_options").on(
        "click",
        ".chk_active_other_input",
        function (e) {
            var item = $(this).attr("id").split("-")[1];
            if ($(this).is(":checked")) {
                $("#active_other_input-" + item).val(1);
            } else {
                $("#active_other_input-" + item).val(0);
            }
        }
    );

    $("#myModal_create_category").on(
        "submit",
        "#myformCreateCategory",
        function (e) {
            var request = $(this).serialize();
            createCategory(request);
            e.preventDefault();
        }
    );

    $("#myModal_create_static_category").on(
        "submit",
        "#myformCreateStaticCategory",
        function (e) {
            var request = $(this).serialize();
            createStaticCategory(request);
            e.preventDefault();
        }
    );

    $("#myModal_create_category").on(
        "submit",
        "#myformEditRCategory",
        function (e) {
            $("#items_deleted").val(JSON.stringify(items_delete));
            var request = $(this).serialize();
            let id = $("#myformEditRCategory input[name=id]").val();
            referenceUpdate(request, id);
            e.preventDefault();
        }
    );

    $("#myModal_create_static_category").on(
        "submit",
        "#myformEditRStaticCategory",
        function (e) {
            $("#items_deleted").val(JSON.stringify(items_delete));
            var request = $(this).serialize();
            let id = $("#myformEditRStaticCategory input[name=id]").val();
            referenceStaticUpdate(request, id);
            e.preventDefault();
        }
    );

    $("#content_categories_list").on(
        "click",
        ".btn_edit_category",
        function (e) {
            let id = $(this).attr("data-id");
            referenceEdit(id);
            e.preventDefault();
        }
    );

    $("#content_categories_list").on(
        "click",
        ".btn_edit_con_category",
        function (e) {
            let id = $(this).attr("data-id");
            referenceConciliacionEdit(id);
            e.preventDefault();
        }
    );

    $("#content_aditional_data").on(
        "change",
        ".data_input_select",
        function (e) {
            let id = $(this).attr("data-id");
            //alert(id)
            let status = $("#option_id-" + id + " option:selected").attr(
                "data-active_other"
            );
            if (status == 1) {
                $("#value_other_text-" + id).attr("type", "text");
                $("#lbl_other-" + id).show();
            } else {
                $("#value_other_text-" + id).attr("type", "hidden");
                $("#lbl_other-" + id).hide();
            }
        }
    );

    $(".insert_adv").on("focus", function (e) {
        $("#older_value").val($(this).val());
    });

    $(".insert_adv").on("blur", function (e) {
        if ($(this).val() != $("#older_value").val() && $(this).val() != "") {
            var request = {
                value: $(this).val(),
                value_is_other: "",
                section: $(this).attr("data-section"),
                name: $(this).attr("data-name"),
                conciliacion_id: $("#conciliacion_id").val(),
            };

            insertConADValue(request);
        }
    });

    $(".insert_adv_change").on("change", function (e) {
        if ($(this).val() != "") {
            if ($(this).prop("type") == "select-one") {
                var request = {
                    value: $(this).val(),
                    value_is_other: "",
                    section: $(this).attr("data-section"),
                    name: $(this).attr("data-name"),
                    conciliacion_id: $("#conciliacion_id").val(),
                    reference_data_option_id: $(this)
                        .find(":selected")
                        .attr("data-option_id"),
                };
            } else {
                var request = {
                    value: $(this).val(),
                    value_is_other: "",
                    section: $(this).attr("data-section"),
                    name: $(this).attr("data-name"),
                    conciliacion_id: $("#conciliacion_id").val(),
                };
            }
            insertConADValue(request);
        }
    });

    $("#btn_create_document").on("click", function (e) {
        $("#myformEditConciliacionAnexo").attr(
            "id",
            "myformCreateConciliacionAnexo"
        );
        $("#myformCreateConciliacionAnexo")[0].reset();
        $("#myformCreateConciliacionAnexo input[name=concept]").val(
            $(this).attr("data-concept")
        );
        $("#myformEditConciliacionAnexo input[name=conciliacion_file]").prop(
            "required",
            true
        );
        $("#myformCreateConciliacionAnexo button[type=submit]").text("Crear");
        $("#myModal_create_document .modal-title").text("Creando anexo");
        $("#myModal_create_document").modal("show");
    });

    $("#myModal_create_document").on(
        "submit",
        "#myformCreateConciliacionAnexo",
        function (e) {
            var request = new FormData($(this)[0]);
            request.append("conciliacion_id", $("#conciliacion_id").val());
            storeConciliacionAnexo(request);
            e.preventDefault();
        }
    );

    $("#myModal_create_document").on(
        "submit",
        "#myformEditConciliacionAnexo",
        function (e) {
            var request = new FormData($(this)[0]);
            request.append("conciliacion_id", $("#conciliacion_id").val());
            updateConciliacionAnexo(request);
            e.preventDefault();
        }
    );

    $("#table_anexos_list").on("click", ".btn_edit_anxcon", function (e) {
        $("#myformCreateConciliacionAnexo").attr(
            "id",
            "myformEditConciliacionAnexo"
        );
        $("#myformEditConciliacionAnexo input[name=file_id]").val(
            $(this).attr("data-id")
        );
        $("#myformEditConciliacionAnexo input[name=concept]").val(
            $(this).attr("data-concept")
        );
        $("#myformEditConciliacionAnexo input[name=conciliacion_file]").prop(
            "required",
            false
        );
        $("#myformEditConciliacionAnexo button[type=submit]").text(
            "Actualizar"
        );
        $("#myModal_create_document .modal-title").text("Actualizando anexo");
        $("#myModal_create_document").modal("show");
    });

    $("#table_anexos_list").on("click", ".btn_delete_anxcon", function (e) {
        var request = {
            file_id: $(this).attr("data-id"),
            conciliacion_id: $("#conciliacion_id").val(),
        };
        Swal.fire({
            title: "Esta seguro de eliminar el archivo?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (result.value) {
                deleteConciliacionAnexo(request);
            }
        });
    });

    $("#btn_cambiar_estado").on("click", function (e) {
        $("#myformEditEstado").attr("id", "myformCreateEstado");
        $("#myformCreateEstado textarea[name=comentario]").val("");
        $("#myformCreateEstado button[type=submit]").text("Crear");
        $("#myModal_create_estado .modal-title").text("Creando estado");
        $("#myModal_create_estado").modal("show");
    });
    $("#btn_agregar_comentario").on("click", function (e) {
        $("#myformEditComentario").attr("id", "myformCreateComentario");
        $("#myformCreateComentario textarea[name=comentario]").val("");
        $("#myformCreateComentario button[type=submit]").text("Crear");
        $("#myModal_create_comentario .modal-title").text("Creando comentario");
        $("#myModal_create_comentario").modal("show");
    });

    $(".btn_asinar_usuario_conciliacion").on("click", function (e) {
        var data_type = $(this).attr("data-type");
        $("#myModal_conc_user_create input[name=tipo_usuario_id]").val(data_type);
        $("#myModal_conc_user_create input[name=section]").val($(this).attr('data-section'));
        var request = {          
            'conciliacion_id':$("#conciliacion_id").val(),          
            'data_type':data_type,
            'section':$(this).attr('data-section'),
        }
        if ($(this).attr('data-user')!=undefined) {
            request['idnumber'] = $(this).attr('data-user');
            request['tipodoc_id'] = $("#myModal_conc_user_create select[name=tipodoc_id]").val();  
            request['is_edit'] = true;  
        }else{
            request['idnumber'] = '0';
            request['tipodoc_id'] = 1;          
        }        
        getUser(request,request.idnumber);
        $("#myModal_conc_user_create").modal("show"); 
    });
    $(".btn_delete_usuario_conciliacion").on("click", function (e) {
        var data_pivot = $(this).attr("data-pivot");
        var request = {'pivot':data_pivot}
        Swal.fire({
            title: "Esta seguro de eliminar la asignación?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (result.value) {
                deleteConciliacionUser(request);
            }
        });
    });
    

    $("#myModal_conc_user_create").on("blur",'input[name=idnumber]',function (e) {
        var id = $(this).val();
        var request = {
            'idnumber':id,
            'conciliacion_id':$("#conciliacion_id").val(),
            'tipodoc_id': $("#myModal_conc_user_create select[name=tipodoc_id]").val(),
            'section':$("#myModal_conc_user_create input[name=section]").val()
        }
        console.log(request);
        getUser(request,id);
    });

    $("#myModal_conc_user_create").on("submit",'#myformEditConciliacionUser',function (e) {
        var id = $("#myformEditConciliacionUser input[name=id]").val();
        var tipo_usuario_id = $("#myModal_conc_user_create input[name=tipo_usuario_id]").val() != '' ? $("#myModal_conc_user_create input[name=tipo_usuario_id]").val() : $("#myModal_conc_user_create select[name=tipo_usuario_id]").val()
        var request = $(this).serialize()+"&tipo_usuario_id="+tipo_usuario_id;
        conciliacionUserUpdate(request,id);
        e.preventDefault();
    });
    $("#myModal_conc_user_create").on("submit",'#myformCreateConciliacionUser',function (e) {
        var tipo_usuario_id = $("#myModal_conc_user_create input[name=tipo_usuario_id]").val() != '' ? $("#myModal_conc_user_create input[name=tipo_usuario_id]").val() : $("#myModal_conc_user_create select[name=tipo_usuario_id]").val()
        var request = $(this).serialize()+"&tipo_usuario_id="+tipo_usuario_id;      
        conciliacionUserStore(request);
        e.preventDefault();
    });


    $("#myModal_create_estado").on("submit","#myformCreateEstado",function (e) {
            //var request = $(this).serialize() +  "&conciliacion_id=" +   $("#conciliacion_id").val();
            var request = new FormData($(this)[0]);
            request.append("conciliacion_id", $("#conciliacion_id").val());
            storeConciliacionEstado(request);
            e.preventDefault();
        }
    );

    $("#myModal_create_comentario").on(
        "submit",
        "#myformCreateComentario",
        function (e) {
            var request =
                $(this).serialize() +
                "&conciliacion_id=" +
                $("#conciliacion_id").val();
            storeConciliacionComentario(request);
            e.preventDefault();
        }
    );

    $("#myModal_create_comentario").on(
        "submit",
        "#myformEditComentario",
        function (e) {
            var request =
                $(this).serialize() +
                "&conciliacion_id=" +
                $("#conciliacion_id").val();
            updateConciliacionComentario(request);
            e.preventDefault();
        }
    );

    $("#myModal_create_estado").on("submit", "#myformEditEstado", function (e) {
        var request =
            $(this).serialize() +
            "&conciliacion_id=" +
            $("#conciliacion_id").val();
        updateConciliacionEstado(request);
        e.preventDefault();
    });

    $("#table_list_comentarios").on(
        "click",
        ".btn_delete_com_con",
        function (e) {
            var request = {
                comentario_id: $(this).attr("data-id"),
                conciliacion_id: $("#conciliacion_id").val(),
            };
            Swal.fire({
                title: "Esta seguro de eliminar el comentario?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, cancelar",
            }).then((result) => {
                if (result.value) {
                    deleteConciliacionComentario(request);
                }
            });
        }
    );

    $("#table_list_estados").on("click", ".btn_delete_est_con", function (e) {
        var request = {
            estado_id: $(this).attr("data-id"),
            conciliacion_id: $("#conciliacion_id").val(),
        };
        Swal.fire({
            title: "Esta seguro de eliminar el estado?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar",
        }).then((result) => {
            if (result.value) {
                deleteConciliacionEstado(request);
            }
        });
    });

    $("#table_list_comentarios").on("click", ".btn_edit_com_con", function (e) {
        var request = {
            comentario_id: $(this).attr("data-id"),
            conciliacion_id: $("#conciliacion_id").val(),
        };
        editConciliacionComentario(request);
    });

    $("#table_list_estados").on("click", ".btn_edit_est_con", function (e) {
        var request = {
            estado_id: $(this).attr("data-id"),
            conciliacion_id: $("#conciliacion_id").val(),
        };
        editConciliacionEstado(request);
    });

    $("#table_list_estados").on("click", ".btn_descargar_rep_pdf", function (e) {
        /*var request = {
            estado_id: $(this).attr("data-id"),
            conciliacion_id: $("#conciliacion_id").val(),
        };
        getEstadosReportesPdf(request);*/

        var request = {
            tabla_destino: "conciliaciones",
            status_id: $(this).attr("data-estado_id"),
            conciliacion_id:$("#conciliacion_id").val()
        };
        getPdfReportesConciliacion(request);

    });

    $("#reporte").on("submit", "#myFormCreatePdfReporte", function (e) {
        var request = serializePdf(
            "myFormCreatePdfReporte",
            "summernote_store"
        );
        if (request) storePdfReporte(request);
        e.preventDefault();
    });

    $("#reporte").on("submit", "#myFormEditPdfReporte", function (e) {      
        var request = serializePdf(
            "myFormEditPdfReporte",
            "summernote_update"
        );
        var id = $("#myFormEditPdfReporte select[name=id]").val();
        if(id==undefined)id = $("#myFormEditPdfReporte input[name=id]").val();
        if (request) updatePdfReporte(request, id);
        e.preventDefault();
    });





    $(".btn_generate_pdf_preview").on("click", function (e) {
        e.preventDefault();
        var myForm = $(this).attr("data-form");
        var mySummernote = $(this).attr("data-summernote");       
        var request = serializePdf(myForm, mySummernote);
        if (request) createPdfPreview(request);
    });

    $("#sel_reporte_id").on("change", function () {
        var id = $(this).val();
        if(id!='')editPdfReporte(id);
    });

    $("#myFormAsigReporte").on("submit", function (e) {
        var request = $(this).serialize();
        asignarReporte(request);
        e.preventDefault();
    });

    $("#myFormAsigReporte .select").on("change", function (e) {
        var tabla_destino = $(
            "#myFormAsigReporte select[name=tabla_destino]"
        ).val();
        var status_id = $("#myFormAsigReporte select[name=status_id]").val();
        if (tabla_destino != "" && status_id != "") {
            var request = {
                tabla_destino: tabla_destino,
                status_id: status_id,
            };
            editAsignacionReporte(request);
        }
    });

    $("#myformCreateEstado select[name=type_status_id]").on("change",function (e) {
            if ($(this).val() != "") {
                var request = {
                    tabla_destino: "conciliaciones",
                    status_id: $(this).val(),
                    conciliacion_id:$("#conciliacion_id").val()
                };
               // getPdfReportesConciliacion(request);
            }
        });

     myPopupWindow = window;
    $("#myReportPdfList").on("click", ".btn_edit_con_pdf", function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        var bgdiv = $("<div>").attr({
            className: "bgtransparent",
            id: "bgtransparent",
        });
        // agregamos nuevo div a la pagina       
        $("body").append(bgdiv);
        // obtenemos ancho y alto de la ventana del explorer
        var wscr = $(window).width();
        var hscr = $(window).height();
        //establecemos las dimensiones del fondo
        $("#bgtransparent").css("width", wscr);
        $("#bgtransparent").css("height", hscr);
        myPopupWindow = window.open(
            url,
            "popup",
            "toolbar=no,width=" +
                (window.screen.width - 10) +
                ", height= " +
                (window.screen.height - 10) +
                ",left=10, top=15,resizable=no,scrollbars=NO"
        );      
        myPopupWindow.addEventListener('beforeunload', function (e) {           
            $("#bgtransparent").remove();
        }); 

        });

   
    
    $("body").on("click", "#bgtransparent", function (params) {
        myPopupWindow.resizeTo(window.screen.width, window.screen.height);
        myPopupWindow.moveTo(0, 0);
        var confirmClose = confirm("Tienes una ventana emergente abierta \nDeseas cerrarla? \nNo se guardaran los cambios!");
        if(confirmClose){
            myPopupWindow.close();   
            $("#bgtransparent").remove();   
        }
      
    });


    $("#btnGuardarPdfTemp").on("click",function (e) {
       // alert('Falta guardar') 
        var request = serializePdf(
            "myFormEditPdfReporte",
            "summernote_update"
        );
        console.log(request);
        var id = $("#myFormEditPdfReporte select[name=id]").val();
        if(id==undefined)id = $("#myFormEditPdfReporte input[name=id]").val();
        if (request){
            var is_temp = $("#myFormEditPdfReporte input[name=is_temp]").val()
            if(is_temp){
                updateConPdfTemporal(request,is_temp)
            }else{
                createConPdfTemporal(request, id);
            }
           
        }

        e.preventDefault();

      
    });
    $("#btnCancelPdfTemp").on("click",function (e) {
        Swal.fire({
            title: 'Esta seguro que desea cancelar?',
            text: "No se guardaran los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cancelar!',
            cancelButtonText: 'No, mantener abierta!'
          }).then((result) => {
            if (result.value) {              
                myPopupWindow.close();   
                $("#bgtransparent").remove();         
            }
          });   
    });

    $("#btnDeletePdfTemp").on("click",function (e) {
        var id = $("#myFormEditPdfReporte input[name=is_temp]").val();
        if(id==undefined){
            var id = $("#myFormEditPdfReporte select[name=id]").val();
        }
        Swal.fire({
            title: 'Esta seguro que desea eliminar el registro temporal?',
            text: "No se podrá revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, mantener abierta!'
          }).then((result) => {
            if (result.value) {              
                deleteConPdfTemporal(id)
                        
            }
          });   
    });

    $(".selec_confi_av").on("click",function (e) {
        var modal = $(this).attr('data-modal');
        $("#"+modal).modal('show');
    });

    $(".btn_add_conc_he_con").on("click",function (e) {
        e.preventDefault();
        $("#myformEditHechoPretencion").attr('id','myformCreateHechoPretencion');
        $("#myformCreateHechoPretencion input[name=id]").val('')
        $("#myformCreateHechoPretencion textarea[name=descripcion]").val('')
        $("#myformCreateHechoPretencion input[name=tipo_id]").val($(this).attr('data-tipo'))
        $("#myModalCreateConcHechosPretenciones").modal('show'); 
    });

    $("#myModalCreateConcHechosPretenciones").on("submit",'#myformCreateHechoPretencion',function (e) {
        var request = $(this).serialize()+"&conciliacion_id="+$("#conciliacion_id").val();
        storeConciliacionHechoPretencion(request);
        e.preventDefault()
    });

    $(".content_hechos_pretensiones").on("click",'.btn_editar_hepr',function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        editConciliacionHechoPretencion(id)

    });

    $(".content_hechos_pretensiones").on("click",'.btn_estado_hepr',function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $("#myformEditEstadoPretension input[name=id]").val(id)
        if($(this).attr('data-estado_id')!='1') $("#myformEditEstadoPretension select[name=estado_id]").val($(this).attr('data-estado_id'))
        $("#myModal_create_estado_pretension").modal('show');
        //editConciliacionHechoPretencion(id)

    });
    

    $("#myModalCreateConcHechosPretenciones").on("submit",'#myformEditHechoPretencion',function (e) {
        var request = $(this).serialize()+"&conciliacion_id="+$("#conciliacion_id").val();
        var id = $("#myformEditHechoPretencion input[name=id]").val()
        updateConciliacionHechoPretencion(request,id);
        e.preventDefault()
    });

    $(".content_hechos_pretensiones").on("click",'.btn_eliminar_hepr',function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Esta seguro que desea eliminar el registro?',
            text: "No se podrá revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, mantener abierta!'
          }).then((result) => {
            if (result.value) {              
                deleteConciliacionHechoPretencion(id)
                        
            }
          });   

    });

    $(".select_values").on("change",function(e) {
        console.log($(this).attr('data-view'));
        $(".content_values_"+$(this).attr('data-view')).hide();
        $("#"+$(this).val()).show()
    });

    $("#myformEditEstadoPretension").on("submit",function (e) {

        var request = $(this).serialize()+"&conciliacion_id="+$("#conciliacion_id").val();
        var id = $("#myformEditEstadoPretension input[name=id]").val()
        updateConciliacionHechoPretencion(request,id);
        //var request = $(this).serialize()
      //  updatePretensionEstado(request)
        e.preventDefault()
        
    });

    $("#form_expediente_edit").on("submit",function (e) {
        var request = $(this).serialize();
        var id = $("#expediente_id").val()
        console.log($("#expediente_id").val());
        expedienteUpdate(request,id)
        e.preventDefault();
    });

    $(".encabezado_file").on("change",function (e) {
       var view = $(this).attr("data-view")
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#encab_img-'+view).attr('src', e.target.result)
                .css({'width':'100%'}); // Renderizamos la imagen
                //console.log(e.target);
                var image = new Image();
              //  console.log(image);
                image.src = e.target.result;
            image.onload = function () {
                var height = this.height;
                var width = this.width;               
                $("#encab_height-"+view).val(height);
                $("#encab_width-"+view).val(width);
               
          }
            }
            reader.readAsDataURL(this.files[0]);
            
        }
    });

    $(".pie_file").on("change",function (e) {
        var view = $(this).attr("data-view")
         if (this.files && this.files[0]) {
             var reader = new FileReader();
             reader.onload = function (e) {
                $('#pie_img-'+view).attr('src', e.target.result)
                .css({'width':'100%'}); // Renderizamos la imagen                 
                var image = new Image();            
                image.src = e.target.result;
                image.onload = function () {
                 var height = this.height;
                 var width = this.width;               
                 $("#pie_height-"+view).val(height);
                 $("#pie_width-"+view).val(width);
                
           }
             }
             reader.readAsDataURL(this.files[0]);
             
         }
     });

     $("#myReportPdfList").on("click","#btn_desc_all_pdf",function (e) {
         e.preventDefault();
         //alert("hola")
        var request = {};
        $(".input_filepdf_id").each((index,element) => {            
            if ($(element).is(":checked")) {
                request[index] = element.value   
                var a = document.createElement("a");
                a.href="/conciliaciones/download/file/"+element.value
                a.download = $(element).attr("data-name");
                a.target = "_blank";   
                a.click();                
            }           
        });
       // descargarAllPdfConcEstado(request)
        console.log(request);
     });


     $("#btn_download_all_pfd").on("click",function(){
        var request = 
        {
            "conciliacion_id":$("#conciliacion_id").val()
        }
        descargarAllPdfConcEstado(request)
     });

     $(".btn_detalles_us_con").on("click",function(e){
        var data_type = $(this).attr("data-type");
        $("#myModal_conc_user_create input[name=tipo_usuario_id]").val(data_type);
        $("#myModal_conc_user_create input[name=section]").val($(this).attr('data-section'));
        var request = {          
            'conciliacion_id':$("#conciliacion_id").val(),          
            'data_type':data_type,
            'section':$(this).attr('data-section')
        }
        if ($(this).attr('data-user')!=undefined) {
            request['idnumber'] = $(this).attr('data-user');
            request['tipodoc_id'] = $("#myModal_conc_user_create select[name=tipodoc_id]").val();  
            request['is_edit'] = true;  
        }else{
            request['idnumber'] = '0';
            request['tipodoc_id'] = 1;          
        }  
     getDetallesUser(request,request.idnumber);
       // $("#myModal_conc_user_create").modal("show"); 
     });

     $(".btn_add_usuario_notas").on("click",function (e) {
         e.preventDefault();
         $("#myform_asig_nota_ext input[name='estidnumber']").val($(this).attr("data-user"))
         $("#myModal_add_nota_conciliaciones").modal("show")
     });

     $(".btn_delete_notas_con").on("click",function (e) {
        e.preventDefault();
        var idnumber = $(this).attr('data-user');
        Swal.fire({
            title: 'Esta seguro que desea eliminar las notas?',
            text: "No se podrá revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, mantener!'
          }).then((result) => {
            if (result.value) {    
                var request = {
                    "idnumber":idnumber,
                    "tbl_org_id":$("#conciliacion_id").val()
                }          
                deleteNotasExt(request);          
            }
          }); 
       
    });

     $(".btn_edit_notas").on("click",function (e) {
        e.preventDefault();
        var request = {
            'idnumber':$(this).attr("data-user"),
            'origen':5,
            'oficina_id':$("#conciliacion_id").val()
        }
        getNotasExt(request)
     });

     $("#myform_edit_nota_ext").on("submit",function(e) {
         var request = $(this).serialize();
        updateNotasExt(request)
         e.preventDefault();
     });

     $("#myReportPdfList").on("click",".btn_asignar_firmantes",function (e) {
         var  id = $(this).attr("data-estado_id");
         var request = {
             "id":id,
            "conciliacion_id":$("#conciliacion_id").val()
            }
        users_delete = [];
        getFirmantes(request);
     });

     $("#myFormAsigFirmaPdf").on("submit",function (e) {
        var request = $(this).serializeArray()
       // request['conciliacion_id'] = $("#conciliacion_id").val();
        request.push({name:'conciliacion_id', value: $("#conciliacion_id").val()})
        if(users_delete.length > 0){
            users_delete.forEach(element => {
                request.push({name:'delete_users_id[]', value: element})
            });            
        }
        console.log(request);
        setFirmantes(request);
        e.preventDefault()
     });

     $("#btn_cancelar_asig_user").on("click",function (e) {
        $("#content_user_pdf_firmas").hide();
        $("#content_user_pdf_list").show();
     });

     var users_delete = {};
     $("#table_list_pdf_users").on("change",'.check_selusfirm',function (e) {
         if(!$(this).is(":checked") && $(this).attr("data-oldnew") == 'old' && users_delete.indexOf($(this).val()) == -1){
           users_delete.push($(this).val());
         }else{
            users_delete.splice(users_delete.indexOf($(this).val()),1);            
         }
     });

     $("#table_list_pdf_users").on("change",'.select_type_firma',function (e) {
        if($(this).val() == '' && $(this).attr("data-oldnew") == 'old' && users_delete.indexOf($(this).attr("data-userid")) == -1){
          users_delete.push($(this).attr("data-userid"));
        }else if($(this).attr("data-oldnew") == 'old'  && users_delete.indexOf($(this).attr("data-userid")) != -1){
           users_delete.splice(users_delete.indexOf($(this).attr("data-userid")),1);            
        }
        
    });


     $("#btn_select_volver_enviar_email").on("click",function (e) {
         $(".volver_enviar_mail").show();
         $(".check_selusfirm").prop("disabled",true);
         $("#btn_select_volver_enviar_email").hide();
         $("#btn_volver_enviar_email").show();
         $("#btn_enviar_email").hide()
     });

     $("#btn_volver_enviar_email").on("click",function (e) {
        var request = $("#myFormAsigFirmaPdf").serialize() + "&conciliacion_id="+$("#conciliacion_id").val()
        reenviarMails(request)
    });


    $("#myFormAsigFirmaPdf").on("change",".select_type_firma",function name(e) {
        console.log($(this).val());
        if($(this).val()!='209' && $(this).val()!=''){           
            $("#check_selusfirm-"+$(this).attr("data-userid")).prop("disabled",true);
            $("#check_selusfirm-"+$(this).attr("data-userid")).prop("checked",false);
            $("#input_selusfirm-"+$(this).attr("data-userid")).val($(this).attr("data-userid"));
            $("#input_selusfirm-"+$(this).attr("data-userid")).prop("disabled",false);

            $("#input_selustipofirm-"+$(this).attr("data-userid")).val($(this).val());
            $("#input_selustipofirm-"+$(this).attr("data-userid")).prop("disabled",false);

        }else if ($(this).val()==''){
            $("#check_selusfirm-"+$(this).attr("data-userid")).prop("disabled",true);
            $("#input_selusfirm-"+$(this).attr("data-userid")).val("");
            $("#input_selusfirm-"+$(this).attr("data-userid")).prop("disabled",true);
            $("#check_selusfirm-"+$(this).attr("data-userid")).prop("checked",false);

            $("#input_selustipofirm-"+$(this).attr("data-userid")).val("");
            $("#input_selustipofirm-"+$(this).attr("data-userid")).prop("disabled",true);

        }else{
            $("#check_selusfirm-"+$(this).attr("data-userid")).prop("disabled",false);
            $("#check_selusfirm-"+$(this).attr("data-userid")).prop("checked",true);

            $("#input_selusfirm-"+$(this).attr("data-userid")).val($(this).attr("data-userid"));
            $("#input_selusfirm-"+$(this).attr("data-userid")).prop("disabled",false);

            $("#input_selustipofirm-"+$(this).attr("data-userid")).val($(this).val());
            $("#input_selustipofirm-"+$(this).attr("data-userid")).prop("disabled",false);

        }
    });

    $("#btn_gene_pdf").on("click",function (e) {
        console.log($(this).is(":checked"));
        Swal.fire({
            title: 'Esta seguro que desea generar los documentos?',
            text: "No se podrá revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, generar!',
            cancelButtonText: 'No, cancelar!'
          }).then((result) => {
            if (result.value) {    
                var request = { }          
                generarPdfs(request);          
            }
          }); 
    }); 
  

}); //FIn del document ready


function reenviarMails(request) {
    var route = "/conciliacion/reporte/firmantes/reenviar/mails";
    $.ajax({
        url: route,
        type: "POST", 
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            
           // $("#lbl_pfd_report_name").text(res.data.reporte.nombre_reporte);
            //$("#table_list_pdf_users tbody").html(res.view);
            Toast.fire({
				title: 'Asignado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            $("#content_user_pdf_firmas").hide();
            $("#content_user_pdf_list").show();
          //  window.location.reload(true);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function setFirmantes(request) {
    var route = "/conciliacion/reporte/firmantes";
    $.ajax({
        url: route,
        type: "POST", 
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            
           // $("#lbl_pfd_report_name").text(res.data.reporte.nombre_reporte);
            //$("#table_list_pdf_users tbody").html(res.view);
            Toast.fire({
				title: 'Asignado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            $("#content_user_pdf_firmas").hide();
            $("#content_user_pdf_list").show();
          //  window.location.reload(true);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function getFirmantes(request) {
    var route = "/conciliacion/reporte/firmantes";
    $.ajax({
        url: route,
        type: "GET", 
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#wait").hide();
            $(".volver_enviar_mail").hide();
            $("#btn_volver_enviar_email").hide();
            $("#btn_enviar_email").show();
            $(".check_selusfirm").prop("disabled",true);
            if(res.all_firmas == true){
                $("#btn_gene_pdf").show()
            }else{
                $("#btn_gene_pdf").hide()
            } 
            if(res.data.users.length > 0 ){
                $("#btn_select_volver_enviar_email").show();
                 }else{
                $("#btn_select_volver_enviar_email").hide()
            }
            $("#lbl_pfd_report_name").text(res.data.reporte.nombre_reporte);
            $("#table_list_pdf_users tbody").html(res.view);
            $("#myFormAsigFirmaPdf input[name=estado_id]").val(res.data.id);
            $("#content_user_pdf_firmas").show();
           
            $("#content_user_pdf_list").hide();
         
          //  window.location.reload(true);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function deleteNotasExt(request) {
    var route = "/notasext/1";
    $.ajax({
        url: route,
        type: "DELETE", 
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#myModal_edit_nota_conciliaciones").modal("hide");
            Toast.fire({
				title: 'Eliminado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            window.location.reload(true);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function updateNotasExt(request) {
    var route = "/notasext/1";
    $.ajax({
        url: route,
        type: "PUT", 
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#myModal_edit_nota_conciliaciones").modal("hide");
            Toast.fire({
				title: 'Actualizado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function getNotasExt(request) {
    var route = "/notasext/1/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#myform_edit_nota_ext input[name='nota_conocimientoid']").val(res.notas.nota_conocimientoid);
            $("#myform_edit_nota_ext input[name='nota_conocimiento']").val(res.notas.nota_conocimiento);
           
            $("#myform_edit_nota_ext input[name='nota_aplicacionid']").val(res.notas.nota_aplicacionid);
            $("#myform_edit_nota_ext input[name='nota_aplicacion']").val(res.notas.nota_aplicacion);
           
            $("#myform_edit_nota_ext input[name='nota_eticaid']").val(res.notas.nota_eticaid);
            $("#myform_edit_nota_ext input[name='nota_etica']").val(res.notas.nota_etica);
           
            $("#myform_edit_nota_ext input[name='nota_conceptoid']").val(res.notas.nota_conceptoid);
            $("#myform_edit_nota_ext textarea[name='nota_concepto']").val(res.notas.nota_concepto);
           

            $("#myModal_edit_nota_conciliaciones").modal("show");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function getDetallesUser(request,idnumber) {
    var route = "/conciliacion/detalles/user/"+idnumber+"";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
       
            $("#content_detalles_user").html(res.view)
            $("#myModal_conc_user_detalles").modal("show");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}


function descargarAllPdfConcEstado(request) {
    var route = "/conciliaciones/get/all/pdf";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            var tr = '';
            var  files = {};
            res.estados.forEach(estado => {
                estado.files.forEach(file => {
                    tr +=
                    `<tr>
                    <td>
                    ${file.original_name}
                    </td>
                    <td width="5%">
                    <a class="btn btn-block btn-warning" toltip="Vista previa del  documento" target="_blank" href="/conciliaciones/download/file/${file.pivot.file_id}">
                    <i class="fa fa-eye"></i>
                    </a>
                    </td>
                    <td>
                    <input type="checkbox" checked data-name="${file.original_name}" class="input_filepdf_id" name=file_id[] value="${file.pivot.file_id}">
                    </td>
                  </tr>`;
                });                
            });
            tr += `<tr>
                    <td>                   
                    </td>
                    <td></td>
                    <td width="5%">
                    <a id="btn_desc_all_pdf" toltip="Descargar"  class="btn btn-block btn-success" href="#">
                    <i class="fa fa-download"></i> Descargar todo
                    </a>         
                    </td>
                  </tr>`;
            $("#myReportPdfList tbody").html(tr);
            $("#myModal_reportes_pdf_estados").modal("show");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function expedienteUpdate(request,id) {
    var route = "/expedientes/"+id ;
	//var token = $("#token").val();
	$.ajax({
		url: route,
		headers: { 'X-CSRF-TOKEN' : token },
		type:'PUT',
		datatype: 'json',
		data: request,
		 beforeSend: function(xhr){

      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
	  $("#wait").show();  
    },	
		success:function(res){
			$("#wait").hide();  
		
			Toast.fire({
				title: 'Actualizado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            window.location.reload(true)
		   

		},
    error:function(xhr, textStatus, thrownError){
		alert("Hubo un error con el servidor ERROR::"+thrownError,textStatus);
		$("#wait").css("display", "none");
    }

	});
}

function deleteConciliacionUser(request) {
    var route = "/conciliacion/delete/user" ;
	//var token = $("#token").val();
	$.ajax({
		url: route,
		headers: { 'X-CSRF-TOKEN' : token },
		type:'GET',
		datatype: 'json',
		data: request,
		 beforeSend: function(xhr){

      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
	  $("#wait").show();  
    },	
		success:function(res){
			$("#wait").hide();  
		
			Toast.fire({
				title: 'Usuario eliminado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            window.location.reload(true)
		   

		},
    error:function(xhr, textStatus, thrownError){
		alert("Hubo un error con el servidor ERROR::"+thrownError,textStatus);
		$("#wait").css("display", "none");
    }

	});
}

function  conciliacionUserStore(request) {
    var route = "/expuser" ;
	//var token = $("#token").val();
	$.ajax({
		url: route,
		headers: { 'X-CSRF-TOKEN' : token },
		type:'POST',
		datatype: 'json',
		data: request,
		 beforeSend: function(xhr){

      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
	  $("#wait").show();  
    },	
		success:function(res){
            $("#myModal_conc_user_create").modal("hide"); 
			$("#wait").hide();  
			Toast.fire({
				title: 'Usuario asignado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            window.location.reload(true)
		    $('#msg-success').fadeIn();	 

		},
    error:function(xhr, textStatus, thrownError){
		alert("Hubo un error con el servidor ERROR::"+thrownError,textStatus);
		$("#wait").css("display", "none");
    }

	});
}

function  conciliacionUserUpdate(request,id) {
    var route = "/expuser/"+id+"" ;
	//var token = $("#token").val();
	$.ajax({
		url: route,
		headers: { 'X-CSRF-TOKEN' : token },
		type:'PUT', 
		datatype: 'json',
		data: request,
		 beforeSend: function(xhr){

      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
	  $("#wait").show();  
    },	
		success:function(res){
            $("#myModal_conc_user_create").modal("hide");  
			$("#wait").hide();  
			Toast.fire({
				title: 'Usuario asignado con éxito.',
				type: 'success', 
				timer: 2000,               
            });
            window.location.reload(true)
		    $('#msg-success').fadeIn();	 

		},
    error:function(xhr, textStatus, thrownError){
		alert("Hubo un error con el servidor ERROR::"+thrownError,textStatus);
		$("#wait").css("display", "none");
    }

	});
}
function getUser(request,idnumber) {
    var route = "/conciliacion/user/"+idnumber+"";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
       
            $("#content_form_user").html(res.view)
            $("#myModal_conc_user_create #type_solicitud_user").val(request.data_type);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}


function deleteConciliacionHechoPretencion(id) {
    var route = "/conciliaciones/hechos/pretenciones/"+id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            toastr.success("Eliminado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            if (res.view || res.view == "") {
                $("#content_hechos_pretensiones-"+res.tipo_id).html(res.view);
            }
            $("#myModalCreateConcHechosPretenciones").modal('hide');  
           
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function updateConciliacionHechoPretencion(request,id) {
    var route = "/conciliaciones/hechos/pretenciones/"+id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            toastr.success("Actualizado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            if (res.view || res.view == "") {
                $("#content_hechos_pretensiones-"+res.tipo_id).html(res.view);
            }
            $("#myModalCreateConcHechosPretenciones").modal('hide');  
            $("#myModal_create_estado_pretension").modal('hide')
           
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function editConciliacionHechoPretencion(id) {
    var route = "/conciliaciones/hechos/pretenciones/"+id+"/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
       
            $("#myformCreateHechoPretencion").attr('id','myformEditHechoPretencion');
            $("#myformEditHechoPretencion input[name=id]").val(res.id)
            $("#myformEditHechoPretencion input[name=tipo_id]").val(res.tipo_id)
            $("#myformEditHechoPretencion textarea[name=descripcion]").val(res.descripcion)
            $("#myModalCreateConcHechosPretenciones").modal('show')
           
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function storeConciliacionHechoPretencion(request) {
    var route = "/conciliaciones/hechos/pretenciones";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            toastr.success("Creado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            if (res.view || res.view == "") {
                $("#content_hechos_pretensiones-"+res.tipo_id).html(res.view);
            }
            $("#myModalCreateConcHechosPretenciones").modal('hide');  
           
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}


function deleteConPdfTemporal(id) {
    var route = "/conciliaciones/pdf/"+id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
            toastr.success("Eliminado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            //window.location.reload(true);
           // myPopupWindow.close();   
           $("#bgtransparent").remove(); 
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function updateConPdfTemporal(request,id) {
    var route = "/conciliaciones/pdf/"+id;
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        cache: false,       
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
            toastr.success("Actualizado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function createConPdfTemporal(request,id) {
    var route = "/conciliaciones/pdf";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        cache: false,       
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
      
            //$("#myFormEditPdfReporte").attr('id','myFormEditPdfTemp');
            $("#myFormEditPdfTemp input[name=id]").val(response.pdf_reporte_id);
           var input_temp = $("<input>").attr({
                type:'hidden',
                value:response.id,
                name:'is_temp'
             });
            $("#cont_temp").append(input_temp);
            $("#btnDeletePdfTemp").show();
            //myPopupWindow.close();   
           // $("#bgtransparent").remove(); 
            toastr.success("Actualizado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function getPdfReportesConciliacion(request) {
    var route = "/conciliacion/reportes/get";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
            $("#myReportPdfList tbody").html("");
            $("#alertmyReportList").hide();
            $("#content_user_pdf_firmas").hide();
            $("#content_user_pdf_list").show();
            if (response.data.length > 0) {
                $("#myReportPdfList tbody").html(response.view);
                //$("#myReportList tbody").html(response.view); 
                $("#alertmyReportList").show();
            }

            
            $("#myModal_reportes_pdf_estados").modal("show");
        
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function editAsignacionReporte(request) {
    var route = "/pdf/reportes/editar/asignacion";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
            $(".checks_reportes").prop("checked", false);
            response.forEach((element) => {
                $("#chk_reporte_" + element.reporte_id).prop("checked", true);
            });
            console.log(response);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function asignarReporte(request) {
    var route = "/pdf/reportes/asignar";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
            toastr.success("Actualizado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function editPdfReporte(id) {
    var route = "/pdf/reportes/" + id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            console.log(res);
            // $("#myModal_create_comentario").modal("hide");
            $("#myFormEditPdfReporte input[name=nombre_reporte]").val(res.nombre_reporte);
            if(res.configuraciones!=null){
                $("#myFormEditPdfReporte input[name=top]").val(res.configuraciones.top);
                $("#myFormEditPdfReporte input[name=right]").val(res.configuraciones.right);
                $("#myFormEditPdfReporte input[name=bottom]").val(res.configuraciones.bottom);
                $("#myFormEditPdfReporte input[name=left]").val(res.configuraciones.left);
                $("#myFormEditPdfReporte select[name=tipo_papel]").val(res.configuraciones.tipo_papel);
                if(res.files.length>0){
                    res.files.forEach(file => {
                        if(file.pivot.seccion=='encabezado'){
                            $("#myModal_configuraciones_formato_pdf_update #encab_img-update")
                            .attr("src",file.temp_path);
                            $("#myModal_configuraciones_formato_pdf_update select[name=encabezado_align]")
                            .val(file.pivot.configuracion.encabezado_align);
                            $("#myModal_configuraciones_formato_pdf_update input[name=encab_width]")
                            .val(file.pivot.configuracion.encab_width);
                            $("#myModal_configuraciones_formato_pdf_update input[name=encab_height]")
                            .val(file.pivot.configuracion.encab_height);
                        }
                        if(file.pivot.seccion=='pie'){
                            $("#myModal_configuraciones_formato_pdf_update #pie_img-update")
                            .attr("src",file.temp_path);
                            $("#myModal_configuraciones_formato_pdf_update select[name=pie_align]")
                            .val(file.pivot.configuracion.pie_align);
                            $("#myModal_configuraciones_formato_pdf_update input[name=pie_width]")
                            .val(file.pivot.configuracion.pie_width);
                            $("#myModal_configuraciones_formato_pdf_update input[name=pie_height]")
                            .val(file.pivot.configuracion.pie_height);
                        }
                    });

                }else{
                    $("#myModal_configuraciones_formato_pdf_update #encab_img-update")
                            .attr("src","");
                            $("#myModal_configuraciones_formato_pdf_update select[name=encabezado_align]")
                            .val("");
                            $("#myModal_configuraciones_formato_pdf_update input[name=encab_width]")
                            .val("");
                            $("#myModal_configuraciones_formato_pdf_update input[name=encab_height]")
                            .val("");
                            $("#myModal_configuraciones_formato_pdf_update #pie_img-update")
                            .attr("src","");
                            $("#myModal_configuraciones_formato_pdf_update select[name=pie_align]")
                            .val("");
                            $("#myModal_configuraciones_formato_pdf_update input[name=pie_width]")
                            .val("");
                            $("#myModal_configuraciones_formato_pdf_update input[name=pie_height]")
                            .val("");
                }
            }else{
                $("#myFormEditPdfReporte input[name=top]").val("1,27");
                $("#myFormEditPdfReporte input[name=right]").val("1,27");
                $("#myFormEditPdfReporte input[name=bottom]").val("1,27");
                $("#myFormEditPdfReporte input[name=left]").val("1,27");
            }
            
            $("#summernote_update").summernote("code", res.reporte);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}
function createPdfPreview(request) {
    var route = "/pdf/reportes/preview";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,       
        headers: { "X-CSRF-TOKEN": token },    
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (response) {
            var a = document.createElement("a");
            a.target = "_blank";
            a.href = response.url;
            a.click();
            // window.location = '/act_temp/load.pdf'
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            /* alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            ); */
            $("#wait").hide();
        },
    });
}

function serializePdf(myForm, mySummernote) {
    var formatVal = $("#" + mySummernote)
        .summernote("code")
        .trim();
    console.log(myForm, mySummernote, "jols");
    // alert(formatVal.length)
    $("#"+myForm + " input[name=reporte]").val('');
    $("#"+myForm + " input[name=reporte]").val(formatVal);
    var items_ = [];
    $("#report_keys").val("");   
  
    if (formatVal != "") {
        $("#"+myForm+" .note-editable .item_sp").each((index, element) => {
            var it = $(element).attr("user-type");
            var dtn = $(element).attr("data-name");
            items_[index] = {
                user_type: it,  
                name: dtn,
                table: $(element).attr("data-table"),
                short_name: $(element).attr("data-short_name"),
            };
          //  $(element).css('border','1px solid red')
           
        });
       
        var json = JSON.stringify(items_);
        $("#"+myForm + " input[name=report_keys]").val(json);
        
      //  return false;
      return (request = new FormData(document.getElementById(myForm)));// $(myForm).serialize());
       // return (request = $(myForm).serialize());
    }else{
        Swal.fire({
            title: "El formato no puede estar vacío",
            icon: "warning",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Aceptar",
        });
    }
    return false;
}
function updatePdfReporte(request, id) {
    var route = "/pdf/reportes/" + id;
    $.ajax({
        url: route, 
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,     
        headers: { "X-CSRF-TOKEN": token },     
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            console.log(res);
            if (res.view || res.view == "") {
                //  $("#table_list_comentarios tbody").html(res.view);
            }
            toastr.success("Actualizado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            $("#myModal_create_comentario").modal("hide");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function storePdfReporte(request) {
    var route = "/pdf/reportes";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,       
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
           window.location.reload(true)
           $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function updateConciliacionComentario(request) {
    var route = "/conciliaciones/update/comentario";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.view || res.view == "") {
                $("#table_list_comentarios tbody").html(res.view);
            }
            $("#myModal_create_comentario").modal("hide");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function updateConciliacionEstado(request) {
    var route = "/conciliaciones/update/estado";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.view || res.view == "") {
                $("#table_list_estados tbody").html(res.view);
            }
            $("#myModal_create_estado").modal("hide");
            toastr.success("Actualizado con éxito!", "", {
                positionClass: "toast-bottom-right",
                timeOut: "1000",
            });
            window.location.reload(true);
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function editConciliacionComentario(request) {
    var route = "/conciliaciones/edit/comentario";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#myformCreateComentario").attr("id", "myformEditComentario");
            $("#myformEditComentario input[name=comentario_id]").val(res.id);
            $("#myformEditComentario input[name=compartido]").prop(
                "checked",
                false
            );
            if (res.compartido == 1)
                $("#myformEditComentario input[name=compartido]").prop(
                    "checked",
                    true
                );

            $("#myformEditComentario textarea[name=comentario]").val(
                res.comentario
            );
            $("#myformEditComentario button[type=submit]").text("Actualizar");
            $("#myModal_create_comentario .modal-title").text(
                "Actualizando comentario"
            );
            $("#myModal_create_comentario").modal("show");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function getEstadosReportesPdf(request) {
    var route = "/conciliaciones/get/estado/pdf";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            var tr = '';
            res.files.forEach(file => {
                 tr += `<tr>
                    <td>
                    ${file.original_name}
                    </td>
                    <td width="5%">
                    <a class="btn btn-block btn-warning" toltip="Vista previa del  documento" target="_blank" href="/conciliaciones/download/file/${file.pivot.file_id}">
                    <i class="fa fa-eye"></i>
                    </a>
                    </td>
                    <td>
                    <input type="checkbox" data-name="${file.original_name}" class="input_filepdf_id" name=file_id[] value="${file.pivot.file_id}">
                    
                    </td>
                  </tr>`;
            });
            tr += `<tr>
                    <td>
                   
                    </td>
                    <td></td>
                    <td width="5%">
                    <a id="btn_desc_all_pdf" toltip="Descargar"  class="btn btn-block btn-success" href="#">
                    <i class="fa fa-download"></i> Descargar todo
                    </a>         
                    </td>
                  </tr>`;
            $("#myReportPdfList tbody").html(tr);
            $("#myModal_reportes_pdf_estados").modal("show");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function editConciliacionEstado(request) {
    var route = "/conciliaciones/edit/estado";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#myformCreateEstado").attr("id", "myformEditEstado");
            $("#myformEditEstado input[name=estado_id]").val(res.id);
            $("#myformEditEstado select[name=type_status_id]").val(
                res.type_status_id
            );
            $("#myformEditEstado textarea[name=concepto]").val(res.concepto);
            $("#myformEditEstado button[type=submit]").text("Actualizar");
            $("#myModal_create_estado .modal-title").text("Actualizado estado");
            $("#myModal_create_estado").modal("show");
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function deleteConciliacionComentario(request) {
    var route = "/conciliaciones/delete/comentario";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.view || res.view == "") {
                $("#table_list_comentarios tbody").html(res.view);
            }

            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function deleteConciliacionEstado(request) {
    var route = "/conciliaciones/delete/estado";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.view || res.view == "") {
                $("#table_list_estados tbody").html(res.view);
            }

            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function storeConciliacionComentario(request) {
    var route = "/conciliaciones/insert/comentario";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.view || res.view == "") {
                $("#table_list_comentarios tbody").html(res.view);
                $("#myModal_create_comentario").modal("hide");
            }
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function storeConciliacionEstado(request) {
    var route = "/conciliaciones/insert/estado";
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {        //
        if (res.view || res.view == "") {
            $("#table_list_estados tbody").html(res.view);
        }
        //window.location.reload(true)
        $("#myModal_create_estado").modal("hide");
        $("#wait").hide();
    });
}


   
    


function insertConADValue(request) {
    var route = "/conciliaciones/insert/data";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            try {
                if (res.error) {
                    toastr.error("A ocurrido un error. " + res.error, "Error", {
                        positionClass: "toast-top-right",
                        timeOut: "50000",
                    });
                } else {
                    //  $("#content_list_categories").html(res.render_view);
                    Toast.fire({
                        type: "success",
                        title: "Actualizado con éxito.",
                    });
                }
                // $("#content_categories_list").html(res.render_view)
                //if(items_delete.length > 0 ) items_delete.length = 0 ;
                //$("#myModal_create_category").modal('hide');
            } catch (error) {
                toastr.error(
                    "A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador",
                    "Error",
                    { positionClass: "toast-top-right", timeOut: "50000" }
                );
                $("#wait").hide();
            }
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}
function referenceUpdate(request, id) {
    var route = "/categorias/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            try {
                if (res.render_view || res.render_view == "") {
                    $("#content_list_categories").html(res.render_view);
                    Toast.fire({
                        type: "success",
                        title: "Categoria actualizada con éxito.",
                    });
                }
                $("#content_categories_list").html(res.render_view);
                if (items_delete.length > 0) items_delete.length = 0;
                $("#myModal_create_category").modal("hide");
            } catch (error) {
                toastr.error(
                    "A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador",
                    "Error",
                    { positionClass: "toast-top-right", timeOut: "50000" }
                );
            }
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}
function referenceStaticUpdate(request, id) {
    var route = "/categories/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            try {
                if (res.render_view || res.render_view == "") {
                    $("#content_list_categories").html(res.render_view);
                    Toast.fire({
                        type: "success",
                        title: "Categoria actualizada con éxito.",
                    });
                }
                $("#content_categories_list").html(res.render_view);
                if (items_delete.length > 0) items_delete.length = 0;
                $("#myModal_create_static_category").modal("hide");
            } catch (error) {
                toastr.error(
                    "A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador",
                    "Error",
                    { positionClass: "toast-top-right", timeOut: "50000" }
                );
            }
            $("#wait").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function referenceEdit(id) {
    var route = "/categorias/" + id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#wait").hide();
            if (items_delete.length > 0) items_delete.length = 0;
            try {
                $("#myformCreateCategory").attr("id", "myformEditRCategory");
                $("#myformEditRCategory")[0].reset();
                $("#myformEditRCategory input[name=id]").val(res.id);
                $("#myformEditRCategory select[name=type_data_id]").val(res.type_data_id);
                $("#myformEditRCategory select[name=table]").val(res.table);
                $("#myformEditRCategory select[name=section]").val(res.section);
                $(".select2").select2();
                if(res.partes.length > 0){   
                    var partes = []    ;          
                    res.partes.forEach(element => {                      
                        partes.push(element.parte);                  
                    });
                    $(".select2").val(partes).trigger('change');;
                }
               

                $("#myformEditRCategory input[name=name]").val(res.name);
                $("#myformEditRCategory input[name=short_name]").val(res.short_name);
                $("#myformEditRCategory button[type=submit]")
                    .text("Actualizar")
                    .removeClass("btn-primary")
                    .addClass("btn-warning");

                $("#lbl_modal_title").text("Actualizar categoria");
                $("#content_section_users").hide();
                $(".content_section_users select").prop("disabled", true);

                if (res.options.length > 0 && res.type_data_id != 168) {
                    var row = "";
                    res.options.forEach((element, item) => {
                        let checked_ = "";
                        let value = "0";
                        if (element.active_other_input) {
                            checked_ = "checked";
                            value = "1";
                        }
                        row += `<tr class="option_row" data-item="${item}" id="option_row-${item}">
                                        <td>
                                            <input value="${element.value}" type="text" required name="option_name[]" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="hidden" id="active_other_input-${item}" name="active_other_input[]" value="${value}">
                                            <input type="hidden"  name="options_id[]" value="${element.id}">

                                            <input type="checkbox" ${checked_} id="active-${item}" class="chk_active_other_input">
                                        </td>
                                        <td>
                                            <button type="button" id="btn_delete_option_row-${item}" data-id="${element.id}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                                            <i class="fa fa-times"></i></button>
                                        </td>               
                                    </tr>`;
                    });
                    $("#aditional_options_table tbody").html(row);
                    $(".adoptions_g").show();
                    $(".adoptions input").prop("disabled", false);
                    $("#chk_add_option").prop("checked", true);
                    $("#sel_answer_type").show();
                    $("#sel_answer_type select").prop("disabled", false);
                } else if (res.section == "aditional_info") {
                    $("#chk_add_option").prop("checked", false);
                    $(".chkadoptions").show();
                    $(".adoptions").hide();
                    $("#sel_answer_type").hide();
                    $("#sel_answer_type select").prop("disabled", true);

                    $(".adoptions input").prop("disabled", false);
                    $("#aditional_options_table tbody").html("");
                } else {
                    $(".adoptions_g").hide();
                    $("#chk_add_option").prop("checked", false);
                    $("#aditional_options_table tbody").html("");
                }
                $("#myModal_create_category").modal("show");
            } catch (error) {
                toastr.error(
                    "A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador",
                    "Error",
                    { positionClass: "toast-top-right", timeOut: "50000" }
                );
            }
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function referenceConciliacionEdit(id) {
    var route = "/categories/" + id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#wait").hide();
            if (items_delete.length > 0) items_delete.length = 0;
            try {
                $("#myformCreateStaticCategory").attr(
                    "id",
                    "myformEditRStaticCategory"
                );
                $("#myformEditRStaticCategory input[name=id]").val(res.id);
                $("#myformEditRStaticCategory select[name=type_data_id]").val(
                    res.type_data_id
                );
                $("#myformEditRStaticCategory select[name=table]").val(
                    res.table
                );
                $("#myformEditRStaticCategory select[name=section]").val(
                    res.section
                );
                $("#myformEditRStaticCategory input[name=display_name]").val(
                    res.display_name
                );
                $("#myformEditRStaticCategory input[name=name]").val(res.name);
                $("#myformEditRStaticCategory button[type=submit]")
                    .text("Actualizar")
                    .removeClass("btn-primary")
                    .addClass("btn-warning");

                $("#lbl_modal_title").text("Actualizar categoria");
                $("#content_section_users").hide();
                $(".content_section_users select").prop("disabled", true);

                if (
                    res.options.length > 0 &&
                    res.type_data_id != 168 &&
                    res.type_data_id != 173 &&
                    res.type_data_id != 174
                ) {
                    var row = "";
                    res.options.forEach((element, item) => {
                        let checked_ = "";
                        let value = "0";
                        if (element.active_other_input) {
                            checked_ = "checked";
                            value = "1";
                        }
                        row += `<tr class="option_row" data-item="${item}" id="option_row-${item}">
                                        <td>
                                            <input value="${element.value}" type="text" required name="option_name[]" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="hidden" id="active_other_input-${item}" name="active_other_input[]" value="${value}">
                                            <input type="hidden"  name="options_id[]" value="${element.id}">

                                            <input type="checkbox" ${checked_} id="active-${item}" class="chk_active_other_input">
                                        </td>
                                        <td>
                                            <button type="button" id="btn_delete_option_row-${item}" data-id="${element.id}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                                            <i class="fa fa-times"></i></button>
                                        </td>               
                                    </tr>`;
                    });
                    $("#aditional_options_table tbody").html(row);
                    $(".adoptions_g").show();
                    $(".adoptions input").prop("disabled", false);
                    $("#chk_add_option").prop("checked", true);
                    $("#sel_answer_type").show();
                    $("#sel_answer_type select").prop("disabled", false);
                } else if (res.section == "aditional_info") {
                    $("#chk_add_option").prop("checked", false);
                    $(".chkadoptions").show();
                    $(".adoptions").hide();
                    $("#sel_answer_type").hide();
                    $("#sel_answer_type select").prop("disabled", true);

                    $(".adoptions input").prop("disabled", false);
                    $("#aditional_options_table tbody").html("");
                } else {
                    $(".adoptions_g").hide();
                    $("#chk_add_option").prop("checked", false);
                    $("#aditional_options_table tbody").html("");
                }
                $("#myModal_create_static_category").modal("show");
            } catch (error) {
                toastr.error(
                    "A ocurrido un error, refresque la página, si el error persiste, consulte con el adiministrador",
                    "Error",
                    { positionClass: "toast-top-right", timeOut: "50000" }
                );
            }
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").hide();
        },
    });
}

function addOptionTable(item) {
    var row = `<tr class="option_row" data-item="${item}" id="option_row-${item}">
                <td>
                    <input  type="text" required name="option_name[]" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="hidden" id="active_other_input-${item}" name="active_other_input[]" value="0">
                    <input type="hidden"  name="options_id[]" value="null">
                    <input type="checkbox" id="active-${item}" class="chk_active_other_input" data-size="xs" data-style="order-check" data-width="60" data-toggle="toggle" data-on="1" data-off="0" data-onstyle="primary" data-offstyle="warning">
                </td>
                <td>
                    <button type="button" id="btn_delete_option_row-${item}" data-item="${item}" class="btn btn-danger btn-sm btn_delete_option_row">
                    <i class="fa fa-times"></i></button>
                </td>               
            </tr>`;
    $("#aditional_options_table tbody").append(row);
}

function createCategory(request) {
    var route = "/categorias";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            Toast.fire({
                title: "Categoria creada con éxito.",
                type: "success",
                timer: 2000,
            });
            $("#myModal_create_category").modal("hide");
            $("#content_categories_list").html(res.render_view);
            //window.location.reload(true)

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function createStaticCategory(request) {
    var route = "/categories";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            Toast.fire({
                title: "Categoria creada con éxito.",
                type: "success",
                timer: 2000,
            });
            $("#myModal_create_static_category").modal("hide");
            $("#content_categories_list").html(res.render_view);
            //window.location.reload(true)

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function asignarExpediente(request) {
    var route = "/expedientes";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            Toast.fire({
                title: "Expediente creado con éxito.",
                type: "success",
                timer: 2000,
            });
            window.location.reload(true);

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function deleteSoliDocumentos(request, id) {
    var route = "/solicitudes/files/delete/" + id;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // fillFormEditSoliDoc(res)
            $("#itemd-" + id).remove();

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function updateSoliDocumentos(request) {
    var route = "/solicitudes/update/documento";
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {
        //
        $("#progress_bar").hide();
        $("#wait").hide();

        try {
            if (res.solic_files || res.solic_files == "") {
                $("#content_solicitudes_files").html(res.solic_files);
            }

            Toast.fire({
                title: "Documento actualizado con éxito.",
                type: "success",
                timer: 2000,
            });

            resetFormSoliDoc();
            // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
        } catch (error) {}
    });
}

function editSoliDocumentos(request, id) {
    var route = "/solicitudes/files/" + id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            fillFormEditSoliDoc(res);

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function storeSoliDocumentos(request) {
    var route = "/solicitudes/store/documento";
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {
        //
        $("#progress_bar").hide();
        $("#wait").hide();

        try {
            if (res.solic_files || res.solic_files == "") {
                $("#content_solicitudes_files").html(res.solic_files);
            }

            Toast.fire({
                title: "Documento creado con éxito.",
                type: "success",
                timer: 2000,
            });

            $("#myformCreateSoliDocumento")[0].reset();
            // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
        } catch (error) {}
    });
}

function storeConciliacionAnexo(request) {
    var route = "/conciliaciones/store/anexo";
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {
        //
        $("#progress_bar").hide();
        $("#wait").hide();

        try {
            if (res.view || res.view == "") {
                $("#table_anexos_list tbody").html(res.view);
            }

            Toast.fire({
                title: "Documento creado con éxito.",
                type: "success",
                timer: 2000,
            });
            $("#myModal_create_document").modal("hide");
            $("#myformCreateConciliacionAnexo")[0].reset();
            // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
        } catch (error) {}
    });
}

function updateConciliacionAnexo(request) {
    var route = "/conciliaciones/update/anexo";
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {
        //
        $("#progress_bar").hide();
        $("#wait").hide();

        try {
            if (res.view || res.view == "") {
                $("#table_anexos_list tbody").html(res.view);
            }

            Toast.fire({
                title: "Documento creado con éxito.",
                type: "success",
                timer: 2000,
            });
            $("#myModal_create_document").modal("hide");
            $("#myformCreateConciliacionAnexo")[0].reset();
            // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
        } catch (error) {}
    });
}

function deleteConciliacionAnexo(request) {
    var route = "/conciliaciones/delete/anexo";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#wait").css("display", "none");
            if (res.view || res.view == "") {
                $("#table_anexos_list tbody").html(res.view);
                Toast.fire({
                    title: "Archivo eliminado con éxito.",
                    type: "success",
                    timer: 2000,
                });
            }
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function updateSolicitud(request, id) {
    var route = "/solicitudes/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#myModal_solicitud_denied").modal("hide");
            $("#myModal_solicitud_acept").modal("hide");
            Toast.fire({
                title: "Solicitud actualizada con éxito.",
                type: "success",
                timer: 2000,
            });
            if (res.type_status_id == 156) {
                $("#con_timer").show();
                if (res.tiempo_espera != null) {
                    $("#tiempo_espera").val(res.tiempo_espera.date);
                } else {
                    $("#con_timer").remove();
                }
            }
            // if(res.type_status_id==162){
            window.location.reload();
            // }
            $("#btns_change_s").remove();
            $("#lbl_status_sol").text(res.type_status);
            $("#lbl_cta_ref_n").text(res.type_category);

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function editDocumentos(id) {
    var route = "/documentos/" + id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            fillFormEditDoc(res);

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function deleteDocumentos(id) {
    var route = "/documentos/" + id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#wait").css("display", "none");
            try {
                if (res.type_log_id == "151") {
                    if (res.doc_files) {
                        $("#content_docs_files").html(res.doc_files);
                    }
                    Toast.fire({
                        title: "Documento eliminado con éxito.",
                        type: "success",
                        timer: 2000,
                    });
                    // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
                }
            } catch (error) {}
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function fillFormEditDoc(res) {
    $("#myformCreateDocumento").attr("id", "myformEditDocumento");
    $("#myformEditDocumento").removeClass("form_store").addClass("form_update");
    $("#myformEditDocumento input[name=id").val(res.caseL.id);
    $("#myformEditDocumento input[name=concept").val(res.caseL.concept);
    $("#myformEditDocumento textarea[name=description").val(
        res.caseL.description
    );
    $("#myformEditDocumento button[type=submit")
        .text("Actualizar")
        .removeClass("btn-primary")
        .addClass("btn-warning");
    if (res.caseL.files.length > 0) {
        $(".custom-file-label").text(res.caseL.files[0].original_name);
        $("#myformEditDocumento input[name=log_file").prop("required", false);
    } else {
        $("#myformEditDocumento input[name=log_file").prop("required", true);
        $(".custom-file-label").text("Sin archivo");
    }
    $("#myformEditDocumento button[type=button").show();

    $("#cont_adm_docs ul li").removeClass("active");
    $("#cont_adm_docs ul li a").attr("aria-expanded", false);
    $("#cont_adm_docs #a_tab_create")
        .attr("aria-expanded", true)
        .text("Actualizar");
    $("#cont_adm_docs #li_tab_create").addClass("active");
    $("#cont_adm_docs .tab-pane").removeClass("active");
    $("#cont_adm_docs #tab_create").addClass("active");
}

function fillFormEditSoliDoc(res) {
    $("#myformCreateSoliDocumento").attr("id", "myformEditSoliDocumento");
    $("#myformEditSoliDocumento")
        .removeClass("form_store")
        .addClass("form_update");
    $("#myformEditSoliDocumento button[type=submit")
        .text("Actualizar")
        .removeClass("btn-primary")
        .addClass("btn-warning");
    if (res.solicitud.files.length > 0) {
        $("#myformEditSoliDocumento input[name=id").val(
            res.solicitud.files[0].id
        );
        $("#myformEditSoliDocumento input[name=concept").val(
            res.solicitud.files[0].pivot.concept
        );
        $(".custom-file-label").text(res.solicitud.files[0].original_name);
        $("#myformEditSoliDocumento input[name=solicitud_file").prop(
            "required",
            false
        );
    } else {
        $("#myformEditSoliDocumento input[name=solicitud_file").prop(
            "required",
            true
        );
        $(".custom-file-label").text("Sin archivo");
    }
    $("#myformEditSoliDocumento button[type=button").show();

    $("#cont_adm_docs ul li").removeClass("active");
    $("#cont_adm_docs ul li a").attr("aria-expanded", false);
    $("#cont_adm_docs #a_tab_create")
        .attr("aria-expanded", true)
        .text("Actualizar");
    $("#cont_adm_docs #li_tab_create").addClass("active");
    $("#cont_adm_docs .tab-pane").removeClass("active");
    $("#cont_adm_docs #tab_create").addClass("active");
}

function updateDocumentos(request, id) {
    var route = "/documentos/" + id;
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {
        //
        $("#progress_bar").hide();
        $("#wait").hide();

        try {
            if (res.type_log_id == "151") {
                if (res.doc_files) {
                    $("#content_docs_files").html(res.doc_files);
                }

                Toast.fire({
                    title: "Documento actualizado con éxito.",
                    type: "success",
                    timer: 2000,
                });
                resetFormCDoc();

                // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
            }
        } catch (error) {}
        if (res.mail_error) {
            toastr.error(res.mail_error, "Error", {
                positionClass: "toast-top-right",
                timeOut: "10000",
            });
        }
    });
}

function resetFormCDoc() {
    $("#myformEditDocumento")[0].reset();
    $("#myformEditDocumento").attr("id", "myformCreateDocumento");
    $("#myformCreateDocumento input[name=log_file").prop("required", true);
    $("#myformCreateDocumento")
        .removeClass("form_update")
        .addClass("form_store");
    $("#myformCreateDocumento button[type=submit")
        .text("Guardar")
        .removeClass("btn-warning")
        .addClass("btn-primary");
    $(".custom-file-label").text("");
    $("#myformCreateDocumento button[type=button").hide();
    $("#cont_adm_docs #a_tab_create").text("Nuevo");
}

function resetFormSoliDoc() {
    $("#myformEditSoliDocumento")[0].reset();
    $("#myformEditSoliDocumento").attr("id", "myformCreateSoliDocumento");
    $("#myformCreateSoliDocumento input[name=solicitud_file").prop(
        "required",
        true
    );
    $("#myformCreateSoliDocumento")
        .removeClass("form_update")
        .addClass("form_store");
    $("#myformCreateSoliDocumento button[type=submit")
        .text("Guardar")
        .removeClass("btn-warning")
        .addClass("btn-primary");
    $(".custom-file-label").text("");
    $("#myformCreateSoliDocumento button[type=button").hide();
    $("#cont_adm_docs #a_tab_create").text("Nuevo");
}

function storeDocumentos(request) {
    var route = "/documentos";
    $.ajax({
        url: route,
        type: "POST",
        data: request,
        contentType: false,
        cache: false,
        datatype: "json",
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        xhr: function () {
            $("#wait").show();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener(
                    "progress",
                    function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil((position / total) * 100);
                        }
                        $("#progress_bar").show();
                        $("#progressbarwait").css("display", "block");
                        $("#progress_bar .progress-bar").css(
                            "width",
                            +percent + "%"
                        );
                        $("#progress_bar .progress-bar").text(percent + "%");
                        $("#progressGeneral").css("width", percent + "%");
                        $("#progressGeneral").html(percent + "%");
                        if (percent >= 100) {
                            $("#progress_bar .progress-bar").text(
                                "Terminando el proceso..."
                            );
                            $("#progressGeneral").html("Terminando proceso...");
                        }
                    },
                    true
                );
            }
            return xhr;
        },
        //	mimeType:"multipart/form-data"
    }).done(function (res) {
        //
        $("#progress_bar").hide();
        $("#wait").hide();

        try {
            if (res.type_log_id == "151") {
                if (res.doc_files) {
                    $("#content_notifications").html(res.doc_files);
                }

                Toast.fire({
                    title: "Notificación enviada con éxito.",
                    type: "success",
                    timer: 2000,
                });
                $("#myModal_notificacion").modal("hide");
                $("#myformCreateDocumento")[0].reset();
                // $("#table_list_logs tbody [data-toggle='toggle']").bootstrapToggle();
            }
        } catch (error) {}
        if (res.mail_error) {
            toastr.error(res.mail_error, "Error", {
                positionClass: "toast-top-right",
                timeOut: "10000",
            });
        }
    });
}

function oficinaUserDelete(request) {
    var route = "/oficinas/user/delete";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            var row = "";
            res.users.forEach((user) => {
                row += `
        <tr><td>${user.name} ${user.lastname}</td>
        <td>
        <button class="btn btn-danger btn-sm btn_delete_userof" data-id="${user.id}" id="btn_delete_userof-${user.id}">Eliminar</button>
        </td> </tr>
        `;
            });
            $("#table_list_oficina_usuarios tbody").html(row);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function oficinaDelete(request) {
    var route = "/oficinas/" + request.oficina_id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#content_list_oficinas_table tbody").html(res.view);

            $("#myModal_oficina_create").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function oficinaUpdate(request, oficina_id) {
    var route = "/oficinas/" + oficina_id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#content_list_oficinas_table tbody").html(res.view);

            $("#myModal_oficina_create").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function oficinaEdit(request) {
    var route = "/oficinas/" + request.oficina_id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // $("#table_list_autorizaciones tbody").html(res.view)
            $("#myformCreateOficina").attr("id", "myformEditOficina");
            $("#myformEditOficina input[name=id]").val(res.id);
            $("#myformEditOficina input[name=nombre]").val(res.nombre);
            $("#myformEditOficina input[name=ubicacion]").val(res.ubicacion);
            $("#myformEditOficina input[type=submit]").text("Actualizar");

            $("#myModal_oficina_create").modal("show");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function findNotas(request) {
    var route = "/notasext/" + request.idnumber + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            if (!res.notas) {
                $("#myform_asig_nota_ext input[name=definitiva]")
                    .prop("checked", false)
                    .prop("disabled", false);
                $("#myform_asig_nota_ext input[name=ntaconocimiento]")
                    .val("")
                    .prop("disabled", false);
                $("#myform_asig_nota_ext textarea[name=ntaconcepto]")
                    .val("")
                    .prop("disabled", false);
                $("#myform_asig_nota_ext input[name=ntaconocimientoid]").val(
                    ""
                );
                $("#myform_asig_nota_ext input[name=ntaconceptoid]").val("");
                $("#myform_asig_nota_ext input[type=submit]")
                    .prop("disabled", false)
                    .show()
                    .val("Guardar");
                $("#lbl_extevaluador_name").text("");
                $("#myform_asig_nota_ext input[name=typesub]").val("store");
            } else {
                $("#myform_asig_nota_ext input[name=ntaconocimiento]")
                    .val(res.notas.nota_conocimiento)
                    .prop("disabled", true);
                $("#myform_asig_nota_ext textarea[name=ntaconcepto]")
                    .val(res.notas.nota_concepto)
                    .prop("disabled", true);
                $("#myform_asig_nota_ext input[name=ntaconocimientoid]").val(
                    res.notas.nota_conocimientoid
                );
                $("#myform_asig_nota_ext input[name=ntaconceptoid]").val(
                    res.notas.nota_conceptoid
                );
                $("#myform_asig_nota_ext input[name=typesub]").val("update");
                $("#myform_asig_nota_ext input[type=submit]")
                    .prop("disabled", true)
                    .hide();
                $("#lbl_extevaluador_name").text(
                    "Evaluado por: " + res.notas.docevname
                );
                if (res.notas.tipo_id == 1) {
                    $("#myform_asig_nota_ext input[name=definitiva]")
                        .prop("checked", true)
                        .prop("disabled", true);
                } else {
                    $("#myform_asig_nota_ext input[name=definitiva]")
                        .prop("checked", false)
                        .prop("disabled", true);
                }
                if (res.notas.can_edit && res.notas.tipo_id == 2) {
                    $("#myform_asig_nota_ext input[type=submit]")
                        .prop("disabled", false)
                        .show()
                        .val("Actualizar");
                    $("#myform_asig_nota_ext input[name=ntaconocimiento]").prop(
                        "disabled",
                        false
                    );
                    $("#myform_asig_nota_ext textarea[name=ntaconcepto]").prop(
                        "disabled",
                        false
                    );
                    $("#myform_asig_nota_ext input[name=definitiva]").prop(
                        "disabled",
                        false
                    );
                }
            }
            $("#myModal_asig_notas_ext").modal("show");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function oficinaUpdateNota(request, id) {
    var route = "/notasext/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#myModal_asig_notas_ext").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function storeNotaExt(request) {
    var route = "/notasext";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#myModal_asig_notas_ext").modal("hide");
            $("#wait").css("display", "none");
            Toast.fire({
                title: "Nota creada con éxito.",
                type: "success",
                timer: 2000,
            });
            window.location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function oficinaStore(request) {
    var route = "/oficinas";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#content_list_oficinas_table tbody").html(res.view);
            $("#myModal_oficina_create").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}
function findUser(request) {
    var route = "/users/find/us";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // $("#table_list_autorizaciones tbody").html(res.view)
            if (res.encontrado) {
                $("#myformUserStore input[name=id]")
                    .val(res.user.id)
                    .prop("disabled", false);
                $("#myformUserStore input[name=idnumber]").val(
                    res.user.idnumber
                );
                $("#myformUserStore input[name=name]")
                    .val(res.user.name)
                    .prop("disabled", true);
                $("#myformUserStore input[name=lastname]")
                    .val(res.user.lastname)
                    .prop("disabled", true);
                $("#myformUserStore input[name=email]")
                    .val(res.user.email)
                    .prop("disabled", true);
                $("#myformUserStore input[name=tel1")
                    .val(res.user.tel1)
                    .prop("disabled", true);
                if (res.user.roles.length > 0) {
                    $("#myformUserStore #lbl_role_name").text(
                        res.user.roles[0].display_name
                    );
                    $("#myformUserStore select[name=idrol")
                        .val(res.user.roles[0].id)
                        .prop("disabled", true)
                        .hide();
                }
            } else {
                $("#myformUserStore input[name=id]")
                    .val("")
                    .prop("disabled", true);
                $("#myformUserStore input[name=name]")
                    .val("")
                    .prop("disabled", false);
                $("#myformUserStore input[name=lastname]")
                    .val("")
                    .prop("disabled", false);
                $("#myformUserStore input[name=email]")
                    .val("")
                    .prop("disabled", false);
                $("#myformUserStore input[name=tel1")
                    .val("")
                    .prop("disabled", false);
                $("#myformUserStore #lbl_role_name").text("");
                $("#myformUserStore select[name=idrol")
                    .prop("disabled", false)
                    .show();
            }
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function oficinaGetUsers(request) {
    var route = "/oficinas/" + request.oficina_id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // $("#table_list_autorizaciones tbody").html(res.view)
            var row = "";
            res.users.forEach((user) => {
                row += `
           <tr><td>${user.name} ${user.lastname}</td>
           <td>
           <button class="btn btn-danger btn-sm btn_delete_userof" data-id="${user.id}" id="btn_delete_userof-${user.id}">Eliminar</button>
           </td> </tr>
           `;
            });
            $("#oficina_id").val(res.id);
            $("#table_list_oficina_usuarios tbody").html(row);
            $("#myModal_list_user_oficina").modal("show");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function userStore(request) {
    var route = "/users/store";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#table_list_autorizaciones tbody").html(res.view);
            $("#myModal_asig_user_oficina").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function index_autorizaciones(route, request) {
    var route = route;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#content_list_autorizaciones").html(res);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function storeAutorizacion(data) {
    var route = "/autorizaciones";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#table_list_autorizaciones tbody").html(res.view);
            $("#mymodalCreateAutorizacion").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function editAutorizacion(id) {
    var route = "/autorizaciones/" + id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#myformCreateAutorizacion").attr("id", "myformEditAutorizacion");
            $("#myformEditAutorizacion input[name=id]").val(res.id);
            $("#myformEditAutorizacion input[name=nombre_estudiante]").val(
                res.nombre_estudiante
            );
            $("#myformEditAutorizacion input[name=num_identificacion]").val(
                res.num_identificacion
            );
            $("#myformEditAutorizacion input[name=doc_expedicion]").val(
                res.doc_expedicion
            );
            $("#myformEditAutorizacion input[name=num_carne]").val(
                res.num_carne
            );
            $("#myformEditAutorizacion input[name=calidad_de]").val(
                res.calidad_de
            );
            $("#myformEditAutorizacion input[name=tipo_proceso]").val(
                res.tipo_proceso
            );
            $("#myformEditAutorizacion input[name=num_radicado]").val(
                res.num_radicado
            );
            $("#myformEditAutorizacion input[name=juzgado]").val(res.juzgado);
            $("#myformEditAutorizacion select[name=genero]").val(res.genero);
            $("#myformEditAutorizacion button")
                .removeClass("btn-primary")
                .addClass("btn-warning")
                .text("Actualizar");

            $("#mymodalCreateAutorizacion").modal("show");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function updateAutorizacion(request, id) {
    var route = "/autorizaciones/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#table_list_autorizaciones tbody").html(res.view);
            $("#mymodalCreateAutorizacion").modal("hide");
            $("#myformEditAutorizacion")[0].reset();
            $("#myformEditAutorizacion button")
                .removeClass("btn-warning")
                .addClass("btn-primary")
                .text("Crear");
            $("#myformEditAutorizacion").attr("id", "myformCreateAutorizacion");

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function changeStatusAutorizacion(request, id) {
    var route = "/autorizaciones/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            if (request.vista == "autorizaciones") {
                $("#content_list_autorizaciones").html(res.view);
            } else {
                $("#table_list_autorizaciones tbody").html(res.view);
            }

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function deleteAutorizacion(id) {
    var route = "/autorizaciones/" + id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            $("#table_list_autorizaciones tbody").html(res.view);

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function updateExpediente(data) {
    var route = "/expedientes/" + data.expediente_id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").show();
        },
        success: function (res) {
            $("#lbl_expfecha_res").text(data.expfecha_res);
            $("#fechalimitres").modal("hide");
            $("#wait").hide();
            console.log(res);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function changeNotifications() {
    var route = "/notifications";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        success: function (res) {
            console.log(res);
            $("#lbl_notify_count").hide();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function searchExpedientes() {
    var route = "/expedientes";
    var request = $("#myformExpFilter").serialize();
    index_page(route, request);
    window.history.pushState(null, "", route + "?" + request);
}
function updateCitacionEstudiante(data, id) {
    var route = "/citaciones/estudiante/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        success: function (res) {
            searchCitaciones();
            $("#mymodalNuevaCitacion").modal("hide");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}
function sendCitacionEstudiante(data) {
    var route = "/citaciones/estudiante";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            searchCitaciones();
            $("#mymodalNuevaCitacion").modal("hide");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}
function editCitacionEstudiante(id) {
    var route = "/citaciones/estudiante/" + id + "/edit";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "GET",
        datatype: "json",
        data: {},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            console.log(res);
            $("#myformCitarEstudiante").attr("id", "myformCitarEstudianteEdit");
            $("#myformCitarEstudianteEdit #id").val(res.id);
            $("#myformCitarEstudianteEdit #hora").val(res.hora);
            $("#myformCitarEstudianteEdit #fecha").val(res.fecha_corta);
            $("#myformCitarEstudianteEdit #motivo").val(res.motivo);

            $("#mymodalNuevaCitacion").modal("show");
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

$(document).ready(searchCitaciones());

function searchCitaciones() {
    var data = { expid: $("#expid").val() };
    if (data.expid !== undefined) {
        console.log(data, "data");
        var route = "/citaciones/estudiante";
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "GET",
            datatype: "json",
            data: data,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            success: function (res) {
                console.log(res);
                llenarTablaListCitaciones(res);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor, consulte con el administrador"
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function llenarTablaListCitaciones(res) {
    row = "";
    console.log(res);
    res.forEach((element) => {
        row += `<tr>
   <td>${element.docente_fullname}</td>
   <td>${element.motivo}</td>
   <td>${element.fecha}</td>
   <td>${element.hora}</td><td>`;
        if (element.can_edit) {
            row += `<button id="${element.id}" type="button" class="btn btn-primary btn_edit_citacion"> Cambiar </button>`;
        }
        row += `</td></tr>`;
    });

    $("#table_list_citaciones tbody").html(row);
}

function searchCitasForDay(fecha) {
    var data = { expid: $("#expid").val(), fecha: fecha };
    if (data.expid !== undefined) {
        console.log(data, "data");
        var route = "/citaciones/search/forday";
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "POST",
            datatype: "json",
            data: data,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            success: function (res) {
                console.log(res);
                llenarListCitas(res);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor, consulte con el administrador"
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function llenarListCitas(res) {
    var li = "";

    if (res.length <= 0) {
        li += `
    <tr>
    <td colspan="4">No se encontraron citas...</td> 
     </tr>
   `;
    } else {
        res.forEach((element) => {
            li += `
       <tr>
       <td>${element.hora} </td> 
       <td>${element.motivo} </td> 
       <td>${element.asignacion.estudiante.name} ${element.asignacion.estudiante.lastname}</td> 
       <td>${element.asignacion.asigexp_id} </td> 
       
       </tr>
      `;
        });
    }
    $("#menu_details_citas").show();
    $("#menu_details_citas tbody").html(li);
}

function changeDocenteExp(data, exp_id) {
    var route = "/docentes/casos/" + exp_id;
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "PUT",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            alertify.success("Espere mientras carga");
            window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

function setFormToObject(form) {
    var dataArray = $("#" + form).serializeArray();
    dataObj = {};
    $(dataArray).each(function (i, field) {
        dataObj[field.name] = field.value;
    });

    //setOptionsToObject(form)

    return dataObj;
}

function setFechaToHumans(fecha) {
    var meses = {
        "01": "Enero",
        "02": "Febrero",
        "03": "Marzo",
        "04": "Abril",
        "05": "Mayo",
        "06": "Junio",
        "07": "Julio",
        "08": "Agosto",
        "09": "Septiembre",
        10: "Octubre",
        11: "Noviembre",
        12: "Diciembre",
    };
    var mes = getIdAttr(fecha, "-", 1);
    var mes = meses[mes];
    var dia = getIdAttr(fecha, "-", 2);
    var año = getIdAttr(fecha, "-", 0);
    var fecha = dia + " de " + mes + " del " + año;
    return fecha;
}

function getIdAttr(id, separador, orientacion) {
    ori = 1;
    if (orientacion != null) {
        ori = orientacion;
    }
    value = id.split(separador)[ori];
    return value;
}

function showElement(element, attrib) {
    if (attrib == null || attrib == "id") {
        $("#" + element).show();
    } else {
        $("." + element).show();
    }
}
function hideElement(element, attrib) {
    if (attrib == null || attrib == "id") {
        $("#" + element).hide();
    } else {
        $("." + element).hide();
    }
}
function enabledInput(input, attrib) {
    if (attrib == "id" || attrib == null) {
        $("#" + input).prop("disabled", false);
        $("#" + input).css({ background: "#FDFEFE" });
    } else {
        $("." + input).prop("disabled", false);
        $("." + input).css({ background: "#FDFEFE" });
    }
}
function disabledInput(input, attrib) {
    if (attrib == "id" || attrib == null) {
        $("#" + input).prop("disabled", true);
        $("#" + input).css({ background: "#EAEDED" });
    } else {
        $("." + input).prop("disabled", true);
        $("." + input).css({ background: "#EAEDED" });
    }
}
//Funcion para contar caracteres de un input
function validateNumChar(obj, num) {
    obj.value = obj.value.substring(0, num);
    obj.value = obj.value.replace(/\D/g, "");
}

//Funcion para activar boton enviar
function comprDato(form) {
    var numInputs = countRequiredInputs(form);
    //////console.log(numInputs.length);
    if (numInputs.length <= 0) {
        $("#btn-enviar-dataEst").prop("disabled", false);
    } else {
        $("#btn-enviar-dataEst").prop("disabled", true);
    }
}

function countRequiredInputs(form) {
    var errors = [];
    $("#" + form + " .required").each(function (index, obj) {
        if ($(this).val() == "") {
            errors.push(1);
        }
    });
    //////console.log(errors.length);
    return errors;
}

function createBiblioteca() {
    //e.preventDefault();
    errors = validateForm("myformCreateBiblioteca");
    // alert(errors)
    if (errors.length <= 0) {
        input = document.getElementById("doc_file");
        ////console.log(input.files)
        if (input.files && input.files.length >= 1) {
            var mydata = "#myformCreateBiblioteca";
            var route = "/bibliotecas";
            // var token = $("#token").val();
            var formData = new FormData(
                document.getElementById("myformCreateBiblioteca")
            );
            $.ajax({
                url: route,
                headers: { "X-CSRF-TOKEN": token },
                type: "POST",
                datatype: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                /*muestra div con mensaje de 'regristrado'*/
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        "X-CSRF-TOKEN",
                        $("#token").attr("content")
                    );
                    $("#wait").css("display", "block");
                },
                success: function (res) {
                    ////console.log(res);
                    document.getElementById("myformCreateBiblioteca").reset();
                    hideElement("lab_doc_file", "id");
                    $("#wait").css("display", "none");
                    hideElement("label-alert", "class");
                    showElement("msg-success");
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(
                        "Hubo un error con el servidor ERROR::" + thrownError,
                        textStatus
                    );
                    $("#wait").css("display", "block");
                },
            });
        } else {
            showElement("label-alert", "class");
        }
    }

    /*oculta mensaje y limpia campos*/
    /*$("#btn_modal").click(function(){
    $('#msg-success').hide();
    
});*/
}

function findBiblioteca(id) {
    //var mydata = "#myformCreateBiblioteca";
    var route = "/bibliotecas/" + id + "/edit";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "GET",
        datatype: "json",
        data: { id: id },
        cache: false,
        contentType: false,
        processData: false,
        /*muestra div con mensaje de 'regristrado'*/
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            ////console.log(res);
            llenarFormEditBiblio(res);
            llenarTablaDetails(res);
            $("#wait").css("display", "none");
            hideElement("label-alert", "class");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").css("display", "block");
        },
    });
}

function llenarFormEditBiblio(data) {
    $("#biblinombre").val(data.biblinombre);
    $("#bibliid_ramaderecho_id").val(data.bibliid_ramaderecho);
    $("#bibliid_tipoarchivo_id").val(data.bibliid_tipoarchivo);
    $("#biblidescrip").val(data.biblidescrip);
    $("#biblioteca_id").val(data.id);
    $("#lab_doc_file i").text(data.biblidocnompropio);
    $("#link_doc").attr("href", "/bibliotecas/pdf/" + data.id);
    //$("#biblinombre").val(data.biblinombre);
}

function llenarTablaDetails(data) {
    var tamanio = "";
    if (data.biblidoctamano / 1024 >= 1000) {
        tamanio = (data.biblidoctamano / 1024 / 1024).toFixed(2) + " Mb";
    } else {
        tamanio = (data.biblidoctamano / 1024).toFixed(0) + " Kb";
    }
    texto = data.biblidescrip.replace(/\n/g, "<br />");
    $("#label_biblinombre").text(data.biblinombre);
    $("#label_user_create").text(data.user.name);
    $("#label_biblidocnompropio").text(data.biblidocnompropio);
    $("#label_biblidoctamano").text(tamanio);
    $("#label_bibliuserupdated").text(data.user_update.name);

    $("#label_bibliid_ramaderecho").text(data.rama_derecho.ramadernombre);
    $("#label_bibliid_tipoarchivo").text(data.categoria.tiparchinombre);
    $("#label_biblidescrip").html(texto);
}

function updateBiblioteca() {
    producto_id = $("#biblioteca_id").val();
    var route = "/bibliotecas/update";
    //var token = $("#token").val();
    var formData = new FormData(
        document.getElementById("myformUpdateBiblioteca")
    );
    ////console.log(formData);
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        /*muestra div con mensaje de 'regristrado'*/
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // $('#msg-success').fadeIn();
            ////console.log(res);
            location.reload(true);

            //llenarTabla(res); //en caso de exito llama a la funcion llenarTabla para poner nuevo registro
            // alert('Actuación guardada con éxito1!!');
            $("#wait").css("display", "none");
            hideElement("label-alert", "class");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").css("display", "block");
        },
    });
}

function ingresarNotas() {

    errors = validateForm("myform_add_nota_final_expedientes");

        var notaapl = $("#myform_add_nota_final_expedientes input[name=ntaaplicacion]").val()
        var notacon = $("#myform_add_nota_final_expedientes input[name=ntaconocimiento]").val()
        var notaet = $("#myform_add_nota_final_expedientes input[name=ntaetica]").val()

        if(notaapl > 5 || notacon > 5 || notaet > 5){
            toastr.error("Por favor verifíque que no haya notas superiores a 5.0", "", {
                positionClass: "toast-top-right",
                timeOut: "6000",
            });
            errors = 1;
        }
        
        if(isNaN(notaapl) || isNaN(notacon) || isNaN(notaet)){
            toastr.error("Por favor verifíque que no haya notas con espacios o caracteres extraños", "", {
                positionClass: "toast-top-right",
                timeOut: "6000",
            });
            errors = 1;
        }

    if (errors <= 0) {
        

        var data = $("#myform_add_nota_final_expedientes").serialize();
        var route = "/notas";
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "POST",
            datatype: "json",
            //data:{'perid':perid,'orgntsid':orgntsid,'tpntid':tpntid,'segid':segid,'expid':expid,'ntaconocimiento':ntaconocimiento,'ntaaplicacion':ntaaplicacion,'ntaetica':ntaetica,'ntaconcepto':ntaconcepto},
            data: data,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function addAsesoria() {
    errors = validateForm("formAddAsesoria");
    ////console.log(errors)
    if (errors <= 0) {
        comentario = $("#asesoria_docente").val();
        expid = $("#expid").val();
        apl_shared = $("#apl_shared").val();
        //var token = $("#token").val();
        var route = "/asesorias";
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "POST",
            datatype: "json",
            data: {
                comentario: comentario,
                expid: expid,
                apl_shared: apl_shared,
            },
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function editAsesoria(id) {
    //var token = $("#token").val();
    var route = "/asesorias/" + id + "/edit";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "GET",
        datatype: "json",
        data: { id: id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            $("#myModal_update_asesoria_docente").modal("show");
            $("#asesoria_docente_update").val(res.comentario);
            $("#asesoria_id").val(res.id);
            //window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function updateAsesoria() {
    errors = validateForm("formUpdateAsesoria");
    if (errors <= 0) {
        id = $("#asesoria_id").val();
        comentario = $("#asesoria_docente_update").val();
        expid = $("#expid").val();
        // var token = $("#token").val();
        var route = "/asesorias/" + id;
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "PUT",
            datatype: "json",
            data: { comentario: comentario, id: id },
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function deleteAsesoria(id) {
    msj = confirm("¿Está seguro de eliminar el registro?");
    if (msj) {
        //var token = $("#token").val();
        var route = "/asesorias/" + id;
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "DELETE",
            datatype: "json",
            data: { id: id },
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

///Cierre de caso

function storeEstadoCaso() {
    var errors = validateForm("cont_data_req");
    var ul = document.createElement("ul");
    $(ul).attr("id", "errors_list");
    var li = "";

    if (errors.length > 0) {
        for (var i = errors.length - 1; i >= 0; i--) {
            li += "<li>" + errors[i] + "</li>";
        }
        $(ul).append(li);
        $("#msg-danger label").html("");
        $("#msg-danger label").append(
            "Recuerda que antes de enviar esta solicitud debes diligenciar los datos del caso y <b>GUARDAR.</b><hr>"
        );
        $("#msg-danger label").append(ul);
        $("#msg-danger").show();
    } else {
        var errors = validateForm("myform_exp_edit_cierre_caso");
        if (errors <= 0) {
            expid = $("#expid").val();
            new_expestado = $("#new_expestado").val();
            motivo_cierre = $("#motivo_cierre").val();
            comentario = $("#comentario").val();
            motivo_estado = $("#motivo_estado").val();
            var hechos = $("#exp_hechos").val();
            var exp_resp_est = $("#exp_resp_est").val();
            //var token = $("#token").val();
            var route = "/estados/caso";
            $.ajax({
                url: route,
                headers: { "X-CSRF-TOKEN": token },
                type: "POST",
                datatype: "json",
                data: {
                    hechos: hechos,
                    exp_resp_est: exp_resp_est,
                    new_expestado: new_expestado,
                    motivo_estado: motivo_estado,
                    comentario: comentario,
                    expid: expid,
                },
                cache: false,
                beforeSend: function (xhr) {
                    $("#wait").css("display", "block");
                    xhr.setRequestHeader(
                        "X-CSRF-TOKEN",
                        $("#token").attr("content")
                    );
                },
                /*muestra div con mensaje de 'regristrado'*/
                success: function (res) {
                    if (!res.guardado) {
                        ////console.log(res.mensaje);
                        $("#msg-danger label").html(res.mensaje);
                        $("#msg-danger").show();
                    } else if (res.exp.exptipoproce_id == "3") {
                        window.location = "/defensas/oficio/" + res.exp.expid;
                    } else {
                        if (res.role != "docente") {
                            window.location = "/expedientes/" + res.exp.expid;
                        } else {
                            window.location.reload(true);
                        }
                    }
                    //
                    $("#wait").css("display", "none");
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(
                        "Hubo un error con el servidor ERROR::" + thrownError,
                        textStatus
                    );
                    $("#wait").css("display", "none");
                },
            });
        }
    }
}

function deleteNotas() {
    var msj = confirm("¿Está seguro de eliminar todas las notas?");
    if (msj) {
        $("#myModal_edit_notas").modal("hide");
        openCamNotas();

        // expid = $("#expid").val();
        var data = $("#myform_update_notas").serialize();
        //var token = $("#token").val();
        var route = "/notas/delete";
        $.ajax({
            url: route,
            type: "POST",
            datatype: "json",
            data: data,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function searchEstadoCaso(id) {
    // var token = $("#token").val();
    var route = "/estado/search";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: { id: id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            $("#comen_details").val(res.comentario);
            $("#nombre_usuario_details").text(
                res.user.name + " " + res.user.lastname
            );
            $("#nombre_estado_details").text(res.estado.nombre_estado);
            $("#nombre_motivo_details").text(res.motivo.nombre_motivo);

            $("#myModal_show_details_searchEstadoCaso").modal("show");
            //window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

/////////////////////////
//Requerimientos

function updateRequerimiento() {
    errors = validateForm("myformUpdateReq");
    if (errors <= 0) {
        var req_id = $("#req_id").val();
        var reqid_asistencia = $("#reqid_asistencia").val();
        var reqcomentario_coorprac = $("#reqcomentario_coorprac").val();
        date = $("#myformUpdateReq").serialize();

        var route = "/requerimientos/" + req_id + "";
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "PUT",
            datatype: "json",
            data: date,
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
                // $("#myformUpdateAct")[0].reset();
                $("#myModal_req_asist").modal("hide");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                $("#wait").css("display", "none");
                ListarTabla_req(0);
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function changeStateReq(id, vista) {
    var msj = confirm("¿Está seguro de cambiar el estado?");
    if (msj) {
        // var token = $("#token").val();
        var route = "/requerimientos/update/" + id + "";
        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "POST",
            datatype: "json",
            data: { id: id, state: 0 },
            cache: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
                $("#wait").css("display", "block");
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                $("#wait").css("display", "none");
                ListarTabla_req(0);

                if (vista != undefined && vista == "general") {
                    location.reload(true);
                }
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
                $("#wait").css("display", "none");
            },
        });
    }
}

function changeAplShared() {
    var check = $("#apl_shared");
    $("#switch").toggleClass("switch-off");
    if (check.val() == "1") {
        check.val(0);
    } else if (check.val() == "0") {
        check.val(1);
        //$("#switch").toggleClass('switch-on')
    }
}

function updateAplShared(id) {
    //var token = $("#token").val();
    var route = "/asesorias/change/shared";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: { id: id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            if (res.apl_shared) {
                $("#switch_edit" + id)
                    .removeClass("switch-off")
                    .addClass("switch-on");
            } else if (!res.apl_shared) {
                $("#switch_edit" + id)
                    .removeClass("switch-on")
                    .addClass("switch-off");
            }

            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function showEditNota(id) {
    showElement("val_nota" + id);
    showElement("btnActNota" + id);
    showElement("btnCancelNota" + id);
    hideElement("btnShowEditNota" + id);
    hideElement("labelNota" + id);
}

function hideEditNota(id) {
    hideElement("val_nota" + id);
    hideElement("btnActNota" + id);
    hideElement("btnCancelNota" + id);
    showElement("btnShowEditNota" + id);
    showElement("labelNota" + id);
}

function hideEditNotas() {
    $("#myform_update_notas input[type='text']").prop("disabled", true);
    $("#myform_update_notas #nota_concepto").prop("disabled", true);
    showElement("btn_cambiar_notas");
    hideElement("btn_update_notas");
    hideElement("btn_cancelar_notas");
}

function updateNota(data, refresh = "") {
    // var token = $("#token").val();
    var route = "/notas/update";
    expid = $("#expid").val();
    //new_nota = $("#val_nota"+id).val();
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            hideEditNotas();

            if (refresh != "") {
                window.location.reload(true);
            }
            //  $("#table_list_notas tbody").html(res.notas_caso);
            $("#myform_update_notas #lbldocevname").text(res.user_name);
            $("#wait").css("display", "none");
            // $("#myModal_edit_notas").modal("hide");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function habilityButtReasCaso() {
    showElement("btnReasignar");
    showElement("btnCancReasig");
    showElement("cont_anotacion");
    hideElement("btnOpReasig");

    $(".disabled-fun4").prop("disabled", false);
    $(".disabled-fun4").selectpicker("refresh");
}

function hideButtReasCaso() {
    hideElement("btnReasignar");
    hideElement("btnCancReasig");
    hideElement("cont_anotacion");
    showElement("btnOpReasig");
    $(".disabled-fun4").prop("disabled", true);
    $(".disabled-fun4").selectpicker("refresh");
}

function reasigCaso() {
    var new_user_id = $("#numberest_id").val();
    var expid = $("#expid").val();
    var anotacion = $("#anotacion").val();
    var periodo_id = $("#periodo_id").val();
    var motivo_asig_id = $("#motivo_asig_id").val();
    // var token = $("#token").val();
    var route = "/expedientes/reasigcaso";

    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: {
            expid: expid,
            new_user_id: new_user_id,
            anotacion: anotacion,
            periodo_id: periodo_id,
            motivo_asig_id: motivo_asig_id,
        },
        cache: false,
        beforeSend: function (xhr) {
            $("#wait").css("display", "block");
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res.exptipoproce);
            $("#wait").css("display", "none");
            location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

/*function sustituirCasos(){
var numberestnew_id = $("#numberestnew_id").val();
var numberestact_id = $("#numberestact_id").val();
 
var route = '/expedientes/sustituircasos'; 
  
    $.ajax({ 
    url: route,
    headers: { 'X-CSRF-TOKEN' : token },
    type:'POST',
    datatype: 'json',
    data:$("#myformSusEstu").serialize(),
    cache: false,
    beforeSend: function(xhr){
      xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      $("#wait").css("display", "block");   
    },
        ///muestra div con mensaje de 'regristrado'
    success:function(res){
      ////console.log(res);      
      $("#wait").css("display", "none");
      //location.reload(true);
      
    },
    error:function(xhr, textStatus, thrownError){
        alert("Hubo un error con el servidor ERROR::"+thrownError,textStatus);
    }
  });
}*/

function searchEstud() {
    var route = "/expedientes/getestudiantes";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        //data:{'numberestnew_id':numberestnew_id,'numberestact_id':numberestact_id},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            //////console.log(res);
            llenarTabSusEstu(res);

            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function searchDocentes(option = "") {
    var route = "/docentes/get";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        //data:{'numberestnew_id':numberestnew_id,'numberestact_id':numberestact_id},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            console.log(res);
            $("#wait").css("display", "none");
            abrirModalDocentes(res, option);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function abrirModalDocentes(res, option) {
    var options = "";
    options = '<option value="">Seleccione...</option>';
    for (var i = res.length - 1; i >= 0; i--) {
        if ($("#doc_id_number").val() != res[i].idnumber)
            options +=
                '<option value="' +
                res[i].idnumber +
                '">' +
                res[i].full_name.toUpperCase() +
                "</option>";
    }
    $("#new_docente_id").html(options);
    if (option != "")
        $("#myform_change_docente_exp #new_docente_id").append($(option));
    $("#myModal_change_docente_exp").modal("show");
}

function llenarTabSusEstu(res) {
    var tabla = $("#tabla-sust-estu tbody");
    var index = $(".filas").length;
    var row = "";
    row += '<tr id="fila_' + index + '" class="filas">';
    row += "<td>";
    row +=
        '<select id="dataSelectAct' +
        index +
        '" required name="numberestact_id[]" class="form-control selectpicker disabled-fun4 dangerous" data-live-search="true" onchange="comparateData(' +
        index +
        ')">';
    row += '<option value="">Seleccione...</option>';
    for (var i = res.length - 1; i >= 0; i--) {
        row +=
            '<option value="' +
            res[i].idnumber +
            '">' +
            res[i].full_name +
            "</option>";
    }
    row += "</select>";
    row += "</td>";
    row += "<td>";
    row += "</td>";
    row += "<td>";
    row +=
        '<select id="dataSelectNew' +
        index +
        '" required name="numberestnew_id[]" class="form-control selectpicker disabled-fun4 dangerous" data-live-search="true" onchange="comparateData(' +
        index +
        ')">';
    row += '<option value="">Seleccione...</option>';
    for (var i = res.length - 1; i >= 0; i--) {
        row +=
            '<option value="' +
            res[i].idnumber +
            '">' +
            res[i].full_name +
            "</option>";
    }
    row += "</select>";
    row += "</td>";
    row += "<td>";

    row +=
        '<a class="btn btn-danger" onclick="deleteRow(' +
        index +
        ')"><i class="fa fa-minus-circle"></> Eliminar</a>';

    row += "</td>";

    row += "</tr>";
    tabla.append(row);
    $(".disabled-fun4").selectpicker("refresh");
}

function deleteRow(index) {
    var tabla = $("#tabla-sust-estu  #fila_" + index).remove();

    // tabla.remove();
}

function comparateData(index) {
    var dataSelectAct = $("#dataSelectAct" + index).val();
    var dataSelectNew = $("#dataSelectNew" + index).val();
    if (dataSelectNew == dataSelectAct) {
        $("#tabla-sust-estu #fila_" + index).addClass("dangerous");
        $("#btnReasignar").prop("disabled", true);
    } else {
        $("#tabla-sust-estu #fila_" + index).removeClass("dangerous");
        $("#btnReasignar").prop("disabled", false);
    }
}

function getDetailsAuditoria(id) {
    var route = "/auditoria/" + id;
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "GET",
        datatype: "json",
        //data:{'numberestnew_id':numberestnew_id,'numberestact_id':numberestact_id},
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            ////console.log(res);
            //  ////console.log(data);
            llenarFormAuditoria(res, res.exp_auditado, res.expediente_actual);

            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}
function llenarFormAuditoria(res, data, expediente_actual) {
    $("#label_userAuditoria").text(
        res.auditoria.usuario.name + " " + res.auditoria.usuario.lastname
    );
    $("#label_fechaAuditoria").text(res.auditoria.created_at);

    $("#label_expidAuditoria").html(data.expid);
    $("#label_expfechaAuditoria").html(data.expfecha);
    $("#label_expramaderecho_idAuditoria").html(data.expramaderecho_id);
    $("#label_expestado_idAuditoria").html(data.expestado_id);
    $("#label_expidnumberAuditoria").html(data.expidnumber);
    $("#label_exptipoproce_idAuditoria").html(data.exptipoproce_id);
    $("#label_exptipocaso_idAuditoria").html(data.exptipoproce_id);
    $("#label_expidnumberestAuditoria").html(data.expidnumberest);
    if (data.exphechos != null) {
        $("#label_exphechosAuditoria").html(
            data.exphechos.replace(/\n/g, "<br />")
        );
    }
    if (data.exprtaest != null) {
        $("#label_exprtaestAuditoria").html(
            data.exprtaest.replace(/\n/g, "<br />")
        );
    }
    $("#label_expingremensualAuditoria").text(data.expingremensual);

    $("#label_expegremensualAuditoria").html(data.expegremensual);
    $("#label_exphechosAuditoria").html(data.exphechos);
    $("#label_exprtaestAuditoria").html(data.exprtaest);
    $("#label_expjuzoentAuditoria").html(data.expjuzoent);
    $("#label_expnumprocAuditoria").html(data.expnumproc);
    $("#label_exppersondemandanteAuditoria").html(data.exppersondemandante);
    $("#label_exppersondemandadaAuditoria").html(data.exppersondemandada);
    $("#label_expfechalimiteAuditoria").html(data.expfechalimite);
    $("#label_expuserupdatedAuditoria").html(data.expuserupdated);

    $("#label_expmunicipio_idAuditoria").html(data.expmunicipio_id);
    $("#label_expdepto_idAuditoria").html(data.expdepto_id);
    $("#label_exptipovivien_idAuditoria").html(data.exptipovivien_id);
    $("#label_expperacargoAuditoria").html(data.expperacargo);
    //$("#label_expfechalimiteAuditoria")

    $("#label_expidActual").html(expediente_actual.expid);
    $("#label_expfechaActual").html(expediente_actual.expfecha);
    $("#label_expramaderecho_idActual").html(
        expediente_actual.expramaderecho_id
    );
    $("#label_expestado_idActual").html(expediente_actual.expestado_id);
    $("#label_expidnumberActual").html(expediente_actual.expidnumber);
    $("#label_exptipoproce_idActual").html(expediente_actual.exptipoproce_id);
    $("#label_exptipocaso_idActual").html(expediente_actual.exptipoproce_id);
    $("#label_expidnumberestActual").html(expediente_actual.expidnumberest);
    if (expediente_actual.exphechos != null) {
        $("#label_exphechosActual").html(
            expediente_actual.exphechos.replace(/\n/g, "<br />")
        );
    }
    if (expediente_actual.exprtaest != null) {
        $("#label_exprtaestActual").html(
            expediente_actual.exprtaest.replace(/\n/g, "<br />")
        );
    }
    $("#label_expingremensualActual").text(expediente_actual.expingremensual);
    $("#label_expegremensualActual").html(expediente_actual.expegremensual);
    $("#label_exphechosActual").html(expediente_actual.exphechos);
    $("#label_exprtaestActual").html(expediente_actual.exprtaest);
    $("#label_expjuzoentActual").html(expediente_actual.expjuzoent);
    $("#label_expnumprocActual").html(expediente_actual.expnumproc);
    $("#label_exppersondemandanteActual").html(
        expediente_actual.exppersondemandante
    );
    $("#label_exppersondemandadaActual").html(
        expediente_actual.exppersondemandada
    );
    $("#label_expfechalimiteActual").html(expediente_actual.expfechalimite);
    $("#label_expuserupdatedActual").html(expediente_actual.expuserupdated);
    $("#label_expmunicipio_idActual").html(expediente_actual.expmunicipio_id);
    $("#label_expdepto_idActual").html(expediente_actual.expdepto_id);
    $("#label_exptipovivien_idActual").html(expediente_actual.exptipovivien_id);
    $("#label_expperacargoActual").html(expediente_actual.expperacargo);
    $("#myModal_auditoria_details").modal("show");
}

function changeStateUser(id) {
    var route = "/users/change/state";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: { id: id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.active) {
                $("#" + id)
                    .removeClass("switch-off")
                    .addClass("switch-on");
            } else if (!res.active) {
                $("#" + id)
                    .removeClass("switch-on")
                    .addClass("switch-off");
            }
            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function searchEstudAsignados(idnumber) {
    var route = "/docentes/asigest/" + idnumber;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: { idnumber: idnumber },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res)
            $("#wait").css("display", "none");
            llenarModalListEstuAsig(res);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function llenarModalListEstuAsig(res) {
    var table = $("#table_list_est_asig_doc tbody");
    table.html("");
    var row = "";
    for (var i = res.length - 1; i >= 0; i--) {
        row += "<tr>";
        row += "<td>";
        row += "" + res[i].estudiante.name + " " + res[i].estudiante.lastname;
        row += "</td>";
        row += "<td>";
        row += "" + res[i].estudiante.curso.ref_nombre + "";
        row += "</td>";
        row += "<td>";
        if (res[i].confirmado) confirmado = "Confirmado";
        if (!res[i].confirmado) confirmado = "Sin Confirmar";
        row += "" + confirmado + "";
        row += "</td>";
        row += "<td>";
        row +=
            '<a class="btn btn-danger btn_deleteasignacionaoc" id="deleteasig_' +
            res[i].id +
            '">Quitar Asignación</a>';
        row += "</td>";
        row += "</tr>";
    }
    table.append(row);
    $("#myModal_est_asig_docente").modal("show");
}

function habilityEditHorario(id) {
    $("#horas_a" + id).attr("type", "text");
    $("#horas_b" + id).attr("type", "text");
    $("#num_max_est" + id).attr("type", "text");
    hideElement("label_horas_a" + id);
    hideElement("label_horas_b" + id);
    hideElement("label_num_max_est" + id);
    hideElement("btn_habilityEditHorario" + id);
    showElement("btn_actualizarHorario" + id);
    showElement("btn_cancelEdhor-" + id);
    hideElement("btn_details-" + id);
}

function hideEditHorario(id) {
    $("#horas_a" + id).attr("type", "hidden");
    $("#horas_b" + id).attr("type", "hidden");
    $("#num_max_est" + id).attr("type", "hidden");
    showElement("label_horas_a" + id);
    showElement("label_horas_b" + id);
    showElement("label_num_max_est" + id);
    showElement("btn_habilityEditHorario" + id);
    hideElement("btn_actualizarHorario" + id);
    hideElement("btn_cancelEdhor-" + id);
    showElement("btn_details-" + id);
}

function actualizarHorario(id) {
    var horas_a = $("#horas_a" + id).val();
    var horas_b = $("#horas_b" + id).val();
    var num_max_est = $("#num_max_est" + id).val();

    var errors = validateForm("table_list_docentes_horas");

    if (errors.length <= 0) {
        var route = "/docentes/horario/" + id;

        $.ajax({
            url: route,
            headers: { "X-CSRF-TOKEN": token },
            type: "PUT",
            datatype: "json",
            data: {
                horas_a: horas_a,
                horas_b: horas_b,
                num_max_est: num_max_est,
            },
            cache: false,
            beforeSend: function (xhr) {
                $("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                $("#wait").css("display", "none");
                $("#label_horas_a" + id).text(res.horas_a);
                $("#label_horas_b" + id).text(res.horas_b);
                $("#label_num_max_est" + id).text(res.num_max_est);
                hideEditHorario(id);
                //location.reload(true);
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function searchHorasDocente(idnumber) {
    var route = "/docentes/search/horario";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: { idnumber: idnumber },
        cache: false,
        beforeSend: function (xhr) {
            $("#wait").css("display", "block");
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            llenarTablaShowDocToAsig(res);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function llenarTablaShowDocToAsig(res) {
    var table = $("#table_show_docente_toAsig tbody");
    table.html("");
    var row = "";
    row += "<tr>";
    row += "<td>";
    row += "Horas Jornada Mañana";
    row += "</td>";
    row += "<td>";
    row += "Horas Jornada Tarde";
    row += "</td>";
    row += "<td>";
    row += "No Max. Estudiantes";
    row += "</td>";
    row += "<td>";
    row += "No Est. Asignados";
    row += "</td>";
    row += "</tr>";

    row += "<tr>";
    row += "<td>";
    row += res.horas_a;
    row += "</td>";
    row += "<td>";
    row += res.horas_b;
    row += "</td>";
    row += "<td>";
    row += res.num_max_est;
    row += "</td>";
    row += "<td>";
    row += res.docente.asignaciones_docente.length;
    row += "</td>";
    row += "</tr>";
    table.append(row);
}

function asigDocenteEstu() {
    var route = "/docentes/asigest";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: $("#myform_asig_doc_est").serialize(),
        cache: false,
        beforeSend: function (xhr) {
            $("#wait").css("display", "block");
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function deleteAsignacion(id) {
    var msj = confirm("¿Está seguro de eliminar en registro?");

    if (msj) {
        var route = "/docentes/asigest/" + id;
        $.ajax({
            url: route,
            type: "DELETE",
            datatype: "json",
            //data:$("#myform_asig_doc_est").serialize(),
            cache: false,
            beforeSend: function (xhr) {
                $("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function deleteAllHorarioDocentes() {
    var msj = confirm("¿Está seguro de eliminar todos los registros..?");

    if (msj) {
        var route = "/docentes/horario/delete/all";
        $.ajax({
            url: route,
            type: "POST",
            datatype: "json",
            //data:$("#myform_asig_doc_est").serialize(),
            cache: false,
            beforeSend: function (xhr) {
                $("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function confAsigDoc() {
    var msj = confirm("¿Está seguro de asignar todos los registros..?");

    if (msj) {
        var route = "/docentes/asigest/confirm";
        $.ajax({
            url: route,
            type: "POST",
            datatype: "json",
            //data:$("#myform_asig_doc_est").serialize(),
            cache: false,
            beforeSend: function (xhr) {
                $("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function habilityEditColor(turno_id) {
    showElement("color_id" + turno_id);
    showElement("cursando_id" + turno_id);
    showElement("horario_id" + turno_id);
    showElement("trnid_oficina" + turno_id);
    showElement("trnid_dia" + turno_id);
    showElement("btn_hideupdatecolor" + turno_id);
    showElement("btnUpdatecolor_" + turno_id);
    hideElement("btn_habilityupdatecolor" + turno_id);
    hideElement("label_color" + turno_id);
    hideElement("label_cursando" + turno_id);
    hideElement("label_horario" + turno_id);
    hideElement("label_trnid_oficina" + turno_id);
    hideElement("label_trnid_dia" + turno_id);
    hideElement("btn_delete_turno-" + turno_id);
}
function hideEditColor(turno_id) {
    hideElement("color_id" + turno_id);
    hideElement("cursando_id" + turno_id);
    hideElement("horario_id" + turno_id);
    hideElement("trnid_oficina" + turno_id);
    hideElement("trnid_dia" + turno_id);
    hideElement("btn_hideupdatecolor" + turno_id);
    hideElement("btnUpdatecolor_" + turno_id);
    showElement("btn_habilityupdatecolor" + turno_id);
    showElement("label_color" + turno_id);
    showElement("label_cursando" + turno_id);
    showElement("label_horario" + turno_id);
    showElement("label_trnid_oficina" + turno_id);
    showElement("label_trnid_dia" + turno_id);
    showElement("btn_delete_turno-" + turno_id);
}

function updateAsigTurno(turno_id) {
    ////console.log(turno_id);
    var estudiante_id = $("#estudiante_id" + turno_id).val();
    var color_id = $("#color_id" + turno_id).val();
    var horario_id = $("#horario_id" + turno_id).val();
    var cursando_id = $("#cursando_id" + turno_id).val();
    var trnid_oficina = $("#trnid_oficina" + turno_id).val();
    var trnid_dia = $("#trnid_dia" + turno_id).val();
    var route = "/turnos/" + turno_id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: {
            trnid_dia: trnid_dia,
            trnid_oficina: trnid_oficina,
            estudiante_id: estudiante_id,
            color_id: color_id,
            horario_id: horario_id,
            cursando_id: cursando_id,
        },
        cache: false,
        beforeSend: function (xhr) {
            $("#wait").css("display", "block");
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function deleteAllTurnos() {
    var msj = confirm("¿Está seguro de eliminar todos los registros..?");

    if (msj) {
        var route = "/turnos/delete/all";
        $.ajax({
            url: route,
            type: "POST",
            datatype: "json",
            //data:$("#myform_asig_doc_est").serialize(),
            cache: false,
            beforeSend: function (xhr) {
                $("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                window.location.reload(true);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function asigTurnoEst() {
    var idnumber = $("#est_idnumber").val();
    var color_id = $("#color_id").val();
    var horario_id = $("#horario_id").val();
    var cursando_id = $("#cursando_id").val();
    var trnid_oficina = $("#trnid_oficina").val();
    var trnid_dia = $("#trnid_dia").val();

    var route = "/turnos";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: {
            trnid_oficina: trnid_oficina,
            trnid_dia: trnid_dia,
            idnumber: idnumber,
            color_id: color_id,
            horario_id: horario_id,
            cursando_id: cursando_id,
        },
        cache: false,
        beforeSend: function (xhr) {
            $("#wait").css("display", "block");
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            ////console.log(res);
            window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function anteriorEstudiante() {
    var fech_desde = $("#fech_desde").val();
    var fech_hasta = $("#fech_hasta").val();
    errors = validateForm("myFormBuscarAntEst");
    if (errors <= 0) {
        var route = "/expedientes/anteriorestudiante";
        $.ajax({
            url: route,
            type: "POST",
            datatype: "json",
            data: { fech_desde: fech_desde, fech_hasta: fech_hasta },
            cache: false,
            beforeSend: function (xhr) {
                $("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                res = unique_array(res);
                llenarTabAntEst(res);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function unique_array(array) {
    var dupes = [];
    var uniqueEmployees = [];
    $.each(array, function (index, entry) {
        if (!dupes[entry.idnumber]) {
            dupes[entry.idnumber] = true;
            uniqueEmployees.push(entry);
        }
    });
    return uniqueEmployees;
}

function llenarTabAntEst(res) {
    var tabla = $("#table_lisestant_exp tbody");
    tabla.html("");
    var row = "";
    for (var i = res.length - 1; i >= 0; i--) {
        row += "<tr>";
        row += "<td>";
        row += "" + res[i].idnumber + "";
        row += "</td>";
        row += "<td>";
        row += "" + res[i].full_name + "";
        row += "</td>";
        row += "<td>";
        row += "" + res[i].fecha_asig + "";
        row += "</td>";
        row += "<td>";
        row +=
            '<a class="btn btn-success btn_asgicasest" id="' +
            res[i].idnumber +
            '"> Detalles</a>';
        row += "</td>";
        row += "</tr>";
    }
    //  ////console.log(row)
    tabla.append(row);
    //$('.disabled-fun4').selectpicker('refresh');
}

function searchExpAsig(idnumber) {
    var fech_desde = $("#fech_desde").val();
    var fech_hasta = $("#fech_hasta").val();
    errors = validateForm("myFormBuscarAntEst");
    if (errors <= 0) {
        var route = "/expedientes/buscarexpasig";
        $.ajax({
            url: route,
            type: "POST",
            datatype: "json",
            data: {
                fech_desde: fech_desde,
                fech_hasta: fech_hasta,
                idnumber: idnumber,
            },
            cache: false,
            beforeSend: function (xhr) {
                //$("#wait").css("display", "block");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    $("#token").attr("content")
                );
            },
            /*muestra div con mensaje de 'regristrado'*/
            success: function (res) {
                ////console.log(res);
                //res = unique_array(res);
                llenarTablaDetailsAsignaciones(res);
                $("#wait").css("display", "none");
            },
            error: function (xhr, textStatus, thrownError) {
                alert(
                    "Hubo un error con el servidor ERROR::" + thrownError,
                    textStatus
                );
            },
        });
    }
}

function llenarTablaDetailsAsignaciones(res) {
    var table = $("#table-details-asig tbody");
    table.html("");
    var row = "";
    for (var i = res.length - 1; i >= 0; i--) {
        row += "<tr>";
        row += "<td>";
        row += "" + res[i].asigexp_id + "";
        row += "</td>";
        row += "<td>";
        row += "" + res[i].name + " " + res[i].lastname;
        row += "</td>";
        row += "<td>";
        row += "" + res[i].numero + "";
        row += "</td>";
        row += "<td>";
        row += "" + res[i].fecha_asig + "";
        row += "</td>";
        row += "<td>";
        row +=
            '<a href="/expedientes/' +
            res[i].id +
            '/edit" class="btn btn-primary" id="' +
            res[i].idnumber +
            '"> Ir al Caso</a>';
        row += "</td>";
        row += "</tr>";
    }
    //  ////console.log(row)
    table.append(row);
    $("#myModal_asig_details").modal("show");
}
function create_periodo(request) {
    var route = "/periodos";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            //$("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            $("#table_list_model").html(res);
            $("#myModal_create_periodo").modal("hide");
            ////console.log(res);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function change_state_periodo(route) {
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        //data:request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            //$("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            $("#table_list_model").html(res);
            //$("#myModal_create_periodo").modal('hide');
            //////console.log(res);
            set_statusfc();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function create_segmento(request) {
    var route = "/segmentos";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            //$("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            $("#table_list_model").html(res);
            $("#myModal_create_segmento").modal("hide");
            ////console.log(res);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function change_state_segfc() {
    var route = "/segmentos/change/fc";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        //data:request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            //$("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.success) {
                $("#radio_state_segmento-" + res.seg).val(res.statusfc);
                set_statusfc();
            }
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}
set_statusfc();
function set_statusfc() {
    var bandera = "";
    $(".radio_state_segmento").each(function () {
        if ($(this).is(":checked")) bandera = $(this).val();
    });
    if (bandera == "1") {
        $("#switch_act_fc").attr({ dataset: 1 });
        $("#switch_act_fc").removeClass("switch-off").addClass("switch-on");
    } else {
        $("#switch_act_fc").attr({ dataset: 0 });
        $("#switch_act_fc").removeClass("switch-on").addClass("switch-off");
    }
}

function searchPeriodo(id) {
    var route = "/periodos/" + id;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: id,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            ////console.log(res);
            //$("#myform_edit_periodo").loadJSON(res)
            $("#myform_edit_periodo input[name='prdfecha_inicio']").val(
                res.prdfecha_inicio
            );
            $("#myform_edit_periodo input[name='prdfecha_fin']").val(
                res.prdfecha_fin
            );
            $("#myform_edit_periodo input[name='prddes_periodo']").val(
                res.prddes_periodo
            );
            $("#myform_edit_periodo input[name='id_periodo']").val(res.id);

            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function searchSegmento(id) {
    var route = "/segmentos/" + id;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: id,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            ////console.log(res);
            //$("#myform_edit_periodo").loadJSON(res)
            $("#myform_edit_segmento input[name='segnombre']").val(
                res.segnombre
            );
            $("#myform_edit_segmento input[name='fecha_inicio']").val(
                res.fecha_inicio
            );
            $("#myform_edit_segmento input[name='fecha_fin']").val(
                res.fecha_fin
            );
            $("#myform_edit_segmento input[name='segmento_id']").val(res.id);

            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function closeSegmento(id) {
    $("#msg-success").hide();
    $("#msg-danger").hide();
    var route = "/segmentos/close/" + id;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        // data:id,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            if (res.saved) {
                $("#msg-success label").html("");
                $("#table_list_model").html(res.view);
                $("#msg-success label").append("Cerrado con éxito!");
                $("#msg-success").show();
            } else {
                // console.log(res)
                $("#msg-danger label").html("");
                $("#msg-danger label").append(
                    "Recuerda que debe haber un final de corte activo"
                );
                $("#msg-danger").show();
            }

            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function updatePeriodo(data) {
    var id = $("#myform_edit_periodo input[name='id_periodo']").val();
    var route = "/periodos/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            $("#myModal_edit_periodo").modal("hide");
            $("#table_list_model").html(res);
            // window.history.replaceState( {} , '/periodos', route );
            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function updateSegmento(data) {
    var id = $("#myform_edit_segmento input[name='segmento_id']").val();
    var route = "/segmentos/" + id;
    $.ajax({
        url: route,
        type: "PUT",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            $("#myModal_edit_segmento").modal("hide");
            $("#table_list_model").html(res);
            // window.history.replaceState( {} , '/periodos', route );
            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function deletePeriodo(id) {
    // var id = $("#myform_edit_periodo input[name='id_periodo']").val();
    var route = "/periodos/" + id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: id,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            ////console.log(res)
            //$("#myModal_edit_periodo").modal('hide');
            $("#table_list_model").html(res);
            // window.history.replaceState( {} , '/periodos', route );
            $("#wait").css("display", "none");
            // location.reload(true);
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function deleteSegmento(id) {
    // var id = $("#myform_edit_periodo input[name='id_periodo']").val();
    var route = "/segmentos/" + id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: id,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            // data = $.parseJSON(res.data)
            ////console.log(res)
            //$("#myModal_edit_periodo").modal('hide');
            $("#table_list_model").html(res);
            // window.history.replaceState( {} , '/periodos', route );
            $("#wait").css("display", "none");
            // location.reload(true);
            set_statusfc();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function updateDocenteAsignado(id, idnumber) {
    var route = "/asignaciones/update/" + id;
    $.ajax({
        url: route,
        type: "post",
        datatype: "json",
        data: { idnumber: idnumber },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            hideElement("btns_act-" + id);
            showElement("btns_edit-" + id);
            hideElement("select_docentes_div-" + id);
            showElement("lbl_nombres_docente-" + id);
            window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function deleteTurno(id) {
    var route = "/turnos/" + id;
    $.ajax({
        url: route,
        type: "DELETE",
        datatype: "json",
        data: { idnumber: id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function index_page(route, request) {
    var route = route;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#table_list_model").html(res);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function index_pageSol(route, request) {
    var route = route;
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: request,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        /*muestra div con mensaje de 'regristrado'*/
        success: function (res) {
            $("#content_list_solicitudesh").html(res);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
        },
    });
}

function changeStateActuacion(id) {
    var route = "/actuaciones/revisar/" + id;
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: { id: id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            console.log(res, "ajjaja");
            ListarTabla(0);
            // window.location.reload(true);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

////////////////////////////////////////////////////////////////////

input = document.getElementById("doc_file");
if (input) {
    input.addEventListener("change", function (e) {
        var fileName = "";
        //////console.log(this.files[0].name);
        if (this.files || this.files.length > 1) {
            fileName = this.files[0].name;
            // ////console.log(fileName.indexOf('.',-1));
            $("#lab_doc_file i").text(fileName);
        }
    });
}

input2 = document.getElementById("actdocnomgen");
if (input2) {
    input2.addEventListener("change", function (e) {
        var fileName = "";
        //////console.log(this.files[0].name);
        if (this.files || this.files.length > 1) {
            fileName = this.files[0].name;
            // ////console.log(fileName.indexOf('.',-1));
            //$("#lab_doc_file i").text(fileName);
            $("#lab_doc_file").text(fileName);
            //////console.log(fileName);
        }
    });
}

function showPassword(input) {
    atributo = $("#" + input).attr("type");
    if (atributo == "password") {
        $("#" + input).attr("type", "text");
    } else {
        $("#" + input).attr("type", "password");
    }
}

function openCamNotas() {
    $("#myform_update_notas input[type='text']").prop("disabled", false);
    $("#myform_update_notas #nota_concepto").prop("disabled", false);
    hideElement("btn_cambiar_notas");
    showElement("btn_update_notas");
    showElement("btn_cancelar_notas");
}

function get_notas(tbl_id, origen) {
    var route = "/notas/" + tbl_id + "/edit";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: { origen: origen },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // console.log(res);

            $("#myform_update_notas #nota_conocimiento").val(
                res.nota_conocimiento
            );
            $("#myform_update_notas #nota_conocimientoid").val(
                res.nota_conocimientoid
            );

            $("#myform_update_notas #nota_etica").val(res.nota_etica);
            $("#myform_update_notas #nota_eticaid").val(res.nota_eticaid);

            $("#myform_update_notas #nota_aplicacion").val(res.nota_aplicacion);
            $("#myform_update_notas #nota_aplicacionid").val(
                res.nota_aplicacionid
            );

            $("#myform_update_notas #nota_concepto").val(res.nota_concepto);
            $("#myform_update_notas #nota_conceptoid").val(res.nota_conceptoid);
            $("#myform_update_notas #lbl_nota_gen_caso").text(res.nota_final);

            //$("#myform_update_notas input[name='tbl_org_id']").val(res.nota_conceptoid);
            $("#myform_update_notas #origen").val(origen);
            $("#myform_update_notas #tbl_org_id").val(tbl_id);
            $("#myform_update_notas #lbldocevname").text(res.docevname);

            $("#myModal_edit_notas #btns_edit_notas").hide();
            $("#wait").css("display", "none");
            if (res.encontrado) {
                $("#myModal_edit_notas #lbl_periodo").text(res.periodo);
                $("#myModal_edit_notas #lbl_segmento").text(res.segmento);
                $("#myModal_edit_notas #lbl_tipo").text(res.tipo);
                $("#myModal_edit_notas #tipo_nota_id").val(res.tipo_id);
                var tipo = res.tipo_id == "1" ? "Parcial" : "Definitiva";
                $("#btn_tipo_update").text("Cambiar notas a: " + tipo);
                var tipo_id = res.tipo_id == "1" ? "2" : "1";

                if (res.can_edit) {
                    if (origen == 1 && $("#expestado_id").val() == "4") {
                        $("#btn_tipo_update").attr("data-value", tipo_id);
                        $("#btn_tipo_update").show();
                        $("#btn_tipo_update").attr(
                            "id",
                            "btn_tipo_nota_update"
                        );
                    }

                    $("#myModal_edit_notas #btns_edit_notas").show();
                    $("#btn_cambiar").attr("id", "btn_cambiar_notas");
                    $("#btn_delete").attr("id", "btn_delete_notas");
                    $("#btn_update").attr("id", "btn_update_notas");
                } else {
                    $("#btn_cambiar_notas").attr("id", "btn_cambiar");
                    $("#btn_delete_notas").attr("id", "btn_delete");
                    $("#btn_update_notas").attr("id", "btn_update");
                    //$("#btn_tipo_nota_update").attr('id', 'btn_update_tipo');
                }
                $("#myModal_edit_notas").modal("show");
            }

            if (origen == 3) {
                $("#myModal_edit_notas .fil_nt_co input[type='text']")
                    .attr("type", "hidden")
                    .prop("disabled", true);
                $("#myModal_edit_notas .fil_nt_co").hide();
                // hideElement('btn_delete_notas');
            } else {
                $("#myModal_edit_notas .fil_nt_co input[type='hidden']")
                    .attr("type", "text")
                    .prop("disabled", false);
                $("#myModal_edit_notas .fil_nt_co").show();
                showElement("btn_delete_notas");
                //if(origen == 2)   hideElement('btn_delete_notas');
            }
            hideEditNotas();
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function searchSegmentos(periodo_id, type) {
    var route = "/periodos/buscar/segmentos/" + periodo_id;
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: { periodo_id: periodo_id },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            var option = "";
            if (res.length > 0) {
                res.forEach((element) => {
                    option += `<option value="${element.id}">${element.segnombre}</option>`;
                });
                $("#segmento_id").html(option);
            } else {
                var option =
                    '<option value="">El periodo no tiene cortes</option>';
            }
            if (type == "gen")
                $("#myFormNotasSearch select[name=segmento_id]").html(option);
            if (type == "ind")
                $("#myFormNotasSearchInd select[name=segmento_id]").html(
                    option
                );
            // $(" #segmento_id").html(option);
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}
function searchNotas(data) {
    var route = "/notas/search";
    $.ajax({
        url: route,
        type: "POST",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // console.log(res)
            if (res.path) location.href = res.path;
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

function get_act_ant() {
    var id_control_list = $("#expid").val();
    var route = "/actuaciones/search/previous";
    $.ajax({
        url: route,
        type: "GET",
        datatype: "json",
        data: { id_control_list: id_control_list, bandera: "1" },
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            // console.log(res.length)
            if (res.length > 0) {
                llenarTabla(res, "datos_prev");
            }
            $(".cont_act_prev").toggle();
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR: " + thrownError,
                textStatus
            );
            $("#wait").css("display", "none");
        },
    });
}

var myVar = setInterval(myTimer, 1000);
function myTimer() {
    var d = new Date();
    var dia = d.getDate();
    var mes = d.getMonth() + 1;
    if (mes <= 9) {
        mes = "0" + mes;
    }
    if (dia <= 9) {
        dia = "0" + dia;
    }
    var anio = d.getFullYear();
    var cadena =
        "" + " " + mes + "/" + dia + "/" + anio + " " + d.toLocaleTimeString();
    document.getElementById("fecha_sistema").innerHTML = cadena;
    //document.getElementById("demo").innerHTML =
}

function getDocentes() {
    var route = "/docentes/get";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        cache: false,
        contentType: false,
        processData: false,
        /*muestra div con mensaje de 'regristrado'*/
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            //$("#wait").css("display", "block");
        },
        success: function (res) {
            $(".disabled-fun1").prop("disabled", false);
            $(".disabled-fun2").prop("disabled", true);
            $(".disabled-fun2").selectpicker("refresh");
            var option = "";
            $(res).each(function (key, value) {
                option +=
                    '<option value="' +
                    value.idnumber +
                    '">' +
                    value.full_name.toUpperCase() +
                    "</option>";
            });
            $("#select_data_users").append(option); //coloca una nueva opcion
            $(".disabled-fun1").selectpicker("refresh"); //refresca el select
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor ERROR::" + thrownError,
                textStatus
            );
            $("#wait").css("display", "block");
        },
    });
}

function getSolicitantes() {
    $(".disabled-fun2").prop("disabled", false);
    $(".disabled-fun2").selectpicker("refresh");
    $(".disabled-fun1").prop("disabled", true);
    $(".disabled-fun1").selectpicker("refresh");
}

function reloadSearchExp() {
    if (
        $("#tipo_busqueda").val() !== "undefined" &&
        $("#tipo_busqueda").val() !== ""
    ) {
        origen = $("#tipo_busqueda").val();
        changeSelectSearchExp(origen);
    }
}

function changeSelectSearchExp(value) {
    $("#input_data").val("");
    $("#select_data").val("");
    $("#date_data").val("");
    switch (value) {
        case "idnumber_doc":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            showElement("input_select_users", "id");
            $("#select_data_consultantes").attr(
                "data-select-origen",
                "docente"
            );
            //enabledInput('select_data_users','data-id');

            if ($("#select_data_users option").length <= 0) {
                getDocentes();
            } else {
                $(".disabled-fun1").prop("disabled", false);
                $(".disabled-fun1").selectpicker("refresh");
                $(".disabled-fun2").prop("disabled", true);
                $(".disabled-fun2").selectpicker("refresh");
            }

            break;

        case "consultante":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            showElement("input_select_consultantes", "id");
            $("#select_data_consultantes").attr(
                "data-select-origen",
                "consultante"
            );
            //  console.log($("#select_data_users option").length)
            if ($("#select_data_consultantes option").length <= 0) {
                getSolicitantes();
            } else {
                $(".disabled-fun2").prop("disabled", false);
                $(".disabled-fun2").selectpicker("refresh");
                $(".disabled-fun1").prop("disabled", true);
                $(".disabled-fun1").selectpicker("refresh");
            }

            break;
        case "estudiante_num":
        case "consultante_num":
        case "codido_exp":
            if (value == "estudiante_num") {
                placeholder = "No de Documento";
            } else if (value == "consultante") {
                placeholder = "No de Documento";
            } else {
                placeholder = "No de expediente";
            }
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            showElement("input_text", "id");
            enabledInput("input_data", "id");
            $("#input_data").attr("placeholder", placeholder);
            break;
        case "estado":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            showElement("input_select_estado", "id");
            enabledInput("select_data_estado", "id");

            break;
        case "tipo_consulta":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            showElement("input_select_tipo_consulta", "id");
            enabledInput("select_data_tipo_consulta", "id");
            break;
        case "fecha_creacion":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            enabledInput("date_data", "id");
            showElement("input_date", "id");
            $("#date_data").attr("placeholder", "yyyy/mm/dd");
            break;
        case "fecha_cita":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            enabledInput("date_data", "id");
            showElement("input_date", "id");
            $("#date_data").attr("placeholder", "yyyy/mm/dd");
            break;
        case "rama_derecho":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            enabledInput("select_data_rama_derecho", "id");
            showElement("input_select_rama_derecho", "id");
            $("#date_data").attr("placeholder", "yyyy/mm/dd");
            break;
        case "fecha_rango":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            enabledInput("date_data_inicio", "id");
            enabledInput("date_data_final", "id");
            showElement("input_date_rango", "id");
            $("#date_data").attr("placeholder", "yyyy/mm/dd");
            break;
        case "all":
            hideElement("inputs", "class");
            disabledInput("input-search", "class");
            showElement("input_data", "id");
            showElement("input_text", "id");
            searchExpedientes();
            //enabledInput('input_data', 'id');
            // window.location ='/expedientes';
            // location.reload();
            break;
        default:
    }
}

function tomarCasoDocente(data) {
    var route = "/docentes/casos";
    $.ajax({
        url: route,
        headers: { "X-CSRF-TOKEN": token },
        type: "POST",
        datatype: "json",
        data: data,
        cache: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $("#token").attr("content"));
            $("#wait").css("display", "block");
        },
        success: function (res) {
            if (res.error) {
                alertify.alert(res.error);
            } else {
                alertify.success("Espere mientras carga");
                window.location.reload(true);
            }
            $("#wait").css("display", "none");
        },
        error: function (xhr, textStatus, thrownError) {
            alert(
                "Hubo un error con el servidor, consulte con el administrador"
            );
            $("#wait").css("display", "none");
        },
    });
}

//Función que lanza el copiado del código
function copiarAlPortapapeles(id) {
    var codigoACopiar = document.getElementById(id); //Elemento a copiar
    //Debe estar seleccionado en la página para que surta efecto, así que...
    var seleccion = document.createRange(); //Creo una nueva selección vacía
    seleccion.selectNodeContents(codigoACopiar); //incluyo el nodo en la selección
    //Antes de añadir el intervalo de selección a la selección actual, elimino otros que pudieran existir (sino no funciona en Edge)
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(seleccion); //Y la añado a lo seleccionado actualmente
    try {
        var res = document.execCommand("copy"); //Intento el copiado
        if (res) {
            Toast.fire({
                title: "Link copiado.",
                type: "success",
                timer: 5000,
            });
        } else {
            Toast.fire({
                title: "Error de copiado, copie el link manualmente.",
                type: "error",
                timer: 5000,
            });
        }
    } catch (ex) {
        Toast.fire({
            title: "Error de copiado, copie el link manualmente.",
            type: "error",
            timer: 5000,
        });
    }
    window.getSelection().removeRange(seleccion);
}

