"use strict";

window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.onpopstate = event => {
    if (event) {
        retorno();
    }
};
let $menu = $('.menu');
let seccion_busqueda = '.contenedor_busqueda_articulos';
let titulo_seccion = '.titulo_seccion';

let $seccion_busqueda = $(seccion_busqueda);
let $titulo_seccion = $(titulo_seccion);
let $costo = $('.costo');
let $form_nombre_producto = $('.form_nombre_producto');
let $selector_carga_modal = $('#stock_servicio_modal');
let $stock_fecha_servicio_modal = $('#stock_fecha_servicio_modal');

let $form_stock_servicio = $('.form_stock_servicio');
let $form_fecha_stock = $('.form_fecha_stock');
let $ocultar_fecha_stock = $('.ocultar_fecha_stock');
let $input_stock = $form_stock_servicio.find('.stock');
let $input_id_servicio = $form_stock_servicio.find('.id_servicio');
let $input_costo = $form_stock_servicio.find('.costo_stock');
let $definir_feche_disponible = $('.definir_feche_disponible');
let $opciones_definicion = $('.opciones_definicion');
let $ultima_fecha_disponible = $('.ultima_fecha_disponible');


$(document).ready(() => {

    set_option("s", 1);
    set_option("page", 1);
    set_option("modalidad", 0);
    $("footer").ready(valida_action_inicial);
    $(".btn_servicios").click(carga_servicios);
    $(".tipo_promocion").click(configuracion_inicial);
    $form_nombre_producto.submit(simula_envio);

    $(".btn_agregar_servicios").click(() => {
        showonehideone(".contenedor_nombre", ".contenedor_categorias");
        set_option("nuevo", 1);
        despliega([".texto_ventas_titulo"], 1);
    });

    $(".li_menu_servicio").click(() => {
        despliega([".btn_agregar_servicios", ".contenedor_top"], 1);
    });
    $(".puntos_venta").click(puntos_venta);

    despliega([".contenedor_busqueda_global_enid_service"], 0);
    $(".ci_facturacion").change(evalua_precio);
    $(".cancelar_registro").click(cancelar_registro);
    def_contenedores();


    $costo.keypress(enter_precio);
    $input_stock.keypress(evita_caracteres);
    $input_costo.keypress(evita_caracteres);
    $input_stock.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_stock_servicio, 1);
    });

    $input_costo.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_stock_servicio, 1);
    });


});

let def_contenedores = () => {

    let secciones = ["selected_2", "selected_3", "selected_4", "selected_5", "selected_6", "selected_7", "primer_nivel", "segundo_nivel", "tercer_nivel", "cuarto_nivel", "quinto_nivel"];
    for (let x in secciones) {
        set_option(secciones[x], 0);
    }
};
let cancelar_carga_imagen = () => {

    showonehideone(".contenedor_global_servicio", ".contenedor_agregar_imagenes");
};

let cancelar_registro = () => {

    showonehideone(".contenedor_agregar_servicio_form", ".contenedor_categorias_servicios");
};

let carga_servicios = function () {

    set_option("s", 1);
    let global = (get_parameter_enid($(this), "id" || get_option("global")) > 0) ? 1 : 0;
    set_option("global", global);
    let e = [".texto_ventas_titulo", ".contenedor_busqueda", ".contenedor_busqueda_articulos"];
    despliega(e, 1);

    let url = "../q/index.php/api/servicio/empresa/format/json/";
    let orden = get_parameter("#orden");
    let data_send = {
        "q": get_parameter(".q_emp"),
        "id_clasificacion": get_option("id_clasificacion"),
        "page": get_option("page"),
        "order": orden,
        "global": global
    };

    request_enid("GET", data_send, url, respuesta_carga_servicios, ".place_servicios", () => {
        sload(".place_servicios", "", "");
        recorre(".contenedor_principal_enid");
    });
};

let respuesta_carga_servicios = data => {

    if (data.num_servicios != undefined) {

        render_enid(".place_servicios", data.info_servicios);

    } else {

        render_enid(".place_servicios", data);
        $(".servicio").click(carga_info_servicio);
        $(".pagination > li > a, .pagination > li > span").click(function (e) {
            let page_html = $(this);
            let num_paginacion = $(page_html).attr("data-ci-pagination-page");
            if (validar_si_numero(num_paginacion) == true) {
                set_option("page", num_paginacion);
            } else {
                num_paginacion = $(this).text();
                set_option("page", num_paginacion);
            }
            carga_servicios();
            e.preventDefault();
        });
        recorre(".contenedor_principal_enid");
    }
};

let carga_info_servicio = function (e) {


    set_option("servicio", get_parameter_enid($(this), "id"));
    if (get_option("servicio") > 0) {

        carga_informacion_servicio(1);
    }
};

let carga_informacion_servicio = (num = 1) => {

    set_option("s", 2);
    despliega([".contenedor_busqueda"], 0);
    let url = "../q/index.php/api/servicio/especificacion/format/json/";
    let data_send = {id_servicio: get_option("servicio"), "num": num};

    request_enid("GET", data_send, url, respuesta_informacion_servicio, ".place_servicios", function () {

        recorre(".contenedor_principal_enid");

    });
};

