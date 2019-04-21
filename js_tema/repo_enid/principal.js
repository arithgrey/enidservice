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

    llenaelementoHTML(".place_usabilidad_general", data);
    $('th').click(ordena_table_general);

}
let response_comparativa_dia = function(data) {

    llenaelementoHTML(".place_prospectos_comparativa", data);
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
    llenaelementoHTML(".place_usabilidad", data);
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

    llenaelementoHTML(".place_metricas_desarrollo", data);
    $('th').click(ordena_table_general);
}
let carga_comparativas = function() {

    let url = "../q/index.php/api/desarrollo/comparativas/format/json/";
    let data_send = {tiempo: 1};
    request_enid("GET", data_send, url, response_carga_comparativa, ".place_metricas_comparativa", 0, ".place_metricas_comparativa");
    e.preventDefault();
}
let response_carga_comparativa = function(data) {
    llenaelementoHTML(".place_metricas_comparativa", data);
    $('th').click(ordena_table_general);
}
let  carga_solicitudes_cliente = function(e) {

    let url = "../q/index.php/api/desarrollo/global_calidad/format/json/";
    let data_send = $(".form_busqueda_desarrollo_solicitudes").serialize();
    request_enid("GET", data_send, url, response_carga_solicitudes_cliente, ".place_metricas_servicio", 0, ".place_metricas_servicio");
    e.preventDefault();
}
let response_carga_solicitudes_cliente = function(data) {

    llenaelementoHTML(".place_metricas_servicio", data);
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

    llenaelementoHTML(".place_reporte", data);
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
    llenaelementoHTML(".repo_usabilidad", data);
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


/*
function carga_info_cotizaciones(e) {
    let num_cotizaciones = get_parameter_enid($(this), "num_cotizaciones");
    if (num_cotizaciones > 0) {
        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/cotizaciones/cotizaciones_sitios_web/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}

function carga_info_descarga_paginas_web(e) {

    let num_contactos = get_parameter_enid($(this), "num_contactos");
    if (num_contactos > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/cotizaciones/sitios_web/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");

    }

}

let carga_info_descarga_crm = function(e) {

    let num_contactos = get_attr(this, "num_contactos");
    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/cotizaciones/crm/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
let carga_info_registros = function(e) {

    let num_contactos = get_attr(this, "num_contactos");
    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/base/registros/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
let carga_info_enviados = function(e) {

    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/base/enviados/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
let  carga_info_blogs = function(e) {

    let num_blogs = get_attr(this, "num_blogs");
    if (num_blogs > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/blog/fecha/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }

}

let cargar_info_clientes_prospecto = function(e) {

    let valor = get_attr(this, "num_proyectos");

    if (valor > 0) {

        let fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        let data_send = {fecha: get_fecha(), "tipo": 1};
        let url = "../q/index.php/api/productividad/num_clientes/format/json/";
        request_enid("GET", data_send, url, response_carga_info_cliente_prospecto, ".place_mas_info");
    }
}
let response_carga_info_cliente_prospecto = function(data) {

    $("#mas_info").modal("show");
    llenaelementoHTML(".place_mas_info", data);
}
let response_cargar_contactos_promociones = function(data){

    $("#mas_info").modal("show");
    llenaelementoHTML(".place_mas_info", data);
}
let cargar_contactos_promociones = function(e) {

    let valor = get_attr(this, "num_contactos");
    if (valor > 0) {

        let fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        let data_send = {fecha: get_fecha(), "tipo": 15};
        let url = "../q/index.php/api/productividad/contactos_lead/format/json/";
        request_enid("GET", data_send, url, response_cargar_contactos_promociones, ".place_mas_info");
    }
}
function cargar_info_sistema(e) {

    let valor = get_attr(this, "num_proyectos");
    if (valor > 0) {

        let fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        let data_send = {fecha: get_fecha(), "tipo": 1};

        let url = "../q/index.php/api/productividad/num_clientes_sistema/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send,
            beforeSend: function () {
                show_load_enid(".place_mas_info", "Cargando...");
            }
        }).done(function (data) {

            $("#mas_info").modal("show");
            llenaelementoHTML(".place_mas_info", data);

        }).fail(function () {
            show_error_enid(".place_mas_info", "Error al actualizar incidencia");
        });

    }
}
let response_info_afiliados = function(data) {
    $("#mas_info").modal("show");
    llenaelementoHTML(".place_mas_info", data);
}

let cargar_info_afiliados = function(e) {

    let valor = get_attr(this, "num_afiliados");
    if (valor > 0) {
        let fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        let data_send = {fecha: get_fecha(), "tipo": 1};
        let url = "../q/index.php/api/productividad/num_afiliados/format/json/";
        request_enid("GET", data_send, url, response_info_afiliados, ".place_mas_info", 0, ".place_mas_info");
    }
}

function evaluar(e) {

    incidencia = get_parameter_enid($(this), "id");
    set_option("inicidencia", incidencia);
}

function data_eventos_g(e){
	let periodo 	=  get_parameter_enid($(this) , "id");
	let url 		=  "../q/index.php/api/enid/resumen_global_admin_e/format/json/";
	let data_send 	= {periodo :  periodo};
	request_enid( "GET",  data_send, url, 1, ".info-resumen-prospecto" , "" , ".info-resumen-prospecto" );
}
function carga_info_descarga_adwords(e) {

    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/cotizaciones/adwords/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
function carga_miembros_empresa(e) {

    $(".place_miembros").empty();
    let empresa = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/enid/miembros_cuenta/format/json/";
    let data_send = {"id_empresa": empresa};

    request_enid("GET", data_send, url,
        function () {
            llenaelementoHTML(".place_miembros", data);
        }, ".place_miembros");
}
function carga_info_descarga_tienda_linea(e) {

    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/cotizaciones/tienda_en_linea/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }

}

function cargar_info_clientes(e) {

    let valor = get_attr(this, "num_proyectos");
    if (valor > 0) {

        let fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        let data_send = {fecha: get_fecha(), "tipo": 2};

        let url = "../q/index.php/api/productividad/num_clientes/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send,
            beforeSend: function () {
                show_load_enid(".place_mas_info", "Cargando...");
            }
        }).done(function (data) {

            $("#mas_info").modal("show");
            llenaelementoHTML(".place_mas_info", data);

        }).fail(function () {
            show_error_enid(".place_mas_info", "Error al actualizar incidencia");
        });

    }
}
function carga_info_proyectos(e) {

    let num_proyectos = get_attr(this, "num_proyectos");
    if (num_proyectos > 0) {

        $("#mas_info").modal("show");
        let fecha = get_parameter_enid($(this), "id");
        let data_send = {"fecha": fecha};
        let url = "../q/index.php/api/portafolio/info_proyectos_fecha/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}


*/