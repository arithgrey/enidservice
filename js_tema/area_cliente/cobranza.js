"use strict";
let inf_ticket = function (e) {

    recorre();
    let id_recibo = get_parameter_enid($(this), "id");
    if (id_recibo == undefined) {
        id_recibo = (get_parameter(".ticket") != undefined) ? get_parameter(".ticket") : get_option("id_recibo");
    }

    if (id_recibo > 0) {

        set_option("id_recibo", id_recibo);
        let url = "../q/index.php/api/recibo/resumen_desglose_pago/format/json/";
        let data_send = {"id_recibo": get_option("id_recibo"), "cobranza": 1};
        request_enid("GET", data_send, url, r_carga_info_resumen_pago_pendiente, ".place_resumen_servicio");
    }
}
let r_carga_info_resumen_pago_pendiente = data => {


    $(".resumen_pagos_pendientes").tab("show");
    render_enid(".place_resumen_servicio", data);
    $(".cancelar_compra").click(conf_cancelacion_compra);
    $(".btn_direccion_envio").click(inf_envio);

}
let resposponse_confirma_cancelacion = data => {

    render_enid(".place_resumen_servicio", data);
    $(".cancelar_orden_compra").click(cancela_compra);

}
let cancela_compra = function () {


    set_option("id_recibo", get_parameter_enid($(this), "id"));
    let url = "../q/index.php/api/tickets/cancelar/format/json/";
    let data_send = {"id_recibo": get_option("id_recibo"), "modalidad": get_option("modalidad_ventas")};
    request_enid("PUT", data_send, url, response_cancelacion_compra);

}
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
}
let conf_cancelacion_compra = function () {

    set_option({

        "modalidad_ventas": get_attr(this, "modalidad"),
        "id_recibo": get_attr(this, "id"),
        "vista": 2,

    });

    if (get_option("id_recibo") > 0) {
        let url = "../q/index.php/api/tickets/cancelar_form/format/json/";
        let data_send = {"id_recibo": get_option("id_recibo"), "modalidad": get_option("modalidad_ventas")};
        request_enid("GET", data_send, url, resposponse_confirma_cancelacion);
    }
}
