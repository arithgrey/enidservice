window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.onpopstate = function (event) {

    if (event) {

        valida_retorno();
    }
};

let id_tarea = 0;
let persona = 0;
let telefono = 0;
let id_proyecto = 0;
let id_usuario = 0;
let flag_mostrar_solo_pendientes = 0;
let id_proyecto_persona_forma_pago = "";
let menu_actual = "clientes";
let id_servicio = 0;
let id_persona = 0;

let id_ticket = '.ticket';
let menu_navegacion_completo =  '.menu_navegacion_completo';
let $id_ticket = $(id_ticket);
let $menu_navegacion_completo = $(menu_navegacion_completo);




$(document).ready(() => {

    set_option("vista", 1);
    set_option("estado_compra", 6);
    set_option("interno", 1);
    retorno();

    $(".btn_mis_ventas").click(() => {

        set_option({
            "estado_compra": 1,
            "modalidad_ventas": 1
        });
        compras_usuario();
    });
    $(".btn_cobranza").click(() => {


        set_option({
            "estado_compra": 6,
            "modalidad_ventas": 0,
        });
        compras_usuario();
    });

    $(".num_alcance").click(alcance_producto);
    $("#mis_ventas").click(() => {
        $("#mis_compras").tab("show");
        $("#mis_ventas").tab("show");
    });
    $("#mis_compras").click(() => {
        $("#mis_ventas").tab("show");
        $("#mis_compras").tab("show");
    });

});
let retorno = () => {

    switch (get_parameter(".action")) {
        case "ventas":

            set_option({
                "modalidad_ventas": 1,
                "estado_compra": 1,
            });

            compras_usuario();

            break;
        case "compras":

            set_option("modalidad_ventas", 0);
            let fn = ($id_ticket.val() > 0) ? inf_ticket() : compras_usuario();
            break;

        default:
            set_option("modalidad_ventas", 0);
            compras_usuario();
            break;
    }
};
let alcance_producto = function (e) {

    let url = "../q/index.php/api/servicio/alcance_producto/format/json/";
    let data_send = {tipo: get_parameter_enid($(this), "id")};
    request_enid("GET", data_send, url, function (data) {
        redirect("../producto/?producto=" + data);
    });
};
let notifica_tipo_compra = (tipo, recibo) => {

    let url = "../q/index.php/api/intento_compra/index/format/json/";
    let data_send = {tipo: tipo, recibo: recibo};
    request_enid("POST", data_send, url);

};
let valida_retorno = () => {

    let vista = get_option("vista");
    if (vista < 1) {
        switch (get_parameter(".action")) {

            case "ventas":

                show_tabs(["#mis_compras", "#mis_ventas"]);

                set_option({
                    "modalidad_ventas": 1,
                    "estado_compra": 1,
                });

                compras_usuario();
                break;

            case "compras":

                show_tabs(["#mis_compras", "#mis_ventas"]);
                set_option("modalidad_ventas", 0);
                compras_usuario();

                break;

            default:
                set_option("modalidad_ventas", 0);
                compras_usuario();
                break;
        }


    } else {


        switch (vista) {

            case 2:

                show_tabs(["#mis_compras", "#mis_ventas"]);
                inf_ticket();

                break;

            default:

                break;
        }

    }
};
let inf_ticket = function (e) {

    recorre();
    let id_recibo = get_parameter_enid($(this), "id");
    if (id_recibo == undefined) {
        id_recibo = ($id_ticket.val()!= undefined) ? $id_ticket.val() : get_option("id_recibo");
    }

    if (id_recibo > 0) {
        //$menu_navegacion_completo.addClass('d-none');
        set_option("id_recibo", id_recibo);
        let url = "../q/index.php/api/recibo/resumen_desglose_pago/format/json/";
        let data_send = {"id_recibo": get_option("id_recibo"), "cobranza": 1};
        request_enid("GET", data_send, url, r_carga_info_resumen_pago_pendiente, ".place_resumen_servicio");
    }
};
let r_carga_info_resumen_pago_pendiente = data => {


    $(".resumen_pagos_pendientes").tab("show");
    render_enid(".place_resumen_servicio", data);
    $(".cancelar_compra").click(conf_cancelacion_compra);
    $(".btn_direccion_envio").click(inf_envio);

};
let resposponse_confirma_cancelacion = data => {

    render_enid(".place_resumen_servicio", data);
    $(".cancelar_orden_compra").click(cancela_compra);

};
let cancela_compra = function () {


    set_option("id_recibo", get_parameter_enid($(this), "id"));
    let url = "../q/index.php/api/tickets/cancelar/format/json/";
    let data_send = {
        "id_recibo": get_option("id_recibo"),
        "modalidad": get_option("modalidad_ventas")
    };
    request_enid("PUT", data_send, url, response_cancelacion_compra);

};
let response_cancelacion_compra = (data) => {


    if (get_option("modalidad_ventas") == 1) {

        show_tabs(["#mi_buzon", "#mis_ventas"]);
        compras_usuario();

    } else {

        let id_servicio = data.registro.id_servicio;
        let href = "../valoracion/?servicio=" + id_servicio;
        let btn_cuenta_historia = "<a href='" + href + "' class='a_enid_blue'>CUENTANOS TU EXPERIENCIA</a>";
        let div = "<div class='cuenta_tu_experiencia'>" + btn_cuenta_historia + "</div>";
        let div2 = "<h3>¿NOS AYUDARÍAS A EVALUAR EL PRODUCTO QUE CANCELASTE?</h3>";
        let response = "<div class='col-lg-8 col-lg-offset-2 text-center'>" + div2 + "" + div + "</div>";

        render_enid(".place_resumen_servicio", response);
        $(".mis_compras_btn").click(compras_usuario);

    }
    metricas_perfil();
};
let conf_cancelacion_compra = function () {

    set_option({

        "modalidad_ventas": get_attr(this, "modalidad"),
        "id_recibo": get_attr(this, "id"),
        "vista": 2,

    });

    if (get_option("id_recibo") > 0) {
        let url = "../q/index.php/api/tickets/cancelar_form/format/json/";
        let data_send = {
            "id_recibo": get_option("id_recibo"),
            "modalidad": get_option("modalidad_ventas")
        };
        request_enid("GET", data_send, url, resposponse_confirma_cancelacion);
    }
};
