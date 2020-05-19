"use strict";
let $tipo_entrega = $('.tipo_entrega');
let $num_domicilios = $('.num_domicilios');
let $recibo = $('.recibo');
let $asignacion_horario_entrega = $('.asignacion_horario_entrega');
let $contenedor_domicilios = $('.contenedor_domicilios');
let $establecer_ubicacion = $(".establecer_ubicacion");
$(document).ready(() => {

    valida_asignacion_domicilio();
    let tipo_entrega = parseInt($tipo_entrega.val());
    let num_domicilios = parseInt($num_domicilios.val());
    if (tipo_entrega === 2 && num_domicilios < 1) {
        $contenedor_domicilios.addClass('d-none');
        submit_enid(".form_registro_direccion");
    }

    $(".agregar_direccion_pedido").click(() => {

        submit_enid(".form_registro_direccion");

    });

    $(".agregar_punto_encuentro_pedido").click(() => {

        submit_enid(".form_puntos_medios");

    });

    $(".establecer_direccion").click(asignar_direccion_existente_pedido);
    $(".eliminar_domicilio").click(eliminar_domicilio);
    $(".establecer_punto_encuentro").click(asignar_punto_encuentro_existente_pedido);
    $establecer_ubicacion.click(asignar_ubicacion_existente_pedido);

});

let asignar_direccion_existente_pedido = function () {

    let id_direccion = get_parameter_enid($(this), "id");
    let id_recibo = get_parameter_enid($(this), "id_recibo");
    let text = "¿DESEAS ENVIAR A ESTA DIRECCIÓN TU PEDIDO?";

    show_confirm("¿DESEAS ENVIAR A ESTA DIRECCIÓN TU PEDIDO?", "", "CONTINUAR", function () {

        proceso_asignar_direccion(id_direccion, id_recibo)

    });
};
let asignar_ubicacion_existente_pedido = function () {

    let id_ubicacion = get_parameter_enid($(this), "id");
    let id_recibo = get_parameter_enid($(this), "id_recibo");

    show_confirm("¿DESEAS ENVIAR A ESTA UBICACIÓN TU PEDIDO?", "", "CONTINUAR", function () {
        proceso_asignar_ubicacion(id_ubicacion, id_recibo);
    });
}
let eliminar_domicilio = function () {

    let $actual = $(this);
    let id_direccion = get_parameter_enid($actual, "id");
    let id_recibo = get_parameter_enid($actual, "id_recibo");
    let tipo = get_parameter_enid($actual, "tipo");
    let text = (tipo == 2) ? "SE ELIMINARÁ EL DOMICILIO ¿DESEAS CONTINUAR?" : "SE ELIMINARÁ TU PUNTO DE ENTREGA ¿DESEAS CONTINUAR?";
    show_confirm(text, "", "CONTINUAR", function () {
        eliminar_domicilio_base(id_direccion, id_recibo, tipo)
    });
}

let proceso_asignar_ubicacion = (id_ubicacion, id_recibo) => {

    let url = "../q/index.php/api/ubicacion/frecuentes/format/json/";
    let data_send = {
        "id_ubicacion": id_ubicacion,
        "id_recibo": id_recibo,
    };
    request_enid("POST", data_send, url, response_proceso_asignacion_ubicacion);

};
let response_proceso_asignacion_ubicacion = function (data) {

    if (data.asignacion === true) {

        redirect(data.siguiente);
    }

};
let proceso_asignar_direccion = (id_direccion, id_recibo) => {

    let url = "../q/index.php/api/proyecto_persona_forma_pago_direccion/index/format/json/";
    let data_send = {
        "id_direccion": id_direccion,
        "id_recibo": id_recibo,
        "asignacion": 1
    };
    request_enid("POST", data_send, url, response_proceso_asignacion);

};
let response_proceso_asignacion = function (data) {

    if (data === true) {

        let id_recibo = $recibo.val();
        redirect("../area_cliente/?action=compras&ticket=" + id_recibo);
    }

};

let asignar_punto_encuentro_existente_pedido = function () {


    let id_punto_encuentro = get_parameter_enid($(this), "id");
    let id_recibo = get_parameter_enid($(this), "id_recibo");
    show_confirm("¿DESEAS QUE TU ENTREGA SEA EN ESTE PUNTO DE ENCUENTRO?", "", "CONTINUAR", function () {
        proceso_asignar_punto_encuentro(id_punto_encuentro, id_recibo)
    });
};

let proceso_asignar_punto_encuentro = (id_punto_encuentro, id_recibo) => {

    if (id_punto_encuentro > 0) {

        set_parameter({
            ".punto_encuentro_asignado": id_punto_encuentro,
            ".id_recibo": id_recibo,
        });
        submit_enid(".form_puntos_medios_avanzado");

    }
};
let eliminar_domicilio_base = function (id_direccion, id_recibo, tipo) {

    let url = "../q/index.php/api/proyecto_persona_forma_pago_direccion/quitar/format/json/";
    let data_send = {
        "id_direccion": id_direccion,
        "id_recibo": id_recibo,
        'tipo': tipo
    };
    request_enid("PUT", data_send, url, reponse_actualizacion_domicilio);
};
let reponse_actualizacion_domicilio = function () {

    redirect("");
};
let valida_asignacion_domicilio = function () {

    if (parseInt($asignacion_horario_entrega.val()) > 0) {

        submit_enid(".form_registro_direccion");

    } else {

        $contenedor_domicilios.removeClass('d-none');
    }
};