let respuesta_informacion_servicio = (data) => {

    add_class([seccion_busqueda, titulo_seccion], 'd-none');
    render_enid(".place_servicios", data);
    verifica_formato_default_inputs();
    $(".cancelar_carga_imagen").click(cancelar_carga_imagen);
    $(".menu_meta_key_words").click(carga_sugerencias_meta_key_words);
    $(".agregar_img_servicio").click(carga_form_img);
    $(".text_costo").click(muestra_input_costo);
    $(".text_ciclo_facturacion").click(muestra_select_ciclo_facturacion);
    $(".text_nombre_servicio").click(muestra_seccion_nombre_servicio);
    $(".text_desc_servicio").click(muestra_seccion_desc_servicio);
    $(".text_porcentaje_ganancia").click(muestra_seccion_porcentaje_ganancia);
    $(".text_porcentaje_ganancias_afiliados").click(muestra_seccion_porcentaje_ganancia_afiliados);
    $(".text_video_servicio").click(muestra_seccion_video_servicio);
    $(".text_url_facebook").click(muestra_seccion_video_servicio_facebook);
    $(".text_info_envio").click(muestra_input_incluye_envio);
    $(".text_pagina_venta").click(muestra_seccion_url_pagina_web);
    $(".form_costo").submit(registra_costo_servicio);
    $(".form_ciclo_facturacion").submit(registrar_ciclo_facturacion);
    $(".form_servicio_nombre_info").submit(actualiza_dato_servicio);
    $(".form_servicio_url_venta").submit(actualiza_dato_url_venta);
    $(".form_servicio_afiliados").submit(actualiza_dato_servicio_afiliado);

    $(".form_servicio_desc").submit(actualiza_dato_servicio_desc);
    $(".form_servicio_youtube").submit(actualiza_dato_servicio_youtube);
    $(".form_servicio_facebook").submit(actualiza_dato_servicio_facebook);
    $(".foto_producto").click(elimina_foto_producto);
    $(".imagen_principal").click(place_load_imgimagen_principal);
    $(".form_tag").submit(agrega_metakeyword);
    $(".text_nuevo").click(muestra_input_producto_nuevo);
    $(".text_ciclo_facturacion").click(muestra_input_ciclo_facturacion);
    $(".text_cantidad").click(muestra_input_cantidad);
    $(".btn_guardar_producto_nuevo").click(actualiza_servicio_usado);
    $(".btn_guardar_ciclo_facturacion").click(actualiza_ciclo_facturacion);
    $(".btn_guardar_cantidad_productos").click(actualiza_cantidad);
    $(".text_incluye_envio").click(muestra_input_incluye_envio);
    $(".btn_guardar_envio").click(actualiza_envio_incluido);
    $(".text_agregar_color").click(muestra_input_color);
    $(".elimina_color").click(elimina_color_servicio);
    $(".entregas_en_casa").click(actualiza_entregas_en_casa);
    $(".telefono_visible").click(actualiza_telefono_visible);
    $(".venta_mayoreo").click(actualiza_ventas_mayoreo);
    $(".entregas_en_auto").click(entregas_en_auto);
    $(".entregas_solo_metro").click(entregas_solo_metro);
    $(".moto").click(moto);
    $(".bicicleta").click(bicicleta);
    $(".pie").click(pie);

    $(".detalle").click(carga_tallas);
    $(".actilet_publicacion").click(activa_publicacion);
    $(".tiempo_entrega").change(set_tiempo_entrega);
    $(".btn_url_ml").click(set_url_ml);
    $(".activar_publicacion").click(activa_publicacion);
    $(".es_publico").click(activa_visibilidad);
    $(".restablecer").click(restablecer);
    $('.stock_disponible').click(editar_stock_disponible);
    $('.stock_disponibilidad').click(editar_fecha_stock_disponible);


    $(".form_dropshipping").submit(modifica_dropshipping);
    $('.form_comision_venta').submit(registro_comision);
    $('.editar_comision').click(function () {

        showonehideone('.form_comision_venta', '.text_comision');
    });
    if (get_option("flag_nueva_categoria") == 1) {
        recorre("#seccion_metakeywords_servicio");
    }
    if (get_option("flag_recorrido") != undefined) {
        recorre(get_option("seccion_a_recorrer"));
    }
    $(".descartar_promocion").click(descartar_promocion);
    $('.form_stock_select').find(".stock").change(set_cantidad_en_stock);
    $('.entregas_en_punto_encuentro').click(actualiza_entregas_en_punto_encuentro);

    verifica_formato_default_inputs();
    $(".input_enid_format :input").focus(next_label_input_focus);

    $(".busqueda_producto_relacionado").keyup(busqueda_posibles_relaciones);
    $(".quitar_servicio_relacionado").click(quitar_servicio_relacionado);


    $('#summernote').summernote();
    despliega([".contenedor_busqueda_articulos", ".agregar_servicio btn_agregar_servicios", ".titulo_articulos_venta"], 0);


};
let actualiza_entregas_en_casa = function (e) {

    let url = "../q/index.php/api/servicio/entregas_en_casa/format/json/";
    let data_send = {
        entregas_en_casa: get_parameter_enid($(this), "id"),
        id_servicio: get_option("servicio")
    };
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
};


let actualiza_telefono_visible = function () {
    let url = "../q/index.php/api/servicio/telefono_visible/format/json/";
    let data_send = {
        telefono_visible: get_parameter_enid($(this), "id"),
        id_servicio: get_option("servicio")
    };
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
};


let actualiza_ventas_mayoreo = function (e) {

    let url = "../q/index.php/api/servicio/ventas_mayoreo/format/json/";
    let data_send = {
        venta_mayoreo: get_parameter_enid($(this), "id"),
        id_servicio: get_option("servicio")
    };
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
};
let entregas_solo_metro = function (e) {

    let url = "../q/index.php/api/servicio/solo_metro/format/json/";
    let id = get_parameter_enid($(this), "id");
    let $id_servicio = get_option("servicio");

    let data_send = {
        solo_metro: id,
        id_servicio: $id_servicio
    };

    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");

}
let entregas_en_auto = function (e) {

    let url = "../q/index.php/api/servicio/requiere_auto/format/json/";
    let id = get_parameter_enid($(this), "id");
    let $id_servicio = get_option("servicio");

    let data_send = {
        requiere_auto: id,
        id_servicio: $id_servicio
    };

    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}
let moto = function (e) {

    let url = "../q/index.php/api/servicio/moto/format/json/";
    let id = get_parameter_enid($(this), "id");
    let $id_servicio = get_option("servicio");

    let data_send = {
        moto: id,
        id_servicio: $id_servicio
    };

    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}
let bicicleta = function (e) {

    let url = "../q/index.php/api/servicio/bicicleta/format/json/";
    let id = get_parameter_enid($(this), "id");
    let $id_servicio = get_option("servicio");

    let data_send = {
        bicicleta: id,
        id_servicio: $id_servicio
    };

    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}
let pie = function (e) {

    let url = "../q/index.php/api/servicio/pie/format/json/";
    let id = get_parameter_enid($(this), "id");
    let $id_servicio = get_option("servicio");

    let data_send = {
        pie: id,
        id_servicio: $id_servicio
    };

    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}
let actualiza_entregas_en_punto_encuentro = function () {

    let url = "../q/index.php/api/servicio/es_posible_punto_encuentro/format/json/";
    let $id = get_parameter_enid($(this), "id");
    let data_send = {
        es_posible_punto_encuentro: $id,
        id_servicio: get_option("servicio")
    };
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");


};

let muestra_input_visible = (visible, i, t) => (visible === true) ? showonehideone(i, t) : showonehideone(i, t);


let muestra_input_costo = () => {

    let visible = $(".text_costo").is(":visible");
    muestra_input_visible(visible, ".input_costo", ".text_costo");

};


