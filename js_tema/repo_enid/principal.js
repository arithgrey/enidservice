"use strict";
let incidencia = 0;
$(document).ready(function () {
    set_option("page", 0);
    $("#nuevos_miembros").click(carga_nuevos_miembros);
    $(".mail_marketing").click(carga_metricas_mail_marketing);
    $(".form_busqueda_mail_enid").submit(carga_metricas_mail_marketing);
    $(".usabilidad_btn").click(function () {
        $(".f_usabilidad").submit();
    });
    $(".f_usabilidad").submit(carga_uso_sistema);

    $(".form_busqueda_global_enid").submit(indicadores);
    $("#form_metas").submit(registra_metas);
    $(".form_busqueda_desarrollo").submit(carga_metricas_desarrollo);
    $(".form_busqueda_desarrollo_solicitudes").submit(carga_solicitudes_cliente);
    $(".comparativa").click(carga_comparativas);
    $(".form_busqueda_afiliacion").submit(carga_repo_afiliacion);
    $(".form_busqueda_afiliacion_productividad").submit(carga_repo_afiliacion_productividad);
    $(".btn_repo_afiliacion").click(carga_productos_mas_solicitados);
    $(".form_busqueda_productos_solicitados").submit(carga_productos_mas_solicitados);
    $(".f_actividad_productos_usuarios").submit(carga_repo_usabilidad);
    $(".f_dipositivos").submit(carga_repo_dispositivos);
    $(".form_tipos_entregas").submit(carga_repo_tipos_entregas);


    $(".cotizaciones").click(function(){set_menu("#btn_menu_tab");} );
    $(".btn_repo_afiliacion").click(function () {set_menu("#btn_usuarios");});




});
/*Aquí se carga la data de las métricas del visitas(día)*/
let carga_uso_sistema = function(e) {

    let data_send = $(".f_usabilidad").serialize();
    let url = "../q/index.php/api/enid/usabilidad_landing_pages/format/json/";
    if (get_parameter(".f_usabilidad #datetimepicker4").length > 5 && get_parameter(".f_usabilidad #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, response_carga_uso_sistema, ".place_usabilidad_general");
    } else {
        focus_input(".f_usabilidad #datetimepicker4");
        focus_input(".f_usabilidad #datetimepicker5");
    }
    e.preventDefault();
}
let response_carga_uso_sistema = function(data) {

    render_enid(".place_usabilidad_general", data);
    $('th').click(ordena_table_general);

}
let response_comparativa_dia = function(data) {

    render_enid(".place_prospectos_comparativa", data);
    $(".info-dia-p").click(data_miembros_g);
    $(".info-d").click(data_eventos_g);
    console.log(data);
}
let data_miembros_g = function(e) {

    let periodo = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/enid/resumen_global_admin_p/format/json/";
    let data_send = {periodo: periodo};
    request_enid("GET", data_send, url, 1, ".info-resumen-prospecto", "", ".info-resumen-prospecto");

}
let carga_nuevos_miembros = function() {

    let url = "../q/index.php/api/enid/nuevos_miembros/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, 1, ".nuevos_miembros", "", ".nuevos_miembros");
}
let carga_metricas_mail_marketing = function(e) {

    let data_send = $(".form_busqueda_mail_enid").serialize();
    let url = "../q/index.php/api/mail/reporte_mail_marketing/format/json/";

    if (get_parameter(".form_busqueda_mail_enid #datetimepicker4").length > 5 && get_parameter(".form_busqueda_mail_enid #datetimepicker5").length > 5) {

        request_enid("GET", data_send, url, 1, ".place_mail_marketing", 0, ".place_mail_marketing");
    } else {
        focus_input(".form_busqueda_mail_enid #datetimepicker4");
        focus_input(".form_busqueda_mail_enid #datetimepicker5");
    }
    e.preventDefault();
}
let indicadores = function(e) {


    

    let data_send = $(".form_busqueda_global_enid").serialize() + "&" + $.param({"vista": "1"});
    let url = "../q/index.php/api/enid/metricas_cotizaciones/format/json/";

    let f_inicio = get_parameter(".form_busqueda_global_enid #datetimepicker4");
    let f_termino = get_parameter(".form_busqueda_global_enid #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {
        bloquea_form(".form_busqueda_global_enid");
        request_enid("GET", data_send, url, response_indicadores, ".place_usabilidad", 0, ".place_usabilidad");
    } else {
        focus_input(".form_busqueda_global_enid #datetimepicker4");
        focus_input(".form_busqueda_global_enid #datetimepicker5");
    }
    e.preventDefault();
}
let response_indicadores = function(data) {

    desbloqueda_form(".form_busqueda_global_enid");
    render_enid(".place_usabilidad", data);
    $(".usuarios").click(resumen_usuarios);
    $(".contactos").click(resumen_mensajes);
    $(".solicitudes").click(resumen_compras);
    $(".valoraciones").click(resumen_valoracion);
    $(".servicios").click(resumen_servicios);
    $(".productos_valorados_distintos").click(resumen_servicios_valorados);
    $(".lista_deseos").click(resume_lista_deseos);
}
let registra_metas = function(e) {

    let data_send = $("#form_metas").serialize();
    let url = "../q/index.php/api/objetivos/meta/format/json/";
    request_enid("POST", data_send, url, response_registro_metas, ".place_registro_metas");
    e.preventDefault();
}
let response_registro_metas = function(data) {

    show_response_ok_enid(".place_registro_metas", "Meta registrada!");
    $("#fijar_metas_equipo").modal("hide");

}
let carga_metricas_desarrollo = function(e) {

    let url = "../q/index.php/api/desarrollo/global/format/json/";
    let data_send = $(".form_busqueda_desarrollo").serialize();


    if (get_parameter(".form_busqueda_desarrollo #datetimepicker4").length > 5 && get_parameter(".form_busqueda_desarrollo #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, response_carga_metricas_desarrollo, ".place_metricas_desarrollo");
    } else {
        focus_input(".form_busqueda_desarrollo #datetimepicker5");
        focus_input(".form_busqueda_desarrollo #datetimepicker5");
    }


    e.preventDefault();
}
let response_carga_metricas_desarrollo = function(data) {

    render_enid(".place_metricas_desarrollo", data);
    $('th').click(ordena_table_general);
}
let carga_comparativas = function() {

    let url = "../q/index.php/api/desarrollo/comparativas/format/json/";
    let data_send = {tiempo: 1};
    request_enid("GET", data_send, url, response_carga_comparativa, ".place_metricas_comparativa", 0, ".place_metricas_comparativa");
    e.preventDefault();
}
let response_carga_comparativa = function(data) {
    render_enid(".place_metricas_comparativa", data);
    $('th').click(ordena_table_general);
}
let  carga_solicitudes_cliente = function(e) {

    let url = "../q/index.php/api/desarrollo/global_calidad/format/json/";
    let data_send = $(".form_busqueda_desarrollo_solicitudes").serialize();
    request_enid("GET", data_send, url, response_carga_solicitudes_cliente, ".place_metricas_servicio", 0, ".place_metricas_servicio");
    e.preventDefault();
}
let response_carga_solicitudes_cliente = function(data) {

    render_enid(".place_metricas_servicio", data);
    $('th').click(ordena_table_general);
}
let carga_repo_afiliacion = function(e) {

    let url = "../q/index.php/api/afiliacion/metricas/format/json/";
    let data_send = $(".form_busqueda_afiliacion").serialize();

    if (get_parameter(".form_busqueda_afiliacion #datetimepicker4").length > 5 && get_parameter(".form_busqueda_afiliacion #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_repo_afiliacion", 0, ".place_repo_afiliacion");
    } else {
        focus_input(".form_busqueda_afiliacion #datetimepicker4");
        focus_input(".form_busqueda_afiliacion #datetimepicker5");
    }
    e.preventDefault();
}
let carga_repo_afiliacion_productividad = function(e) {

    let url = "../q/index.php/api/afiliacion/afiliados_productividad/format/json/";
    let data_send = $(".form_busqueda_afiliacion_productividad").serialize();
    request_enid("GET", data_send, url, 1, ".place_repo_afiliacion_productividad", 0, ".place_repo_afiliacion_productividad");
    e.preventDefault();
}
let carga_productos_mas_solicitados = function(e) {


    let url = "../q/index.php/api/servicio/metricas_productos_solicitados/format/json/";
    let data_send = $(".form_busqueda_productos_solicitados").serialize();


    if (get_parameter(".form_busqueda_productos_solicitados #datetimepicker4").length > 5 && get_parameter(".form_busqueda_productos_solicitados #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");
    } else {
        focus_input(".form_busqueda_productos_solicitados #datetimepicker4");
        focus_input(".form_busqueda_productos_solicitados #datetimepicker5");
    }
    e.preventDefault();
}
let resumen_usuarios = function() {

    let fecha_inicio = get_attr(this, "fecha_inicio");
    let fecha_termino = get_attr(this, "fecha_termino");
    let url = "../q/index.php/api/usuario/usuarios/format/json/";
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino, "page": get_option("page")};
    request_enid("GET", data_send, url, response_resumen_usuarios, ".place_reporte");
}
let response_resumen_usuarios = function(data) {

    render_enid(".place_reporte", data);
    $(".pagination > li > a, .pagination > li > span").css("color", "white");
    $(".pagination > li > a, .pagination > li > span").click(function (e) {
        let page_html = $(this);
        let num_paginacion = $(page_html).attr("data-ci-pagination-page");
        if (validar_si_numero(num_paginacion) == true) {
            set_option("page", num_paginacion);
        } else {
            num_paginacion = $(this).text();
            set_option("page", num_paginacion);
        }
        resumen_usuarios();
        e.preventDefault();
    });
}
let resumen_mensajes = function() {

    let fecha_inicio = get_attr(this, "fecha_inicio");
    let fecha_termino = get_attr(this, "fecha_termino");
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    let url = "../q/index.php/api/cotizaciones/contactos/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
let resumen_compras = function() {

    let fecha_inicio = get_attr(this, "fecha_inicio");
    let fecha_termino = get_attr(this, "fecha_termino");
    let tipo = get_attr(this, "tipo_compra");
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino, "tipo": tipo, "v": 1};
    let url = "../q/index.php/api/recibo/compras/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}

let resumen_valoracion = function() {

    let fecha_inicio = get_attr(this, "fecha_inicio");
    let fecha_termino = get_attr(this, "fecha_termino");
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    let url = "../q/index.php/api/valoracion/resumen_valoraciones_periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
let resumen_servicios = function() {

    let fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    let fecha_termino = get_parameter_enid($(this), "fecha_termino");
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino, "v": 1};

    let url = "../q/index.php/api/servicio/periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
let resumen_servicios_valorados = function() {

    let fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    let fecha_termino = get_parameter_enid($(this), "fecha_termino");
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    let url = "../q/index.php/api/valoracion/resumen_valoraciones_periodo_servicios/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");

}
let resume_lista_deseos = function() {

    let fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    let fecha_termino = get_parameter_enid($(this), "fecha_termino");
    let data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    let url = "../q/index.php/api/servicio/lista_deseos_periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
let carga_repo_usabilidad = function(e) {

    let data_send = $(".f_actividad_productos_usuarios").serialize() + "&" + $.param({"v": 1});
    let url = "../q/index.php/api/usuario/actividad/format/json/";

    if (get_parameter(".f_actividad_productos_usuarios #datetimepicker4").length > 5 && get_parameter(".f_actividad_productos_usuarios #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, info_usabilidad, ".place_reporte");
    } else {
        focus_input(".f_actividad_productos_usuarios #datetimepicker4");
        focus_input(".f_actividad_productos_usuarios #datetimepicker5");
    }
    e.preventDefault();
}

let  carga_repo_dispositivos = function(e) {

    let data_send = $(".f_dipositivos").serialize() + "&" + $.param({"v": 1});
    let url = "../q/index.php/api/pagina_web/productividad/format/json/";

    if (get_parameter(".f_dipositivos #datetimepicker4").length > 5 && get_parameter(".f_dipositivos #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".repo_dispositivos", 0, ".repo_dispositivos");
    } else {
        focus_input(".f_dipositivos #datetimepicker4");
        focus_input(".f_dipositivos #datetimepicker5");
    }
    e.preventDefault();
}
let info_usabilidad = function(data) {
    render_enid(".repo_usabilidad", data);
    $(".servicios").click(resumen_servicios);
    $(".usuarios").click(resumen_usuarios);
}
let carga_repo_tipos_entregas = function (e) {

    let data_send = $(".form_tipos_entregas").serialize() + "&" + $.param({"v": 1});
    let url = "../q/index.php/api/servicio/tipos_entregas/format/json/";

    if (get_parameter(".form_tipos_entregas #datetimepicker4").length > 5 && get_parameter(".form_tipos_entregas #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_tipos_entregas", 0, ".place_tipos_entregas");
        $('th').click(ordena_table_general);
    } else {
        focus_input(".form_tipos_entregas #datetimepicker4");
        focus_input(".form_tipos_entregas #datetimepicker5");
    }
    e.preventDefault();
};
let  comparativa_dia = function() {

    let url = "../q/index.php/api/enid/prospectos_comparativa_d/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, response_comparativa_dia, ".place_prospectos_comparativa");
}
let set_menu = function (go) {

    $("#btn_repo_afiliacion").tab("show");
    $(go).tab("show");

}