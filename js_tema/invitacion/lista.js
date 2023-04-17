let $form_asistencia = $(".form_asistencia");

$(document).ready(() => {

    asistencia();

});

let asistencia = function (e) {

    let data_send = $form_asistencia.serialize();
    let url = "../q/index.php/api/asistencia/index/format/json/";
    request_enid("GET", data_send, url, response_asistencia);

    e.preventDefault();

}
let response_asistencia = function (data) {
    
    render_enid(".lista", data);

}   