let muestra_input_producto_nuevo = () => {

    let visible = $(".text_nuevo").is(":visible");
    muestra_input_visible(visible, ".input_nuevo", ".text_nuevo");
};

let muestra_input_ciclo_facturacion = () => {

    let visible = $(".text_ciclo_facturacion").is(":visible");
    muestra_input_visible(visible, ".input_ciclo_facturacion", ".text_ciclo_facturacion");

};

let muestra_input_cantidad = () => {


    if ($(".text_cantidad").is(":visible") == true) {
        showonehideone(".input_cantidad", ".text_cantidad");
    } else {
        showonehideone(".input_cantidad", ".text_cantidad");
    }
};

let muestra_input_incluye_envio = () => {


    if ($(".contenedor_informacion_envio").is(":visible") == true) {
        showonehideone(".input_envio", ".contenedor_informacion_envio");
    } else {
        showonehideone(".input_envio", ".contenedor_informacion_envio");
    }
};


let muestra_select_ciclo_facturacion = function (e) {

    set_option("id_ciclo_facturacion", get_parameter_enid($(this), "id"));
    let visible = $(".text_ciclo_facturacion").is(":visible");
    let x = (visible == true) ? showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion") : showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
};


let muestra_seccion_nombre_servicio = e => {

    let visible = $(".text_nombre_servicio").is(":visible");
    let x = (visible == true) ? showonehideone(".form_servicio_nombre_info", ".text_nombre_servicio") : showonehideone(".input_nombre_servicio_facturacion", ".text_nombre_servicio");
};


let muestra_seccion_video_servicio = () => {

    let visible = $(".text_video_servicio").is(":visible");
    let x = (visible == true) ? showonehideone(".form_servicio_youtube", ".text_video_servicio") : showonehideone(".input_url_youtube", ".text_video_servicio");
};


let muestra_seccion_video_servicio_facebook = () => {
    let visible = $(".text_video_servicio_facebook").is(":visible");
    let x = (visible == true) ? showonehideone(".input_url_facebook", ".text_video_servicio_facebook") : showonehideone(".input_url_facebook", ".text_video_servicio_facebook");
};


let muestra_seccion_desc_servicio = e => {
    $(".note-codable").hide();
    let visible = $(".text_desc_servicio").is(":visible");
    let x = (visible == true) ? showonehideone(".input_desc_servicio_facturacion", ".text_desc_servicio") : showonehideone(".input_desc_servicio_facturacion", ".text_desc_servicio");
};


let muestra_input_color = (e) => {

    let visible = $(".text_agregar_color").is(":visible");
    if (visible == true) {

        showonehideone(".input_servicio_color", ".text_agregar_color");
        carga_listado_colores();
    } else {
        showonehideone(".input_servicio_color", ".text_agregar_color");
    }
};
let registra_costo_servicio = e => {


    let $precio_unidad = $('.precio_unidad');
    let $total_precio_unidad = $precio_unidad.val();
    if (es_float($total_precio_unidad) && $total_precio_unidad > 0) {
        let url = "../q/index.php/api/servicio/costo/format/json/";
        let data_send = $(".form_costo").serialize() + "&" + $.param({
            "id_servicio": get_option("servicio")
        });
        request_enid("PUT", data_send, url, function (data) {
            carga_informacion_servicio(4)
        });
    } else {
        next_error($precio_unidad);
    }

    e.preventDefault();
};

let actualiza_dato_servicio = e => {

    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $(".form_servicio_nombre_info").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });

    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(1);

    });
    e.preventDefault();
};
let actualiza_dato_url_venta = e => {
    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $(".form_servicio_url_venta").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(1);
    });
    e.preventDefault();
};


let actualiza_dato_servicio_afiliado = e => {

    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $(".form_servicio_afiliados").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(1);
    });
    e.preventDefault();
};


let valida_url_youtube = () => {

    let url = get_parameter(".url_youtube");
    let text_youtube = "youtu";

    let input = ".url_youtube";
    let place_msj = ".place_url_youtube";
    let mensaje_user = "Url no valida!, ingrese url de youtube <div class='url_youtube_alert'><i class='fa fa-youtube-play'></i> Youtube! </div>";

    if (url.indexOf(text_youtube) != -1) {
        $(place_msj).empty();
        return 1;
    } else {

        $(input).css("border", "1px solid rgb(13, 62, 86)");
        render_enid(place_msj, "<div class='alerta_enid'>" + mensaje_user + "</div>");
        return 0;
    }

};

let actualiza_dato_servicio_youtube = e => {
    if (valida_url_youtube() == 1) {
        /* Validamos que la url realmente sea de youtube */
        let url = "../q/index.php/api/servicio/q/format/json/";
        let data_send = $(".form_servicio_youtube").serialize() + "&" + $.param({
            "id_servicio": get_option("servicio")
        });
        request_enid("PUT", data_send, url, function (data) {
            carga_informacion_servicio(1);
        });
    }
    e.preventDefault();
};


let actualiza_dato_servicio_facebook = e => {
    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $(".form_servicio_facebook").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(1);
    });
    e.preventDefault();
};


let actualiza_dato_servicio_desc = e => {
    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $(".form_servicio_desc").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio"),
        "q2": $(".note-editable").html()
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(2);
    });
    e.preventDefault();
};


let registrar_ciclo_facturacion = e => {

    let url = "../q/index.php/api/servicio/ciclo_facturacion/format/json/";
    let data_send = $(".form_ciclo_facturacion").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });
    e.preventDefault();
};

let carga_grupos = () => {
    let url = "../q/index.php/api/servicio/grupos/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, respuesta_grupos);
};


let respuesta_grupos = data => {

    render_enid(".place_grupos", data);
    $(".grupo").change(function () {
        let nuevo_grupo = get_parameter(".grupo");
        set_option("nuevo_grupo", nuevo_grupo);
        carga_info_grupos();
    });
    carga_info_grupos();
};


let carga_info_grupos = () => {

    let grupo = get_option("grupo");
    if (grupo == 0) {
        let grupo = get_parameter(".grupo");
        set_option("grupo", grupo);
    }
    let url = "../q/index.php/api/servicio/grupo/format/json/";
    let data_send = {grupo: get_option("grupo")};
    request_enid("GET", data_send, url, respuesta_info_grupos);

};
let respuesta_info_grupos = data => {

    render_enid(".place_info_grupos", data);
    $(".servicio").click(carga_info_servicio);
    $(".nuevo_grupo_servicios").click(carga_form_nuevo_grupo);
    $(".agregar_servicios_grupo").click(agregar_servicio_grupo);
};

