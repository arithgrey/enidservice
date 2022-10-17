"use strict";
let incidencia = 0;
let $form_arquetipos = $('.form_arquetipos');
let $form_tipificaciones = $('.form_tipificaciones');
let $form_evaluaciones = $('.form_evaluaciones');
let $form_ventas_comisionistas = $('.form_ventas_comisionistas');
let $form_entregas = $('.form_entregas');
let $form_motivos_cancelaciones = $('.form_motivos_cancelaciones');
let $form_top_ventas = $('.form_top_ventas');
let $form_sin_ventas = $('.form_sin_ventas');
let $funnel_ventas = $('.funnel');



$(document).ready(() => {

    set_option("page", 0);    
    $("#nuevos_miembros").click(carga_nuevos_miembros);
    $(".mail_marketing").click(carga_metricas_mail_marketing);
    $(".form_busqueda_mail_enid").submit(carga_metricas_mail_marketing);

    $(".form_busqueda_global_enid").submit(indicadores);
    $(".form_busqueda_global_enid").submit();
    
    $("#form_metas").submit(registra_metas);
    $(".form_busqueda_desarrollo").submit(metricas_desarrollo);
    $(".form_busqueda_desarrollo_solicitudes").submit(solicitudes_cliente);
    $(".comparativa").click(carga_comparativas);
    $(".form_busqueda_afiliacion").submit(carga_repo_afiliacion);
    $(".form_busqueda_afiliacion_productividad").submit(carga_repo_afiliacion_productividad);
    $(".btn_repo_afiliacion").click(carga_productos_mas_solicitados);
    $(".btn_acceso_paginas").click(carga_accesos_pagina);
    $(".form_busqueda_accesos_pagina").submit(carga_accesos_pagina);
    $(".form_busqueda_accesos_pagina_productos").submit(carga_accesos_pagina_productos);
    $(".form_busqueda_accesos_dominio").submit(carga_accesos_pagina_dominio);
    $(".form_busqueda_accesos_franja_horaria").submit(carga_accesos_franja_horaria);
    $(".form_busqueda_accesos_time_line").submit(carga_accesos_time_line);
    $(".form_busqueda_accesos_time_line").submit();



    $(".form_busqueda_productos_solicitados").submit(carga_productos_mas_solicitados);
    $(".f_actividad_productos_usuarios").submit(carga_repo_usabilidad);

    $(".form_tipos_entregas").submit(carga_repo_tipos_entregas);

    $(".cotizaciones").click(() => {
        set_menu("#btn_menu_tab");
    });
    $(".btn_repo_afiliacion").click(() => {
        set_menu("#btn_usuarios");
    });
    $form_arquetipos.submit(arquetipos)
    $form_tipificaciones.submit(tipificaciones);
    $form_evaluaciones.submit(evaluaciones);
    $form_ventas_comisionistas.submit(ventas_comisionistas);
    $form_entregas.submit(ventas_entregadas);
    $form_motivos_cancelaciones.submit(motovos_cancelaciones_busqueda);
    $form_top_ventas.submit(top_ventas);
    $form_sin_ventas.submit(sin_ventas);

    $funnel_ventas.click(funnel);

    productos_buscados_dia();
    dominios_que_apuntan_a_enid();
    busqueda_funnel_ventas();
    carga_accesos_pagina();
    

});

let busqueda_funnel_ventas = function () {

    let data_send = $.param({"dashboard":1});
    let url = "../q/index.php/api/enid/funnel/format/json/";
    request_enid("GET", data_send, url, response_funnel_ventas);

};
let response_funnel_ventas = data => {

    render_enid(".funnel_ventas_hoy", data);

    $(".dashboard_funnel").click(function(){
        recorre("#flipkart-navbar");
    });

    $(".personas_registradas_carrito").click(personas_registradas_carrito);
    $(".externos_en_carrito").click(externos_en_carrito);

    $(".personas_registradas_contacto").click(personas_registradas_contacto);
    $(".personas_externas_contacto").click(personas_externas_contacto);


};

