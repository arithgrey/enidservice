let registro_costo_operativo = function (e) {


    let data_send = $(".form_costos").serialize();
    let url = "../q/index.php/api/costo_operacion/index/format/json/";
    bloquea_form(".form_costos");
    request_enid("POST", data_send, url, response_costo, ".notificacion_registro_costo");


    e.preventDefault();
}
let response_costo = function (data) {

    debugger;
    if (data.num > 0) {

        desbloqueda_form(".form_costos");
        advierte("Ya registraste un costos de operación de este tipo!");

    } else {

        $(".notificacion_registro_costo").empty();
        redirect("");
    }

}
let muestra_formulario_costo = function () {

    showonehideone(".contenedor_form_costos_operacion", ".contenedor_costos_registrados");
}