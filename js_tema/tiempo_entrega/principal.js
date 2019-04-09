"use strict";
$(document).ready(function(){

    $(".form_tiempo_entrega").submit(busqueda);
});
let busqueda =  function (e) {


    let data_send = $(".form_tiempo_entrega").serialize();
    let url  		=  "../q/index.php/api/recibo/tiempo_venta/format/json/";
    request_enid( "GET",  data_send, url, response_busqueda);
    e.preventDefault();
}
let response_busqueda =  function (data) {

    llenaelementoHTML(".place_tiempo_entrega" , data)
}