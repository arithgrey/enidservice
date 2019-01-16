"use strict";
$(document).ready(function(){
	$(".numero_tarjeta").keyup(function(){

		var valor = get_parameter(".numero_tarjeta");
		console.log(valor.length);
		var nuevo =  quitar_espacios_numericos(valor);
		$(".numero_tarjeta").val(nuevo);

	});

});
