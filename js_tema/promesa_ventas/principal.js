"use strict";

let $promesa_venta_form = $(".promesa_venta_form");

$(document).ready(() => {
    
    $promesa_venta_form.submit(promesa_venta);
    
});

let promesa_venta = function(e){
        
    let data_send = $promesa_venta_form.serialize();
    let url = "../q/index.php/api/servicio_meta/index/format/json/";
    bloquea_form(".promesa_venta_form");
    request_enid("POST", data_send, url, response_promesa_venta);
    
    e.preventDefault();
}
let response_promesa_venta = function(data){

    redirect(path_enid(""));
    
}