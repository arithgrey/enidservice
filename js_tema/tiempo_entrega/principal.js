"use strict";
$(document).ready(function(){

    $(".form_tiempo_entrega").submit(busqueda);
});
let busqueda =  (e) =>{


    let data_send = $(".form_tiempo_entrega").serialize();
    let url  		=  "../q/index.php/api/recibo/tiempo_venta/format/json/";
    request_enid( "GET",  data_send, url, r_busqueda);
    e.preventDefault();

}
let r_busqueda =  (data)  => {

    render_enid(".place_tiempo_entrega" , data)
}