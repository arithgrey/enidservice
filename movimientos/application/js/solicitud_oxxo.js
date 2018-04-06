$(document).ready(function(){	
	
	$(".monto_a_ingresar").keyup(valida_monto_ingreso);	
});
/**/
function valida_monto_ingreso(){

	valor =  this.value; 	
	$(".monto_a_ingresar").val(quitar_espacios_numericos(valor));		
}