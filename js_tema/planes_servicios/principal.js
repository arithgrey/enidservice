"use strict";
$(document).ready(function () {
    set_option("page", 1);
    $("footer").ready(valida_action_inicial);
    $(".btn_servicios").click(carga_servicios);
    $(".tipo_promocion").click(configuracion_inicial);
    $(".form_nombre_producto").submit(simula_envio);
    $(".btn_agregar_servicios").click(function () {
        showonehideone(".contenedor_nombre", ".contenedor_categorias");
        set_option("nuevo", 1);
        display_elements([".texto_ventas_titulo"], 1);
    });
    $(".li_menu_servicio").click(function () {
        display_elements([".btn_agregar_servicios", ".contenedor_top"], 1);
    });
    display_elements([".contenedor_busqueda_global_enid_service"], 0);
    $(".ci_facturacion").change(evalua_precio);
    $(".cancelar_registro").click(cancelar_registro);
    def_contenedores();
});

var def_contenedores = function() {

    var secciones = ["selected_2", "selected_3", "selected_4", "selected_5", "selected_6", "selected_7", "primer_nivel", "segundo_nivel", "tercer_nivel", "cuarto_nivel", "quinto_nivel"];
    for (var x in secciones) {
        set_option(secciones[x], 0);
    }
}
var cancelar_carga_imagen = function() {
    showonehideone(".contenedor_global_servicio", ".contenedor_agregar_imagenes");
}

var cancelar_registro = function() {
    showonehideone(".contenedor_agregar_servicio_form", ".contenedor_categorias_servicios");
}

var carga_servicios = function() {

    display_elements([".texto_ventas_titulo", ".contenedor_busqueda", ".contenedor_busqueda_articulos"], 1);
    var url = "../q/index.php/api/servicio/empresa/format/json/";
    var orden = get_parameter("#orden");
    var data_send = {
        "q": get_parameter(".q_emp"),
        "id_clasificacion": get_option("id_clasificacion"),
        "page": get_option("page"),
        "order": orden
    };

    request_enid("GET", data_send, url, respuesta_carga_servicios, ".place_servicios", function () {

        show_load_enid(".place_servicios", "", "");
        recorrepage(".contenedor_principal_enid");
    });
}

var respuesta_carga_servicios = function(data) {

    if (data.num_servicios != undefined) {
        llenaelementoHTML(".place_servicios", data.info_servicios);
    } else {

        llenaelementoHTML(".place_servicios", data);
        $(".servicio").click(carga_info_servicio);
        $(".pagination > li > a, .pagination > li > span").click(function (e) {
            var page_html = $(this);
            var num_paginacion = $(page_html).attr("data-ci-pagination-page");
            if (validar_si_numero(num_paginacion) == true) {
                set_option("page", num_paginacion);
            } else {
                num_paginacion = $(this).text();
                set_option("page", num_paginacion);
            }
            carga_servicios();
            e.preventDefault();
        });
        recorrepage(".contenedor_principal_enid");
    }
}

var carga_info_servicio = function(e) {

    set_option("servicio", get_parameter_enid($(this), "id"));
    if (get_option("servicio") > 0) {
        carga_informacion_servicio(1);
    }
}

var carga_informacion_servicio = function(num = 1) {

    display_elements([".contenedor_busqueda"], 0);
    var url = "../q/index.php/api/servicio/especificacion/format/json/";
    var data_send = {id_servicio: get_option("servicio"), "num": num};
    request_enid("GET", data_send, url, respuesta_informacion_servicio, ".place_servicios", function () {
        recorrepage(".contenedor_principal_enid");

    });
}

var respuesta_informacion_servicio = function(data) {

    llenaelementoHTML(".place_servicios", data);
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
    $(".imagen_principal").click(set_imagen_principal);
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
    $(".detalle").click(carga_tallas);
    $(".activar_publicacion").click(activa_publicacion);
    $(".tiempo_entrega").change(set_tiempo_entrega);
    $(".btn_url_ml").click(set_url_ml);

    $(".form_dropshipping").submit(modifica_dropshipping);
    if (get_option("flag_nueva_categoria") == 1) {
        recorrepage("#seccion_metakeywords_servicio");
    }
    if (get_option("flag_recorrido") != undefined) {
        recorrepage(get_option("seccion_a_recorrer"));
    }
    $(".descartar_promocion").click(descartar_promocion);
    $(".stock").change(set_cantidad_en_stock);
    $('#summernote').summernote();
    display_elements([".contenedor_busqueda_articulos", ".agregar_servicio btn_agregar_servicios", ".titulo_articulos_venta"], 0);


}
var actualiza_entregas_en_casa = function(e) {

    var url = "../q/index.php/api/servicio/entregas_en_casa/format/json/";
    var data_send = {entregas_en_casa: get_parameter_enid($(this), "id"), id_servicio: get_option("servicio")};
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}


