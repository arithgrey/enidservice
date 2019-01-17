"use strict";
$(document).ready(function(){
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
	$("#form_update_password").submit(set_password);	
	$(".editar_imagen_perfil").click(carga_form_imagenes_usuario);
	$(".f_telefono_usuario").submit(actualiza_telefono_usuario);
	$(".f_telefono_usuario_negocio").submit(set_telefono_usuario_negocio);

	
});
var  carga_direccion_usuario = function(){

	var url 		=  "../q/index.php/api/usuario_direccion/index/format/json/";		
	var data_send 	=  $(".form_notificacion").serialize()+"&"+$.param({"v":get_option("v")});
	request_enid( "GET",  data_send, url, response_direccion_usuario);

}
var response_direccion_usuario = function(data){


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
var  registra_direccion_usuario = function(e){
	debugger;

	if(get_option("existe_codigo_postal") ==  1){			
		
		var url 			=  	"../q/index.php/api/codigo_postal/direccion_usuario/format/json/";	
		var data_send 		=  	$(".form_direccion_envio").serialize()+"&"+$.param({"direccion_principal" : 1});						
		var asentamiento 	= 	get_parameter(".asentamiento");
		if (asentamiento != 0 ) {
			request_enid( "POST",  data_send, url, response_registra_direccion_usuario, ".place_proyectos" );
			$(".place_asentamiento").empty();		
		}else{
			recorrepage("#asentamiento");										
			llenaelementoHTML( ".place_asentamiento" ,  "<span class='alerta_enid'>Seleccione</span>");					
		}		
	}
	e.preventDefault();
}
var  response_registra_direccion_usuario = function(data){
	set_option("v" , 1);
	carga_direccion_usuario();
}
var  actualiza_nombre_usuario = function(e){

	var data_send=  $(".f_nombre_usuario").serialize();  
	var url =  "../q/index.php/api/usuario/nombre_usuario/format/json/";		
	request_enid("PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_nombre_usuario" , "Tu nombre de usuario fue actualizado!");
	},".registro_nombre_usuario" );
	e.preventDefault();
}
var actualiza_telefono_usuario = function(e){

	var data_send=  $(".f_telefono_usuario").serialize();  
	var url =  "../q/index.php/api/usuario/telefono/format/json/";			
	request_enid( "PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_telefono_usuario" , "Tu teléfono fue actualizado!");
	},".registro_telefono_usuario");
	e.preventDefault();
}
var  set_telefono_usuario_negocio = function(e){


	if (get_parameter(".tel2").length > 4 && get_parameter(".lada2").length > 1 ){

		var data_send	=  $(".f_telefono_usuario_negocio").serialize();  	
		var url 		=  "../q/index.php/api/usuario/telefono_negocio/format/json/";			
		request_enid( "PUT",  data_send, url, function(){
			show_response_ok_enid(".registro_telefono_usuario_negocio" , "Tu teléfono fue actualizado!");
		}  , ".registro_telefono_usuario_negocio" );
		
	}else{		
		var inputs = [".tel2", ".lada2"];
		focus_input(inputs);				
	}
	e.preventDefault();
}
var  quita_espacios_nombre_usuario = function(){
	
	var nombre_usuario 	=  	$(this).val();
	var nuevo_text 		= 	nombre_usuario.toLowerCase();
	$(this).val(quita_espacios_text(nuevo_text));

}
var  quita_espacios_text = function(nuevo_valor){

	var valor  ="";
	for(var a = 0; a < nuevo_valor.length; a++){		
		if(nuevo_valor[a] != " "){				
			valor += nuevo_valor[a]; 						
		}
	}
	return valor;	
}
var  set_password = function(e){

	var flag 			=  valida_text_form("#password" , ".place_pw_1" , 7 , "Texto " );			
	var flag2 			=  valida_text_form("#pw_nueva" , ".place_pw_2" , 7 , "Texto " );			
	var flag3 			=  valida_text_form("#pw_nueva_confirm" , ".place_pw_3" , 7 , "Texto " );			
	var nueva_password 	= 0;
	
	if (flag == flag2 && flag ==  flag3) {	
		/*Ahora validamos que no sean las mismas que la antigua*/		
		nueva_password = (get_parameter("#password") !=  get_parameter("#pw_nueva") ) ? 1: 2;
		if (get_parameter("#password") !=  get_parameter("#pw_nueva_confirm") ){nueva_password =  1;}else{nueva_passwor	 =  2;}		

	}


	switch(nueva_password){
		case 1: 
			
			var a = get_parameter("#password");
			var b = get_parameter("#pw_nueva");
			var c = get_parameter("#pw_nueva_confirm");

			var anterior = "" +CryptoJS.SHA1(a);
			var nuevo = "" +CryptoJS.SHA1(b);
			var confirma = "" +CryptoJS.SHA1(c);
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
function  actualiza_password(anterior , nuevo , confirma){
	
	var 		url 		=	"../q/index.php/api/usuario/pass/format/json/";	
	var 		data_send 	= 	{"nuevo": nuevo, "anterior": anterior, "confirma": confirma , "type": 2};
	request_enid( "PUT",  data_send, url, resp_actualizacion_pass, ".msj_password" );
}
var resp_actualizacion_pass = function(data){

	if(data == true){				
		show_response_ok_enid(".msj_password" , "Contraseña actualizada, inicia sessión para verificar el cambio.");	
		setInterval('termina_session()',3000);
	}else{
		llenaelementoHTML(".msj_password" , data );			
	}
};

/*
function auto_completa_direccion(){
	

	
	quita_espacios(".codigo_postal"); 	
	var cp = get_parameter(".codigo_postal");
	var numero_caracteres = cp.length; 
	if(numero_caracteres > 4 ) {
		var url 		=  "../portafolio/index.php/api/portafolio/cp/format/json/";	
		var data_send 	=  {"cp" : cp , "delegacion" : get_delegacion() };
		request_enid( "GET",  data_send , url , response_auto_complete_direccion );
	}

}
*/