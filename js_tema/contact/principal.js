"use strict";
$(document).ready(function(){
	$(".selector").click(muestra_opciones);
	$(".form_correo").submit(envia_correo);
	$(".form_whatsapp").submit(envia_whatsapp);
	
});
let muestra_opciones = function(){
	let id 			= 	get_parameter_enid( $(this) , "id");
	$(".text_selector").hide();
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
};
let envia_correo = function(e){
	

	let nombre 	= 	get_parameter(".nombre");
	let correo 	= 	get_parameter(".correo_electronico");

	if ( nombre.length > 5 && correo.length > 5 ){

		let password 	 = 	""+CryptoJS.SHA1(randomString(8));					
		let data_send 	 = 	$(".form_correo").serialize()+"&"+$.param({"password":password});			
		let url 		 = 	"../q/index.php/api/usuario/vendedor/format/json/";
		bloquea_form(".form_correo");
		request_enid("POST",  data_send , url , response_send_email);					

	}else{
		
		focus_input([".correo_electronico" ,".nombre_correo"]);
	}
	e.preventDefault();	
	
};
let response_send_email = function(data){
	redirect("../contact/?ubicacion=1#direccion");
};
let envia_whatsapp = function(e){
	
	let nombre 	= 	get_parameter(".nombre_whatsapp").length;
	let tel 	= 	get_parameter(".tel").length;

	if ( nombre > 5 && tel > 5 ){
		

		let password 	 = ""+CryptoJS.SHA1(randomString(8));					
		let data_send 	 = $(".form_whatsapp").serialize()+"&"+$.param({"password":password});					
		let url 		 = "../q/index.php/api/usuario/whatsapp/format/json/";
		bloquea_form(".form_whatsapp");
		request_enid("POST",  data_send , url , response_send_whatsApp);

	}else{			
		let inputs = [".tel" ,".nombre_whatsapp"];
		focus_input(inputs);

	}

	e.preventDefault();		
};
let response_send_whatsApp = function (data) {

	let usuario = data.id_usuario;
	set_parameter(".usuario" , usuario);
	$(".form_proceso_compra").submit();
};