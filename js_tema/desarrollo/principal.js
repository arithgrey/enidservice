"use strict";
window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.onpopstate = function (event) {

    if (event) {
        valida_retorno();
    }
}
$(document).ready(() => {


    set_option("s", 0);
    let num_departamento = get_parameter(".num_departamento");
    set_option("modulo", 2);


    $("footer").ready(() => {

        let id_depto = get_parameter(".num_departamento");
        set_option("id_depto", id_depto);
        num_pendientes();
    });


    $(".depto").change(() => {

        let id_depto = get_parameter(".depto");
        set_option("id_depto", id_depto);
        tikets_usuario();
    });

    $(".q").keyup(tikets_usuario);


    $(".form_busqueda_actividad_enid").submit(productividad);

    set_option("id_usuario", get_parameter(".id_usuario"));

    $(".li_menu").click(recorre_web_version_movil);
    $(".base_tab_clientes").click(tikets_usuario);
    $(".form_busqueda_desarrollo").submit(metricas_desarrollo);
    $(".form_busqueda_desarrollo_solicitudes").submit(solicitudes_cliente);

    if (num_departamento == 4) {

        $(".contenedor_deptos").show();
        set_option("id_depto", num_departamento);
        selecciona_select(".depto", 4);
    }

    $(".comparativa").click(carga_comparativas);
    $(".abrir_ticket").click(form_n_ticket);

    on_load();

});

let productividad = e => {

    let url = "../q/index.php/api/productividad/usuario/format/json/";
    request_enid("GET", data_send, url, 1, ".place_productividad", 0, ".place_productividad");
    e.preventDefault();

}

let recorre_web_version_movil = () => recorre(".tab-content");