var actualiza_telefono_visible = function() {
    var url = "../q/index.php/api/servicio/telefono_visible/format/json/";
    var data_send = {telefono_visible: get_parameter_enid($(this), "id"), id_servicio: get_option("servicio")};
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}


var actualiza_ventas_mayoreo = function(e) {

    var url = "../q/index.php/api/servicio/ventas_mayoreo/format/json/";
    var data_send = {venta_mayoreo: get_parameter_enid($(this), "id"), id_servicio: get_option("servicio")};
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    }, ".place_sobre_el_negocio");
}


var muestra_input_costo = function() {

    var visible = $(".text_costo").is(":visible");
    if (visible == true) {
        showonehideone(".input_costo", ".text_costo");
    } else {
        showonehideone(".input_costo", ".text_costo");
    }
}


var muestra_input_producto_nuevo = function() {


    if ($(".text_nuevo").is(":visible") == true) {
        showonehideone(".input_nuevo", ".text_nuevo");
    } else {
        showonehideone(".input_nuevo", ".text_nuevo");
    }
}

var muestra_input_ciclo_facturacion = function() {


    if ($(".text_ciclo_facturacion").is(":visible") == true) {
        showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
    } else {
        showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
    }
}

var muestra_input_cantidad = function() {


    if ($(".text_cantidad").is(":visible") == true) {
        showonehideone(".input_cantidad", ".text_cantidad");
    } else {
        showonehideone(".input_cantidad", ".text_cantidad");
    }
}

var muestra_input_incluye_envio = function() {


    if ($(".contenedor_informacion_envio").is(":visible")  == true) {
        showonehideone(".input_envio", ".contenedor_informacion_envio");
    } else {
        showonehideone(".input_envio", ".contenedor_informacion_envio");
    }
}


var muestra_select_ciclo_facturacion  = function(e) {

    set_option("id_ciclo_facturacion", get_parameter_enid($(this), "id"));
    var visible = $(".text_ciclo_facturacion").is(":visible");
    var x = (visible == true) ? showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion") : showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
}


var muestra_seccion_nombre_servicio = function(e) {

    var visible = $(".text_nombre_servicio").is(":visible");
    var x = (visible == true) ? showonehideone(".input_nombre_servicio_facturacion", ".text_nombre_servicio") : showonehideone(".input_nombre_servicio_facturacion", ".text_nombre_servicio");
}


var muestra_seccion_video_servicio = function() {

    var visible = $(".text_video_servicio").is(":visible");
    var x = (visible == true) ? showonehideone(".input_url_youtube", ".text_video_servicio") : showonehideone(".input_url_youtube", ".text_video_servicio");
}


var muestra_seccion_video_servicio_facebook = function() {
    var visible = $(".text_video_servicio_facebook").is(":visible");
    var x = (visible == true) ? showonehideone(".input_url_facebook", ".text_video_servicio_facebook") : showonehideone(".input_url_facebook", ".text_video_servicio_facebook");
}


var muestra_seccion_desc_servicio = function(e) {

    var visible = $(".text_desc_servicio").is(":visible");
    var x = (visible == true) ? showonehideone(".input_desc_servicio_facturacion", ".text_desc_servicio") : showonehideone(".input_desc_servicio_facturacion", ".text_desc_servicio");
}


var muestra_input_color = function(e) {

    var visible = $(".text_agregar_color").is(":visible");
    if (visible == true) {

        showonehideone(".input_servicio_color", ".text_agregar_color");
        carga_listado_colores();
    } else {
        showonehideone(".input_servicio_color", ".text_agregar_color");
    }
}
var registra_costo_servicio = function(e) {

    var url = "../q/index.php/api/servicio/costo/format/json/";
    var data_send = $(".form_costo").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(4)
    });
    e.preventDefault();
}

var actualiza_dato_servicio  = function(e) {

    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $(".form_servicio_nombre_info").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });

    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(1);

    });
    e.preventDefault();
}
var actualiza_dato_url_venta = function(e) {
    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $(".form_servicio_url_venta").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(1);
    });
    e.preventDefault();
}


var actualiza_dato_servicio_afiliado = function(e) {

    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $(".form_servicio_afiliados").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(1);
    });
    e.preventDefault();
}


