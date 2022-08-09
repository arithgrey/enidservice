"use strict";
let $num_ciclos = $('#num_ciclos');
let $se_agrego = $('.se_agrego');
let $se_agregara = $('.se_agregara');
let $agregar_deseos_sin_antecedente = $('.agregar_deseos_sin_antecedente');
let $bottom_carro_compra_recompensa = $(".bottom_carro_compra_recompensa");
let $costos_precios_servicio = $(".costos_precios_servicio");
let $form_precio = $(".form_precio");
let $form_costo = $(".form_costo");

$(document).ready(function () {

    
    oculta_acceder();
    set_option([
        "servicio", get_parameter(".servicio"),
        "respuesta_valorada", 0,
        "desde_valoracion", get_parameter(".desde_valoracion"),
        "orden", "desc",
    ]);
    $("footer").ready(carga_productos_sugeridos);
    $("footer").ready(carga_valoraciones);
    $(".agregar_a_lista_deseos").click(agregar_a_lista_deseos);
    $(".talla").click(agregar_talla);
    $(".descripcion_producto ").click(tab_descripcion);
    $(".descripcion_detallada ").click(tab_descripcion_avanzada);

    $(".click_amazon_link").click(function () {
        log_operaciones_externas(15);
    });
    $(".click_ml_link").click(function () {
        log_operaciones_externas(16);
    });

    $(".texto_externo_compra").click(operaciones_compra_externas);

    $num_ciclos.change(articulos_seleccionados);
    $agregar_deseos_sin_antecedente.click(agregar_deseos);
    $bottom_carro_compra_recompensa.click(carro_compra_recompensa);
    $costos_precios_servicio.click(costos_precios_servicio);
    $form_costo.submit(costo_servicio);
    $form_precio.submit(precio_servicio);
});

let carro_compra_recompensa  = function(){

    let $id = $(this).attr('id');
    let $antecedente_compra = $(this).attr('antecedente_compra');

    if (parseInt($id) > 0) {

        $("#modal-error-message").modal("show");            
            
        let $selector_carga_modal = $('.cargando_modal');
        $selector_carga_modal.removeClass('d-none');
        $(".text-order-name-error").text("Procesando ...");    
        $(this).addClass("d-none");
        let url = "../q/index.php/api/recompensa/deseo_compra/index/format/json/";
        let data_send = {"id": $id, "antecedente_compra" : $antecedente_compra};
        request_enid("POST", data_send, url, response_deseo_compra_recompensa);
        
        
    }
}

let response_deseo_compra_recompensa = function(data){
    $("#modal-error-message").modal("hide");            
    redirect("../lista_deseos");

}
let operaciones_compra_externas = () => {

    log_operaciones_externas(14);
    $(".link_externo_compra").removeClass("d-none");
    $(".texto_externo_compra").addClass("d-none");

}

let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let data_send = {
        "id_servicio": get_option("servicio"),
        "q": get_parameter(".qservicio")
    };
    request_enid("GET", data_send, url, response_carga_productos);
};

let response_carga_productos = data => {


    if (data["sugerencias"] == undefined) {
        $(".text_sugerencias").removeClass("d-none");
        render_enid(".place_tambien_podria_interezar", data);
    }
};

let carga_valoraciones = () => {

    let url = "../q/index.php/api/valoracion/articulo/format/json/";
    let data_send = {
        "id_servicio": get_option("servicio"),
        "respuesta_valorada": get_option("respuesta_valorada")
    };
    request_enid("GET", data_send, url, response_carga_valoraciones);
};

let response_carga_valoraciones = data => {

    render_enid(".place_valoraciones", data);
    $('.agregar_referencia_fotografica').click(agregar_referencia_fotografica);
    $(".eliminar_foto_referencia").click(elimina_imagen_referencia);

    if (get_option("desde_valoracion") == 1) {
        recorre(".place_valoraciones");
        set_option("desde_valoracion", 0);
    }
    $(".ordenar_valoraciones_button").click(ordenar_valoraciones);
    let valoracion_persona = $(".contenedor_promedios").html();
    render_enid(".valoracion_persona", valoracion_persona);
    $("body > div:nth-child(3) > div.p-0.col-lg-3 > div:nth-child(1) > a").click(function (e) {
        e.preventDefault();
    });
    $("body > div:nth-child(3) > div.p-0.col-lg-3 > div:nth-child(1) > a").before("<div class='black'>Opiniones de clientes</div>");
    $("body > div:nth-child(3) > div.p-0.col-lg-3 > div:nth-child(1) > a").addClass("d-block");
    $("body > div:nth-child(3) > div.p-0.col-lg-3 > div:nth-child(1) > a").css("margin-top", "-8px");
    $(".baja_valoracion").click(confirmacion_baja_valoracion);


};
let agrega_valoracion_respuesta = (valoracion, num) => {

    let url = "../q/index.php/api/valoracion/utilidad/format/json/";
    let data_send = {"valoracion": valoracion, "utilidad": num};
    set_option("respuesta_valorada", valoracion);
    request_enid("PUT", data_send, url, carga_valoraciones);
};

