"use strict";
let id_tarea = 0;
let persona = 0;
let telefono = 0;
let id_proyecto = 0;
let id_usuario = 0;
let id_ticket = 0;
let flag_mostrar_solo_pendientes = 0;
let flag_estoy_en_agendado = 0;
let menu_actual = "clientes";
let banco = 0;
let numero_tarjeta = 0;
let propietario = "";
let id_proyecto_persona_forma_pago = 0;

$(document).ready(function () {
    $("footer").ready(cargar_ultimos_movimientos);
});
let metodos_de_envio_disponibles = () => {

    let url = "../pagos/index.php/api/afiliados/metodos_disponibles_pago/format/json/";
    request_enid("GET", {}, url, response_metodos_envio, ".place_info_cuentas_pago");
}
let response_metodos_envio = (data) => {
    render_enid(".place_info_cuentas_pago", data);
    $(".actualizar_form").click(registra_actualizacion_banco_persona);
    $(".siguiente_banco").click(valida_banco_seleccionado);
    $(".siguiente_numero_tarjeta").click(valida_tarjeta_registrada);
    $(".banco_cuenta").change(muestra_imagen_banco);
    $(".numero_tarjeta").keyup(() => {
        quita_espacios(".numero_tarjeta");
    });

    $('.next').click(function () {
        let numStep = get_attr(this, "num-step");
        let clStep = '#collapse' + (parseInt(numStep) + 1);
        $(clStep).collapse('show');
        $('#accordion .in').collapse('hide');

        $('.s' + numStep).addClass('step-ok').removeClass('step');
        $('.s' + numStep).empty().append('<i class=\"fa fa-check\" aria-hidden=\"true\"><\/i>');

    });

    $('.prev').click(function () {
        let numStep = get_attr(this, "num-step");
        let clStep = '#collapse' + (parseInt(numStep) - 1);
        $(clStep).collapse('show');
        $('#accordion .in').collapse('hide');
    });

    $('.btn-primary').click(function () {

        let delay = 4000;
    });

    $('.btn-secondary').click(function () {
        $('.step-ok').addClass('step').removeClass('step-ok');
        $('.s0').empty().append('1');
        $('.s1').empty().append('2');
        $('#collapse0').collapse('show');
        $('#accordion .in').collapse('hide');

    });

}
let muestra_imagen_banco = () => {


    let banco = get_parameter(".banco_cuenta");
    set_option("banco", parseInt(banco));
    let bancos_imgs = ["", "1.png", "2.png", "3.png", "4.png", "5.png", "6.png", "7.png", "8.png", "9.png"];

    if (get_option("banco") > 0) {
        let url_img_banco = "../img_tema/bancos/" + bancos_imgs[banco];
        let imagen = "<img src='" + url_img_banco + "' style='width:100%'>";
        render_enid(".place_imagen_banco", imagen);
    } else {
        render_enid(".place_imagen_banco", "");
    }
}
let registra_actualizacion_banco_persona = () => {

    let flag_1 = valida_banco_seleccionado();
    let flag_2 = valida_tarjeta_registrada();
    let flag_3 = valida_propietario_tarjeta();

    if (flag_1 > 0 && flag_2 > 0 && flag_3 > 0) {

        let url = "../pagos/index.php/api/afiliados/cuenta_afiliado/format/json/";
        let data_send = {
            "numero_tarjeta": get_numero_tarjeta(),
            "banco": get_option("banco"),
            "propietario": get_propietario()
        };
        request_enid("PUT", data_send, url, metodos_de_envio_disponibles, ".place_info_cuentas_pago");
    }

}
let valida_banco_seleccionado = () => {

    banco = get_parameter(".banco_cuenta");
    set_option("banco", banco);
    if (get_option("banco") == 0) {

        $('.step-ok').addClass('step').removeClass('step-ok');
        $('.s0').empty().append('1');
        $('.s1').empty().append('2');
        $('#collapse0').collapse('show');
        $('#accordion .in').collapse('hide');
        render_enid(".place_banco", "<span class='alerta_enid'>Selecciona un banco</span>");
        return 0;
    } else {

        render_enid(".place_banco", "");
        return 1;
    }
}
let valida_tarjeta_registrada = () => {

    set_option("numero_tarjeta", get_parameter(".numero_tarjeta"));
    return val_text_form(".numero_tarjeta", ".place_numero_tarjeta", 16, "Número de tarjeta");

}
let valida_propietario_tarjeta = () => {

    set_optino("propietario", get_parameter(".propietario"));
    return val_text_form(".propietario", ".place_propietario_tarjeta", 5, "Propietario de la tarjeta");
}