var valida_url_youtube = function() {

    var url = get_parameter(".url_youtube");
    var text_youtube = "youtu";

    var input = ".url_youtube";
    var place_msj = ".place_url_youtube";
    var mensaje_user = "Url no valida!, ingrese url de youtube <span class='url_youtube_alert'><i class='fa fa-youtube-play'></i> Youtube! </span>";

    if (url.indexOf(text_youtube) != -1) {
        $(place_msj).empty();
        return 1;
    } else {

        $(input).css("border", "1px solid rgb(13, 62, 86)");
        llenaelementoHTML(place_msj, "<span class='alerta_enid'>"
            + mensaje_user + "</span>");
        return 0;
    }

}

var actualiza_dato_servicio_youtube = function(e) {
    if (valida_url_youtube() == 1) {
        /* Validamos que la url realmente sea de youtube */
        var url = "../q/index.php/api/servicio/q/format/json/";
        var data_send = $(".form_servicio_youtube").serialize() + "&" + $.param({
            "id_servicio": get_option("servicio")
        });
        request_enid("PUT", data_send, url, function (data) {
            carga_informacion_servicio(1);
        });
    }
    e.preventDefault();
}


var actualiza_dato_servicio_facebook = function(e) {
    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $(".form_servicio_facebook").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(1);
    });
    e.preventDefault();
}


var actualiza_dato_servicio_desc = function(e) {
    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $(".form_servicio_desc").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio"),
        "q2": $(".note-editable").html()
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(2);
    });
    e.preventDefault();
}


var registrar_ciclo_facturacion = function(e) {

    var url = "../q/index.php/api/servicio/ciclo_facturacion/format/json/";
    var data_send = $(".form_ciclo_facturacion").serialize() + "&" + $.param({
        "id_servicio": get_option("servicio")
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });
    e.preventDefault();
}

var carga_grupos = function() {
    var url = "../q/index.php/api/servicio/grupos/format/json/";
    var data_send = {};
    request_enid("GET", data_send, url, respuesta_grupos);
}


var respuesta_grupos = function(data) {
    llenaelementoHTML(".place_grupos", data);
    $(".grupo").change(function () {
        var nuevo_grupo = get_parameter(".grupo");
        set_option("nuevo_grupo", nuevo_grupo);
        carga_info_grupos();
    });
    carga_info_grupos();
}


var carga_info_grupos = function() {

    var grupo = get_option("grupo");
    if (grupo == 0) {
        var grupo = get_parameter(".grupo");
        set_option("grupo", grupo);
    }
    var url = "../q/index.php/api/servicio/grupo/format/json/";
    var data_send = {grupo: get_option("grupo")};
    request_enid("GET", data_send, url, respuesta_info_grupos);

}
var respuesta_info_grupos = function(data) {
    llenaelementoHTML(".place_info_grupos", data);
    $(".servicio").click(carga_info_servicio);
    $(".nuevo_grupo_servicios").click(carga_form_nuevo_grupo);
    $(".agregar_servicios_grupo").click(agregar_servicio_grupo);
}

var carga_form_nuevo_grupo = function() {

    var url = "../q/index.php/api/servicio/grupo_form/format/json/";
    var data_send = {};
    request_enid("GET", data_send, url, respuesta_nuevo_grupo, ".place_info_grupos");
}
var respuesta_nuevo_grupo = function(data) {
    llenaelementoHTML(".place_grupos", data);
    $(".form_grupo_sistema").submit(agregar_grupo_sistema);
}
var agregar_grupo_sistema = function (e) {
    var url = "../q/index.php/api/servicio/grupo_form/format/json/";
    var data_send = $(".form_grupo_sistema").serialize();
    request_enid("POST", data_send, url, respuesta_grupo_sistema, ".place_info_grupos", "Cargando ... ");
    e.preventDefault();
}
var respuesta_grupo_sistema = function(data) {
    set_option("grupo", data);
    carga_grupos();
    carga_info_grupos();
}
var agregar_servicio_grupo = function(e) {

    $("#seccion_izquierda_grupos").removeClass("col-lg-11");
    $("#seccion_izquierda_grupos").addClass("col-lg-6");
    $("#seccion_derecha_grupos").removeClass("col-lg-1");
    $("#seccion_derecha_grupos").addClass("col-lg-6");
    cargar_lista_servicios_grupo();
}


var cargar_lista_servicios_grupo = function() {
    var url = "../q/index.php/api/servicio/servicios_grupo/format/json/";
    var data_send = {grupo: get_option("grupo")};
    request_enid("GET", data_send, url, respuestas_cargar_lista_servicios, ".place_servicios_en_grupos");
}


