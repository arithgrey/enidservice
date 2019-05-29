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

	$(".form_telefono_usuario").submit(actualiza_telefono);


	$(".f_telefono_usuario_negocio").submit(set_telefono_usuario_negocio);

	
});
let  carga_direccion_usuario = function(){

	let url 		=  "../q/index.php/api/usuario_direccion/index/format/json/";		
	let data_send 	=  $(".form_notificacion").serialize()+"&"+$.param({"v":get_option("v")});
	request_enid( "GET",  data_send, url, response_direccion_usuario);

}
let response_direccion_usuario = function(data){


	render_enid(".direcciones" , data);
	$(".codigo_postal").keyup(auto_completa_direccion);						
	$(".numero_exterior").keyup(function (){quita_espacios(".numero_exterior");});
	$(".numero_interior").keyup(function (){quita_espacios(".numero_interior"); });					
	$(".form_direccion_envio").submit(registra_direccion_usuario);
	$(".editar_direccion_persona").click(function(){
		set_option("v" , 2);
		carga_direccion_usuario();

	});

}
let  registra_direccion_usuario = function(e){
	debugger;

	if(get_option("existe_codigo_postal") ==  1){			
		
		let url 			=  	"../q/index.php/api/codigo_postal/direccion_usuario/format/json/";	
		let data_send 		=  	$(".form_direccion_envio").serialize()+"&"+$.param({"direccion_principal" : 1});						
		let asentamiento 	= 	get_parameter(".asentamiento");
		if (asentamiento != 0 ) {
			request_enid( "POST",  data_send, url, response_registra_direccion_usuario, ".place_proyectos" );
			$(".place_asentamiento").empty();		
		}else{
			recorrepage("#asentamiento");										
			render_enid( ".place_asentamiento" ,  "<span class='alerta_enid'>Seleccione</span>");					
		}		
	}
	e.preventDefault();
}
let  response_registra_direccion_usuario = function(data){
	set_option("v" , 1);
	carga_direccion_usuario();
}
let  actualiza_nombre_usuario = function(e){

	let data_send=  $(".f_nombre_usuario").serialize();  
	let url =  "../q/index.php/api/usuario/nombre_usuario/format/json/";		
	request_enid("PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_nombre_usuario" , "Tu nombre de usuario fue actualizado!");
	},".registro_nombre_usuario" );
	e.preventDefault();
}
let actualiza_telefono = function(e){

	let data_send=  $(".form_telefono_usuario").serialize();
	let url =  "../q/index.php/api/usuario/telefono/format/json/";			
	request_enid( "PUT",  data_send, url, function(){
		show_response_ok_enid(".registro_telefono_usuario" , "Tu teléfono fue actualizado!");
	},".registro_telefono_usuario");

	e.preventDefault();
}
let  set_telefono_usuario_negocio = function(e){


	if (get_parameter(".tel2").length > 4 && get_parameter(".lada2").length > 1 ){

		let data_send	=  $(".f_telefono_usuario_negocio").serialize();  	
		let url 		=  "../q/index.php/api/usuario/telefono_negocio/format/json/";			
		request_enid( "PUT",  data_send, url, function(){
			show_response_ok_enid(".registro_telefono_usuario_negocio" , "Tu teléfono fue actualizado!");
		}  , ".registro_telefono_usuario_negocio" );
		
	}else{		
		let inputs = [".tel2", ".lada2"];
		focus_input(inputs);				
	}
	e.preventDefault();
}
let  quita_espacios_nombre_usuario = function(){
	
	let nombre_usuario 	=  	$(this).val();
	let nuevo_text 		= 	nombre_usuario.toLowerCase();
	$(this).val(quita_espacios_text(nuevo_text));

}
let  quita_espacios_text = function(nuevo_valor){

	let valor  ="";
	for(let a = 0; a < nuevo_valor.length; a++){		
		if(nuevo_valor[a] != " "){				
			valor += nuevo_valor[a]; 						
		}
	}
	return valor;	
}
let  set_password = function(e){

	let flag 			=  valida_text_form("#password" , ".place_pw_1" , 7 , "Texto " );			
	let flag2 			=  valida_text_form("#pw_nueva" , ".place_pw_2" , 7 , "Texto " );			
	let flag3 			=  valida_text_form("#pw_nueva_confirm" , ".place_pw_3" , 7 , "Texto " );			
	let n_password  	= 0;
	
	if (flag == flag2 && flag ==  flag3) {	
		/*Ahora validamos que no sean las mismas que la antigua*/		
		let n_password = (get_parameter("#password") !=  get_parameter("#pw_nueva") ) ? 1: 2;
		if (get_parameter("#password") !=  get_parameter("#pw_nueva_confirm") ){
			let n_password  =  1;
		}else{
			let n_password 	 =  2;
		}

	}


	switch(n_password){
		case 1: 
			
			let a = get_parameter("#password");
			let b = get_parameter("#pw_nueva");
			let c = get_parameter("#pw_nueva_confirm");

			let anterior = "" +CryptoJS.SHA1(a);
			let nuevo = "" +CryptoJS.SHA1(b);
			let confirma = "" +CryptoJS.SHA1(c);
			actualiza_password(anterior , nuevo , confirma); 			
			break;
		case 2:			
			render_enid(".msj_password" , "La nueva contraseña no puede ser igual a la actual ");
			break;
		default: 
			break;
	}

	e.preventDefault();
}
function  actualiza_password(anterior , nuevo , confirma){
	
	let 		url 		=	"../q/index.php/api/usuario/pass/format/json/";	
	let 		data_send 	= 	{"nuevo": nuevo, "anterior": anterior, "confirma": confirma , "type": 2};
	request_enid( "PUT",  data_send, url, resp_actualizacion_pass, ".msj_password" );
}
let resp_actualizacion_pass = function(data){

	if(data == true){				
		show_response_ok_enid(".msj_password" , "Contraseña actualizada, inicia sessión para verificar el cambio.");	
		setInterval('termina_session()',3000);
	}else{
		render_enid(".msj_password" , data );			
	}
}