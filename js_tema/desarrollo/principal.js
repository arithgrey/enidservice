"use strict";
let frm_efectivo_resultante = '.frm_efectivo_resultante';
let frm_nota_monetaria = '.frm_nota_monetaria';
let input_efectivo = '.input_efectivo_resultante';
let input_clientes_ab = '.input_clientes_ab';
let input_asunto = '.input_asunto';

let menu_efectivo_resultante = '.menu_efectivo_resultante';
let frm_clientes_ab_testing = '.frm_clientes_ab_testing';
let resumen_efectivo_resultante = '.resumen_efectivo_resultante';
let resumen_clientes_ab = '.resumen_clientes_ab';
let num_departamento = ".num_departamento";
let id_departamento = 0;
let select_departamento = '.depto';
let id_ticket = '.ticket';
let boton_agregar_tarea = '.boton_agregar_tarea';
let seccion_nueva_tarea = '.seccion_nueva_tarea';
let menu_tareas_pendientes = '.menu_tareas_pendientes';

/*selectores globales*/
let $q = $(".q");
let $id_ticket = $(".ticket");

window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.onpopstate = function (event) {

    if (event) {
        valida_retorno();
    }
};
$(document).ready(() => {


    set_option("s", 0);
    set_option("modulo", 2);
    let $num_departamento = $(num_departamento);
    id_departamento = $num_departamento.val();

    $(select_departamento).change(() => {
        set_option("id_depto", get_parameter(select_departamento));
        tikets_usuario();
    });

    $q.keyup(tikets_usuario);
    set_option("id_usuario", get_parameter(".id_usuario"));
    $(".base_tab_clientes").click(tikets_usuario);
    if (id_departamento == 4) {
        $(".contenedor_deptos").show();
        selecciona_select(select_departamento, id_departamento);
    }
    $(".abrir_ticket").click(form_nuevo_ticket);
    es_ticket();


});

let form_nuevo_ticket = () => {

    let url = "../q/index.php/api/tickets/form/format/json/";
    request_enid("GET", {}, url, r_form_ticket, ".place_form_tickets");
};

let r_form_ticket = data => {

    render_enid(".place_form_tickets", data);
    if (document.body.querySelector(".input_enid_format")) {

        $(".input_enid_format :input").focus(next_label_input_focus);
        $(".input_enid_format :input").focusout(next_label_focus_out);
    }
    $(".form_ticket").submit(registra_ticket);
};

let registra_ticket = e => {

    let url = "../q/index.php/api/tickets/index/format/json/";
    let data_send = $(".form_ticket").serialize();
    request_enid("POST", data_send, url, response_registro_ticket);
    e.preventDefault();

};
let response_registro_ticket = data => {
    render_enid(".place_registro_ticket", "A la brevedad se realizará su solicitud!");
    set_option("id_ticket", data);
    show_tabs(["#ver_avances", "#base_tab_clientes"]);
    ticket();
};

let set_estatus_ticket = function (id_ticket, status) {

    let url = "../q/index.php/api/tickets/estado/format/json/";
    let data_send = {"id_ticket": id_ticket, "status": status};
    request_enid("PUT", data_send, url, () => {
        tikets_usuario();
    });
};
let ticket = () => {

    set_option("s", 1);
    let url = "../q/index.php/api/tickets/detalle/format/json/";
    let data_send = {"id_ticket": get_option("id_ticket")};
    request_enid("GET", data_send, url, response_carga_ticket);
};

