"use strict";

let $sorteo_form = $(".sorteo_form");

$(document).ready(() => {
    
    $sorteo_form.submit(registro_sorteo);
    //$('.agregar_deseos_sin_antecedente').click(agregar_deseos_sin_antecedente_gbl);
});

let registro_sorteo = function(e){
        
    let data_send = $sorteo_form.serialize();
    let url = "../q/index.php/api/servicio_sorteo/index/format/json/";
    bloquea_form(".sorteo_form");
    request_enid("POST", data_send, url, response_registro_sorteo);
    
    e.preventDefault();
}
let response_registro_sorteo = function(data){

    redirect("");    
}