"use strict";
let $modal_ubicacion = $("#modal_ubicacion");
let $informacion_resumen_envio = $('.contenedor_form_envio');
let $ingreso_texto_completo = $('.ingreso_texto_completo');
let $ingreso_ubicacion = $('.ingreso_ubicacion');
let $selector_ubicaciones_domicilio = $('.selector_ubicaciones_domicilio');
let formulario_registro_ubicacion = '.formulario_registro_ubicacion';
let $formulario_registro_ubicacion = $('.formulario_registro_ubicacion');
let $form_ubicacion = $('.form_ubicacion');
let $fecha_entrega_ubicacion = $form_ubicacion.find('.fecha_entrega');
let $ubicacion_delegacion = $form_ubicacion.find('.ubicacion_delegacion');

let $adicionales_seccion = $(".adicionales_seccion");
$(document).ready(() => {
    
    $(".barra_categorias_ab").removeClass("d-block").addClass("d-none");
    $(".cerrar_modal").addClass("d-none");
    $(".seccion_menu_comunes").removeClass("d-block").addClass("d-none");
    
    $('footer').addClass('d-none');
    $(".codigo_postal").keyup(auto_completa_direccion);
    $(".numero_exterior").keyup(() => quita_espacios(".numero_exterior"));
    $(".numero_interior").keyup(() => quita_espacios(".numero_interior"));
    $(".form_direccion_envio").submit(registra_nueva_direccion);

    if ($('.form_direccion_envio .fecha_entrega').length) {
        $('.form_direccion_envio .fecha_entrega').change(horarios_disponibles);
    }

    $adicionales_seccion.click(seccion_adicionales);
    $fecha_entrega_ubicacion.change(horarios_disponibles_ubicacion);
    $ingreso_texto_completo.click(ingreso_completo);
    $ingreso_ubicacion.click(ingreso_ubicacion);
    $ubicacion_delegacion.change(busqueda_colonia_ubicacion);
    $form_ubicacion.submit(registro_ubicacion);

    valida_indicacion_ubicacion();

}
);
let seccion_adicionales = () => {

    $adicionales_seccion.addClass('d-none').removeClass('d-flex');
    $(".campos_adicionales").removeClass("d-none");

}

let busqueda_colonia_ubicacion = () => {

    let id_delegacion = $ubicacion_delegacion.val();
    if (parseInt(id_delegacion) > 0) {

        let $nombre = $(".ubicacion_delegacion option:selected").text();
        $(".text_delegacion").val($nombre);
        let url = "../q/index.php/api/colonia/delegacion/format/json/";
        let data_send = { "delegacion": $nombre, 'auto': 1 };
        request_enid("GET", data_send, url, response_colonias);
    }

};
let response_colonias = (data) => {

    $(".place_colonia").removeClass("d-none");
    render_enid(".place_colonia", data);
    $(".sin_colonia").click(function () {
        selecciona_select(".colonia_ubicacion", 0);
        $(".place_colonia").addClass("d-none");
    });

};

let horarios_disponibles = () => {

    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = { "dia": $('.form_direccion_envio .fecha_entrega').val() };
    request_enid("GET", data_send, url, response_horario);

};
let horarios_disponibles_ubicacion = () => {
    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = { "dia": $fecha_entrega_ubicacion.val() };
    request_enid("GET", data_send, url, response_horario_ubicacion);

}

let response_horario = (data) => {

    if (!isArray(data)) {
        render_enid(".horario_entrega", data);
    }
};

let response_horario_ubicacion = (data) => {

    if (!isArray(data)) {

        render_enid(".form_ubicacion .horario_entrega", data);
    }
};

let valida_indicacion_ubicacion = () => {

    $informacion_resumen_envio.addClass('d-none');
    $modal_ubicacion.modal("show");
};

let ingreso_completo = () => {

    $informacion_resumen_envio.removeClass('d-none');
    $modal_ubicacion.modal("hide");

};

let ingreso_ubicacion = () => {

    $selector_ubicaciones_domicilio.addClass('d-none');
    $formulario_registro_ubicacion.removeClass('d-none');
};

let registro_ubicacion = (e) => {
    $(".cargando_modal").removeClass("d-none");
    let url = "../q/index.php/api/ubicacion/index/format/json/";
    let data_send = $form_ubicacion.serialize();
    bloquea_form(formulario_registro_ubicacion);
    request_enid("POST", data_send, url, response_ubicacion);

    e.preventDefault();
};

let response_ubicacion = function (data) {

    if (array_key_exists('orden_compra', data)) {
        redirect(data.siguiente);
    }
};