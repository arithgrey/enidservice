"use strict";
$(document).ready(function(){

    $('.datetimepicker4').datepicker();
    $('.datetimepicker5').datepicker();
    $(".form_compras").submit(busqueda);
});
let busqueda = function(e){

    let data_send   =     $(".form_compras").serialize()+"&"+$.param({"v":1});
    let url 		=  "../q/index.php/api/stock/compras/format/json/";
    request_enid( "GET",  data_send, url, response_busqueda, ".place_compras" );

    e.preventDefault();
}
let response_busqueda = function(data){
    llenaelementoHTML(".place_compras" , data);
}