var respuestas_cargar_lista_servicios = function(data) {
    llenaelementoHTML(".place_servicios_en_grupos", data);
    $(".grupo_servicio").click(agrega_quita_servicio_grupo);
}


var agrega_quita_servicio_grupo = function(e) {
    var id_servicio = get_parameter_enid($(this), "id");
    set_option("servicio", id_servicio);
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "grupo": get_option("grupo")
    });

    var url = "../q/index.php/api/servicio/servicio_grupo/format/json/";
    request_enid("PUT", data_send, url, carga_grupos);
}


var muestra_seccion_url_pagina_web = function() {

    if ( $(".text_pagina_venta").is(":visible") == true) {
        showonehideone(".input_url_pagina_web", ".text_pagina_venta");
    } else {
        showonehideone(".input_url_pagina_web", ".text_pagina_venta");
    }
}

var muestra_seccion_porcentaje_ganancia = function () {


    if ($(".text_porcentaje_ganancia").is(":visible") == true) {
        showonehideone(".input_porcentaje_ganancia",
            ".text_porcentaje_ganancia");
    } else {
        showonehideone(".input_porcentaje_ganancia",
            ".text_porcentaje_ganancia");
    }
}

var muestra_seccion_porcentaje_ganancia_afiliados = function() {


    if ($(".text_porcentaje_ganancias_afiliados").is(":visible") == true) {
        showonehideone(".input_porcentaje_ganancia_afiliados",
            ".text_porcentaje_ganancias_afiliados");
    } else {
        showonehideone(".input_porcentaje_ganancia_afiliados",
            ".text_porcentaje_ganancias_afiliados");
    }
}

var configuracion_inicial = function(e) {


    set_option("modalidad", get_parameter_enid($(this), "id"));
    if (get_option("modalidad") == 1) {
        set_option("id_ciclo_facturacion", 9);
        $(".text_modalidad").text("Servicio");
        $(".tipo_producto").css("color", "black");
        $(".tipo_servicio").css("color", "blue");
        selecciona_select(".ci_facturacion", 9);
        $(".precio").val(0);
        display_elements([".contenedor_ciclo_facturacion", ".siguiente_btn"], 1);
        display_elements([".contenedor_precio"], 0);

    } else {

        set_option("id_ciclo_facturacion", 5);
        $(".text_modalidad").text("Artículo/Producto");
        $(".tipo_producto").css("color", "blue");
        $(".tipo_servicio").css("color", "black");
        display_elements([".contenedor_precio"], 1);
        display_elements([".contenedor_ciclo_facturacion"], 0);


    }
}


var simula_envio = function(e) {

    var costo = get_parameter(".costo");
    var next = (get_option("modalidad") == 0 && costo == 0) ? 0 : 1;

    if (next) {

        showonehideone(".contenedor_categorias", ".contenedor_nombre");
        display_elements([".contenedor_top"], 0);
        set_nombre_servicio_html(get_parameter(".nuevo_producto_nombre"));
        set_option("costo", costo);
        $(".extra_precio").text("");
        verifica_existencia_categoria();
    } else {
        $("#costo").css("border", "1px solid rgb(13, 62, 86)");
        $(".extra_precio").text("INGRESA EL PRECIO DEL PRODUCTO");
    }
    e.preventDefault();
}
var verifica_existencia_categoria = function() {

    var url = "../q/index.php/api/servicio/verifica_existencia_clasificacion/format/json/";
    var nombre = get_parameter(".nuevo_producto_nombre");
    var data_send = {clasificacion: nombre, id_servicio: get_option("modalidad")};
    request_enid("GET", data_send, url, listar_categorias);
}

var def_categorias = function() {

    for (var i = 1; i < 6; i++) {
        var agregar_categoria_def = "agregar_categoria_" + i;
        set_option(agregar_categoria_def, 0);
    }
}