let carga_form_nuevo_grupo = () => {

    let url = "../q/index.php/api/servicio/grupo_form/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, respuesta_nuevo_grupo, ".place_info_grupos");
};
let respuesta_nuevo_grupo = data => {
    render_enid(".place_grupos", data);
    $(".form_grupo_sistema").submit(agregar_grupo_sistema);
};
let agregar_grupo_sistema = e => {
    let url = "../q/index.php/api/servicio/grupo_form/format/json/";
    let data_send = $(".form_grupo_sistema").serialize();
    request_enid("POST", data_send, url, respuesta_grupo_sistema, ".place_info_grupos", "Cargando ... ");
    e.preventDefault();
};
let respuesta_grupo_sistema = data => {
    set_option("grupo", data);
    carga_grupos();
    carga_info_grupos();
};
let agregar_servicio_grupo = e => {

    $("#seccion_izquierda_grupos").removeClass("col-lg-11");
    $("#seccion_izquierda_grupos").addClass("col-lg-6");
    $("#seccion_derecha_grupos").removeClass("col-lg-1");
    $("#seccion_derecha_grupos").addClass("col-lg-6");
    cargar_lista_servicios_grupo();
};


let cargar_lista_servicios_grupo = () => {
    let url = "../q/index.php/api/servicio/servicios_grupo/format/json/";
    let data_send = {grupo: get_option("grupo")};
    request_enid("GET", data_send, url, respuestas_cargar_lista_servicios, ".place_servicios_en_grupos");
};


let respuestas_cargar_lista_servicios = (data) => {
    render_enid(".place_servicios_en_grupos", data);
    $(".grupo_servicio").click(agrega_quita_servicio_grupo);
};


let agrega_quita_servicio_grupo = function (e) {
    let id_servicio = get_parameter_enid($(this), "id");
    set_option("servicio", id_servicio);
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "grupo": get_option("grupo")
    });

    let url = "../q/index.php/api/servicio/servicio_grupo/format/json/";
    request_enid("PUT", data_send, url, carga_grupos);
};


let muestra_seccion_url_pagina_web = () => {

    if ($(".text_pagina_venta").is(":visible") == true) {
        showonehideone(".input_url_pagina_web", ".text_pagina_venta");
    } else {
        showonehideone(".input_url_pagina_web", ".text_pagina_venta");
    }
};

let muestra_seccion_porcentaje_ganancia = () => {


    if ($(".text_porcentaje_ganancia").is(":visible") == true) {
        showonehideone(".input_porcentaje_ganancia",
            ".text_porcentaje_ganancia");
    } else {
        showonehideone(".input_porcentaje_ganancia",
            ".text_porcentaje_ganancia");
    }
};

let muestra_seccion_porcentaje_ganancia_afiliados = () => {


    if ($(".text_porcentaje_ganancias_afiliados").is(":visible") == true) {
        showonehideone(".input_porcentaje_ganancia_afiliados",
            ".text_porcentaje_ganancias_afiliados");
    } else {
        showonehideone(".input_porcentaje_ganancia_afiliados",
            ".text_porcentaje_ganancias_afiliados");
    }
};

let configuracion_inicial = function () {


    let modalidad = parseInt(get_parameter_enid($(this), "id"));
    set_option("modalidad", modalidad);
    if (modalidad > 0) {
        /*Servicio*/
        set_option("id_ciclo_facturacion", 9);
        $(".text_modalidad").text("Servicio");
        $(".tipo_producto").removeClass('button_enid_eleccion_active');
        $(".tipo_servicio").addClass('button_enid_eleccion_active');
        selecciona_select(".ci_facturacion", 9);
        $(".precio").val(0);
        despliega([".contenedor_ciclo_facturacion", ".siguiente_btn"], 1);
        despliega([".contenedor_precio"], 0);

    } else {

        set_option("id_ciclo_facturacion", 5);
        $(".text_modalidad").text("Artículo/Producto");
        $(".tipo_producto").addClass('button_enid_eleccion_active');
        $(".tipo_servicio").removeClass('button_enid_eleccion_active');
        despliega([".contenedor_precio"], 1);
        despliega([".contenedor_ciclo_facturacion"], 0);

    }
};


let simula_envio = (e) => {

    let costo = $costo.val();
    let next = (get_option("modalidad") == 0 && costo == 0) ? 0 : 1;
    next_error($costo, 0);
    if (next) {

        if (es_float(costo)) {

            showonehideone(".contenedor_categorias", ".contenedor_nombre");
            despliega([".contenedor_top"], 0);
            set_nombre_servicio_html(get_parameter(".nuevo_producto_nombre"));
            set_option("costo", costo);
            $(".extra_precio").text("");
            verifica_existencia_categoria();

        } else {
            next_error($costo);
        }

    } else {
        $costo.css("border", "1px solid rgb(13, 62, 86)");
        $(".extra_precio").text("INGRESA EL PRECIO DEL PRODUCTO");
    }
    e.preventDefault();
};
let verifica_existencia_categoria = () => {

    set_option("s", 4);
    let url = "../q/index.php/api/servicio/verifica_existencia_clasificacion/format/json/";
    let nombre = get_parameter(".nuevo_producto_nombre");
    let data_send = {"clasificacion": nombre, "id_servicio": get_option("modalidad")};
    request_enid("GET", data_send, url, listar_categorias);
};

let def_categorias = () => {

    for (let i = 1; i < 6; i++) {
        let agregar_categoria_def = "agregar_categoria_" + i;
        set_option(agregar_categoria_def, 0);
    }
};

