"use strict";
$(document).ready(function(){
	
	$(".monto_a_ingresar").keyup(valida_monto_ingreso);	
});
let valida_monto_ingreso = function(){

	let valor =  this.value;
	$(".monto_a_ingresar").val(quitar_espacios_numericos(valor));		
}