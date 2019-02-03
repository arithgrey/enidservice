//"use strict";
$(document).on("ready", function(){

	$("footer").ready(valida_seccion_inicial);
	$(".btn_soy_nuevo").click(mostrar_seccion_nuevo_usuario);
	$(".btn_soy_nuevo_simple").click(mostrar_seccion_nuevo_usuario);
	$(".registrar-cuenta").click(mostrar_seccion_nuevo_usuario);
	$(".form_sesion_enid").submit(valida_form_session);
	$(".form-pass").submit(recupera_password);
	$("#olvide-pass").click(carga_mail);
	$(".form-miembro-enid-service").submit(agrega_usuario);
	$(".recupara-pass").click(muestra_contenedor_recuperacion);
	$(".btn_acceder_cuenta_enid").click(muestra_seccion_acceso);
	$(".nombre_persona").keyup(function(){
		transforma_mayusculas(this);
	});
	display_elements([".extra_menu_simple"] , 1  );	
	display_elements([".base_compras" ,".base_paginas_extra" , ".info_metodos_pago"] , 0  );
	$("#mail").keyup(function(){
		sin_espacios("#mail");
	});
	$("#email_recuperacion").keyup(function(){
		sin_espacios("#email_recuperacion");
	});


});
let inicio_session =  function(){


	let url 		= get_option("url");
	let data_send	= { secret:get_option("tmp_password") , "email" : get_option("email") };
	if (get_parameter("#mail").length > 5 &&  get_parameter("#pw").length > 5){
		request_enid( "POST",  data_send , url , response_inicio_session , 1 , before_inicio_session); 
	}else{		
		let inputs = ["#email", "#pw"];
		focus_input(inputs);				
	}
}
let before_inicio_session =  function(){
	desabilita_botones();
	show_load_enid(".place_acceso_sistema" ,  "Validando datos " , 1 );
}
let response_inicio_session =  function(data){

	if(data != 0){
		redirect(data);
	}else{
		habilita_botones();
		format_error(".place_acceso_sistema" , "Error en los datos de acceso");
	}
}
let valida_form_session =  function(e){

	let  pw 	= $.trim(get_parameter("#pw"));	
	let  email 	= get_parameter('#mail');	
	if(	valida_formato_pass(pw) == valida_formato_email(email) ){		

		let tmp_password = ""+CryptoJS.SHA1(pw);
		set_option("tmp_password" , tmp_password);	
		set_option("url" , $("#in").attr("action"));
		set_option("email" , email);
		inicio_session();
	}
	e.preventDefault();
}
let recupera_password =  function(e){

	let  flag= valida_email_form("#email_recuperacion" ,  ".place_recuperacion_pw" );  	
	if (flag ==1 ){
		$(".place_recuperacion_pw").empty();
		let url = $(".form-pass").attr("action");		
		let data_send =  $(".form-pass").serialize();
		bloquea_form(".form-pass");
		request_enid( "POST",  data_send , url , response_recupera_password  , ".place_status_inicio");
	}
	e.preventDefault();	
}
let  response_recupera_password  = function(data){

	if(data ==  1){

		$('#contenedor-form-recuperacion').find('input, textarea, button, select').attr('disabled','disabled');
		let newDiv = document.createElement("div" );
		newDiv.setAttribute("class", "envio_correcto");
		let newContent = document.createTextNode("El correo de recuperación se ha enviado con éxito.!");
		newDiv.appendChild(newContent);
		llenaelementoHTML(".place_recuperacion_pw" ,  newDiv);
		show_response_ok_enid(".place_status_inicio" , newDiv);
	}

}
let  carga_mail =  function(){

	$("#email_recuperacion").val(get_parameter("#mail"));

}
let  valida_formato_pass =  function(text){
	let estado = 0;
	if(text.length >= 8){
		estado =1;
	}else{
		format_error( ".place_acceso_sistema", "Contraseña muy corta!");
	}
	return estado;
}
let  valida_formato_email =  function(email){
	estado = 1;
	expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!expr.test(email)){		
		estado = 0;		
		format_error(".place_acceso_sistema" , "Correo no valido");
	}
	return estado;
}
let  habilita_botones =  function(){
	for (a=0; a < document.getElementsByTagName('input').length; a++){
		document.getElementsByTagName('input')[a].disabled = false;		
	}
}
let  desabilita_botones  =  function(){
	
	for(a=0; a < document.getElementsByTagName('input').length; a++){
		document.getElementsByTagName('input')[a].disabled = true;
	}
}
let  mostrar_seccion_nuevo_usuario =  function(){

	display_elements( [".contenedor_recuperacion_password" , ".wrapper_login"], 0);
	display_elements( [".seccion_registro_nuevo_usuario_enid_service"], 1);
	
}
let  agrega_usuario =  function(e){

	let url 		= "../q/index.php/api/usuario/vendedor/format/json/";
	let password 	=  get_parameter(".form-miembro-enid-service .password");
	let email 		=  get_parameter(".form-miembro-enid-service .email");
	let nombre 		=  get_parameter(".form-miembro-enid-service .nombre");

	if(valida_formato_email(email) ==  valida_formato_pass(password)){
		if(valida_text_form(".nombre" , ".place_registro_miembro" , 5 , "Nombre" ) ==  1){
			
			let tmp_password = ""+CryptoJS.SHA1(password);		
			set_option("tmp_password" , tmp_password);			
			set_option("email" , email);	
			set_option("nombre" ,nombre);	
			let  data_send = {"nombre" : nombre , "email" : email , "password": tmp_password , "simple" : 1 };
			request_enid("POST",  data_send , url , response_usuario_registro);			
		}
	}
	e.preventDefault();
}
let  response_usuario_registro =  function(data){

	
	if (data.usuario_registrado ==   1) {						
		llenaelementoHTML(".place_acceso_sistema" ,  "<a class='acceder_btn'> Registro correcto! ahora puedes acceder aquí!</a>");
		habilita_botones();						
		redirect("?action=registro");
	}else{
	
		if(data.usuario_existe ==  1) {
			llenaelementoHTML(".place_registro_miembro" , "<span class='alerta_enid'> Este usuario ya se encuentra registrado, <span class='acceso_a_cuenta'> accede a tu cuenta aquí </span> </span>");   			
			$(".acceso_a_cuenta").click(muestra_seccion_acceso);							
			habilita_botones();

		}				
	}				
}
let  muestra_seccion_acceso = function(){
	display_elements([".wrapper_login"] , 1);
	display_elements([".contenedor_recuperacion_password" , ".seccion_registro_nuevo_usuario_enid_service" ] ,  0);
}
let muestra_contenedor_recuperacion =  function(){
	
	display_elements([".wrapper_login" , ".seccion_registro_nuevo_usuario_enid_service" ] , 0 );
	display_elements([".contenedor_recuperacion_password" ] , 1 );
}
let  valida_seccion_inicial = function(){
	switch(get_parameter(".action")){
	    case "nuevo":
			mostrar_seccion_nuevo_usuario();
	        break;	    
	    case "recuperar":
	    	muestra_contenedor_recuperacion();
	    	break;    
	    case "registro":
	    	facilita_acceso();
	    	break;    
	    default:	    	
	} 
}
let facilita_acceso = function(){	
	let secciones = [".olvide_pass"  , ".registrar_cuenta" ,".btn_soy_nuevo" , ".iniciar_sesion_lateral" , ".call_to_action_anuncio" , ".contenedor-lateral-menu"];
	display_elements(secciones , 0);	
};
