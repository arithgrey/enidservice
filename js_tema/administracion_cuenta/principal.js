$(document).ready(function(){	
	/**/
	$(".btn_direccion").click(function(){
		set_option("v",1);
		carga_direccion_usuario();	
	});	

	$(".f_nombre_usuario").submit(actualiza_nombre_usuario);	
	$(".tab_privacidad_seguridad").click(get_conceptos);
	$(".nombre_usuario").keyup(quita_espacios_nombre_usuario);
	$(".tel2").keyup(function(){
		quita_espacios(".tel2");		
	});
	$(".lada2").keyup(function(){
		quita_espacios(".lada2");		
	});
	/**/
	$("#form_update_password").submit(update_password);	
	$(".editar_imagen_perfil").click(carga_form_imagenes_usuario);
	$(".f_telefono_usuario").submit(actualiza_telefono_usuario);
	$(".f_telefono_usuario_negocio").submit(actualiza_telefono_usuario_negocio);

	//$(".form_direccion_envio").submit(registra_nueva_direccion);
});
/**/
function carga_direccion_usuario(){
	/**/	
	var url =  "../q/index.php/api/usuario_direccion/index/format/json/";		
	var data_send =  $(".form_notificacion").serialize()+"&"+$.param({"v":get_option("v")});
	request_enid( "GET",  data_send, url, response_direccion_usuario);
}
/**/
function response_direccion_usuario(data){

	llenaelementoHTML(".direcciones" , data);
	$(".codigo_postal").keyup(auto_completa_direccion);						
	$(".numero_exterior").keyup(function (){quita_espacios(".numero_exterior");});
	$(".numero_interior").keyup(function (){quita_espacios(".numero_interior"); });					
	$(".form_direccion_envio").submit(registra_direccion_usuario);
	$(".editar_direccion_persona").click(function(){
		set_option("v" , 2);
		carga_direccion_usuario();

	});

}
/*Solo para usuario*/
function registra_direccion_usuario(e){

	if(get_existe_codigo_postal() ==  1){			
		var url =  "../q/index.php/api/portafolio/direccion_usuario/format/json/";	
		var data_send =  $(".form_direccion_envio").serialize()+"&"+$.param({"direccion_principal" : 1});						
		var asentamiento = $(".asentamiento").val();
				if (asentamiento != 0 ) {
					request_enid( "POST",  data_send, url, response_registra_direccion_usuario, ".place_proyectos" );
					$(".place_asentamiento").empty();		
				}else{
					recorrepage("#asentamiento");										
					llenaelementoHTML( ".place_asentamiento" ,  "<span class='alerta_enid'>Seleccione</span>");					
				}		

	}else{
		muestra_error_codigo(1);
	}
	e.preventDefault();
}
/**/
function response_registra_direccion_usuario(data){
	set_option("v" , 1);
	carga_direccion_usuario();
}
/**/
function actualiza_nombre_usuario(e){
	var data_send=  $(".f_nombre_usuario").serialize();  
	var url =  "../q/index.php/api/usuario/nombre_usuario/format/json/";		
	request_enid("PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_nombre_usuario" , "Tu nombre de usuario fue actualizado!");
	},".registro_nombre_usuario" );
	e.preventDefault();
}
/**/
function actualiza_telefono_usuario(e){

	var data_send=  $(".f_telefono_usuario").serialize();  
	var url =  "../q/index.php/api/usuario/telefono/format/json/";			
	request_enid( "PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_telefono_usuario" , "Tu teléfono fue actualizado!");
	},".registro_telefono_usuario");
	e.preventDefault();
}
/**/
function actualiza_telefono_usuario_negocio(e){


	var data_send=  $(".f_telefono_usuario_negocio").serialize();  	
	var url =  "../q/index.php/api/usuario/telefono_negocio/format/json/";			
	request_enid( "PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_telefono_usuario_negocio" , "Tu teléfono fue actualizado!");
	}  , ".registro_telefono_usuario_negocio" );
	e.preventDefault();
}
/**/
function quita_espacios_nombre_usuario(){	
	
	nombre_usuario =  $(this).val(); 	
	var nuevo_text = nombre_usuario.toLowerCase();	
	$(this).val(quita_espacios_text(nuevo_text));
}
/**/
function quita_espacios_text(nuevo_valor){
	valor  ="";
	for(var a = 0; a < nuevo_valor.length; a++){		
		if(nuevo_valor[a] != " "){				
			valor += nuevo_valor[a]; 						
		}
	}
	return valor;	
}
/**/
function update_password(e){
	
	flag = 0; 
	flag2 = 0;
	flag3 = 0;
	flag =  valida_text_form("#password" , ".place_pw_1" , 7 , "Texto " );			
	flag2 =  valida_text_form("#pw_nueva" , ".place_pw_2" , 7 , "Texto " );			
	flag3 =  valida_text_form("#pw_nueva_confirm" , ".place_pw_3" , 7 , "Texto " );			
	nueva_password = 0;
	
	msj_user = "";
	if (flag == flag2 && flag ==  flag3) {
	
			/*Ahora validamos que no sean las mismas que la antigua*/			
			if ($("#password").val() !=  $("#pw_nueva").val() ){nueva_password =  1;}else{nueva_password =  2;}
			if ($("#password").val() !=  $("#pw_nueva_confirm").val() ){nueva_password =  1;}else{nueva_passwor	 =  2;}		
	}


	switch(nueva_password){
		case 1: 
			a = $("#password").val();
			b = $("#pw_nueva").val();
			c = $("#pw_nueva_confirm").val();
			anterior = "" +CryptoJS.SHA1(a);
			nuevo = "" +CryptoJS.SHA1(b);
			confirma = "" +CryptoJS.SHA1(c);
			actualiza_password(anterior , nuevo , confirma); 			
			break;
		case 2:			
			llenaelementoHTML(".msj_password" , "La nueva contraseña no puede ser igual a la actual ");
			break;
		default: 
			break;
	}

	e.preventDefault();
}
/**/
function termina_session(){
	url =   '../login/index.php/startsession/logout/';
	redirect(url);	
}
/**/
function  actualiza_password(anterior , nuevo , confirma){
	
	var url ="../q/index.php/api/usuario/pass/format/json/";	
	var data_send = {"nuevo": nuevo, "anterior": anterior, "confirma": confirma , "type": 2};
	request_enid( "PUT",  data_send, url, response_actualizacion_pass, ".msj_password" );
}
/**/
function response_actualizacion_pass(data){

	if(data == true){				
		show_response_ok_enid(".msj_password" , "Contraseña actualizada correctamente, inicia sessión para verificar el cambio.");	
		setInterval('termina_session()',3000);
	}else{
		llenaelementoHTML(".msj_password" , data );			
	}			
	
}
/**/