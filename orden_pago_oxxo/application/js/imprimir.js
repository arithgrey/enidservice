$(document).ready(function(){
	/**/
	$(".imprimir").click(carga_fuente_impresion);
});
/**/
function carga_fuente_impresion(){

	var contenedor=  $(".contenedor_orden_pago").html();
	/*Agregamos el formato*/	
	$(".contenido_imp").val(contenedor);
	$(".form_imprimir").submit();
	
	
}