let response_carga_ticket = (data) => {

    render_enid(".place_proyectos", data);
    verifica_formato_default_inputs();
    despliega([seccion_nueva_tarea, menu_tareas_pendientes], 0);
    $(boton_agregar_tarea).click(agregar_tarea);
    $(".agregar_respuesta").click(carga_formulario_respuesta_ticket);
    $(".comentarios_tarea").click(carga_comentarios_tareas);
    $(".form_agregar_tarea").submit(registra_tarea);
    $(".tarea").click(actualiza_tareas);
    $(menu_tareas_pendientes).click(muestra_tareas_por_estatus);
    $(".mostrar_todas_las_tareas").click(muestra_todas_las_tareas);
    $(".ver_tickets").click(tikets_usuario);
    $(".asunto").click(set_asunto);

    $('.form_datetime').datetimepicker({
        language: 'es',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        leftArrow: '<i class="fa fa-long-arrow-left"></i>',
        rightArrow: '<i class="fa fa-long-arrow-right"></i>'
    });

    $(".agendar_google").click(agendar_google);
    $(".frm_agendar_google").submit(google_path);

    $(frm_nota_monetaria).submit(registra_nota_monetaria);
    $('.estrella').click(registra_efecto_monetario);


    $(".menu_nota_monetaria").click(function () {
        toggle_format_menu(frm_nota_monetaria);
    });

    $('.menu_efectivo_resultante').click(function () {
        toggle_format_menu(frm_efectivo_resultante, resumen_efectivo_resultante);
    });

    $('.menu_clientes_ab_testing').click(function () {
        toggle_format_menu(frm_clientes_ab_testing, resumen_clientes_ab);
    });


    $(frm_efectivo_resultante).submit(efectivo_resultante);
    $(frm_clientes_ab_testing).submit(clientes_ab);
    if (get_option("flag_mostrar_solo_pendientes") > 0) {
        muestra_tareas_por_estatus();
    }

};
let carga_formulario_respuesta_ticket = function (e) {

    let tarea = get_parameter_enid($(this), "id");
    set_option("tarea", tarea);
    let url = "../q/index.php/api/tickets/formulario_respuesta/format/json/";
    let data_send = {"tarea": tarea};
    let seccion = ".seccion_respuesta_" + get_option("tarea");

    request_enid("GET", data_send, url, function (data) {
        render_enid(seccion, data);
        $(".form_respuesta_ticket").submit(registra_respuesta_pregunta);

    }, seccion);
};

let carga_comentarios_tareas = function (e) {

    showonehideone(".ocultar_comentarios", ".comentarios_tarea");
    let tarea = get_parameter_enid($(this), "id");
    set_option("tarea", tarea);
    let url = "../q/index.php/api/respuesta/respuestas/format/json/";
    let data_send = {"tarea": tarea};
    let seccion = ".seccion_respuesta_" + get_option("tarea");
    set_option("seccion", seccion);
    request_enid("GET", data_send, url, response_carga_comentario_tareas);

};

let carga_comentarios_terea_simple = () => {

    let tarea = get_option("tarea");
    let url = "../q/index.php/api/respuesta/respuestas/format/json/";
    let data_send = {"tarea": tarea};
    let seccion = ".seccion_respuesta_" + tarea;
    set_option("seccion", seccion);
    request_enid("GET", data_send, url, response_carga_comentario_tareas);

};

let response_carga_comentario_tareas = function (data) {

    let seccion = get_option("seccion");
    render_enid(seccion, data);
    $(".ocultar_comentarios").click(function (e) {
        set_option("tarea", get_parameter_enid($(this), "id"));
        empty_elements(seccion);
    });

};

let registra_tarea = e => {


    let url = "../q/index.php/api/tarea/index/format/json/";
    let data_send = $(".form_agregar_tarea").serialize() + "&" + $.param({
        "id_ticket": get_option("id_ticket"),
        "tarea": $(".form_agregar_tarea .note-editable").html()
    });
    request_enid("POST", data_send, url, ticket, ".place_proyectos");
    e.preventDefault();

};
let muestra_tareas_por_estatus = () => {

    showonehideone(".mostrar_todas_las_tareas", ".tarea_pendiente");
    $(menu_tareas_pendientes).hide();
    set_option("flag_mostrar_solo_pendientes", 1);
};

