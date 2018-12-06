$(document).ready(function(){
	$(".codigo_postal").keyup(auto_completa_direccion);						
	$(".numero_exterior").keyup(function (){quita_espacios(".numero_exterior");});
	$(".numero_interior").keyup(function (){quita_espacios(".numero_interior"); });					
	$(".form_direccion_envio").submit(registra_nueva_direccion);
	
	
});
/*
function registra_nueva_direccion(e){

	if(get_option("existe_codigo_postal") ==  1){
		registro_direccion();	
		
	}else{
		muestra_error_codigo(1);
	}
	e.preventDefault();
}*/
/*
function registro_direccion(){
	alert();
	if (asentamiento != 0 ){
		
		set_option("id_recibo" , $(".id_recibo").val());
		var data_send 		=  	$(".form_direccion_envio").serialize();		
		var url =  	"../q/index.php/api/codigo_postal/direccion_envio_pedido/format/json/";
		request_enid( "POST",  data_send , url , response_registro_direccion);
	}else{
		recorrepage("#asentamiento");										
		llenaelementoHTML( ".place_asentamiento" ,  "<span class='alerta_enid'>Seleccione</span>");
	}
}
function muestra_error_codigo(flag_error){
	llenaelementoHTML( ".place_codigo_postal" ,  "");
	if (flag_error ==  1) {
		$(".codigo_postal").css("border" , "1px solid rgb(13, 62, 86)");			
		var mensaje_user =  "Codigo postal invalido, verifique"; 		
		llenaelementoHTML( ".place_codigo_postal" ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
		recorrepage("#codigo_postal");
	}
}
var  response_registro_direccion = function(data){

	if (data != -1 ){
		
		var url =  "../pedidos/?seguimiento="+get_option("id_recibo")+"&domicilio=1";		
		alert(url);
		redirect(url);
	}else{

		format_error( ".notificacion_direccion", "VERIFICA LOS DATOS DE TU DIRECCIÓN");
		recorrepage(".notificacion_direccion");
	}	
}
*/