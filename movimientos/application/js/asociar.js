$(document).ready(function(){	
	$(".numero_tarjeta").keyup(function(){

		valor = $(".numero_tarjeta").val();
		console.log(valor.length);
		nuevo =  quitar_espacios_numericos(valor);
		$(".numero_tarjeta").val(nuevo);

	});

});
/**/