var listar_categorias = function(data) {

    def_categorias();
    if (array_key_exists("total", data) == true && data.total > 0) {
        var categorias = data.categorias;
        if (array_key_exists(1, categorias) == true && categorias[1].nivel != undefined && categorias[1].nivel == 1) {

            var data_categorias = categorias;
            var keys = getObjkeys(data_categorias);
            var posicion_final = getMaxOfArray(keys);

            for (var a in data_categorias) {

                var nivel = parseInt(data_categorias[a].nivel);
                var id_clasificacion = parseInt(data_categorias[a].id_clasificacion);
                var agregar_categoria_ = "agregar_categoria_" + posicion_final;
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

}


var set_nombre_servicio_html = function(n_nombre_servicio) {
    set_option("nombre_servicio", n_nombre_servicio);
    var nombre_servicio = n_nombre_servicio;
    $(".nombre_producto").val(n_nombre_servicio);
}

var clean_data_categorias = function() {

    empty_elements([".segundo_nivel_seccion", ".tercer_nivel_seccion", ".cuarto_nivel_seccion", ".quinto_nivel_seccion", ".sexto_nivel_seccion"]);
    set_option("nivel", 1);
    set_option("padre", 0);
    showonehideone(".contenedor_categorias_servicios", ".contenedor_agregar_servicio_form");
}

var carga_listado_categorias = function() {

    var nombre = get_parameter(".nuevo_producto_nombre");
    clean_data_categorias();
    var data_send = {
        "modalidad": get_option("modalidad"),
        "padre": 0,
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile(),
        "nombre": nombre
    };
    var url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    request_enid("GET", data_send, url, respuestas_primer_nivel, ".primer_nivel_seccion");
}


var respuestas_primer_nivel = function(data) {

    llenaelementoHTML(".primer_nivel_seccion", data);
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
}

var carga_listado_categorias_segundo_nivel =  function() {

    set_option("nivel", 2);
    var url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    if (get_option("selected_2") == 0) {
        set_option("padre", get_parameter(".nivel_1 option:selected"));
    }
    set_option("primer_nivel", get_parameter(".nivel_1 option:selected"));
    empty_elements([".segundo_nivel_seccion", ".tercer_nivel_seccion", ".cuarto_nivel_seccion", ".quinto_nivel_seccion", ".sexto_nivel_seccion"]);
    var data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestra_segundo_nivel, ".segundo_nivel_seccion");
}

var muestra_segundo_nivel = function(data) {

    llenaelementoHTML(".segundo_nivel_seccion", data);
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

}
var carga_listado_categorias_tercer_nivel = function() {


    empty_elements([".cuarto_nivel_seccion", ".quinto_nivel_seccion", ".sexto_nivel_seccion"]);
    var url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("nivel", 3);
    if (get_option("selected_3") == 0) {
        var n_padre = get_parameter(".nivel_2 option:selected");
        set_option("padre", n_padre);
    }
    set_option("segundo_nivel", get_parameter(".nivel_2 option:selected"));
    var data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestra_t_nivel, ".tercer_nivel_seccion");
}

var muestra_t_nivel = function(data) {

    llenaelementoHTML(".tercer_nivel_seccion", data);
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
}
var carga_listado_categorias_cuarto_nivel = function() {

    var url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("nivel", 4);
    $(".quinto_nivel_seccion").empty();
    $(".sexto_nivel_seccion").empty();

    if (get_option("selected_4") == 0) {
        set_option("padre", get_parameter(".nivel_3 option:selected"));
    }
    set_option("tercer_nivel", get_parameter(".nivel_3 option:selected"));
    var data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestras_c_nivel, ".cuarto_nivel_seccion");
}

