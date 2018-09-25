$(document).on("ready", function(){	
	//$(".upper-links").css("display", "none");
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
	
});
/*****************************/
function inicio_session(){


	var url 		= get_option("url");
	var data_send	= { secret:get_option("tmp_password") , "email" : get_option("email") }	
	if (get_parameter("#mail").length > 5 &&  get_parameter("#pw").length > 5){
		request_enid( "POST",  data_send , url , response_inicio_session , 1 , before_inicio_session); 
	}else{
		focus_input("#email");
		focus_input("#pw");
	}
}
/**/
function before_inicio_session(){
	desabilita_botones();
	show_load_enid(".place_acceso_sistema" ,  "Validando datos " , 1 );
}
/**/
function response_inicio_session(data){

	if(data == 1){
		redirect("");
	}else{
		habilita_botones();
		llenaelementoHTML(".place_acceso_sistema" , data);		
	}
}
/**/
function valida_form_session(e){
	/**/
	var  pw 	= $.trim(get_parameter("#pw"));	
	var  email 	= get_parameter('#mail');	
	if(	valida_formato_pass(pw) == valida_formato_email(email) ){		

		tmp_password = ""+CryptoJS.SHA1(pw);
		set_option("tmp_password" , tmp_password);	
		set_option("url" , $("#in").attr("action"));
		set_option("email" , email);
		inicio_session();
	}
	e.preventDefault();
}
/**/
function recupera_password(e){
	
	//$(".wrapper_login").empty();
	var  flag= valida_email_form("#email_recuperacion" ,  ".place_recuperacion_pw" );  	
	if (flag ==1 ){
		$(".place_recuperacion_pw").empty();
		var url = $(".form-pass").attr("action");		
		var data_send =  $(".form-pass").serialize();
		request_enid( "POST",  data_send , url , response_recupera_password  , ".place_status_inicio");
	}
	e.preventDefault();	
}
/**/
function response_recupera_password(data){

	$('#contenedor-form-recuperacion').find('input, textarea, button, select').attr('disabled','disabled');			
	llenaelementoHTML(".place_recuperacion_pw" ,  "El correo de recuperación se ha enviado con éxito.!" ); 			
	show_response_ok_enid(".place_status_inicio" , "El correo de recuperación se ha enviado con éxito.!");		
}
/**/
function carga_mail(){
	$("#email_recuperacion").val(get_parameter("#mail"));
}
/**/
function valida_formato_pass(text){
	estado = 0;
	if(text.length >= 8){
		estado =1;
	}else{
		$("#pw").css("border" , "1px solid rgb(13, 62, 86)");
		llenaelementoHTML(".place_acceso_sistema" , "<span class='error_login'> Contraseña muy corta! </span>");
	}
	return estado;
}
/**/
function valida_formato_email(email){
	estado = 1;
	expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!expr.test(email)){		
		estado = 0;
		llenaelementoHTML(".place_acceso_sistema" , "<span class='error_login'> Correo no valido </span>");		
	}
	return estado;
}
function habilita_botones(){
	for (a=0; a < document.getElementsByTagName('input').length; a++){
		document.getElementsByTagName('input')[a].disabled = false;		
	}
}
function desabilita_botones(){
	
	for(a=0; a < document.getElementsByTagName('input').length; a++){
		document.getElementsByTagName('input')[a].disabled = true;
	}
}
/**/
function mostrar_seccion_nuevo_usuario(){	

	display_elements( [".contenedor_recuperacion_password" , ".wrapper_login"], 0);
	display_elements( [".seccion_registro_nuevo_usuario_enid_service"], 1);
	
}
/**/
function agrega_usuario(e){

	var url 		= "../q/index.php/api/usuario/vendedor/format/json/";
	var password 	=  get_parameter(".form-miembro-enid-service .password");
	var email 		=  get_parameter(".form-miembro-enid-service .email");
	var nombre 		=  get_parameter(".form-miembro-enid-service .nombre");

	if(valida_formato_email(email) ==  valida_formato_pass(password)){
		if(valida_text_form(".nombre" , ".place_registro_miembro" , 5 , "Nombre" ) ==  1){
			
			var tmp_password = ""+CryptoJS.SHA1(password);		
			set_option("tmp_password" , tmp_password);			
			set_option("email" , email);	
			set_option("nombre" ,nombre);	
			var  data_send = {"nombre" : nombre , "email" : email , "password": tmp_password}												
			request_enid("POST",  data_send , url , response_usuario_registro);			
		}
	}
	e.preventDefault();
}
/**/
function response_usuario_registro(data){

	
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
/**/
function muestra_seccion_acceso(){
	display_elements([".wrapper_login"] , 1);
	display_elements([".contenedor_recuperacion_password" , ".seccion_registro_nuevo_usuario_enid_service" ] ,  0);
}
/**/
function muestra_contenedor_recuperacion(){
	
	display_elements([".wrapper_login" , ".seccion_registro_nuevo_usuario_enid_service" ] , 0 );
	display_elements([".contenedor_recuperacion_password" ] , 1 );
}
/**/
function valida_seccion_inicial(){	
	switch(get_parameter(".action")){
	    case "nuevo":
			mostrar_seccion_nuevo_usuario();
	        break;	    
	    case "recuperar":
	    	muestra_contenedor_recuperacion();
	    	break;    
	    default:	    	
	} 
}