let muestra_todas_las_tareas = () => {

    showonehideone(".tarea_pendiente", ".mostrar_todas_las_tareas");
    $(menu_tareas_pendientes).show();
    set_option("flag_mostrar_solo_pendientes", 0);
};
let tikets_usuario = () => {

    let status_ticket = 0;
    if (document.querySelector(".estatus_tickets")) {
        status_ticket = get_parameter(".estatus_tickets");
    }

    let keyword = $q.val();
    let url = "../q/index.php/api/tickets/ticket_desarrollo/format/json/";
    let data_send = {
        "status": status_ticket,
        "id_departamento": id_departamento,
        "keyword": keyword,
        "modulo": 3
    };

    request_enid("GET", data_send, url, response_carga_tickets);

};
let response_carga_tickets = function (data) {

    render_enid(".place_proyectos", data);
    $(".hecho").click(marcar_como_hecho);

    $(".draggable").draggable({
        drag: function (event, ui) {
            let id = $(this).attr("id");
            set_option("ticket_drag", id);

        }

    });
    $(".droppable").droppable({
        drop: function (event, ui) {
            let status = $(this).attr("id");
            set_estatus_ticket(get_option("ticket_drag"), status);
        }
    });
    $(".ver_detalle_ticket").dblclick(function (e) {

        set_option("id_ticket", get_parameter_enid($(this), "id"));
        ticket();

    });

    $('.up_ab').click(function () {
        $('.bloque_ab').addClass('d-none');
    });
    $('.up_backlog').click(function () {
        $('.bloque_backlog').addClass('d-none');
    });
    $('.up_pendiente').click(function () {
        $('.bloque_pendiente').addClass('d-none');
    });
    $('.up_proceso').click(function () {
        $('.bloque_haciendo').addClass('d-none');
    });
    $('.up_hecho').click(function () {
        $('.bloque_hecho').addClass('d-none');
    });
    $('.up_revision').click(function () {
        $('.bloque_revision').addClass('d-none');
    });
    $(".estatus_tickets").change(tikets_usuario);


};
let actualiza_tareas = function (e) {

    set_option("id_tarea", get_parameter_enid($(this), "id"));
    let nuevo_valor = this.value;
    let url = "../q/index.php/api/tarea/estado/format/json/";
    let data_send = {
        "id_tarea": get_option("id_tarea"),
        "nuevo_valor": nuevo_valor,
        "id_ticket": get_option("id_ticket")
    };
    request_enid("PUT", data_send, url, response_actualiza_tareas, ".place_proyectos");
};

let response_actualiza_tareas = data => {

    if (data === "cerrado") {

        tikets_usuario();

    } else {

        ticket();

    }
};

let set_visible = s => ($(s).is(":visible")) ? $(s).hide() : $(s).show();

