"use strict";

let $utilidad_form = $(".utilidad_form");
let $input_precio  = $(".precio");
let $input_costo  = $(".costo");
let $input_venta  = $(".venta");
let $input_entrega  = $(".entrega");
let $input_otro  = $(".otro");

$(document).ready(() => {
    
    $utilidad_form.submit(simila_ventas);
    
});

let simila_ventas = function(e){
    
    
    let data_send = $utilidad_form.serialize();
    let url = "../q/index.php/api/simulador/index/format/json/";
    bloquea_form(".utilidad_form");
    request_enid("GET", data_send, url, response_utilidad);
    
    e.preventDefault();
}
let response_utilidad = function(data){

    render_enid(".simulacion_gastos_utilidad", data);
    recorre(".simulacion_gastos_utilidad");
    desbloqueda_form(".utilidad_form");
}