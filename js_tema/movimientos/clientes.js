"use strict";
let actualiza_info_campo = (valor, id_persona, name) => {

    let data_send = {"id_persona": id_persona, "nuevo_valor": valor.value, "name": name};
    let url = "../persona/index.php/api/persona/q/format/json/";
    request_enid("PUT", data_send, url, response_actualiza_info_campo, ".place_campo_editado");

}
let response_actualiza_info_campo = data => {

    seccess_enid(".place_campo_editado", "Información actualizada!");
    carga_info_persona();

}