let metricas_desarrollo = (e) => {


    if (get_parameter(".form_busqueda_desarrollo #datetimepicker4").length > 5 && get_parameter(".form_busqueda_desarrollo #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/desarrollo/global/format/json/";
        let data_send = $(".form_busqueda_desarrollo").serialize();
        bloquea_form(".form_busqueda_desarrollo");
        request_enid("GET", data_send, url, response_carga_metricas, ".place_metricas_desarrollo");

    } else {

        let inputs = [".form_busqueda_desarrollo #datetimepicker4", ".form_busqueda_desarrollo #datetimepicker5"];
        focus_input(inputs);
    }
    e.preventDefault();
}
let response_carga_metricas = (data) => {

    render_enid(".place_metricas_desarrollo", data);
    $('th').click(ordena_tabla);
}
let carga_comparativas = () => {

    let url = "../q/index.php/api/desarrollo/comparativas/format/json/";
    let data_send = {tiempo: 1};

    request_enid("GET", data_send, url, () => {
        render_enid(".place_metricas_comparativa", data);
        $('th').click(ordena_tabla);

    }, ".place_metricas_comparativa");
}
let solicitudes_cliente = e => {


    if (get_parameter(".form_busqueda_desarrollo_solicitudes #datetimepicker4").length > 5 && get_parameter(".form_busqueda_desarrollo_solicitudes #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/desarrollo/global_calidad/format/json/";
        let data_send = $(".form_busqueda_desarrollo_solicitudes").serialize();
        request_enid("GET", data_send, url, response_carga_solicitudes, ".place_metricas_servicio");
    } else {

        let inputs = [".form_busqueda_desarrollo_solicitudes #datetimepicker4", ".form_busqueda_desarrollo_solicitudes #datetimepicker5"];
        focus_input(inputs);

    }
    e.preventDefault();
}
let response_carga_solicitudes = data => {

    render_enid(".place_metricas_servicio", data);
    $('th').click(ordena_tabla);
}

let num_pendientes = () => {

    let url = "../q/index.php/api/desarrollo/num_tareas_pendientes/format/json/";
    let data_send = {"id_usuario": get_option("id_usuario"), "id_departamento": get_option("id_depto")};
    request_enid("GET", data_send, url, 1, ".place_tareas_pendientes", ".place_tareas_pendientes");
}

let form_n_ticket = () => {

    let url = "../q/index.php/api/tickets/form/format/json/";
    request_enid("GET", {}, url, r_form_ticket, ".place_form_tickets");
}

let r_form_ticket = data => {

    render_enid(".place_form_tickets", data);
    $(".form_ticket").submit(registra_ticket);
}

let registra_ticket = e => {

    let url = "../q/index.php/api/tickets/index/format/json/";
    let data_send = $(".form_ticket").serialize();
    request_enid("POST", data_send, url, response_registro_ticket, ".place_registro_ticket");
    e.preventDefault();

}
let response_registro_ticket = data => {
    render_enid(".place_registro_ticket", "A la brevedad se realizará su solicitud!");
    set_option("id_ticket", data);
    $("#ver_avances").tab("show");
    $("#base_tab_clientes").tab("show");
    carga_info_detalle_ticket();
}

let set_estatus_ticket = function (id_ticket, status) {

    let nuevo_estado = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/tickets/estado/format/json/";
    let data_send = {"id_ticket": id_ticket, "status": status};
    request_enid("PUT", data_send, url, () => {
        tikets_usuario();
    });
}
let carga_info_detalle_ticket = () => {

    set_option("s", 1);
    let url = "../q/index.php/api/tickets/detalle/format/json/";
    let data_send = {"id_ticket": get_option("id_ticket")};
    request_enid("GET", data_send, url, response_carga_ticket);
}

let response_carga_ticket = (data) => {


    render_enid(".place_proyectos", data);
    despliega([".seccion_nueva_tarea"], 0);
    $(".mostrar_tareas_pendientes").hide();
    $(".btn_agregar_tarea").click(agregar_tarea);


    $(".agregar_respuesta").click(carga_formulario_respuesta_ticket);
    $(".comentarios_tarea").click(carga_comentarios_tareas);
    $(".form_agregar_tarea").submit(registra_tarea);
    $(".tarea").click(actualiza_tareas);
    $(".mostrar_tareas_pendientes").click(muestra_tareas_por_estatus);
    $(".mostrar_todas_las_tareas").click(muestra_todas_las_tareas);
    $(".ver_tickets").click(tikets_usuario);
    if (get_option("flag_mostrar_solo_pendientes") == 1) {
        muestra_tareas_por_estatus();
    }

}
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
}

let carga_comentarios_tareas = function (e) {


    showonehideone(".ocultar_comentarios", ".comentarios_tarea");
    let tarea = get_parameter_enid($(this), "id");
    set_option("tarea", tarea);
    let url = "../q/index.php/api/respuesta/respuestas/format/json/";
    let data_send = {"tarea": tarea};
    let seccion = ".seccion_respuesta_" + get_option("tarea");
    set_option("seccion", seccion);
    request_enid("GET", data_send, url, response_carga_comentario_tareas);


}

let carga_comentarios_terea_simple = () => {

    let tarea = get_option("tarea");
    let url = "../q/index.php/api/respuesta/respuestas/format/json/";
    let data_send = {"tarea": tarea};
    let seccion = ".seccion_respuesta_" + tarea;
    set_option("seccion", seccion);
    request_enid("GET", data_send, url, response_carga_comentario_tareas);

}

let response_carga_comentario_tareas = function (data) {

    let seccion = get_option("seccion");
    render_enid(seccion, data);
    $(".ocultar_comentarios").click(function (e) {
        set_option("tarea", get_parameter_enid($(this), "id"));
        $(seccion).empty();
    });

}

let registra_tarea = e => {

    let requerimiento = $(".form_agregar_tarea .note-editable").html();
    let url = "../q/index.php/api/tarea/index/format/json/";
    let data_send = $(".form_agregar_tarea").serialize() + "&" + $.param({
        "id_ticket": get_option("id_ticket"),
        "tarea": requerimiento
    });
    request_enid("POST", data_send, url, carga_info_detalle_ticket, ".place_proyectos");
    e.preventDefault();

}
let muestra_tareas_por_estatus = () => {

    showonehideone(".mostrar_todas_las_tareas", ".tarea_pendiente");
    $(".mostrar_tareas_pendientes").hide();
    set_option("flag_mostrar_solo_pendientes", 1);
}

let muestra_todas_las_tareas = () => {

    showonehideone(".tarea_pendiente", ".mostrar_todas_las_tareas");
    $(".mostrar_tareas_pendientes").show();
    set_option("flag_mostrar_solo_pendientes", 0);
}
let tikets_usuario = () => {

    let status_ticket = 0;
    if (document.querySelector(".estatus_tickets")) {
        status_ticket = get_parameter(".estatus_tickets");
    }
    let keyword = get_parameter(".q");
    set_option("keyword", keyword);
    let url = "../q/index.php/api/tickets/ticket_desarrollo/format/json/";
    let data_send = {
        "status": status_ticket,
        "id_departamento": get_option("id_depto"),
        "keyword": get_option("keyword"),
        "modulo": 3
    };
    request_enid("GET", data_send, url, response_carga_tickets);


}
let response_carga_tickets = function (data) {

    render_enid(".place_proyectos", data);

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
        carga_info_detalle_ticket();

    });

    $(".btn_refresh").click(tikets_usuario);
    $(".estatus_tickets").change(tikets_usuario);


}
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
}