var muestras_c_nivel = function(data) {

    llenaelementoHTML(".cuarto_nivel_seccion", data);
    if (get_option("selected_4") == 1) {
        selecciona_valor_select(".nivel_4", get_option("selected_num_4"));
    }
    $(".cuarto_nivel_seccion .nivel_4").change(carga_listado_categorias_quinto_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    recorrepage(".cuarto_nivel_seccion");

    if (array_key_exists("agregar_categoria_4", option) && get_option("agregar_categoria_4") == 1) {
        carga_listado_categorias_quinto_nivel();
        set_option("agregar_categoria_4", 0);
    }
    add_cancelar_movil();
}


var carga_listado_categorias_quinto_nivel = function() {

    var url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("nivel", 5);
    $(".sexto_nivel_seccion").empty();
    if (get_option("selected_5") == 0) {
        var n_padre = get_parameter(".nivel_4 option:selected");
        set_option("padre", n_padre);
    }
    set_option("cuarto_nivel", get_parameter(".nivel_4 option:selected"));
    var data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    request_enid("GET", data_send, url, muestra_q_nivel, ".quinto_nivel_seccion");
}


var muestra_q_nivel = function(data) {

    llenaelementoHTML(".quinto_nivel_seccion", data);
    $(".quinto_nivel_seccion .nivel_5").change(carga_listado_categorias_sexto_nivel);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    recorrepage(".quinto_nivel_seccion");
    if (array_key_exists("agregar_categoria_5", option) && get_option("agregar_categoria_5") == 1) {
        carga_listado_categorias_sexto_nivel();
        set_option("agregar_categoria_5", 0);
    }
    add_cancelar_movil();
}


var carga_listado_categorias_sexto_nivel = function() {
    var url = "../q/index.php/api/servicio/lista_categorias_servicios/format/json/";
    set_option("padre", padre);
    set_option("nivel", 6);
    empty_elements([".sexto_nivel"]);
    var data_send = {
        "modalidad": get_option("modalidad"),
        "padre": get_option("padre"),
        "nivel": get_option("nivel"),
        "is_mobile": is_mobile()
    };
    set_option("quinto_nivel", get_parameter(".nivel_5 option:selected"));
    request_enid("GET", data_send, url, muestra_sexo_nivel, ".sexto_nivel_seccion");
}


var muestra_sexo_nivel = function(data) {

    llenaelementoHTML(".sexto_nivel_seccion", data);
    $(".nueva_categoria_producto").click(agregar_categoria_servicio);
    set_option("agregar_categoria_6", 0);
    add_cancelar_movil();
}

var agregar_categoria_servicio = function() {

    var id_clasificacion = get_parameter_enid($(this), "id");
    set_option("id_clasificacion", id_clasificacion);
    var id_ciclo_facturacion = (get_option("modalidad") == 0) ? 5 : get_parameter("#ciclo");
    set_option("id_ciclo_facturacion", id_ciclo_facturacion);
    registra_nuevo_servicio();
}


var registra_nuevo_servicio = function() {

    var url = "../q/index.php/api/servicio/index/format/json/";
    var data_send = {
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
}
var response_registro = function(data) {

    if (data.registro != 0 && data.registro.servicio > 0) {
        set_option("servicio", data.registro.servicio);
        carga_informacion_servicio(1);
        $("#tab_productividad").tab("show");
        $(".btn_serv").tab("show");
        if (is_mobile() != 1) {
            reset_form("form_nombre_producto");
            display_elements([".btn_agregar_servicios"], 1);
        }
    } else {
        redirect("../planes_servicios/?action=nuevo&mensaje=" + data.registro.mensaje);
    }

}
var elimina_foto_producto = function(e) {

    var url = "../q/index.php/api/imagen_servicio/index/format/json/";
    if (get_parameter_enid($(this), "id") > 0) {
        var data_send = {"id_imagen": get_parameter_enid($(this), "id"), "id_servicio": get_option("servicio")};
        request_enid("DELETE", data_send, url, function () {
            carga_informacion_servicio(1);
        }, ".place_servicios");
    }
}
var agrega_metakeyword = function(e) {

    var url = "../q/index.php/api/servicio/metakeyword_usuario/format/json/";
    var data_send = $(".form_tag").serialize();
    request_enid("POST", data_send, url, respuesta_agrega_metakeyword);

    e.preventDefault();
}


var respuesta_agrega_metakeyword = function(data) {
    set_option("flag_nueva_categoria", 1);
    carga_informacion_servicio(3);
    carga_sugerencias_meta_key_words();
}

var eliminar_tag = function(text, id_servicio) {

    var url = "../q/index.php/api/servicio/metakeyword_usuario/format/json/";
    var data_send = {"tag": text, "id_servicio": id_servicio};
    request_enid("DELETE", data_send, url, respuesta_eliminar_tags);
}

var respuesta_eliminar_tags = function(data) {

    carga_informacion_servicio(3);
    carga_sugerencias_meta_key_words();
}

var  onkeyup_colfield_check = function(e) {
    var enterKey = 13;
    if (e.which == enterKey) {
        set_option("page", 1);
        carga_servicios();
    }
}
var actualiza_servicio_usado = function() {

    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "q2": get_parameter(".producto_nuevo"),
        "q": "flag_nuevo"
    });
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });
}

var actualiza_envio_incluido = function() {

    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "q2": get_parameter(".input_envio_incluido"),
        "q": "flag_envio_gratis"
    });
    request_enid("PUT", data_send, url, respuestas_actualiza_envio_incluido);
}


var respuestas_actualiza_envio_incluido = function(data) {
    carga_informacion_servicio(4);
    set_option("flag_recorrido", 1);
    set_option("seccion_a_recorrer", ".text_info_envio");
}


var  actualiza_ciclo_facturacion = function() {

    set_option("id_ciclo_facturacion", get_parameter(".ciclo_facturacion"));
    var url = "../q/index.php/api/servicio/ciclo_facturacion/format/json/";
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "ciclo_facturacion": get_option("id_ciclo_facturacion")
    });
    request_enid("PUT", data_send, url, function (data) {
        carga_informacion_servicio(4);
    });
}