let ordenar_valoraciones = function (e) {

    let tipo_ordenamiento = get_parameter_enid($(this), "id");
    let div = $(".contenedor_global_recomendaciones");
    let listitems = div.children('.contenedor_valoracion_info').get();
    switch (parseInt(tipo_ordenamiento)) {
        case 0:
            /*Ordenamos por los que tienen más votos*/


            listitems.sort(function (a, b) {

                return (+$(a).attr('numero_utilidad') > +$(b).attr('numero_utilidad')) ?
                    -1 : (+$(a).attr('numero_utilidad') < +$(b).attr('numero_utilidad')) ?
                        1 : 0;

            });
            render_enid(".contenedor_global_recomendaciones", listitems);
            set_option("orden", "asc");
            break;
        case 1:


            listitems.sort(function (a, b) {

                return (+$(a).attr('fecha_info_registro') > +$(b).attr('fecha_info_registro')) ?
                    -1 : (+$(a).attr('fecha_info_registro') < +$(b).attr('fecha_info_registro')) ?
                        1 : 0;

            });
            render_enid(".contenedor_global_recomendaciones", listitems);

            break;
        case 2:
            break;
        default:
    }
};
let agregar_a_lista_deseos = () => {

    let $numero_articulos = get_valor_selected("#num_ciclos");
    if ($numero_articulos > 0) {

        $se_agrego.removeClass('d-none');
        $se_agregara.addClass('d-none');
        let url = "../q/index.php/api/usuario_deseo/lista_deseos/format/json/";
        let data_send = {"id_servicio": get_option("servicio"), "articulos": $numero_articulos};
        request_enid("PUT", data_send, url, respuesta_add_valoracion);

    }
};

let respuesta_add_valoracion = data => {

    redirect("../lista_deseos");

};

let agregar_talla = function () {

    let id_seleccion = get_attr(this, "id");
    $(".talla ").each(function (index) {
        $(this).removeClass("talla_select");
        if (id_seleccion == get_attr(this, "id")) {
            $(this).addClass("talla_select");
            $(".producto_talla").val(id_seleccion);
        }
    });
};
let tab_descripcion = function () {

    $(".descripcion_producto").addClass("border_enid");
    $(".descripcion_producto").removeClass("border");
    $(".descripcion_detallada").removeClass("border_enid");
    $(".descripcion_detallada").addClass("border");


};
let tab_descripcion_avanzada = function () {

    $(".descripcion_producto").removeClass("border_enid").addClass("border");
    $(".descripcion_detallada").addClass("border_enid");
    $(".descripcion_detallada").removeClass("border");

};
let articulos_seleccionados = function () {

    let numero_articulos = this.value;
    if (parseInt(numero_articulos) > 0) {
        $('.num_ciclos').val(numero_articulos);
    }
}
let agregar_deseos = function () {

    let $id_servicio = $(this).attr('id');

    if (parseInt($id_servicio) > 0) {
        let $articulos = $num_ciclos.val();
        let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
        let data_send = {"id_servicio": $id_servicio, "articulos": $articulos};
        request_enid("POST", data_send, url, respuesta_add_valoracion);
    }
}

let agregar_referencia_fotografica = function () {


    let $id_servicio = $(this).attr('id');
    let $data_send = {"id_servicio": $id_servicio};
    let url = "../q/index.php/api/imagen_cliente_empresa/referencia_servicio/format/json/";
    request_enid("GET", $data_send, url, catalogo_referencias);

    $("#modal_referencia_fotografica").modal('show');

}
let confirmacion_baja_valoracion = function () {


    let $id_valoracion = $(this).attr('id');
    if(parseInt($id_valoracion) > 0){

        show_confirm("¿Seguro que quieres ocultar esta valoración?", "", "CONTINUAR", function () {
                
            let url = "../q/index.php/api/valoracion/id/format/json/";
            let data_send = {"id": $id_valoracion, "status" : 2};
    
            request_enid("PUT", data_send, url, function(){
                carga_valoraciones();
            });
            
    
        });

        
    }
    

}

let catalogo_referencias = function (data) {

    render_enid("#galeria_referencias", data);
    $(".imagen_referencia_muestra").click(anexar_galeria);


}
let anexar_galeria = function (e) {

    let $id_imagen = $(this).attr('id');
    let $id_servicio = $(this).attr('id_servicio');

    let $data_send = {"id_servicio": $id_servicio, "id_imagen": $id_imagen};
    let url = "../q/index.php/api/referencia/index/format/json/";
    $("#modal_referencia_fotografica").modal('hide');

    request_enid("POST", $data_send, url, function (data) {
        carga_valoraciones();
    });

}
let elimina_imagen_referencia = function (e) {
    
    let $id_imagen = $(this).attr('id_imagen');
    let $id_servicio = $(this).attr('id_servicio');

    let $data_send = {"id_servicio": $id_servicio, "id_imagen": $id_imagen};
    let url = "../q/index.php/api/referencia/index/format/json/";

    request_enid("DELETE", $data_send, url, function (data) {
        carga_valoraciones();
    });

}
let costos_precios_servicio = function(e){

    let $id = $(this).attr('id');
    $("#gb_costos_precios").modal("show");
    $(".modal-backdrop").addClass("super_index");


}
let costo_servicio = function(e){

    let $costo = $(".costo_servicio").val();    
    if (es_float($costo) && $costo > 0) {

        let url = "../q/index.php/api/servicio/costo_compra/format/json/";
        let data_send = $form_costo.serialize();        
        request_enid("PUT", data_send, url, function (data) {
            redirect("");
        });
    } 

    e.preventDefault();

}
let precio_servicio = function(e){

    let $precio = $(".precio_servicio").val();    
    if (es_float($precio) && $precio > 0) {

        let url = "../q/index.php/api/servicio/costo/format/json/";
        let data_send = $form_precio.serialize();        
        request_enid("PUT", data_send, url, function (data) {
            redirect("");
        });
    } 

    e.preventDefault();

}

