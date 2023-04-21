let $accion_agregar_repuesta_frecuente = $('.accion_agregar_repuesta_frecuente');
let $form_registro_respuesta_frecuente = $(".form_registro_respuesta_frecuente");
let $modal_registro = $("#modal_registro");
let $input_atajo = $form_registro_respuesta_frecuente.find(".input_atajo");
let $input_respuesta = $form_registro_respuesta_frecuente.find(".input_respuesta");

$(document).ready(function () {

    $accion_agregar_repuesta_frecuente.click(agregar_respuesta_frecuente);
    $form_registro_respuesta_frecuente.submit(registro_puesta_frecuente);


});
let agregar_respuesta_frecuente = function () {

    $modal_registro.modal("show");
}
let registro_puesta_frecuente = function (e) {
    let $input_atajo_text = $input_atajo.val();
    let $input_respuesta_text = $input_respuesta.val();

    if ($input_atajo_text.length > 3 && $input_respuesta_text.length > 3) {


        let url = "../q/index.php/api/respuesta_frecuente/index/format/json/";
        let data_send = $form_registro_respuesta_frecuente.serialize();
        request_enid("POST", data_send, url, response_registro_puesta_frecuente);
    }
    e.preventDefault();

}
let response_registro_puesta_frecuente = function () {

    $modal_registro.modal("hide");
    redirect("");
}