let agregar_tarea = () => {

    set_visible(seccion_nueva_tarea);
    set_visible(boton_agregar_tarea);
    recorre(seccion_nueva_tarea);

    despliega([".listado_pendientes", ".mostrar_todas_las_tareas", ".table_resumen_ticket"], 0);
    $('.summernote').summernote({
        placeholder: 'Tarea pendiente',
        tabsize: 2,
        height: 100
    });

};
let cerrar_ticket = (id) => {

    id = parseInt(id);
    if (id > 0) {
        set_option("id_ticket", id);
        show_confirm("¿DESEAS CERRAR EL TICKET?", "Se descartarán todas sus tareas incluidas", "CERRAR TICKET", confirmacion_cerrar_ticket);
    }

};
let confirmacion_cerrar_ticket = () => {

    let id_ticket = get_option("id_ticket");
    let url = "../q/index.php/api/tickets/estado/format/json/";
    let data_send = {"status": 2, "id_ticket": id_ticket};
    request_enid("PUT", data_send, url, tikets_usuario);

};
let valida_retorno = () => {

    switch (parseInt(get_option("s"))) {

        case 1:

            tikets_usuario();
            break;
        default:

            break;
    }

};
let es_ticket = () => {

    let id_ticket = $id_ticket.val();
    if (id_ticket > 0) {
        set_option("id_ticket", id_ticket);
        ticket();
    }
};
let edita_descripcion_tarea = id_tarea => {

    showonehideone("#tarea_" + id_tarea, ".text_tarea_" + id_tarea);
    $("#tarea_" + id_tarea).keyup(function (e) {

        var code = (e.keyCode ? e.keyCode : e.which);

        if (code == 13) {

            let text_tarea = get_parameter(".itarea_" + id_tarea);
            let url = "../q/index.php/api/tarea/descripcion/format/json/";
            let data_send = {"id_tarea": id_tarea, "descripcion": text_tarea};
            request_enid("PUT", data_send, url, () => {
                ticket();
            });

        }

    });
};
let elimina_tarea = id_tarea => {

    show_confirm("¿DESEAS ELIMINAR LA TAREA?", "Se borrará completamente", "ELIMINAR", () => {

        let url = "../q/index.php/api/tarea/index/format/json/";
        let data_send = {"id_tarea": id_tarea};
        request_enid("DELETE", data_send, url, () => {

            ticket();

        });

    });

};
let marcar_como_hecho = function (e) {

    let id = get_parameter_enid($(this), "id");
    if (id > 0) {
        set_estatus_ticket(id, 4);
    }
};
let set_asunto = function () {
    let id = get_parameter_enid($(this), "id");
    if (id > 0) {

        showonehideone(".i_desc_asunto", ".s_desc_asunto");
        $(input_asunto).keyup(function (e) {

            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                let asunto = get_parameter(input_asunto);
                if (asunto.length > 3) {

                    rm_class(input_asunto);
                    let url = "../q/index.php/api/tickets/asunto/format/json/";
                    let data_send = {"id_ticket": id, "asunto": asunto};
                    request_enid("PUT", data_send, url, () => {
                        ticket();
                    });

                } else {

                    focus_input(input_asunto);
                }
            }
        });
    }
};
let agendar_google = () => $(".seccion_agendar").removeClass("hidden");
let google_path = function (e) {
    e.preventDefault();
    let base = "https://calendar.google.com/calendar/r/eventedit";
    let desc_google = get_parameter(".descripcion_google");
    let hora_fecha = get_parameter(".hora_fecha");
    if (desc_google.length > 5) {
        base += "?text=Enid Service " + desc_google;
    }
    if (hora_fecha.length > 5) {
        let format_google = "";
        let eliminar = ['-', ':'];
        for (let x in hora_fecha) {

            if (eliminar.includes(hora_fecha[x]) == false) {
                if (hora_fecha[x] != ' ') {

                    format_google += hora_fecha[x];

                } else {

                    format_google += "T";
                }

            }

        }

        base += "&dates=" + format_google + "/" + format_google;
    }
    window.open(base, '_blank');
};
let registra_nota_monetaria = function (e) {

    e.preventDefault();
    let url = "../q/index.php/api/tickets/nota_monetaria/format/json/";
    let data_send = $(this).serialize() + "&" + $.param({"id_ticket": get_option("id_ticket")});
    set_option("s", 1);
    request_enid("PUT", data_send, url, ticket);

};
let registra_efecto_monetario = function (e) {

    let efecto_monetario = e.target.id;
    if (efecto_monetario > 0) {
        let url = "../q/index.php/api/tickets/efecto_monetario/format/json/";
        let data_send = $.param({
            "id_ticket": get_option("id_ticket"),
            "efecto_monetario": efecto_monetario
        });
        set_option("s", 1);
        request_enid("PUT", data_send, url, ticket);
    }
};
let efectivo_resultante = function (e) {

    if ($(input_efectivo).val() > 0) {
        let url = "../q/index.php/api/tickets/efectivo_resultante/format/json/";
        let data_send = $(frm_efectivo_resultante).serialize();
        request_enid("PUT", data_send, url, ticket);
    }
    e.preventDefault();
};
let clientes_ab = function (e) {

    if ($(input_clientes_ab).val() > 0) {
        let url = "../q/index.php/api/tickets/clientes_ab/format/json/";
        let data_send = $(frm_clientes_ab_testing).serialize();
        request_enid("PUT", data_send, url, ticket);
    }
    e.preventDefault();
};
