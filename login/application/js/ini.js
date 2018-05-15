$(document).on("ready", function(){	
	//$(".upper-links").css("display", "none");
	$("footer").ready(valida_seccion_inicial);
	/**/
	$(".btn_soy_nuevo").click(mostrar_seccion_nuevo_usuario);
	$(".btn_soy_nuevo_simple").click(mostrar_seccion_nuevo_usuario);

	$(".form_sesion_enid").submit(valida_form_session);
	$(".form-pass").submit(recupera_password);
	$("#olvide-pass").click(carga_mail);
	$(".form-miembro-enid-service").submit(agrega_usuario);
	/**/
	$(".recupara-pass").click(muestra_contenedor_recuperacion);
	$(".btn_acceder_cuenta_enid").click(muestra_seccion_acceso);
	$(".nombre_persona").keyup(function(){
		transforma_mayusculas(this);
	});
	carga_logo_enid();
});
/*****************************/
function inicio_session(){
	url = get_option("url");
	data_send= {secret:get_option("tmp_password") , "email" : get_option("email")}
	$.ajax({
		url : url , 
		type : "POST" , 
		data: data_send, 
		beforeSend : function(){										
			desabilita_botones();
			show_load_enid(".place_acceso_sistema" ,  "Validando datos " , 1 );
			} 					
		}).done(function(data){				
			if(data.in_session == 1){
				redirect("");
			}else{
				habilita_botones();
				llenaelementoHTML(".place_acceso_sistema" , data.mensaje);
			}	
			/**/
		}).fail(function(){				
			show_error_enid(".place_acceso_sistema" , "Error al iniciar sessión");				
		});					
}
/**/
function valida_form_session(e){
	
	pw = $.trim($("#pw").val());	
	email = $('#mail').val();		

	if(valida_formato_pass(pw) == valida_formato_email(email)){		
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

	/*Valida previo a enviar */
	$(".wrapper_login").empty();
	flag= valida_email_form("#email_recuperacion" ,  ".place_recuperacion_pw" );  
	
	if (flag ==1 ){
		$(".place_recuperacion_pw").empty();
		url = $(".form-pass").attr("action");	
		
		$.ajax({
			url :  url , 
			type: "POST", 
			data: $(".form-pass").serialize(),
			beforeSend: function(){
				show_load_enid( ".place_recuperacion_pw" , "Enviando a tu correo electrónico ... " , 1 ); 						
			}
		}).done(function(data){
			
			/**/
			$('#contenedor-form-recuperacion').find('input, textarea, button, select').attr('disabled','disabled');			
			console.log(data);
			llenaelementoHTML(".place_recuperacion_pw" ,  "El correo de recuperación se ha enviado con éxito.!" ); 			
			show_response_ok_enid(".place_status_inicio" , "El correo de recuperación se ha enviado con éxito.!");	
			/**/
		}).fail(function(){
			/**/
			show_error_enid(".place_recuperacion_pw"  , "Error en el envió, verifique que su correo sea correcto."); 
		});
	}
	e.preventDefault();	
}
/**/
function carga_mail(){
	mail =  $("#mail").val();
	$("#email_recuperacion").val(mail );
}
/**/
function set_option(key , value ){
	option[key] =  value;
}
/**/
function get_option(key){
	return option[key]; 
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

	$(".seccion_registro_nuevo_usuario_enid_service").show();
	$(".contenedor_recuperacion_password").hide();	
	$(".wrapper_login").hide();
}
/**/
function agrega_usuario(e){

	url = "../persona/index.php/api/persona/vendedor/format/json/";
	password =  $(".form-miembro-enid-service .password").val();
	email =  $(".form-miembro-enid-service .email").val();
	nombre =  $(".form-miembro-enid-service .nombre").val();

	if(valida_formato_email(email) ==  valida_formato_pass(password)){

		f =  valida_text_form(".nombre" , ".place_registro_miembro" , 5 , "Nombre" ); 
		if(f ==  1){
			tmp_password = ""+CryptoJS.SHA1(password);		
			set_option("tmp_password" , tmp_password);			
			set_option("email" , email);	
			set_option("nombre" , $(".form-miembro-enid-service .nombre").val());	

			/**/
			data_send= {"nombre" : get_option("nombre") , "email" : get_option("email") , "password": get_option("tmp_password")}			
			$.ajax({
				url : url , 
				type : "POST" , 
				data: data_send, 
				beforeSend : function(){										
					desabilita_botones();
					show_load_enid(".place_registro_miembro" ,  "Validando datos " , 1 );

				} 					
			}).done(function(data){	
					
					
					/**/
					if (data.usuario_registrado ==   1) {
						
						llenaelementoHTML(".place_acceso_sistema" ,  "<a class='acceder_btn'> Registro correcto! ahora puedes acceder aquí!</a>");
						habilita_botones();
						//showonehideone(  ".wrapper_login" , ".seccion_registro_nuevo_usuario_enid_service" );
						redirect("?action=registro");
						
					}else{
						
						if(data.usuario_existe ==  1) {
					
							llenaelementoHTML(".place_registro_miembro" , "<span class='alerta_enid'> Este usuario ya se encuentra registrado, <span class='acceso_a_cuenta'> accede a tu cuenta aquí </span> </span>");   			
							$(".acceso_a_cuenta").click(muestra_seccion_acceso);							
							habilita_botones();
						}
						
					}
					
			}).fail(function(){			
				habilita_botones();
				show_error_enid(".place_registro_miembro" , "Error al iniciar sessión");				
			});					
		}

	}
	e.preventDefault();
}
/**/
function muestra_seccion_acceso(){
	
	$(".wrapper_login").show();
	$(".seccion_registro_nuevo_usuario_enid_service").hide();
	$(".contenedor_recuperacion_password").hide();
}
/**/
function muestra_contenedor_recuperacion(){
	
	$(".wrapper_login").hide();
	$(".seccion_registro_nuevo_usuario_enid_service").hide();
	$(".contenedor_recuperacion_password").show();	
}
/**/
function valida_seccion_inicial(){
	
	switch($(".action").val()){
	    case "nuevo":
			mostrar_seccion_nuevo_usuario();
	        break;	    
	    case "recuperar":
	    	muestra_contenedor_recuperacion();
	    	break;    
	    default:	    	
	} 
}
/**/
function carga_logo_enid(){
	$(".extra_menu_simple").show();	
}