let response_actualiza_tareas = data => {

    if (data === "cerrado") {

        tikets_usuario();

    } else {

        carga_info_detalle_ticket();

    }
}

let show_section_dinamic_button = seccion => ($(seccion).is(":visible")) ? $(seccion).hide() : $(seccion).show();

let agregar_tarea = () => {

    show_section_dinamic_button(".seccion_nueva_tarea");
    show_section_dinamic_button(".btn_agregar_tarea");
    recorre(".seccion_nueva_tarea");

    despliega([".listado_pendientes", ".mostrar_todas_las_tareas", ".table_resumen_ticket"], 0);
    $('.summernote').summernote({
        placeholder: 'Tarea pendiente',
        tabsize: 2,
        height: 100
    });

};
let cerrar_ticket = (id) => {

    id = parseInt(id)
    if (id > 0) {
        set_option("id_ticket", id);
        show_confirm("¿DESEAS CERRAR EL TICKET?", "Se descartarán todas sus tareas incluidas", "CERRAR TICKET", confirmacion_cerrar_ticket);
    }

}
let confirmacion_cerrar_ticket = () => {

    let id_ticket = get_option("id_ticket");
    let url = "../q/index.php/api/tickets/estado/format/json/";
    let data_send = {"status": 2, "id_ticket": id_ticket};
    request_enid("PUT", data_send, url, tikets_usuario);

}
let valida_retorno = () => {

    switch (parseInt(get_option("s"))) {

        case 1:

            tikets_usuario();
            break;

        case 2:

            break;

        default:

            break;
    }

}
let on_load = () => {


    let action = get_parameter(".ticket", 1);
    if (action > 0) {

        set_option("id_ticket", action);
        carga_info_detalle_ticket();
    }
}
let edita_descripcion_tarea = id_tarea => {

    showonehideone("#tarea_" + id_tarea, ".text_tarea_" + id_tarea);
    $("#tarea_" + id_tarea).keyup(function (e) {

        var code = (e.keyCode ? e.keyCode : e.which);

        if (code == 13) {

            let text_tarea = get_parameter(".itarea_" + id_tarea);
            let url = "../q/index.php/api/tarea/descripcion/format/json/";
            let data_send = {"id_tarea": id_tarea, "descripcion": text_tarea};
            request_enid("PUT", data_send, url, () => {
                carga_info_detalle_ticket();
            });

        }

    });
}
let elimina_tarea = id_tarea => {


    show_confirm("¿DESEAS ELIMINAR LA TAREA?", "Se borrará completamente", "ELIMINAR", () => {

        let url = "../q/index.php/api/tarea/index/format/json/";
        let data_send = {"id_tarea": id_tarea};
        request_enid("DELETE", data_send, url, () => {

            carga_info_detalle_ticket();

        });

    });

}
