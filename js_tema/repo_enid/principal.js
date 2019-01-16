"use strict";
var incidencia = 0;
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
    $('.datetimepicker4').datepicker();
    $('.datetimepicker5').datepicker();
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
var carga_uso_sistema = function(e) {

    var data_send = $(".f_usabilidad").serialize();
    var url = "../q/index.php/api/enid/usabilidad_landing_pages/format/json/";
    if (get_parameter(".f_usabilidad #datetimepicker4").length > 5 && get_parameter(".f_usabilidad #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, response_carga_uso_sistema, ".place_usabilidad_general");
    } else {
        focus_input(".f_usabilidad #datetimepicker4");
        focus_input(".f_usabilidad #datetimepicker5");
    }
    e.preventDefault();
}
var response_carga_uso_sistema = function(data) {

    llenaelementoHTML(".place_usabilidad_general", data);
    $('th').click(ordena_table_general);

}
var response_comparativa_dia = function(data) {

    llenaelementoHTML(".place_prospectos_comparativa", data);
    $(".info-dia-p").click(data_miembros_g);
    $(".info-d").click(data_eventos_g);
    console.log(data);
}
var data_miembros_g = function(e) {

    var periodo = get_parameter_enid($(this), "id");
    var url = "../q/index.php/api/enid/resumen_global_admin_p/format/json/";
    var data_send = {periodo: periodo};
    request_enid("GET", data_send, url, 1, ".info-resumen-prospecto", "", ".info-resumen-prospecto");

}
var carga_nuevos_miembros = function() {

    var url = "../q/index.php/api/enid/nuevos_miembros/format/json/";
    var data_send = {};
    request_enid("GET", data_send, url, 1, ".nuevos_miembros", "", ".nuevos_miembros");
}
var carga_metricas_mail_marketing = function(e) {

    var data_send = $(".form_busqueda_mail_enid").serialize();
    var url = "../q/index.php/api/mail/reporte_mail_marketing/format/json/";

    if (get_parameter(".form_busqueda_mail_enid #datetimepicker4").length > 5 && get_parameter(".form_busqueda_mail_enid #datetimepicker5").length > 5) {

        request_enid("GET", data_send, url, 1, ".place_mail_marketing", 0, ".place_mail_marketing");
    } else {
        focus_input(".form_busqueda_mail_enid #datetimepicker4");
        focus_input(".form_busqueda_mail_enid #datetimepicker5");
    }
    e.preventDefault();
}
var indicadores = function(e) {

    var data_send = $(".form_busqueda_global_enid").serialize() + "&" + $.param({"vista": "1"});
    var url = "../q/index.php/api/enid/metricas_cotizaciones/format/json/";

    var f_inicio = get_parameter(".form_busqueda_global_enid #datetimepicker4");
    var f_termino = get_parameter(".form_busqueda_global_enid #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {
        bloquea_form(".form_busqueda_global_enid");
        request_enid("GET", data_send, url, response_indicadores, ".place_usabilidad", 0, ".place_usabilidad");
    } else {
        focus_input(".form_busqueda_global_enid #datetimepicker4");
        focus_input(".form_busqueda_global_enid #datetimepicker5");
    }
    e.preventDefault();
}
var response_indicadores = function(data) {

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
var registra_metas = function(e) {

    var data_send = $("#form_metas").serialize();
    var url = "../q/index.php/api/objetivos/meta/format/json/";
    request_enid("POST", data_send, url, response_registro_metas, ".place_registro_metas");
    e.preventDefault();
}
var response_registro_metas = function(data) {

    show_response_ok_enid(".place_registro_metas", "Meta registrada!");
    $("#fijar_metas_equipo").modal("hide");

}
var carga_metricas_desarrollo = function(e) {

    var url = "../q/index.php/api/desarrollo/global/format/json/";
    var data_send = $(".form_busqueda_desarrollo").serialize();


    if (get_parameter(".form_busqueda_desarrollo #datetimepicker4").length > 5 && get_parameter(".form_busqueda_desarrollo #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, response_carga_metricas_desarrollo, ".place_metricas_desarrollo");
    } else {
        focus_input(".form_busqueda_desarrollo #datetimepicker5");
        focus_input(".form_busqueda_desarrollo #datetimepicker5");
    }


    e.preventDefault();
}
var response_carga_metricas_desarrollo = function(data) {

    llenaelementoHTML(".place_metricas_desarrollo", data);
    $('th').click(ordena_table_general);
}
var carga_comparativas = function() {

    var url = "../q/index.php/api/desarrollo/comparativas/format/json/";
    var data_send = {tiempo: 1};
    request_enid("GET", data_send, url, response_carga_comparativa, ".place_metricas_comparativa", 0, ".place_metricas_comparativa");
    e.preventDefault();
}
var response_carga_comparativa = function(data) {
    llenaelementoHTML(".place_metricas_comparativa", data);
    $('th').click(ordena_table_general);
}
var  carga_solicitudes_cliente = function(e) {

    var url = "../q/index.php/api/desarrollo/global_calidad/format/json/";
    var data_send = $(".form_busqueda_desarrollo_solicitudes").serialize();
    request_enid("GET", data_send, url, response_carga_solicitudes_cliente, ".place_metricas_servicio", 0, ".place_metricas_servicio");
    e.preventDefault();
}
var response_carga_solicitudes_cliente = function(data) {

    llenaelementoHTML(".place_metricas_servicio", data);
    $('th').click(ordena_table_general);
}
var carga_repo_afiliacion = function(e) {

    var url = "../q/index.php/api/afiliacion/metricas/format/json/";
    var data_send = $(".form_busqueda_afiliacion").serialize();

    if (get_parameter(".form_busqueda_afiliacion #datetimepicker4").length > 5 && get_parameter(".form_busqueda_afiliacion #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_repo_afiliacion", 0, ".place_repo_afiliacion");
    } else {
        focus_input(".form_busqueda_afiliacion #datetimepicker4");
        focus_input(".form_busqueda_afiliacion #datetimepicker5");
    }
    e.preventDefault();
}
var carga_repo_afiliacion_productividad = function(e) {

    var url = "../q/index.php/api/afiliacion/afiliados_productividad/format/json/";
    var data_send = $(".form_busqueda_afiliacion_productividad").serialize();
    request_enid("GET", data_send, url, 1, ".place_repo_afiliacion_productividad", 0, ".place_repo_afiliacion_productividad");
    e.preventDefault();
}
var carga_productos_mas_solicitados = function(e) {


    var url = "../q/index.php/api/servicio/metricas_productos_solicitados/format/json/";
    var data_send = $(".form_busqueda_productos_solicitados").serialize();


    if (get_parameter(".form_busqueda_productos_solicitados #datetimepicker4").length > 5 && get_parameter(".form_busqueda_productos_solicitados #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");
    } else {
        focus_input(".form_busqueda_productos_solicitados #datetimepicker4");
        focus_input(".form_busqueda_productos_solicitados #datetimepicker5");
    }
    e.preventDefault();
}
var resumen_usuarios = function() {

    var fecha_inicio = get_attr(this, "fecha_inicio");
    var fecha_termino = get_attr(this, "fecha_termino");
    var url = "../q/index.php/api/usuario/usuarios/format/json/";
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino, "page": get_option("page")};
    request_enid("GET", data_send, url, response_resumen_usuarios, ".place_reporte");
}
var response_resumen_usuarios = function(data) {

    llenaelementoHTML(".place_reporte", data);
    $(".pagination > li > a, .pagination > li > span").css("color", "white");
    $(".pagination > li > a, .pagination > li > span").click(function (e) {
        var page_html = $(this);
        var num_paginacion = $(page_html).attr("data-ci-pagination-page");
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
var resumen_mensajes = function() {

    var fecha_inicio = get_attr(this, "fecha_inicio");
    var fecha_termino = get_attr(this, "fecha_termino");
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    var url = "../q/index.php/api/cotizaciones/contactos/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
var resumen_compras = function() {

    var fecha_inicio = get_attr(this, "fecha_inicio");
    var fecha_termino = get_attr(this, "fecha_termino");
    var tipo = get_attr(this, "tipo_compra");
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino, "tipo": tipo, "v": 1};
    var url = "../q/index.php/api/recibo/compras/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}

var resumen_valoracion = function() {

    var fecha_inicio = get_attr(this, "fecha_inicio");
    var fecha_termino = get_attr(this, "fecha_termino");
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    var url = "../q/index.php/api/valoracion/resumen_valoraciones_periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
var resumen_servicios = function() {

    var fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    var fecha_termino = get_parameter_enid($(this), "fecha_termino");
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino, "v": 1};

    var url = "../q/index.php/api/servicio/periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
var resumen_servicios_valorados = function() {

    var fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    var fecha_termino = get_parameter_enid($(this), "fecha_termino");
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    var url = "../q/index.php/api/valoracion/resumen_valoraciones_periodo_servicios/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");

}
var resume_lista_deseos = function() {

    var fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    var fecha_termino = get_parameter_enid($(this), "fecha_termino");
    var data_send = {"fecha_inicio": fecha_inicio, "fecha_termino": fecha_termino};
    var url = "../q/index.php/api/servicio/lista_deseos_periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
}
var carga_repo_usabilidad = function(e) {

    var data_send = $(".f_actividad_productos_usuarios").serialize() + "&" + $.param({"v": 1});
    var url = "../q/index.php/api/usuario/actividad/format/json/";

    if (get_parameter(".f_actividad_productos_usuarios #datetimepicker4").length > 5 && get_parameter(".f_actividad_productos_usuarios #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, info_usabilidad, ".place_reporte");
    } else {
        focus_input(".f_actividad_productos_usuarios #datetimepicker4");
        focus_input(".f_actividad_productos_usuarios #datetimepicker5");
    }
    e.preventDefault();
}

var  carga_repo_dispositivos = function(e) {

    var data_send = $(".f_dipositivos").serialize() + "&" + $.param({"v": 1});
    var url = "../q/index.php/api/pagina_web/productividad/format/json/";

    if (get_parameter(".f_dipositivos #datetimepicker4").length > 5 && get_parameter(".f_dipositivos #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".repo_dispositivos", 0, ".repo_dispositivos");
    } else {
        focus_input(".f_dipositivos #datetimepicker4");
        focus_input(".f_dipositivos #datetimepicker5");
    }
    e.preventDefault();
}
var info_usabilidad = function(data) {
    llenaelementoHTML(".repo_usabilidad", data);
    $(".servicios").click(resumen_servicios);
    $(".usuarios").click(resumen_usuarios);
}
var carga_repo_tipos_entregas = function (e) {

    var data_send = $(".form_tipos_entregas").serialize() + "&" + $.param({"v": 1});
    var url = "../q/index.php/api/servicio/tipos_entregas/format/json/";

    if (get_parameter(".form_tipos_entregas #datetimepicker4").length > 5 && get_parameter(".form_tipos_entregas #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_tipos_entregas", 0, ".place_tipos_entregas");
        $('th').click(ordena_table_general);
    } else {
        focus_input(".form_tipos_entregas #datetimepicker4");
        focus_input(".form_tipos_entregas #datetimepicker5");
    }
    e.preventDefault();
};
var  comparativa_dia = function() {

    var url = "../q/index.php/api/enid/prospectos_comparativa_d/format/json/";
    var data_send = {};
    request_enid("GET", data_send, url, response_comparativa_dia, ".place_prospectos_comparativa");
}


/*
function carga_info_cotizaciones(e) {
    var num_cotizaciones = get_parameter_enid($(this), "num_cotizaciones");
    if (num_cotizaciones > 0) {
        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/cotizaciones/cotizaciones_sitios_web/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}

function carga_info_descarga_paginas_web(e) {

    var num_contactos = get_parameter_enid($(this), "num_contactos");
    if (num_contactos > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/cotizaciones/sitios_web/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");

    }

}

var carga_info_descarga_crm = function(e) {

    var num_contactos = get_attr(this, "num_contactos");
    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/cotizaciones/crm/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
var carga_info_registros = function(e) {

    var num_contactos = get_attr(this, "num_contactos");
    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/base/registros/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
var carga_info_enviados = function(e) {

    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/base/enviados/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
var  carga_info_blogs = function(e) {

    var num_blogs = get_attr(this, "num_blogs");
    if (num_blogs > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/blog/fecha/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }

}

var cargar_info_clientes_prospecto = function(e) {

    var valor = get_attr(this, "num_proyectos");

    if (valor > 0) {

        var fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        var data_send = {fecha: get_fecha(), "tipo": 1};
        var url = "../q/index.php/api/productividad/num_clientes/format/json/";
        request_enid("GET", data_send, url, response_carga_info_cliente_prospecto, ".place_mas_info");
    }
}
var response_carga_info_cliente_prospecto = function(data) {

    $("#mas_info").modal("show");
    llenaelementoHTML(".place_mas_info", data);
}
var response_cargar_contactos_promociones = function(data){

    $("#mas_info").modal("show");
    llenaelementoHTML(".place_mas_info", data);
}
var cargar_contactos_promociones = function(e) {

    var valor = get_attr(this, "num_contactos");
    if (valor > 0) {

        var fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        var data_send = {fecha: get_fecha(), "tipo": 15};
        var url = "../q/index.php/api/productividad/contactos_lead/format/json/";
        request_enid("GET", data_send, url, response_cargar_contactos_promociones, ".place_mas_info");
    }
}
function cargar_info_sistema(e) {

    var valor = get_attr(this, "num_proyectos");
    if (valor > 0) {

        var fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        var data_send = {fecha: get_fecha(), "tipo": 1};

        var url = "../q/index.php/api/productividad/num_clientes_sistema/format/json/";
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
var response_info_afiliados = function(data) {
    $("#mas_info").modal("show");
    llenaelementoHTML(".place_mas_info", data);
}

var cargar_info_afiliados = function(e) {

    var valor = get_attr(this, "num_afiliados");
    if (valor > 0) {
        var fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        var data_send = {fecha: get_fecha(), "tipo": 1};
        var url = "../q/index.php/api/productividad/num_afiliados/format/json/";
        request_enid("GET", data_send, url, response_info_afiliados, ".place_mas_info", 0, ".place_mas_info");
    }
}

function evaluar(e) {

    incidencia = get_parameter_enid($(this), "id");
    set_option("inicidencia", incidencia);
}

function data_eventos_g(e){
	var periodo 	=  get_parameter_enid($(this) , "id");
	var url 		=  "../q/index.php/api/enid/resumen_global_admin_e/format/json/";
	var data_send 	= {periodo :  periodo};
	request_enid( "GET",  data_send, url, 1, ".info-resumen-prospecto" , "" , ".info-resumen-prospecto" );
}
function carga_info_descarga_adwords(e) {

    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/cotizaciones/adwords/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}
function carga_miembros_empresa(e) {

    $(".place_miembros").empty();
    var empresa = get_parameter_enid($(this), "id");
    var url = "../q/index.php/api/enid/miembros_cuenta/format/json/";
    var data_send = {"id_empresa": empresa};

    request_enid("GET", data_send, url,
        function () {
            llenaelementoHTML(".place_miembros", data);
        }, ".place_miembros");
}
function carga_info_descarga_tienda_linea(e) {

    if (get_parameter_enid($(this), "num_contactos") > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/cotizaciones/tienda_en_linea/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }

}

function cargar_info_clientes(e) {

    var valor = get_attr(this, "num_proyectos");
    if (valor > 0) {

        var fecha = get_parameter_enid($(this), "id");
        set_option("fecha", fecha);
        var data_send = {fecha: get_fecha(), "tipo": 2};

        var url = "../q/index.php/api/productividad/num_clientes/format/json/";
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

    var num_proyectos = get_attr(this, "num_proyectos");
    if (num_proyectos > 0) {

        $("#mas_info").modal("show");
        var fecha = get_parameter_enid($(this), "id");
        var data_send = {"fecha": fecha};
        var url = "../q/index.php/api/portafolio/info_proyectos_fecha/format/json/";
        request_enid("GET", data_send, url, 1, ".place_mas_info", 0, ".place_mas_info");
    }
}


*/