let listar_categorias = (data) => {


    def_categorias();
    if (array_key_exists("total", data) == true && data.total > 0) {
        let categorias = data.categorias;
        if (array_key_exists(1, categorias) == true && categorias[1].nivel != undefined && categorias[1].nivel == 1) {

            let data_categorias = categorias;
            let keys = getObjkeys(data_categorias);
            let posicion_final = getMaxOfArray(keys);

            for (let a in data_categorias) {

                let nivel = parseInt(data_categorias[a].nivel);
                let id_clasificacion = parseInt(data_categorias[a].id_clasificacion);
                let agregar_categoria_ = "agregar_categoria_" + posicion_final;
                set_option(agregar_categoria_, 1);

                switch (nivel) {

                    case 1:
                        set_option("selected_1", 1);
                        set_option("selected_num_1", id_clasificacion);
                        carga_listado_categorias();
                        set_option("padre", id_clasificacion);

                        break;

                    case 2:

                        set_option("selected_2", 1);
                        set_option("selected_num_2", id_clasificacion);
                        carga_listado_categorias_segundo_nivel();
                        set_option("padre", id_clasificacion);
                        set_option("segundo_nivel", id_clasificacion);
                        break;

                    case 3:
                        set_option("selected_3", 1);
                        set_option("selected_num_3", id_clasificacion);
                        carga_listado_categorias_tercer_nivel();
                        set_option("padre", id_clasificacion);
                        set_option("tercer_nivel", id_clasificacion);
                        break;

                    case 4:


                        set_option("selected_4", 1);
                        set_option("selected_num_4", id_clasificacion);
                        carga_listado_categorias_cuarto_nivel();
                        set_option("padre", id_clasificacion);
                        set_option("cuarto_nivel", id_clasificacion);
                        break;

                    default:
                }
            }
        } else {
            carga_listado_categorias();
        }
    } else {
        carga_listado_categorias();
    }

};


let set_nombre_servicio_html = n_nombre_servicio => {

    set_option("nombre_servicio", n_nombre_servicio);
    let nombre_servicio = n_nombre_servicio;
    $(".nombre_producto").val(n_nombre_servicio);
};

let clean_data_categorias = () => {

    empty_elements([".segundo_nivel_seccion", ".tercer_nivel_seccion", ".cuarto_nivel_seccion", ".quinto_nivel_seccion", ".sexto_nivel_seccion"]);
    set_option("nivel", 1);
    set_option("padre", 0);
    showonehideone(".contenedor_categorias_servicios", ".contenedor_agregar_servicio_form");
};

let carga_listado_categorias = () => {


    let nombre = get_parameter(".nuevo_producto_nombre");
    clean_data_categorias();
    let data_send = {
        "modalidad": get_option("modalidad"),
        "padre": 0,
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile(),
        "nombre": nombre
    };
    let url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    request_enid("GET", data_send, url, respuestas_primer_nivel, ".primer_nivel_seccion");
};


let respuestas_primer_nivel = data => {

    render_enid(".primer_nivel_seccion", data);
    if (get_option("selected_1") == 1) {
        selecciona_valor_select(".nivel_1", get_option("selected_num_1"));
    }
    set_option("primer_nivel", get_parameter(".nivel_1 option"));
    $(".primer_nivel_seccion .nivel_1").change(carga_listado_categorias_segundo_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    if (array_key_exists("agregar_categoria_1", option) && get_option("agregar_categoria_1") == 1) {
        carga_listado_categorias_segundo_nivel();
        set_option("agregar_categoria_1", 0);
    }
    add_cancelar_movil();
};

let carga_listado_categorias_segundo_nivel = () => {

    set_option("nivel", 2);
    let url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    if (get_option("selected_2") == 0) {
        set_option("padre", get_parameter(".nivel_1 option:selected"));
    }
    set_option("primer_nivel", get_parameter(".nivel_1 option:selected"));
    empty_elements([".segundo_nivel_seccion", ".tercer_nivel_seccion", ".cuarto_nivel_seccion", ".quinto_nivel_seccion", ".sexto_nivel_seccion"]);
    let data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestra_segundo_nivel, ".segundo_nivel_seccion");
};

let muestra_segundo_nivel = (data) => {

    render_enid(".segundo_nivel_seccion", data);
    if (get_option("selected_2") == 1) {
        selecciona_valor_select(".nivel_2", get_option("selected_num_2"));
    }
    set_option("segundo_nivel", get_parameter(".nivel_2 option:selected"));
    $(".segundo_nivel_seccion .nivel_2").change(carga_listado_categorias_tercer_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);

    if (array_key_exists("agregar_categoria_2", option) && get_option("agregar_categoria_2") == 1) {
        carga_listado_categorias_tercer_nivel();
        set_option("agregar_categoria_2", 0);
    }
    add_cancelar_movil();

};
let carga_listado_categorias_tercer_nivel = () => {


    empty_elements([".cuarto_nivel_seccion", ".quinto_nivel_seccion", ".sexto_nivel_seccion"]);
    let url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("nivel", 3);
    if (get_option("selected_3") == 0) {
        let n_padre = get_parameter(".nivel_2 option:selected");
        set_option("padre", n_padre);
    }
    set_option("segundo_nivel", get_parameter(".nivel_2 option:selected"));
    let data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestra_t_nivel, ".tercer_nivel_seccion");
};

let muestra_t_nivel = (data) => {

    render_enid(".tercer_nivel_seccion", data);
    if (get_option("selected_3") == 1) {
        selecciona_valor_select(".nivel_3", get_option("selected_num_3"));
    }
    $(".tercer_nivel_seccion .nivel_3").change(carga_listado_categorias_cuarto_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    if (array_key_exists("agregar_categoria_3", option) && get_option("agregar_categoria_3") == 1) {
        carga_listado_categorias_cuarto_nivel();
        set_option("agregar_categoria_3", 0);
    }
    add_cancelar_movil();
};
let carga_listado_categorias_cuarto_nivel = () => {

    let url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("nivel", 4);
    $(".quinto_nivel_seccion").empty();
    $(".sexto_nivel_seccion").empty();

    if (get_option("selected_4") == 0) {
        set_option("padre", get_parameter(".nivel_3 option:selected"));
    }
    set_option("tercer_nivel", get_parameter(".nivel_3 option:selected"));
    let data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestras_c_nivel, ".cuarto_nivel_seccion");
};

let muestras_c_nivel = (data) => {

    render_enid(".cuarto_nivel_seccion", data);
    if (get_option("selected_4") == 1) {
        selecciona_valor_select(".nivel_4", get_option("selected_num_4"));
    }
    $(".cuarto_nivel_seccion .nivel_4").change(carga_listado_categorias_quinto_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    recorre(".cuarto_nivel_seccion");

    if (array_key_exists("agregar_categoria_4", option) && get_option("agregar_categoria_4") == 1) {
        carga_listado_categorias_quinto_nivel();
        set_option("agregar_categoria_4", 0);
    }
    add_cancelar_movil();
};


let carga_listado_categorias_quinto_nivel = () => {

    let url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("nivel", 5);
    $(".sexto_nivel_seccion").empty();
    if (get_option("selected_5") == 0) {
        let n_padre = get_parameter(".nivel_4 option:selected");
        set_option("padre", n_padre);
    }
    set_option("cuarto_nivel", get_parameter(".nivel_4 option:selected"));
    let data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestra_q_nivel, ".quinto_nivel_seccion");
};


