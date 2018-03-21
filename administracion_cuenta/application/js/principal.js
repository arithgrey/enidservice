$(document).ready(function(){	
	/**/
	$(".btn_direccion").click(function(){
		carga_direccion_usuario();
		set_option("v",1);

	});
	$("#form_update_password").submit(update_password);
	/**/
	$(".editar_imagen_perfil").click(carga_form_imagenes_usuario);

});
/**/
function carga_direccion_usuario(){
	/**/
	url =  "../portafolio/index.php/api/portafolio/direccion_usuario/format/json/";		
	data_send =  $(".form_notificacion").serialize()+"&"+$.param({"v":get_option("v")});

			$.ajax({
					url : url , 
					type: "GET",
					data: data_send , 
					beforeSend: function(){
						//show_load_enid(".place_direccion_envio" , "Cargando ... ", 1 );
					}
			}).done(function(data){										

				llenaelementoHTML(".direcciones" , data);

				$(".codigo_postal").keyup(auto_completa_direccion);		
				
				$(".numero_exterior").keyup(function (){
					quita_espacios(".numero_exterior"); 	
				});
				$(".numero_interior").keyup(function (){
					quita_espacios(".numero_interior"); 
				});				
				$(".form_direccion_envio").submit(registra_direccion_usuario);
				$(".editar_direccion_persona").click(function(){
					set_option("v" , 2);
					carga_direccion_usuario();
				});


			}).fail(function(){
				//show_error_enid(".place_direccion_envio" , "Error ... al cargar portafolio.");
			});

	/**/
}
/*Solo para usuario*/
function registra_direccion_usuario(e){

	if(get_existe_codigo_postal() ==  1){
				
				url =  "../portafolio/index.php/api/portafolio/direccion_usuario/format/json/";	
				data_send =  $(".form_direccion_envio").serialize()+"&"+$.param({"direccion_principal" : 1});						
				asentamiento = $(".asentamiento").val();
				if (asentamiento != 0 ) {
					$.ajax({
							url : url , 
							type: "POST",
							data: data_send, 
							beforeSend: function(){
								//show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
							}
					}).done(function(data){																	
						

						set_option("v" , 1);
						carga_direccion_usuario();
						
					}).fail(function(){			
						show_error_enid(".place_proyectos" , "Error ... ");
					});		
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