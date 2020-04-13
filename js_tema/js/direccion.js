let auto_completa_direccion = function () {

    quita_espacios(".codigo_postal");
    let cp = get_parameter(".codigo_postal");
    let numero_caracteres = cp.length;
    if (numero_caracteres > 4) {
        let url = "../q/index.php/api/codigo_postal/cp/format/json/";
        let data_send = {"cp": cp, "delegacion": get_option("delegacion")};
        request_enid("GET", data_send, url, response_auto_complete_direccion);
    }
};

function response_auto_complete_direccion(data) {


    if (data.resultados > 0) {
        render_enid(".place_colonias_info", data.colonias);
        $(".parte_colonia_delegacion").show();

        $(".delegacion_c").show();
        render_enid(".place_delegaciones_info", data.delegaciones);

        $(".estado_c").show();
        render_enid(".place_estado_info", data.estados);

        $(".pais_c").show();
        render_enid(".place_pais_info", data.pais);
        muestra_error_codigo(0);
        set_option("existe_codigo_postal", 1);

    } else {
        advierte('Ups! no encontramos esta código postal ¿Es correcto?');
        let elementos = [".delegacion", ".place_colonias_info"];
        set_black(elementos);
        $(".parte_colonia_delegacion").hide();
        set_option("existe_codigo_postal", 0);
        muestra_error_codigo(1);
    }
}

function muestra_error_codigo(flag_error) {
    render_enid(".place_codigo_postal", "");
    if (flag_error == 1) {
        $(".codigo_postal").css("border", "1px solid rgb(13, 62, 86)");
        let mensaje_user = "Codigo postal invalido, verifique";
        render_enid(".place_codigo_postal", "<span class='alerta_enid'>" + mensaje_user + "</span>");
        recorre("#codigo_postal");
    }
}

function registra_nueva_direccion(e) {

    if (parseInt(get_option("existe_codigo_postal")) > 0) {

        registro_direccion();

    } else {

        muestra_error_codigo(1);
    }
    e.preventDefault();
}

function registro_direccion() {

    if (parseInt(asentamiento) !== 0) {

        set_option("id_recibo", $(".id_recibo").val());
        let data_send = $(".form_direccion_envio").serialize();
        let url = "../q/index.php/api/codigo_postal/direccion_envio_pedido/format/json/";
        bloquea_form(".form_direccion_envio");
        modal('Estamos procesando tu pedido ...', 1);
        request_enid("POST", data_send, url, response_registro_direccion);
    } else {
        recorre("#asentamiento");
        render_enid(".place_asentamiento", "<span class='alerta_enid'>Seleccione</span>");
    }
}

let response_registro_direccion = function (data) {

    if (data !== -1) {
        let $asignacion_horario = $('.asignacion_horario').val();
        let $es_asignacion_horario = (parseInt($asignacion_horario) > 0);
        let $id_recibo = get_option("id_recibo");
        let url_area_cliente = _text("../area_cliente/?action=compras&ticket=", $id_recibo, "&primercompra=1");
        let ext = ($es_asignacion_horario) ? '&asignacion=1' : '';
        let url_seguimiento = _text("../pedidos/?seguimiento=", $id_recibo, "&&domicilio=1", ext);
        let $es_seguimiento = (get_parameter(".es_seguimiento") !== undefined && get_parameter(".es_seguimiento") === 1);
        let url = ($es_seguimiento) ? url_seguimiento : url_area_cliente;
        if ($es_asignacion_horario) {
            url = _text("../pedidos/?recibo=", $id_recibo);
        }
        redirect(url);

    } else {

        $("#modal-error-message").modal("hide");
        format_error(".notificacion_direccion", "VERIFICA LOS DATOS DE TU DIRECCIÓN");
        recorre(".notificacion_direccion");
    }
};

function inf_envio_complete() {

    let url = "../q/index.php/api/usuario_direccion/direccion_envio_pedido/format/json/";
    let data_send = {id_recibo: get_option("recibo")};
    let place_info = ".place_info";
    if (get_option("interno") == 1) {
        place_info = ".place_servicios_contratados";
    }
    request_enid("GET", data_send, url, function (data) {
        response_inf_envio_complete(data, place_info)
    });
}

function response_inf_envio_complete(data, place_info) {

    render_enid(place_info, data);
    $(".resumen_pagos_pendientes").click(inf_ticket);
    $(".editar_envio_btn").click(function () {
        showonehideone(".contenedor_form_envio", ".contenedor_form_envio_text");
    });
    $(".codigo_postal").keyup(auto_completa_direccion);

    $(".numero_exterior").keyup(function () {
        quita_espacios(".numero_exterior");
    });
    $(".numero_interior").keyup(function () {
        quita_espacios(".numero_interior");
    });

    $(".form_direccion_envio").submit(registra_nueva_direccion);
}