let muestra_q_nivel = (data) => {

    render_enid(".quinto_nivel_seccion", data);
    $(".quinto_nivel_seccion .nivel_5").change(carga_listado_categorias_sexto_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    recorre(".quinto_nivel_seccion");
    if (array_key_exists("agregar_categoria_5", option) && get_option("agregar_categoria_5") == 1) {
        carga_listado_categorias_sexto_nivel();
        set_option("agregar_categoria_5", 0);
    }
    add_cancelar_movil();
};


let carga_listado_categorias_sexto_nivel = () => {
    let url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("padre", padre);
    set_option("nivel", 6);
    empty_elements([".sexto_nivel"]);
    let data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    set_option("quinto_nivel", get_parameter(".nivel_5 option:selected"));
    request_enid("GET", data_send, url, muestra_sexo_nivel, ".sexto_nivel_seccion");
};


let muestra_sexo_nivel = (data) => {

    render_enid(".sexto_nivel_seccion", data);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    set_option("agregar_categoria_6", 0);
    add_cancelar_movil();
};

let agregar_categoria_servicio = function () {

    let id_clasificacion = get_parameter_enid($(this), "id");
    set_option("id_clasificacion", id_clasificacion);
    let id_ciclo_facturacion = (get_option("modalidad") == 0) ? 5 : get_parameter("#ciclo");
    set_option("id_ciclo_facturacion", id_ciclo_facturacion);
    registra_nuevo_servicio();
};


let registra_nuevo_servicio = () => {

    let url = "../q/index.php/api/servicio/index/format/json/";
    let data_send = {
        "nombre_servicio": get_option("nombre_servicio"),
        "flag_servicio": get_option("modalidad"),
        "precio": get_option("costo"),
        "ciclo_facturacion": get_option("id_ciclo_facturacion"),
        "primer_nivel": get_option("primer_nivel"),
        "segundo_nivel": get_option("segundo_nivel"),
        "tercer_nivel": get_option("tercer_nivel"),
        "cuarto_nivel": get_option("cuarto_nivel"),
        "quinto_nivel": get_option("quinto_nivel")
    };
    request_enid("POST", data_send, url, response_registro);
};
let response_registro = (data) => {

    if (data.registro != 0 && data.registro.servicio > 0) {
        set_option("servicio", data.registro.servicio);
        carga_informacion_servicio(1);
        $("#tab_productividad").tab("show");
        $(".btn_serv").tab("show");
        if (is_mobile() != 1) {
            reset_form("form_nombre_producto");
            despliega([".btn_agregar_servicios"], 1);
        }
    } else {
        redirect("../planes_servicios/?action=nuevo&mensaje=Verificar el precio que ingresaste");
    }

};
let elimina_foto_producto = function (e) {

    let url = "../q/index.php/api/imagen_servicio/index/format/json/";
    if (get_parameter_enid($(this), "id") > 0) {
        let data_send = {
            "id_imagen": get_parameter_enid($(this), "id"),
            "id_servicio": get_option("servicio")
        };
        request_enid("DELETE", data_send, url, function () {
            carga_informacion_servicio(1);
        }, ".place_servicios");
    }
};
let agrega_metakeyword = (e) => {

    let url = "../q/index.php/api/servicio/metakeyword_usuario/format/json/";
    let data_send = $(".form_tag").serialize();
    request_enid("POST", data_send, url, respuesta_agrega_metakeyword);

    e.preventDefault();
};


let respuesta_agrega_metakeyword = (data) => {
    set_option("flag_nueva_categoria", 1);
    carga_informacion_servicio(3);
    carga_sugerencias_meta_key_words();
};

let eliminar_tag = (text, id_servicio) => {

    let url = "../q/index.php/api/servicio/metakeyword_usuario/format/json/";
    let data_send = {"tag": text, "id_servicio": id_servicio};
    request_enid("DELETE", data_send, url, respuesta_eliminar_tags);
};

let respuesta_eliminar_tags = (data) => {

    carga_informacion_servicio(3);
    carga_sugerencias_meta_key_words();
};

let onkeyup_colfield_check = (e) => {
    let enterKey = 13;
    if (e.which == enterKey) {
        set_option("page", 1);
        carga_servicios();
    }
};
let actualiza_servicio_usado = () => {

    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "q2": get_parameter(".producto_nuevo"),
        "q": "flag_nuevo"
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });
};

let actualiza_envio_incluido = () => {

    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "q2": get_parameter(".input_envio_incluido"),
        "q": "flag_envio_gratis"
    });
    request_enid("PUT", data_send, url, respuestas_actualiza_envio_incluido);
};


let respuestas_actualiza_envio_incluido = (data) => {
    carga_informacion_servicio(4);
    set_option("flag_recorrido", 1);
    set_option("seccion_a_recorrer", ".text_info_envio");
};


let actualiza_ciclo_facturacion = () => {

    set_option("id_ciclo_facturacion", get_parameter(".ciclo_facturacion"));
    let url = "../q/index.php/api/servicio/ciclo_facturacion/format/json/";
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "id_ciclo_facturacion": get_option("id_ciclo_facturacion")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(4);
    });
};

let actualiza_cantidad = () => {

    set_option("existencia", get_parameter(".existencia"));
    let url = "../q/index.php/api/servicio/q/format/json/";
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "q2": get_option("existencia"),
        "q": "existencia"
    });
    request_enid("PUT", data_send, url, respuesta_actualiza_cantidad);
};

let respuesta_actualiza_cantidad = () => {
    carga_informacion_servicio(4);
    set_option("seccion_a_recorrer", ".text_cantidad");
    set_option("flag_recorrido", 1);
};


let agrega_color_servicio = function (e) {

    let color = get_parameter_enid($(this), "id");
    set_option("color", color);
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "color": get_option("color")
    });
    let url = "../q/index.php/api/servicio/color/format/json/";
    request_enid("POST", data_send, url, respuesta_agregar_color);
};


let respuesta_agregar_color = (data) => {
    carga_informacion_servicio(2);
    set_option("seccion_a_recorrer", "#contenedor_colores_disponibles");
    set_option("flag_recorrido", 1);
};

