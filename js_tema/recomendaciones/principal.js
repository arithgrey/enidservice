"use strict";
let agrega_valoracion_respuesta = (valoracion, num) => {

    let url = "../q/index.php/api/valoracion/utilidad/format/json/";
    let data_send = {"valoracion": valoracion, "utilidad": num};
    set_option("respuesta_valorada", valoracion);
    request_enid("PUT", data_send, url, up_page);
}


