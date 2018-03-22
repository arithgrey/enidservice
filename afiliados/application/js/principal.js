$(document).ready(function(){

	$(".inicia_registro").click(inicia_registro_afiliado);
	$(".form-miembro-enid-service").submit(registra_afiliado);
	$(".afiliar_usuario").submit(afilia_usuario_registrado);
	$(".nombre_persona").keyup(function(){
		transforma_mayusculas(this);
	});

});
/**/
function inicia_registro_afiliado(){

	recorrepage("#info_articulo");
	showonehideone( ".seccion_registro_afiliados" , ".seccion_continido_afiliados" );	
}
/**/

function registra_afiliado(e){
		
	text_password =  $.trim($(".password").val());
	
	if (text_password.length>7 ){
		flag =  valida_tel_form(".telefono_info_contacto" , ".place_num_tel"  );
		if (flag ==  1 ) {			
				$(".telefono_info_contacto").empty();
				flag_correo =  valida_email_form(".email" , ".place_correo_incorrecto");         				
				if(flag_correo == 1 ){
					
					flag =  valida_text_form(".nombre" , ".place_nombre_info" , 8 , "Nombre" );
					if (flag ==  1 ){

						$(".email").empty();
						url = "../persona/index.php/api/equipo/afiliado/format/json/";
						pw = $.trim($(".password").val());	
						pwpost = ""+CryptoJS.SHA1(pw);
						data_send =  {"password": pwpost , email : $(".email").val(),  nombre : $(".nombre").val() , telefono :  $(".telefono").val()};

						$.ajax({
							url : url , 
							type : "POST" , 
							data: data_send, 
							beforeSend : function(){						
								show_load_enid(".place_registro_afiliado" ,  "Validando datos " , 1 );
							} 					

							}).done(function(data){			
								
								
								if(data.usuario_existe > 0){				
									usuario_registrado =   "<span class='alerta_enid'>Este usuario ya se encuentra registrado</span><br><a href='../login/' class='blue_enid_background white' style='padding:5px;' >Acceder aquí</a>";
									llenaelementoHTML(".place_registro_afiliado" , usuario_registrado);				 				
								}else{
									next  = "../login?action=registro";												
									redirect(next);
								}				
							}).fail(function(){							
								show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");				
							});
						}
					}
			}		
	}else{
		llenaelementoHTML( ".place_password_afiliado" ,  "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
	}

	e.preventDefault();
}
/**/
function afilia_usuario_registrado(e){

	url = "../base/index.php/api/perfiles/afiliado/format/json/";
	data_send = {};
	$.ajax({
			url : url , 
			type : "PUT" , 
			data: data_send, 
			beforeSend : function(){						
				show_load_enid(".place_registro_programa_afiliados" ,  "Validando datos " , 1 );
			} 					

		}).done(function(data){			
				
			redirect("../programa_afiliados");

		}).fail(function(){							
			show_error_enid(".place_registro_programa_afiliados" , "Error al iniciar sessión");				
		});
	e.preventDefault();
}