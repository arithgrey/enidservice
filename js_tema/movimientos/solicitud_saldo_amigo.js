"use strict";
$(document).ready(function () {
    $(".monto_a_ingresar").keyup(valida_monto_ingreso);
    $(".solicitar_saldo_amigo_form").submit(solicita_saldo_amigo);
});
let valida_monto_ingreso =  ()  =>{
    let valor = this.value;
    $(".monto_a_ingresar").val(quitar_espacios_numericos(valor));
}
let solicita_saldo_amigo = e  => {

    let url = "../q/index.php/api/solicitud_pago/index/format/json/";
    let data_send = $(".solicitar_saldo_amigo_form").serialize();
    request_enid("POST", data_send, url, response_solicita_saldo_amigo, ".place_solicitud_amigo", before_solicitud_saldo);
    e.preventDefault();
}
let response_solicita_saldo_amigo =  data =>{

    let url_movimientos = "../movimientos";
    let msj = "Tu solicitud fue enviada, cuando tu amigo responda, tendrás un notificación, puedes consultar tus solicitudes <a href='" + url_movimientos + "' class='a_enid_blue_sm white'>aquí</a>";
    render_enid(".place_solicitud_amigo", "<br><div class='mensaje_envio_amigo'>" + msj + "</div>");
}
let before_solicitud_saldo =  () => {

    bloquea_form(".solicitar_saldo_amigo_form");
}