let carga_listado_colores = () => {
    let data_send = {};
    let url = "../q/index.php/api/servicio/colores/format/json/";
    request_enid("GET", data_send, url, respuesta_listado_colores, ".place_colores_disponibles");
};
let respuesta_listado_colores = (data) => {
    render_enid(".place_colores_disponibles", data);
    $(".colores").click(agrega_color_servicio);
    recorre("#seccion_colores_info");
};
let elimina_color_servicio = function () {
    let color = get_parameter_enid($(this), "id");
    set_option("color", color);
    let data_send = $.param({
        "id_servicio": get_option("servicio"),
        "color": get_option("color")
    });
    let url = "../q/index.php/api/servicio/color/format/json/";
    request_enid("DELETE", data_send, url, respuesta_eliminar_color);
};
let respuesta_eliminar_color = (data) => {
    carga_informacion_servicio(2);
    set_option("seccion_a_recorrer", "#contenedor_colores_disponibles");
    set_option("flag_recorrido", 1);
};


let evalua_precio = () => {

    switch (parseInt(get_parameter(".ci_facturacion"))) {
        case 9:

            despliega([".contenedor_precio"], 0);
            $(".precio").val(0);
            break;
        case 5:
            despliega([".contenedor_precio"], 0);
            $(".precio").val(0);
            break;
        default:

            despliega([".contenedor_precio"], 1);
    }
};


let valida_action_inicial = () => {


    switch (parseInt(get_parameter(".q_action"))) {
        case 2:
            set_option("servicio", get_parameter(".extra_servicio"));
            carga_informacion_servicio(1);
            set_option("modalidad", 1);
            set_option("nuevo", 0);
            break;

        case 1:

            if (is_mobile()) {
                $menu.addClass('d-none');
            }
            let x = (is_mobile() == 1) ? despliega([".btn_agregar_servicios", ".btn_servicios"], 0) : "";
            set_option("modalidad", 0);
            set_option("nuevo", 1);
            despliega([".contenedor_articulos_mobil"], 0);
            break;
        case 0:

            carga_servicios();
            set_option("modalidad", 1);
            set_option("nuevo", 0);
            break;
        default:
            break;
    }
};

let add_cancelar_movil = () => {
    empty_elements([".add_cancelar"]);
    if (is_mobile() == 1 && get_parameter(".nueva_categoria_producto") !== undefined) {
        let btn_cancelar = "<div class='cancelar_registro'>REGRESAR</div>";
        render_enid(".add_cancelar", btn_cancelar);
        $(".cancelar_registro").click(cancelar_registro);
    }
};


let carga_sugerencias_meta_key_words = () => {
    let url = "../q/index.php/api/metakeyword/metakeyword_catalogo/format/json/";
    let data_send = {"v": 1};
    request_enid("GET", data_send, url, muestra_sugerencias_meta_key_words);
};


let muestra_sugerencias_meta_key_words = function (data) {

    render_enid(".contenedor_sugerencias_tags", data);
    let tag_servicio_registrados = $('.tag_servicio');
    let arr_registros = [];
    $.each(tag_servicio_registrados, function (i, val) {
        arr_registros.push(get_parameter_enid($(this), "id"));
    });

    if (arr_registros.length > 0) {
        let tag_sugerencias = $('.tag_catalogo');
        let arr_sugerencias = [];
        let x = 0;

        $.each(tag_sugerencias, function (i, val) {
            for (let i = 0; i < arr_registros.length; i++) {

                if (get_parameter_enid($(this), "id") == arr_registros[i]) {
                    despliega([val], 0);
                }
            }
        });
    }
    $(".tag_catalogo").click(auto_complete_metakeyword);
};
let auto_complete_metakeyword = function (e) {

    let tag = get_parameter_enid($(this), "id");
    $(".metakeyword_usuario").val(tag);
    $(".form_tag").submit();
};

let carga_tallas = () => {

    let url = "../q/index.php/api/clasificacion/tallas_servicio/format/json/";
    let data_send = {"id_servicio": get_option("servicio"), "nivel": 3, "v": 1};
    request_enid("GET", data_send, url, muestra_clasificaciones_servicio);
};

let muestra_clasificaciones_servicio = (data) => {

    if (array_key_exists("options", data)) {
        render_enid(".place_tallas_disponibles", data.options);
        $(".talla_servicio").click(actualiza_talla_servicio);
    }
};

let actualiza_talla_servicio = function () {

    let id = get_parameter_enid($(this), "id");
    let existencia = get_parameter_enid($(this), "existencia");
    if (id > 0) {
        let url = "../q/index.php/api/servicio/talla/format/json/";
        let data_send = {
            "id_servicio": get_option("servicio"),
            "id_talla": id,
            "existencia": existencia
        };
        request_enid("PUT", data_send, url, carga_tallas);
    }
};
let set_tiempo_entrega = () => {

    let tiempo_entrega = get_valor_selected(".tiempo_entrega");
    let url = "../q/index.php/api/servicio/tiempo_entrega/format/json/";
    let data_send = {
        "id_servicio": get_option("servicio"),
        "tiempo_entrega": tiempo_entrega
    };
    request_enid("PUT", data_send, url, respuesta_tiempo_entrega, ".response_tiempo_entrega");


};

let respuesta_tiempo_entrega = () => {

    $(".response_tiempo_entrega").empty();

};
let place_load_imgimagen_principal = function () {

    let id = get_parameter_enid($(this), "id");
    if (id > 0) {

        let url = "../q/index.php/api/imagen_servicio/principal/format/json/";
        let data_send = {"id_servicio": get_option("servicio"), "id_imagen": id};
        request_enid("PUT", data_send, url, carga_informacion_servicio(1), ".place_servicios");
    }
};
let set_url_ml = () => {

    let url_ml = get_parameter(".url_mercado_libre");
    if (url_ml.length > 5) {

        let url = "../q/index.php/api/servicio/url_ml/format/json/";
        let data_send = {"id_servicio": get_option("servicio"), "url": url_ml};

        request_enid("PUT", data_send, url, carga_informacion_servicio(4), ".place_servicios", function () {
            recorre(".url_mercado_libre");

        });
    } else {
        focus_input(".url_mercado_libre");
    }

};
let activa_publicacion = function () {
    let status = get_parameter_enid($(this), "status");
    let id_servicio = get_parameter_enid($(this), "id");
    let data_send = {"status": status, "id_servicio": id_servicio};
    let url = "../q/index.php/api/servicio/status/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

};
let activa_visibilidad = function () {
    let status = get_parameter_enid($(this), "es_publico");
    let id_servicio = get_parameter_enid($(this), "id");
    let data_send = {"es_publico": status, "id_servicio": id_servicio};
    let url = "../q/index.php/api/servicio/espublico/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

};


