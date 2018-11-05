$(document).ready(function(){
	$(".selector").click(muestra_opciones);
	$(".form_correo").submit(envia_correo);
	$(".form_whatsapp").submit(envia_whatsapp);
	
});
var muestra_opciones = function(){

	var id 			= 	get_parameter_enid($(this) , "id");
	switch(id){

		case "1":			

			showonehideone(".contenedor_eleccion_correo_electronico", ".contenedor_eleccion");

			break;
		case "2":

			showonehideone(".contenedor_eleccion_whatsapp", ".contenedor_eleccion");
			break;	

		default:

		break;
	}
}
var envia_correo = function(e){
	
	var password 	 = ""+CryptoJS.SHA1(randomString(8));					
	var data_send 	 = $(".form_correo").serialize()+"&"+$.param({"password":password});			
	var url 		 = "../q/index.php/api/usuario/vendedor/format/json/";
	bloquea_form(".form_correo");
	request_enid("POST",  data_send , url , response_send_email);					
	e.preventDefault();	
	
}
var response_send_email = function(data){
	redirect("../contact/?ubicacion=1#direccion");
}
var envia_whatsapp = function(e){
	
	var password 	 = ""+CryptoJS.SHA1(randomString(8));					
	var data_send 	 = $(".form_whatsapp").serialize()+"&"+$.param({"password":password});					
	var url 		 = "../q/index.php/api/usuario/whatsapp/format/json/";
	bloquea_form(".form_whatsapp");
	request_enid("POST",  data_send , url , response_send_email);			

	e.preventDefault();	
	
}