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
let $horario_entrega_ubicacion = $form_ubicacion.find('.horario_entrega');

$(document).ready(() => {


    $('footer').addClass('d-none');
    $(".codigo_postal").keyup(auto_completa_direccion);
    $(".numero_exterior").keyup(() => quita_espacios(".numero_exterior"));
    $(".numero_interior").keyup(() => quita_espacios(".numero_interior"));
    $(".form_direccion_envio").submit(registra_nueva_direccion);

    if ($('.form_direccion_envio .fecha_entrega').length) {

        $('.form_direccion_envio .fecha_entrega').change(horarios_disponibles);
    }
    $fecha_entrega_ubicacion.change(horarios_disponibles_ubicacion);
    $ingreso_texto_completo.click(ingreso_completo);
    $ingreso_ubicacion.click(ingreso_ubicacion);
    $form_ubicacion.submit(registro_ubicacion);
    valida_indicacion_ubicacion();


});
let horarios_disponibles = () => {

    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = {"dia": $('.form_direccion_envio .fecha_entrega').val()};
    request_enid("GET", data_send, url, response_horario);

};
let horarios_disponibles_ubicacion = () => {
    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = {"dia": $fecha_entrega_ubicacion.val()};
    request_enid("GET", data_send, url, response_horario_ubicacion);

}

let response_horario = (data) => {

    if (!isArray(data)) {
        render_enid(".horario_entrega", data);
    }
};
let response_horario_ubicacion = (data) => {

    if (!isArray(data)) {

        render_enid(".form_ubicacion    .horario_entrega", data);
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


    let url = "../q/index.php/api/ubicacion/index/format/json/";
    let data_send = $form_ubicacion.serialize();
    bloquea_form(formulario_registro_ubicacion);
    request_enid("POST", data_send, url, response_ubicacion);

    e.preventDefault();
};
let response_ubicacion = function (data) {

    let id_recibo = $form_ubicacion.find('.id_recibo').val();
    redirect(path_enid('recibo', id_recibo));

};