"use strict";
$(document).ready(function(){

    $('.datetimepicker4').datepicker();
    $('.datetimepicker5').datepicker();
    $(".form_compras").submit(busqueda);
});
var busqueda = function(e){

    var data_send   =     $(".form_compras").serialize()+"&"+$.param({"v":1});
    var url 		=  "../q/index.php/api/stock/compras/format/json/";
    request_enid( "GET",  data_send, url, response_busqueda, ".place_compras" );

    e.preventDefault();
}
var response_busqueda = function(data){
    llenaelementoHTML(".place_compras" , data);
}