var actualiza_cantidad = function() {

    set_option("existencia", get_parameter(".existencia"));
    var url = "../q/index.php/api/servicio/q/format/json/";
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "q2": get_option("existencia"),
        "q": "existencia"
    });
    request_enid("PUT", data_send, url, respuesta_actualiza_cantidad);
}

var respuesta_actualiza_cantidad = function() {
    carga_informacion_servicio(4);
    set_option("seccion_a_recorrer", ".text_cantidad");
    set_option("flag_recorrido", 1);
}


var agrega_color_servicio = function(e) {

    var color = get_parameter_enid($(this), "id");
    set_option("color", color);
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "color": get_option("color")
    });
    var url = "../q/index.php/api/servicio/color/format/json/";
    request_enid("POST", data_send, url, respuesta_agregar_color);
}


var respuesta_agregar_color = function(data) {
    carga_informacion_servicio(2);
    set_option("seccion_a_recorrer", "#contenedor_colores_disponibles");
    set_option("flag_recorrido", 1);
}

var carga_listado_colores = function() {
    var data_send = {};
    var url = "../q/index.php/api/servicio/colores/format/json/";
    request_enid("GET", data_send, url, respuesta_listado_colores, ".place_colores_disponibles");
}
var respuesta_listado_colores = function(data) {
    llenaelementoHTML(".place_colores_disponibles", data);
    $(".colores").click(agrega_color_servicio);
    recorrepage("#seccion_colores_info");
}
var  elimina_color_servicio = function() {
    var color = get_parameter_enid($(this), "id");
    set_option("color", color);
    var data_send = $.param({
        "id_servicio": get_option("servicio"),
        "color": get_option("color")
    });
    var url = "../q/index.php/api/servicio/color/format/json/";
    request_enid("DELETE", data_send, url, respuesta_eliminar_color);
}
var respuesta_eliminar_color = function(data) {
    carga_informacion_servicio(2);
    set_option("seccion_a_recorrer", "#contenedor_colores_disponibles");
    set_option("flag_recorrido", 1);
}


var  evalua_precio = function() {

    switch (parseInt(get_parameter(".ci_facturacion"))) {
        case 9:

            display_elements([".contenedor_precio"], 0);
            $(".precio").val(0);
            break;
        case 5:
            display_elements([".contenedor_precio"], 0);
            $(".precio").val(0);
            break;
        default:

            display_elements([".contenedor_precio"], 1);
    }
}


var  valida_action_inicial = function() {


    switch (parseInt(get_parameter(".q_action"))) {
        case 2:
            set_option("servicio", get_parameter(".extra_servicio"));
            carga_informacion_servicio(1);
            set_option("modalidad", 1);
            set_option("nuevo", 0);
            break;

        case 1:
            /*Si es version movil recorre pantalla*/
            if (is_mobile() == 1) {
                recorrepage(".contenedor_agregar_servicio_form")
            }
            var x = (is_mobile() == 1) ? display_elements([".btn_agregar_servicios", ".btn_servicios"], 0) : "";
            set_option("modalidad", 0);
            set_option("nuevo", 1);
            display_elements([".contenedor_articulos_mobil"], 0);
            break;
        case 0:

            carga_servicios();
            set_option("modalidad", 1);
            set_option("nuevo", 0);
            break;
        default:
            break;
    }
}

var  add_cancelar_movil = function() {
    empty_elements([".add_cancelar"]);
    if (is_mobile() == 1 && get_parameter(".nueva_categoria_producto") !== undefined) {
        var btn_cancelar = "<div class='cancelar_registro'>REGRESAR</div>";
        llenaelementoHTML(".add_cancelar", btn_cancelar);
        $(".cancelar_registro").click(cancelar_registro);
    }
}


var  carga_sugerencias_meta_key_words = function() {
    var url = "../q/index.php/api/metakeyword/metakeyword_catalogo/format/json/";
    var data_send = {"v": 1};
    request_enid("GET", data_send, url, muestra_sugerencias_meta_key_words);
}


var  muestra_sugerencias_meta_key_words = function(data) {

    llenaelementoHTML(".contenedor_sugerencias_tags", data);
    var tag_servicio_registrados = $('.tag_servicio');
    var arr_registros = [];
    $.each(tag_servicio_registrados, function (i, val) {
        arr_registros.push(get_parameter_enid($(this), "id"));
    });

    if (arr_registros.length > 0) {
        var tag_sugerencias = $('.tag_catalogo');
        var arr_sugerencias = [];
        var x = 0;

        $.each(tag_sugerencias, function (i, val) {
            for (var i = 0; i < arr_registros.length; i++) {

                if (get_parameter_enid($(this), "id") == arr_registros[i]) {
                    display_elements([val], 0);
                }
            }
        });
    }
    $(".tag_catalogo").click(auto_complete_metakeyword);
}
var  auto_complete_metakeyword = function(e) {

    var tag = get_parameter_enid($(this), "id");
    $(".metakeyword_usuario").val(tag);
    $(".form_tag").submit();
}