let descartar_promocion = function () {

    let id_servicio = get_parameter_enid($(this), "id");

    if (id_servicio > 0) {
        set_option("id_servicio", id_servicio);
        show_confirm("NO SE PUBLICARÁ MÁS ESTE ARTÍCULO ¿ESTAS DE ACUERTO?", "", "SI, DESCARTAR PROMOCIÓN", descarta_promocion);

    }
};
let descarta_promocion = () => {


    let id_servicio = get_option("id_servicio");
    let data_send = {"status": 1, "id_servicio": id_servicio};
    let url = "../q/index.php/api/servicio/status/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_servicios();
    });

};
let muestra_cambio_link_dropshipping = (id_servicio) => {
    showonehideone(".input_link_dropshipping", ".text_link_dropshipping");

};
let modifica_dropshipping = (e) => {

    let data_send = $(".form_dropshipping").serialize();
    let url = "../q/index.php/api/servicio/dropshiping/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });
    e.preventDefault();
};
let set_cantidad_en_stock = () => {

    let stock = $('.form_stock_select').find(".stock").val();
    let id_servicio = get_parameter(".id_servicio");
    let data_send = $.param({"stock": stock, "id_servicio": id_servicio});
    let url = "../q/index.php/api/servicio/stock/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

};
let contra_entrega = (opcion, servicio) => {

    let data_send = {"opcion": opcion, "servicio": servicio};
    let url = "../q/index.php/api/servicio/contra_entrega/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

};
let retorno = () => {

    let s = get_option("s");
    switch (s) {

        case 1:

            window.location = document.referrer;

            break;

        case 2:

            carga_servicios();
            break;

        case 3:

            carga_informacion_servicio();

            break;

        case 4:

            window.location = "";

            break;


        default:

            break;
    }
};
let puntos_venta = () => {

    let url = "../q/index.php/api/linea_metro/disponibilidad/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, r_lineas);
};
let r_lineas = function (data) {

    render_enid(".place_puntos_venta", data);
    $(".agregar_linea").click(agregar_linea);
    $(".quitar_linea").click(quitar_linea);
    $(".puntos_encuentro").click(puntos_encuentro);


};
let agregar_linea = function () {

    let id = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/linea_lista_negra/index/format/json/";
    let data_send = {"lista_negra": 0, "id": id};
    request_enid("PUT", data_send, url, puntos_venta);
};
let quitar_linea = function () {

    let id = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/linea_lista_negra/index/format/json/";
    let data_send = {"lista_negra": 1, "id": id};
    request_enid("PUT", data_send, url, puntos_venta);
};
let puntos_encuentro = function () {

    let id = (get_parameter_enid($(this), "id") > 0) ? get_parameter_enid($(this), "id") : get_option("id_punto_encuentro");
    set_option("id_punto_encuentro", id);
    if (id > 0) {

        let url = "../q/index.php/api/punto_encuentro/disponibilidad/format/json/";
        let data_send = {"id": id, "v": 1};
        request_enid("GET", data_send, url, r_puntos_encuentro);
    }
};
let r_puntos_encuentro = function (data) {

    render_enid(".place_puntos_venta", data);
    $(".quitar_punto").click(quitar_punto);
    $(".agregar_punto").click(agregar_punto);


};
let quitar_punto = function () {


    let id = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/lista_negra_encuentro/index/format/json/";
    let data_send = {"lista_negra": 1, "id": id};
    request_enid("PUT", data_send, url, puntos_encuentro);

};
let agregar_punto = function () {


    let id = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/lista_negra_encuentro/index/format/json/";
    let data_send = {"lista_negra": 0, "id": id};
    request_enid("PUT", data_send, url, puntos_encuentro);
};
let restablecer = function () {

    let id = get_parameter_enid($(this), "id");
    if (id > 0) {
        set_option("id_servicio", id);
        show_confirm("SE RE INICIARÁN LOS VALORES DE LA PUBLICACIÓN ¿ESTAS DE ACUERTO?", "", "SI, RE INICIAR PROMOCIÓN", restablecer_promocion);

    }


};
let restablecer_promocion = function () {


    let id = get_option("id_servicio");
    let url = "../q/index.php/api/servicio/restablecer/format/json/";
    let data_send = {"id": id};
    request_enid("PUT", data_send, url, () => {
        carga_informacion_servicio();
    });


};
let enter_precio = function (e) {

    if (e.keyCode === 13) {
        $form_nombre_producto.submit();
    }
};
let registro_comision = function (e) {

    e.preventDefault();
    let data_send = $('.form_comision_venta').serialize();
    let url = "../q/index.php/api/servicio/comision/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

};
let busqueda_posibles_relaciones = function (e) {

    let keycode = e.keyCode;

    if (keycode === 13) {

        let url = "../q/index.php/api/servicio/relacionados/format/json/";
        let ids_relacionados = $('.ids_relacionados').val();
        let  ids = (ids_relacionados.length > 0) ? ids_relacionados : 0;
        let data_send = {
            "q": $('.busqueda_producto_relacionado').val(),
            "page": 1,
            "order": 1,
            "global": 0,
            "id_servicio": get_option("servicio"),
            "ids_relacionados": ids
        };

        request_enid("GET", data_send, url, respuesta_busqueda_servicio, ".place_servicios", () => {

        });

    }

}
let quitar_servicio_relacionado = function (e) {

    let id_servicio_relacion = e.target.id;
    let id_servicio = get_option("servicio");

    let url = "../q/index.php/api/servicio_relacion/index/format/json/";
    let data_send = {
        'id_servicio_relacion': id_servicio_relacion,
        'id_servicio_dominante': id_servicio
    };

    request_enid("DELETE", data_send, url, function () {
        carga_informacion_servicio(5);
    });


}

let respuesta_busqueda_servicio = function (data) {

    render_enid('.lista_productos_relacionados', data);
    $('.boton_agregar_articulo').click(relacionar_servicio);

}
let relacionar_servicio = function (e) {

    let id_servicio_relacion = e.target.id;
    let id_servicio = get_option("servicio");

    let url = "../q/index.php/api/servicio_relacion/index/format/json/";
    let data_send = {
        'id_servicio_relacion': id_servicio_relacion,
        'id_servicio_dominante': id_servicio
    };

    request_enid("POST", data_send, url, function () {
        carga_informacion_servicio(5);
    });

}