let dominios_que_apuntan_a_enid = function () {

    let url = "../q/index.php/api/acceso/dominio_dia/format/json/";
    let data_send = $(".form_busqueda_accesos_dominio").serialize();
    request_enid("GET", data_send, url, response_dominios_que_apuntan_a_enid);

};
let response_dominios_que_apuntan_a_enid = data => {

    render_enid(".dominios_que_apuntan_a_enid", data);

};
let productos_buscados_dia = function () {

    let url = "../q/index.php/api/servicio/metricas_productos_solicitados_dia/format/json/";
    let data_send = $(".form_busqueda_productos_solicitados").serialize();

    request_enid("GET", data_send, url, response_busqueda_productos);

};
let response_busqueda_productos = data => {

    render_enid(".busquedas_productos", data);

};

let carga_nuevos_miembros = function () {

    let url = "../q/index.php/api/enid/nuevos_miembros/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, 1, ".nuevos_miembros", "", ".nuevos_miembros");
};
let carga_metricas_mail_marketing = function (e) {


    if (get_parameter(".form_busqueda_mail_enid #datetimepicker4").length > 5 && get_parameter(".form_busqueda_mail_enid #datetimepicker5").length > 5) {

        let data_send = $(".form_busqueda_mail_enid").serialize();
        let url = "../q/index.php/api/mail/reporte_mail_marketing/format/json/";

        request_enid("GET", data_send, url, 1, ".place_mail_marketing", 0, ".place_mail_marketing");

    } else {

        focus_input([".form_busqueda_mail_enid #datetimepicker5", ".form_busqueda_mail_enid #datetimepicker4"]);
    }
    e.preventDefault();
};
let indicadores = function (e) {


    let f_inicio = get_parameter(".form_busqueda_global_enid #datetimepicker4");
    let f_termino = get_parameter(".form_busqueda_global_enid #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $(".form_busqueda_global_enid").serialize() + "&" + $.param({ "vista": "1" });
        let url = "../q/index.php/api/enid/metricas_cotizaciones/format/json/";

        bloquea_form(".form_busqueda_global_enid");
        request_enid("GET", data_send, url, response_indicadores);

    } else {

        focus_input([".form_busqueda_global_enid #datetimepicker5", ".form_busqueda_global_enid #datetimepicker4"]);
    }
    e.preventDefault();
};
let response_indicadores = function (data) {

    desbloqueda_form(".form_busqueda_global_enid");
    render_enid(".place_usabilidad", data);
    $(".usuarios").click(resumen_usuarios);
    $(".contactos").click(resumen_mensajes);
    $(".solicitudes").click(resumen_compras);
    $(".valoraciones").click(resumen_valoracion);
    $(".servicios").click(resumen_servicios);
    $(".productos_valorados_distintos").click(resumen_servicios_valorados);
    $(".lista_deseos").click(resume_lista_deseos);    
    $(".numero_compras_efectivas_place").text( $(".numero_compras_efectivas_input").val());
    $(".numero_transacciones_place").text( $(".numero_transacciones_input").val());
    $(".numero_cancelaciones_place").text( $(".numero_cancelaciones_input").val());
    
};
let registra_metas = function (e) {

    let data_send = $("#form_metas").serialize();
    let url = "../q/index.php/api/objetivos/meta/format/json/";
    request_enid("POST", data_send, url, response_registro_metas, ".place_registro_metas");
    e.preventDefault();
};
let response_registro_metas = function (data) {

    seccess_enid(".place_registro_metas", "Meta registrada!");
    $("#fijar_metas_equipo").modal("hide");

};
let metricas_desarrollo = function (e) {


    if (get_parameter(".form_busqueda_desarrollo #datetimepicker4").length > 5 && get_parameter(".form_busqueda_desarrollo #datetimepicker5").length > 5) {


        let url = "../q/index.php/api/desarrollo/global/format/json/";
        let data_send = $(".form_busqueda_desarrollo").serialize();
        request_enid("GET", data_send, url, response_metricas_desarrollo, ".place_metricas_desarrollo");

    } else {

        focus_input([".form_busqueda_desarrollo #datetimepicker5", ".form_busqueda_desarrollo #datetimepicker5"]);
    }


    e.preventDefault();
};
let response_metricas_desarrollo = function (data) {

    render_enid(".place_metricas_desarrollo", data);
    $('th').click(ordena_tabla);
};
let carga_comparativas = function () {

    let url = "../q/index.php/api/desarrollo/comparativas/format/json/";
    let data_send = { tiempo: 1 };
    request_enid("GET", data_send, url, response_carga_comparativa, ".place_metricas_comparativa", 0, ".place_metricas_comparativa");
    e.preventDefault();
};
let response_carga_comparativa = function (data) {
    render_enid(".place_metricas_comparativa", data);
    $('th').click(ordena_tabla);
};
let solicitudes_cliente = function (e) {

    let url = "../q/index.php/api/desarrollo/global_calidad/format/json/";
    let data_send = $(".form_busqueda_desarrollo_solicitudes").serialize();
    request_enid("GET", data_send, url, response_solicitudes_cliente, ".place_metricas_servicio", 0, ".place_metricas_servicio");
    e.preventDefault();
};
let response_solicitudes_cliente = function (data) {

    render_enid(".place_metricas_servicio", data);
    $('th').click(ordena_tabla);
};
let carga_repo_afiliacion = function (e) {

    let url = "../q/index.php/api/afiliacion/metricas/format/json/";
    let data_send = $(".form_busqueda_afiliacion").serialize();

    if (get_parameter(".form_busqueda_afiliacion #datetimepicker4").length > 5 && get_parameter(".form_busqueda_afiliacion #datetimepicker5").length > 5) {
        request_enid("GET", data_send, url, 1, ".place_repo_afiliacion", 0, ".place_repo_afiliacion");
    } else {
        focus_input([".form_busqueda_afiliacion #datetimepicker4", ".form_busqueda_afiliacion #datetimepicker5"]);

    }
    e.preventDefault();
};
let carga_repo_afiliacion_productividad = function (e) {

    let url = "../q/index.php/api/afiliacion/afiliados_productividad/format/json/";
    let data_send = $(".form_busqueda_afiliacion_productividad").serialize();
    request_enid("GET", data_send, url, 1, ".place_repo_afiliacion_productividad", 0, ".place_repo_afiliacion_productividad");
    e.preventDefault();
};
let carga_productos_mas_solicitados = function (e) {

    if (get_parameter(".form_busqueda_productos_solicitados #datetimepicker4").length > 5 && get_parameter(".form_busqueda_productos_solicitados #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/servicio/metricas_productos_solicitados/format/json/";
        let data_send = $(".form_busqueda_productos_solicitados").serialize();
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");
    } else {

        focus_input([".form_busqueda_productos_solicitados #datetimepicker4", ".form_busqueda_productos_solicitados #datetimepicker5"]);

    }
    e.preventDefault();
};
let carga_accesos_pagina = function (e) {


    if (get_parameter(".form_busqueda_accesos_pagina #datetimepicker4").length > 5 && get_parameter(".form_busqueda_accesos_pagina #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/acceso/busqueda_fecha/format/json/";
        let data_send = $(".form_busqueda_accesos_pagina").serialize();
        request_enid("GET", data_send, url, response_accesos_metricas);

    } else {

        focus_input([".form_busqueda_productos_solicitados #datetimepicker4", ".form_busqueda_productos_solicitados #datetimepicker5"]);

    }
    e.preventDefault();
}

let response_accesos_metricas = function (data) {

    render_enid(".place_keywords", data);    

    $(".vista_a_producto").text($(".detalle_accesos_input").val());
    $(".procesar_compra_input").text($(".procesar_compra_input").val());
    $(".promociones_input").text($(".promociones_input").val());

    /*6 lista de deseos*/
    
    $(".lista_deseos_place").text($(".lista_deseos_input").val());

    /*17 click_whatsapp_input*/
    $(".click_whatsapp_place").text($(".click_whatsapp_input").val());
    /*43 click_whatsapp_input*/
    $(".click_facebook_trigger_place").text($(".click_facebook_trigger_input").val());

    /**22 **/ 
    $(".click_producto_recompensa_place").text($(".click_producto_recompensa_input").val());
    /*24 */
    $(".click_en_ver_fotos_clientes_place").text($(".click_en_ver_fotos_clientes_input").val());    
    /*25*/
    $(".click_en_formas_pago_place").text($(".click_en_formas_pago_input").val());
    /*26  Agregar carrito promoción*/
    $(".click_en_agregar_carrito_promocion_place").text($(".click_en_agregar_carrito_promocion_input").val());
    /*27*/
    $(".click_en_agregar_carrito_place").text($(".click_en_agregar_carrito_input").val());
    
    /*45 ir a pinteres*/
    $(".click_pagina_pinterest_place").text($(".click_pinteres_input").val());
    /*44 abdomen*/
    $(".click_abdomen_place").text($(".click_abdomen_input").val());


    /*Ir a Facebook*/
    $(".click_pagina_facebook_place").text($(".click_facebook_input").val());
    /*Ir a instagram*/
    $(".click_pagina_instagram_place").text($(".click_instagram_input").val());

    /*46 solicitar catalogo*/
    $(".click_catalogo_afiliados_place").text($(".click_catalogo_afiliados_input").val());

    
}

let carga_accesos_pagina_productos = function (e) {


    if (get_parameter(".form_busqueda_accesos_pagina_productos #datetimepicker4").length > 5 && get_parameter(".form_busqueda_accesos_pagina_productos #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/acceso/busqueda_fecha_producto/format/json/";
        let data_send = $(".form_busqueda_accesos_pagina_productos").serialize();
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_busqueda_productos_solicitados #datetimepicker4", ".form_busqueda_productos_solicitados #datetimepicker5"]);

    }
    e.preventDefault();
}

let carga_accesos_pagina_dominio = function (e) {


    if (get_parameter(".form_busqueda_accesos_dominio #datetimepicker4").length > 5 && get_parameter(".form_busqueda_accesos_dominio #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/acceso/dominio/format/json/";
        let data_send = $(".form_busqueda_accesos_dominio").serialize();
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_busqueda_accesos_dominio #datetimepicker4", ".form_busqueda_accesos_dominio #datetimepicker5"]);

    }
    e.preventDefault();
}

let carga_accesos_franja_horaria = function (e) {


    if (get_parameter(".form_busqueda_accesos_franja_horaria #datetimepicker4").length > 5 && get_parameter(".form_busqueda_accesos_franja_horaria #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/acceso/franja_horaria/format/json/";
        let data_send = $(".form_busqueda_accesos_franja_horaria").serialize();
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_busqueda_accesos_franja_horaria #datetimepicker4", ".form_busqueda_accesos_franja_horaria #datetimepicker5"]);

    }
    e.preventDefault();

}
let carga_accesos_time_line = function (e) {


    if (get_parameter(".form_busqueda_accesos_time_line #datetimepicker4").length > 5 && get_parameter(".form_busqueda_accesos_time_line #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/acceso/timeline/format/json/";
        let data_send = $(".form_busqueda_accesos_time_line").serialize();
        request_enid("GET", data_send, url, response_acceso_time_line);

    } else {

        focus_input([".form_busqueda_accesos_time_line #datetimepicker4", ".form_busqueda_accesos_time_line #datetimepicker5"]);

    }
    e.preventDefault();

}
let response_acceso_time_line = function(data){
    
    render_enid(".place_keywords", data);
    $(".personas_trafico_place").text($(".personas_trafico").val());
    
    $(".personas_interacciones_positivas_place").text($(".personas_interacciones_positivas").val());
    $(".personas_interacciones_negativas_place").text($(".personas_interacciones_negativas").val());
    
    
    $(".personas_interacciones_positivas_telefono_place").text($(".personas_interacciones_positivas_telefono").val());
    $(".personas_interacciones_positivas_dektop_place").text($(".personas_interacciones_positivas_desktop").val());
    

    $(".personas_interacciones_negativas_telefono_place").text($(".personas_interacciones_negativas_telefono").val());
    $(".personas_interacciones_negativas_dektop_place").text($(".personas_interacciones_negativas_desktop").val());
    

    

}

let resumen_usuarios = function () {

    let url = "../q/index.php/api/usuario/usuarios/format/json/";
    let data_send = {
        "fecha_inicio": get_attr(this, "fecha_inicio"),
        "fecha_termino": get_attr(this, "fecha_termino"),
        "page": get_option("page")
    };
    request_enid("GET", data_send, url, response_resumen_usuarios, ".place_reporte");
};
let response_resumen_usuarios = function (data) {

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
};
let resumen_mensajes = function () {


    let data_send = {
        "fecha_inicio": get_attr(this, "fecha_inicio"),
        "fecha_termino": get_attr(this, "fecha_termino")
    };
    let url = "../q/index.php/api/cotizaciones/contactos/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
};
let resumen_compras = function () {


    let data_send = {
        "fecha_inicio": get_attr(this, "fecha_inicio"),
        "fecha_termino": get_attr(this, "fecha_termino"),
        "tipo": get_attr(this, "tipo_compra"),
        "v": 1
    };
    let url = "../q/index.php/api/recibo/compras/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
};

let resumen_valoracion = function () {


    let data_send = {
        "fecha_inicio": get_attr(this, "fecha_inicio"),
        "fecha_termino": get_attr(this, "fecha_termino")
    };
    let url = "../q/index.php/api/valoracion/resumen_valoraciones_periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
};
let resumen_servicios = function () {


    let data_send = {
        "fecha_inicio": get_parameter_enid($(this), "fecha_inicio"),
        "fecha_termino": get_parameter_enid($(this), "fecha_termino"),
        "v": 1
    };

    let url = "../q/index.php/api/servicio/periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
};
let resumen_servicios_valorados = function () {


    let data_send = {
        "fecha_inicio": get_parameter_enid($(this), "fecha_inicio"),
        "fecha_termino": get_parameter_enid($(this), "fecha_termino")
    };
    let url = "../q/index.php/api/valoracion/resumen_valoraciones_periodo_servicios/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");

};
let resume_lista_deseos = function () {


    let data_send = {
        "fecha_inicio": get_parameter_enid($(this), "fecha_inicio"),
        "fecha_termino": get_parameter_enid($(this), "fecha_termino")
    };

    let url = "../q/index.php/api/servicio/lista_deseos_periodo/format/json/";
    request_enid("GET", data_send, url, 1, ".place_reporte", 0, ".place_reporte");
};
let carga_repo_usabilidad = function (e) {

    let data_send = $(".f_actividad_productos_usuarios").serialize() + "&" + $.param({ "v": 1 });
    let url = "../q/index.php/api/usuario/actividad/format/json/";

    if (get_parameter(".f_actividad_productos_usuarios #datetimepicker4").length > 5 && get_parameter(".f_actividad_productos_usuarios #datetimepicker5").length > 5) {

        request_enid("GET", data_send, url, info_usabilidad, ".place_reporte");

    } else {

        focus_input([".f_actividad_productos_usuarios #datetimepicker5", ".f_actividad_productos_usuarios #datetimepicker4"]);

    }
    e.preventDefault();
};

let info_usabilidad = (data) => {

    render_enid(".repo_usabilidad", data);
    $(".servicios").click(resumen_servicios);
    $(".usuarios").click(resumen_usuarios);

};
let carga_repo_tipos_entregas = function (e) {

    let data_send = $(".form_tipos_entregas").serialize() + "&" + $.param({ "v": 1 });
    let url = "../q/index.php/api/servicio/tipos_entregas/format/json/";

    if (get_parameter(".form_tipos_entregas #datetimepicker4").length > 5 && get_parameter(".form_tipos_entregas #datetimepicker5").length > 5) {

        request_enid("GET", data_send, url, 1, ".place_tipos_entregas", 0, ".place_tipos_entregas");
        $('th').click(ordena_tabla);

    } else {

        focus_input([".form_tipos_entregas #datetimepicker4", ".form_tipos_entregas #datetimepicker5"]);

    }
    e.preventDefault();
};

let arquetipos = function (e) {


    let f_inicio = get_parameter(".form_arquetipos #datetimepicker4");
    let f_termino = get_parameter(".form_arquetipos #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_arquetipos.serialize();
        let url = "../q/index.php/api/tag_arquetipo/q/format/json/";

        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_arquetipos #datetimepicker5", ".form_arquetipos #datetimepicker4"]);
    }
    e.preventDefault();
};
let tipificaciones = function (e) {

    let f_inicio = get_parameter(".form_tipificaciones #datetimepicker4");
    let f_termino = get_parameter(".form_tipificaciones #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_tipificaciones.serialize() + "&" + $.param({ 'v': 1 });
        let url = "../q/index.php/api/tipificacion_recibo/q/format/json/";
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_arquetipos #datetimepicker5", ".form_arquetipos #datetimepicker4"]);
    }
    e.preventDefault();
};
let evaluaciones = function (e) {

    let f_inicio = get_parameter(".form_evaluaciones #datetimepicker4");
    let f_termino = get_parameter(".form_evaluaciones #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_evaluaciones.serialize() + "&" + $.param({ 'v': 1 });
        let url = "../q/index.php/api/puntuacion/recibos/format/json/";
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_evaluaciones #datetimepicker5", ".form_evaluaciones #datetimepicker4"]);

    }
    e.preventDefault();
}
let set_menu = go => show_tabs(["#btn_repo_afiliacion", go]);

let ventas_comisionistas = function (e) {


    let f_inicio = get_parameter(".form_ventas_comisionistas #datetimepicker4");
    let f_termino = get_parameter(".form_ventas_comisionistas #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_ventas_comisionistas.serialize() + "&" + $.param({ 'v': 1 });
        let url = "../q/index.php/api/enid/ventas_comisionadas/format/json/";
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_arquetipos #datetimepicker5", ".form_arquetipos #datetimepicker4"]);
    }
    e.preventDefault();
};
let ventas_entregadas = function (e) {

    let f_inicio = get_parameter(".form_entregas #datetimepicker4");
    let f_termino = get_parameter(".form_entregas #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_entregas.serialize() + "&" + $.param({ 'v': 1 });
        let url = "../q/index.php/api/enid/ventas_entregas/format/json/";
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_entregas #datetimepicker5", ".form_entregas #datetimepicker4"]);
    }
    e.preventDefault();
};
let motovos_cancelaciones_busqueda = function (e) {

    let f_inicio = get_parameter(".form_motivos_cancelaciones #datetimepicker4");
    let f_termino = get_parameter(".form_motivos_cancelaciones #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_motivos_cancelaciones.serialize() + "&" + $.param({ 'v': 1 });
        let url = "../q/index.php/api/tipificacion_recibo/cancelacion/format/json/";
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    }

    e.preventDefault();
}

let top_ventas = function (e) {

    let f_inicio = get_parameter(".form_top_ventas #datetimepicker4");
    let f_termino = get_parameter(".form_top_ventas #datetimepicker5");

    if (f_inicio.length > 5 && f_termino.length > 5) {

        let data_send = $form_top_ventas.serialize() + "&" + $.param({ 'v': 1 });
        let url = "../q/index.php/api/recibo/top/format/json/";
        request_enid("GET", data_send, url, render_top_ventas);

    }

    e.preventDefault();
}
let sin_ventas = function (e) {

    let data_send = { 'v': 1 };
    let url = "../q/index.php/api/servicio/sin_ventas/format/json/";
    request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    e.preventDefault();
}

let render_top_ventas = function (data) {

    render_enid(".place_keywords", data);

}
let funnel = function (e) {

    let data_send = $.param({});
    let url = "../q/index.php/api/enid/funnel/format/json/";
    request_enid("GET", data_send, url, response_funnel, ".place_usabilidad", 0, ".place_usabilidad");

};
let response_funnel = function (data) {

    render_enid(".funnel_ventas", data);
    $(".personas_registradas_carrito").click(personas_registradas_carrito);
    $(".externos_en_carrito").click(externos_en_carrito);

    $(".personas_registradas_contacto").click(personas_registradas_contacto);
    $(".personas_externas_contacto").click(personas_externas_contacto);




};
let personas_registradas_contacto = function (e) {

    let data_send = $.param({});
    let url = "../q/index.php/api/usuario_deseo/en_registro/format/json/";
    request_enid("GET", data_send, url, response_personas_registradas_carrito);

};
let personas_externas_contacto = function (e) {

    let data_send = $.param({});
    let url = "../q/index.php/api/usuario_deseo_compra/en_registro/format/json/";
    request_enid("GET", data_send, url, response_personas_registradas_carrito);

};
let personas_registradas_carrito = function (e) {

    let data_send = $.param({});
    let url = "../q/index.php/api/usuario_deseo/agregados/format/json/";
    request_enid("GET", data_send, url, response_personas_registradas_carrito);

};
let externos_en_carrito = function (e) {

    let data_send = $.param({});
    let url = "../q/index.php/api/usuario_deseo_compra/agregados/format/json/";
    request_enid("GET", data_send, url, response_personas_registradas_carrito);

}
let response_personas_registradas_carrito = function (data) {


    render_enid(".funnel_ventas", data);

};
