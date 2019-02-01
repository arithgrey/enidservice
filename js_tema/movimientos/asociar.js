"use strict";
$(document).ready(function(){
	$(".numero_tarjeta").keyup(function(){

		let valor = get_parameter(".numero_tarjeta");
		console.log(valor.length);
		let nuevo =  quitar_espacios_numericos(valor);
		$(".numero_tarjeta").val(nuevo);

	});

});