var  carga_tallas = function() {

    var url = "../q/index.php/api/clasificacion/tallas_servicio/format/json/";
    var data_send = {"id_servicio": get_option("servicio"), "nivel": 3, "v": 1};
    request_enid("GET", data_send, url, muestra_clasificaciones_servicio);
}

var muestra_clasificaciones_servicio = function(data) {

    if (array_key_exists("options", data)) {
        llenaelementoHTML(".place_tallas_disponibles", data.options);
        $(".talla_servicio").click(actualiza_talla_servicio);
    }
}

var  actualiza_talla_servicio = function() {

    var id = get_parameter_enid($(this), "id");
    var existencia = get_parameter_enid($(this), "existencia");
    if (id > 0) {
        var url = "../q/index.php/api/servicio/talla/format/json/";
        var data_send = {"id_servicio": get_option("servicio"), "id_talla": id, "existencia": existencia};
        request_enid("PUT", data_send, url, carga_tallas);
    }
}
var  set_tiempo_entrega = function(){

    var tiempo_entrega = get_valor_selected(".tiempo_entrega");
    var url = "../q/index.php/api/servicio/tiempo_entrega/format/json/";
    var data_send = {"id_servicio": get_option("servicio"), "tiempo_entrega": tiempo_entrega};
    request_enid("PUT", data_send, url, respuesta_tiempo_entrega, ".response_tiempo_entrega");


}

var respuesta_tiempo_entrega = function (data) {

    $(".response_tiempo_entrega").empty();
    debugger;
};
var set_imagen_principal = function () {
    var id = get_parameter_enid($(this), "id");
    if (id > 0) {

        var url = "../q/index.php/api/imagen_servicio/principal/format/json/";
        var data_send = {"id_servicio": get_option("servicio"), "id_imagen": id};
        request_enid("PUT", data_send, url, carga_informacion_servicio(1), ".place_servicios");
    }
};
var set_url_ml = function () {

    var url_ml = get_parameter(".url_mercado_libre");
    if (url_ml.length > 5) {

        var url = "../q/index.php/api/servicio/url_ml/format/json/";
        var data_send = {"id_servicio": get_option("servicio"), "url": url_ml};

        request_enid("PUT", data_send, url, carga_informacion_servicio(4), ".place_servicios", function () {
            recorrepage(".url_mercado_libre");

        });
    } else {
        focus_input(".url_mercado_libre");
    }

};
var activa_publicacion = function () {
    var status = get_parameter_enid($(this), "status");
    var id_servicio = get_parameter_enid($(this), "id");
    var data_send = {"status": status, "id_servicio": id_servicio};
    var url = "../q/index.php/api/servicio/status/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

};
var descartar_promocion = function () {

    var id_servicio = get_parameter_enid($(this), "id");

    if (id_servicio > 0) {
        set_option("id_servicio", id_servicio);
        show_confirm("NO SE PUBLICARÁ MÁS ESTE ARTÍCULO ¿ESTAS DE ACUERTO?", "", "SI, DESCARTAR PROMOCIÓN", descarta_promocion);

    }
};
var descarta_promocion = function () {


    var id_servicio = get_option("id_servicio");
    var data_send = {"status": 1, "id_servicio": id_servicio};
    var url = "../q/index.php/api/servicio/status/format/json/";
    request_enid("PUT", data_send, url, function () {
        carga_servicios();
    });

};
var muestra_cambio_link_dropshipping = function (id_servicio) {
    showonehideone(".input_link_dropshipping", ".text_link_dropshipping");

};
var modifica_dropshipping = function (e) {

    var data_send = $(".form_dropshipping").serialize();
    var url = $(".form_dropshipping").attr("action");
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });
    e.preventDefault();
};
var set_cantidad_en_stock = function () {

    var stock = get_parameter(".stock");
    var id_servicio = get_parameter(".id_servicio");
    var data_send = $.param({"stock": stock, "id_servicio": id_servicio});
    var url = $(".form_stock").attr("action");
    request_enid("PUT", data_send, url, function () {
        carga_informacion_servicio(4);
    });

}