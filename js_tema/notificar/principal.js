"use strict";
$(document).ready(function () {


    $("footer").ready(function () {
        recorre("#info_articulo");
    });
    $(".num_recibo").keyup(() => {
        quita_espacios_en_input_num(".num_recibo");
        valida_auto_complete_recibo();
    });

    $(".form_notificacion").submit(notifica_pago);


});
let notifica_pago = e => {

    let flag = get_option("resultados");
    if (flag > 0) {
        flag = get_option("pago_notificado_previamente");
        if (flag == 0) {

            let url = "../q/index.php/api/notificacion_pago/notifica_pago_usuario/format/json/";
            let data_send = $(".form_notificacion").serialize();
            request_enid("POST", data_send, url, response_notificacion_pago, ".placa_notificador_pago");
        } else {

            $(".num_recibo").css("border", "1px solid rgb(13, 62, 86)");
            render_enid(".place_recibo", "<span class='alerta_enid'>Este pago ya ha sido notificado previamente</span>");
            recorre(".num_recibo");
        }

    } else {
        $(".num_recibo").css("border", "1px solid rgb(13, 62, 86)");
        recorre(".num_recibo");
    }
    e.preventDefault();
};

let response_notificacion_pago = data => {

    let str = "<span class='blue_enid_background white' style='padding:10px;'>" +
        " Recibimos la notificación de tu pago, a la brevedad será procesado!." +
        "</span>";
    render_enid(".placa_notificador_pago", str);
    recorre(".placa_notificador_pago");
    notifica_registro_pago(data);
};

let notifica_registro_pago = data => {

    let data_send = {"id_notificacion_pago": data};
    let url = "../msj/index.php/api/emp/notifica_pago/format/json/";
    request_enid("POST", data_send, url, response_notificacion_registro_pago, ".placa_notificador_pago");
};
let response_notificacion_registro_pago = data => {

    let str = "<div class='white' " +
        "style='background:#04319E;padding:10px;font-size:.9em;'> " +
        "Su pago ha sido notificado, a continuación será procesado, " +
        "puede consultar más detalles desde su área de clientes " +
        "<a href='../login' class='strong' style='color:white!important;'> ingresando aquí</a> </div> ";

    render_enid(".placa_notificador_pago", str);
    $(".form_notificacion :input").attr("disabled", true);

};
let valida_auto_complete_recibo = () => {


    let url = "../pagos/index.php/api/cobranza/info_saldo_pendiente/format/json/";
    let data_send = {"recibo": $(".num_recibo").val()};
    request_enid("GET", data_send, url, response_autocomplete);
};

let response_autocomplete = data => {

    let resultados = data.resultados;
    set_option({
        "resultados": resultados,
        "pago_notificado_previamente": data.resultado_notificado
    });

    if (resultados == 0 && get_option("flag_accesos") > 0) {

        let str = "<span class='alerta_enid'>Recibo no encontrado</span>";
        render_enid(".place_recibo", str);

    } else {

        set_option("flag_accesos", 1);
        $(".place_recibo").empty();
    }

    let id_servicio = data.id_servicio;
    let info_pago_pendiente = data.info_pago_pendiente;
    let saldo_cubierto = info_pago_pendiente[0].saldo_cubierto;
    let monto_a_pagar = info_pago_pendiente[0].monto_a_pagar;
    notifica_recibo_en_proceso(saldo_cubierto, monto_a_pagar);

    set_option("monto_a_pagar", monto_a_pagar);
    set_parameter(".cantidad", monto_a_pagar);
    set_id_servicio(id_servicio);
    set_select_servicio(data.data_servicio);

};
let notifica_recibo_en_proceso = (saldo_cubierto, monto_a_pagar) => {

    if (saldo_cubierto >= monto_a_pagar) {
        $(".place_recibo").show();
        render_enid(".place_recibo", "RECIBIMOS TU NOTIFICACIÓN!");
    }
};

let set_id_servicio = id_servicio => selecciona_select(".servicio", id_servicio);
let set_select_servicio = data_servicio => {

    let select = "<select name='servicio' class='form-control input-sm servicio' id='servicio'>";
    for (let x in data_servicio) {

        let id_servicio = data_servicio[x].id_servicio;
        let nombre_servicio = data_servicio[x].nombre_servicio;
        select += "<option value='" + id_servicio + "'>" + nombre_servicio + "</option>";
    }
    select += "</select>";
    render_enid("#servicio", select);
};