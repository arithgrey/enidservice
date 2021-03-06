"use strict";
window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.onpopstate = function (event) {
    if (event) {

        let fn = (parseInt(get_option("vista")) == 1) ? window.history.back() : valida_retorno();
    }
};

let form_miembro = '#form-miembro-enid-service';
let form_cotizacion = ".form_cotizacion_enid_service";

let input_nombre = '.nombre';
let input_email = '.email';
let input_id_servicio = '.id_servicio';
let descripcion_servicio = '.resumen_producto';
let id_ciclo_facturacion = '.id_ciclo_facturacion';
let usuario_referencia = '.q2';
let num_ciclos = '.num_ciclos';
let talla = '.talla';

let $form_miembro = $(form_miembro);
let $form_cotizacion = $(form_cotizacion);

let $id_servicio = $(input_id_servicio);
let $descripcion_servicio = $(descripcion_servicio);
let $id_ciclo_facturacion = $(id_ciclo_facturacion);
let $usuario_referencia = $(usuario_referencia);
let $num_ciclos = $(num_ciclos);
let $talla = $(talla);

let input_password = "#password_registro";
let fecha_servicio = ".fecha_servicio";

let $input_nombre_registro_envio = $form_miembro.find(input_nombre);
let $input_email_registro_envio = $form_miembro.find(input_email);
let $input_password_registro_envio = $form_miembro.find(input_password);
let $input_telefono_registro_envio = $form_miembro.find('.telefono');

let $input_fecha_servicio = $(fecha_servicio);
let $input_es_cliente = $('.es_cliente');

let primer_compra = '.primer_compra';
let $primer_compra = $(primer_compra);

$(document).ready(() => {

    $('footer').addClass('d-none');
    oculta_acceder();
    set_option({"vista": 1});
    despliega([".base_compras", ".nav-sidebar", ".base_paginas_extra"]);
    $form_miembro.submit(registro);
    $form_cotizacion.submit(registro_cotizacion);
    $(".btn_procesar_pedido_cliente").click(procesar_pedido_usuario_activo);
    $(".link_acceso").click(set_link);
    $(".continuar_pedido").click(continuar_compra);

    $('.agregar_commentario').click(function () {
        $('.text_comentarios').removeClass('d-none');
    });

    $input_nombre_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });
    $input_email_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });
    $input_password_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });
    $input_telefono_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });

});

let registro = (e) => {

    let respuestas = [];
    respuestas.push(es_formato_nombre($input_nombre_registro_envio));
    respuestas.push(es_formato_password($input_password_registro_envio));
    respuestas.push(es_formato_email($input_email_registro_envio));
    respuestas.push(es_formato_telefono($input_telefono_registro_envio));
    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {

        advierte('Procesando tu pedido', 1);
        let url = "../q/index.php/api/cobranza/primer_orden/format/json/";

        let text_password = $.trim($input_password_registro_envio.val());
        let pwpost = "" + CryptoJS.SHA1(text_password);
        let data_send = {
            "password": pwpost,
            "email": $input_email_registro_envio.val(),
            "nombre": $input_nombre_registro_envio.val(),
            "telefono": $input_telefono_registro_envio.val(),
            "id_servicio": $id_servicio.val(),
            "num_ciclos": $num_ciclos.val(),
            "descripcion_servicio": $descripcion_servicio.val(),
            "ciclo_facturacion": $id_ciclo_facturacion.val(),
            "usuario_referencia": $usuario_referencia.val(),
            "talla": $talla.val(),
            "tipo_entrega": 2,
            "fecha_servicio": $input_fecha_servicio.val(),
            "es_cliente": $input_es_cliente.val(),
        };
        bloquea_form(form_miembro);
        request_enid("POST", data_send, url, respuesta_registro, 0);

    }
    e.preventDefault();
};

let registro_cotizacion = (e) => {

    let data_send = $form_cotizacion.serialize();
    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    bloquea_form(form_cotizacion);
    valida_load();
    request_enid("POST", data_send, url, respuesta_proceso_usuario_activo);
    e.preventDefault();
};

let respuesta_registro = (data) => {

    empty_elements(".place_registro_afiliado");
    if (data !== -1) {

        $("#modal-error-message").modal("hide");
        desbloqueda_form(form_miembro);
        if (parseInt(data.usuario_existe) > 0) {

            $('.usuario_existente').removeClass('d-none');
            $primer_compra.addClass('d-none');
            recorre(".usuario_existente");

        } else {

            let $path = _text("../area_cliente/?action=compras&ticket=", data.id_orden_compra);
            redirect($path);
        }

    } else {

        redirect("../");
    }

};

let procesar_pedido_usuario_activo = () => {

    advierte('Procesando pedido', 1);
    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    let data_send = {
        "id_servicio": $id_servicio.val(),
        "num_ciclos": $num_ciclos.val(),
        "descripcion_servicio": $descripcion_servicio.val(),
        "ciclo_facturacion": $id_ciclo_facturacion.val(),
        "talla": $talla.val(),
        "tipo_entrega": 2,
        "id_carro_compras": get_parameter(".id_carro_compras"),
        "carro_compras": get_parameter(".carro_compras"),
    };

    $('.btn_procesar_pedido_cliente').prop('disabled', true);
    request_enid("POST", data_send, url, respuesta_registro);

};
let respuesta_proceso_usuario_activo = (data) => {

    redirect("../area_cliente");

};

let set_link = function () {

    let id = get_parameter_enid($(this), "id_servicio");
    let extension_dominio = get_parameter_enid($(this), "extension_dominio");
    let ciclo_facturacion = get_parameter_enid($(this), "ciclo_facturacion");
    let is_servicio = get_parameter_enid($(this), "is_servicio");
    let q2 = get_parameter_enid($(this), "q2");
    let num_ciclos = get_parameter_enid($(this), "num_ciclos");

    let data_send = $.param({
        "id_servicio": id,
        "extension_dominio": extension_dominio,
        "ciclo_facturacion": ciclo_facturacion,
        is_servicio: is_servicio,
        "q2": q2,
        "num_ciclos": num_ciclos
    });
    let url = "../login/index.php/api/sess/servicio/format/json/";
    request_enid("POST", data_send, url, response_set_link);

};
let continuar_compra = function () {
    showonehideone(primer_compra, ".compra_resumen");
    set_option("vista", 2)
};
let response_set_link = (data) => redirect("../login");
let valida_retorno = () => {
    let vista = parseInt(get_option("vista"));
    switch (vista) {

        case 2:
            showonehideone(".compra_resumen", primer_compra);
            set_option("vista", 1);
            break;

        default:

            break;

    }
};
