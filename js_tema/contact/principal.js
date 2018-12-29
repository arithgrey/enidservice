$(document).ready(function(){
	$(".selector").click(muestra_opciones);
	$(".form_correo").submit(envia_correo);
	$(".form_whatsapp").submit(envia_whatsapp);
	
});
var muestra_opciones = function(){
	var id 			= 	get_parameter_enid( $(this) , "id");
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
var envia_correo = function(e){
	

	var nombre 	= 	get_parameter(".nombre");
	var correo 	= 	get_parameter(".correo_electronico");

	if ( nombre.length > 5 && correo.length > 5 ){

		var password 	 = 	""+CryptoJS.SHA1(randomString(8));					
		var data_send 	 = 	$(".form_correo").serialize()+"&"+$.param({"password":password});			
		var url 		 = 	"../q/index.php/api/usuario/vendedor/format/json/";
		bloquea_form(".form_correo");
		request_enid("POST",  data_send , url , response_send_email);					

	}else{
		
		focus_input([".correo_electronico" ,".nombre_correo"]);
	}
	e.preventDefault();	
	
};
var response_send_email = function(data){
	redirect("../contact/?ubicacion=1#direccion");
};
var envia_whatsapp = function(e){
	
	var nombre 	= 	get_parameter(".nombre_whatsapp").length;
	var tel 	= 	get_parameter(".tel").length;

	if ( nombre > 5 && tel > 5 ){
		

		var password 	 = ""+CryptoJS.SHA1(randomString(8));					
		var data_send 	 = $(".form_whatsapp").serialize()+"&"+$.param({"password":password});					
		var url 		 = "../q/index.php/api/usuario/whatsapp/format/json/";
		bloquea_form(".form_whatsapp");
		request_enid("POST",  data_send , url , response_send_whatsApp);

	}else{			
		var inputs = [".tel" ,".nombre_whatsapp"];
		focus_input(inputs);

	}

	e.preventDefault();		
};
var response_send_whatsApp = function (data) {

	var usuario = data.id_usuario;
	set_parameter(".usuario" , usuario);
	$(".form_proceso_compra").submit();
};