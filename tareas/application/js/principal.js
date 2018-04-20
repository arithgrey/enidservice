var red_social = 1;
var servicio =  1; 
var contador_mensaje =0;
var tipo_negocio = 0;
var id_mensaje = 0;
var id_usuario = 0;
var usuario_mensaje =0;
var fla_busqueda =0;
var modalidad_social_media = 0;
var contenido_mensaje ="";
var nombre_servicio = "";
var padre =0;
var nivel = "";
var id_clasificacion =0;
var precio = 0;

/*Categirias*/
var  categoria_primer_nivel = 0; 
var categoria_segundo_nivel =0;
var categoria_tercer_nivel =0;
var categoria_cuarto_nivel =0;
var categoria_quinto_nivel =0;
/**/

$(document).ready(function(){


	set_form_avanzado();
	$(".busqueda_avanzada").click(set_form_avanzado);
	/**/	

	set_id_usuario($(".id_usuario").val());
	set_red_social(1);	
	set_servicio($(".servicio_email").val() );
	$(".form_nombre_producto").submit(simula_envio);
	/**/
	//set_tipo_negocio($(".contenedor_fb_servicios .tipo_negocio").val());
	servicio =  $(".servicio_red_social").val();
	set_servicio(servicio);
	carga_mensaje_red_social();
	carga_ranking_mensajes();

	
	$(".tab_articulos").click(carga_ranking_blog);
	/**/
	//$(".tab_ranking_personal").click(carga_ranking_personal);
	$(".form_productividad_web").submit(carga_metricas_productividad_usuario);

	/**/		
		$(".form_busqueda_trafico").submit(cargar_metricas_trafico_web);
	/***/

	$('.summernote').summernote();
	$("#form_registro_contacto").submit(registra_contacto);
		
	/**/
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();	
	$('.datetimepicker6').datepicker();	

	$(".form_busqueda_actividad_enid").submit(cargar_productividad);	
	$("#form_descargar_contactos").submit(descargar_contactos);	
	/**/
	$(".descargar_correos").click(function(){
		
		llenaelementoHTML(".place_contactos_disponibles" , "");											
	});


	$(".mensaje_red_social").submit(registrar_mensaje_red_social);
	$(".btn_cargar_perfiles_disponibles").click(cargar_perfiles_disponibles);

	$(".contenedor_fb_servicios .servicio_red_social").change(function(){		
		carga_mensaje_red_social();
	});
	$(".contenedor_fb_servicios .tipo_negocio").change(function(){
		carga_mensaje_red_social();
	});
	/**/
	$(".contenedor_ml_servicios .servicio_red_social").change(function(){

		carga_mensaje_red_social();
	});
	/**/	
	$(".contenedor_ml_servicios .tipo_negocio").change(function(){
		
		carga_mensaje_red_social();
	});


	/**/
	$(".contenedor_linkedin_servicios .servicio_red_social").change(function(){
		carga_mensaje_red_social();
	});
	$(".contenedor_linkedin_servicios .tipo_negocio").change(function(){
		
		carga_mensaje_red_social();
	});
	/**/
	$(".contenedor_twitter_servicios .servicio_red_social").change(function(){
		carga_mensaje_red_social();
	});
	$(".contenedor_twitter_servicios .tipo_negocio").change(function(){
		
		carga_mensaje_red_social();
	});
	
	/**/
	$(".contenedor_gplus_servicios .servicio_red_social").change(function(){
		carga_mensaje_red_social();
	});
	$(".contenedor_gplus_servicios .tipo_negocio").change(function(){
		
		carga_mensaje_red_social();
	});
	/**/
	$(".contenedor_pinterest_servicios .servicio_red_social").change(function(){
		carga_mensaje_red_social();
	});
	$(".contenedor_pinterest_servicios .tipo_negocio").change(function(){
		carga_mensaje_red_social();
	});
	/**/	
	$(".contenedor_instagram_servicios .servicio_red_social").change(function(){
		
		
		carga_mensaje_red_social();
	});
	$(".contenedor_instagram_servicios .tipo_negocio").change(function(){
		
		
		
		carga_mensaje_red_social();
	});


	$(".contenedor_email_servicios .servicio_red_social").change(function(){
		
		
		carga_mensaje_red_social();
	});
	$(".contenedor_email_servicios .tipo_negocio").change(function(){
		
		
		
		carga_mensaje_red_social();
	});
	/**/	
	/*******************************************************************************************/
	/*Facebook */
		$(".btn_indicador_izquierdo_fb").click(function(){
				set_contador_mensaje("-1");
				carga_mensaje_red_social();			
		});
		/**/
		$(".btn_indicador_derecho_fb").click(function(){
				set_contador_mensaje("1");
				carga_mensaje_red_social();			
		});
		/**/
		$(".btn_tareas_fb").click(function(){
			libera_active_menu(1);
			set_red_social(1);	
			
			
			carga_mensaje_red_social();
		});
	/*******************************************************************************************/



	/*******************************************************************************************/
	/*Mercado libre  */

		$(".btn_indicador_izquierdo_ml").click(function(){
				set_contador_mensaje("-1");
				carga_mensaje_red_social();			

		});

		$(".btn_indicador_derecho_ml").click(function(){
				set_contador_mensaje("1");
				carga_mensaje_red_social();			

		});
		/**/
		$(".btn_tareas_mercado_libre").click(function(){
					
			set_red_social(2);	
			libera_active_menu(2);
			
			
			
			
			carga_mensaje_red_social();

		});
		/**/
		$(".btn_indicador_izquierdo_linkedin").click(function(){
				set_contador_mensaje("-1");
				carga_mensaje_red_social();			
		});

		$(".btn_indicador_derecho_linkedin").click(function(){
				set_contador_mensaje("1");
				carga_mensaje_red_social();			
		});
		$(".btn_tareas_linkedin").click(function(){

			set_red_social(4);	
			libera_active_menu(3);
			
			
			
			
			carga_mensaje_red_social();
		});


	/*************************************************************************************************************/






	/*Correo */
	$(".btn_indicador_izquierdo_email").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			


	});

	$(".btn_indicador_derecho_email").click(function(){
			set_contador_mensaje("1");
			carga_mensaje_red_social();			

	});

		

	$(".btn_correo_e").click(function(){
		set_red_social(3);	
		libera_active_menu(3);
		
		
		carga_mensaje_red_social();

	});


	$(".btn_indicador_izquierdo_twitter").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			

	});

	$(".btn_indicador_derecho_twitter").click(function(){
			set_contador_mensaje("1");
			carga_mensaje_red_social();			

	});
	$(".btn_tareas_twitter").click(function(){

		set_red_social(5);
		libera_active_menu(4);	
		
		
		
		
		carga_mensaje_red_social();
	});


	/********************************************************************************************************/	
		$(".btn_indicador_izquierdo_gplus").click(function(){
				set_contador_mensaje("-1");
				carga_mensaje_red_social();			

		});
		/**/
		$(".btn_indicador_derecho_gplus").click(function(){
				set_contador_mensaje("1");
				carga_mensaje_red_social();			

		});
		/**/
		$(".btn_tareas_gplus").click(function(){				
			set_red_social(6);	
			libera_active_menu(5);
			
			
			
			
			carga_mensaje_red_social();
		});
	/********************************************************************************************************/	




	/**************************/	

	$(".btn_indicador_izquierdo_pinterest").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			

	});

	$(".btn_indicador_derecho_pinterest").click(function(){
			set_contador_mensaje("1");
			carga_mensaje_red_social();			

	});
	$(".btn_tareas_pinterest").click(function(){

			set_red_social(7);	
			libera_active_menu(6);
			
			
			
			
			carga_mensaje_red_social();

		
	});
	/**/
	$(".btn_tareas_email").click(function(){
			
			/**/
			set_red_social(9);	
			libera_active_menu(8);
			
			
			
			
			carga_mensaje_red_social();
	});




	/**************************/	

	$(".btn_indicador_izquierdo_instagram").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			

	});

	$(".btn_indicador_derecho_instagram").click(function(){
			set_contador_mensaje("1");

			carga_mensaje_red_social();			

	});
	$(".btn_tareas_instagram").click(function(){
			
		set_red_social(8);
		libera_active_menu(7);	
		
		
		
		
		carga_mensaje_red_social();

	});







	/***/
	$(".btn_indicador_izquierdo_email").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			

	});

	$(".btn_indicador_derecho_email").click(function(){
			set_contador_mensaje("1");
			carga_mensaje_red_social();			

	});
	

	/**/
	$(".btn_indicador_izquierdo_whatsapp").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			
	});
	$(".btn_indicador_derecho_whatsapp").click(function(){			
			set_contador_mensaje("1");
			carga_mensaje_red_social();			

	});
	$(".btn_tareas_whatsapp").click(function(){		
		/**/		
		set_red_social(10);
		libera_active_menu(9);	
		
		
		
		
		carga_mensaje_red_social();

	});
	
	/**/
	$(".btn_indicador_izquierdo_tumblr").click(function(){
			set_contador_mensaje("-1");
			carga_mensaje_red_social();			
	});
	$(".btn_indicador_derecho_tumblr").click(function(){			
			set_contador_mensaje("1");
			carga_mensaje_red_social();			
	});
	/**/
	$(".btn_tareas_tumblr").click(function(){		
		/**/		
		set_red_social(11);
		libera_active_menu(10);	
		
		
		
		
		carga_mensaje_red_social();

	});
	
	//$(".btn_comandos_ayuda").click(cargar_comandos_ayuda);	
	//$(".form_comando").submit(registrar_comando);
	//$(".form_up_correo").submit(registrar_actualizacion_correo);
	

	$(".form_mover_mensaje").submit(mover_mensaje);

	$(".section_correos").click(cargar_correos_disponibles);
	
	
	/**/
	$(".productividad_btn").click(carga_metricas_prospectacion);
	$(".form_busqueda_labor_venta").submit(carga_metricas_prospectacion);
	$(".form_busqueda_prospecto").submit(cargar_posibles_clientes);
	/**/
	$(".btn_nuevo_mensaje").click(configura_form_nuevo_mensaje);
	/**/
	$("footer").ready(carga_notificacion_email_enviados);
	$("footer").ready(carga_notificacion_accesos_sitios_web);
	
	

	
	

	$(".form_busqueda_blog").submit(carga_metricas_blog);

	$(".btn_repo_blog").click(function(){
		$(".form_busqueda_blog").submit();
	});
	/**/
	$(".keyword").keyup(function(){
		carga_mensaje_red_social();
	});
	/**/

	$(".modo_productos").click(evalua_modalidad_social_media);
	$(".modo_servicios").click(evalua_modalidad_social_media);
	/**/	
	/*Búsqueda*/
	$(".nombre_producto").keyup(busqueda_servicio);
	/**/
	
});
/**/
function registra_contacto(e){
	
	url =  "../base/index.php/api/base/prospecto/format/json/";	
	data_send =  $("#form_registro_contacto").serialize();

	
	$.ajax({
			url : url , 
			type: "POST",
			data: $("#form_registro_contacto").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
			
			llenaelementoHTML(".place_registro" , data );			
			document.getElementById("form_registro_contacto").reset();
			carga_info_registros();				
			/**/
			

		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();
}
/**/

/**/
function carga_info_registros(){
	
	url =  "../base/index.php/api/base/prospecto/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: {}, 
			beforeSend: function(){
				show_load_enid(".place_reporte_mail" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
		llenaelementoHTML(".place_reporte_mail" , data);											
			
	}).fail(function(){
			show_error_enid(".place_reporte_mail" , "Error ... al cargar portafolio.");
	});

}
/**/
function cargar_productividad(e){	
	/**/		
	url =  "../q/index.php/api/productividad/usuario/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: $(".form_busqueda_actividad_enid").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_productividad" , "Cargando ... ", 1 );
		}
	}).done(function(data){										
			
		llenaelementoHTML(".place_productividad" , data);											
			
	}).fail(function(){
			show_error_enid(".place_productividad" , "Error ... al cargar portafolio.");
	});	
	e.preventDefault();
}
/********************/
function registrar_mensaje_red_social(e){

	mensaje =  $(".note-editable").html();
	mensaje=  $.trim(mensaje);
	set_contenido_mensaje(mensaje);			
	mensaje_limpio =  $.trim(mensaje);
	num_mensaje =  mensaje_limpio.length;  


	if (num_mensaje> 10){
		flag =1;
		$(".place_notificacion_mensaje").empty();		
	}else{
		flag =0;
		llenaelementoHTML(".place_notificacion_mensaje" , "<span class='alerta_enid'>Mensaje muy corto!</span>");
	}	
	
	if (flag ==  1){



		data_send = $(".mensaje_red_social").serialize()+ "&" + $.param({"red_social" : get_red_social(),  "modalidad":get_modalidad_social_media() ,  "mensaje": get_contenido_mensaje(), "servicio" :  get_servicio() }); 						
		url =  $(".mensaje_red_social").attr("action");							
		

		$.ajax({
				url : url , 
				type: "POST",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_mensaje_red_social" , "Cargando ... ", 1 );
			}
		}).done(function(data){										

			
			show_response_ok_enid(".place_mensaje_red_social" , "Registrado!");													
			$(".tab_marketing").tab("show");
			$(".tab_redes_s").tab("show");
			set_contador_mensaje(0);
			carga_mensaje_red_social();
			mensaje =  $(".note-editable").html("-");

			/**/
			set_id_mensaje(0);
				
		}).fail(function(){
				show_error_enid(".place_mensaje_red_social" , "Error ... al cargar portafolio.");
		});	
	}
	e.preventDefault();

}
/**/
function set_red_social(n_red_social){
	red_social =  n_red_social;

}
/**/
function get_red_social(){
	return red_social;
}
function carga_mensaje_red_social(){

	keyword =  $(".keyword").val(); 	
	data_send =  $.param({"red_social" : get_red_social() ,  "servicio" :  get_servicio() ,  "contador":  get_contador_mensaje() , "keyword": keyword  , modalidad : get_modalidad_social_media()}) ; 				

	url =  $(".mensaje_red_social").attr("action");	

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".plance_mensaje_red_social" , "Cargando ... ", 1 );
		}
	}).done(function(data){										
		

		red_social =  get_red_social();
		switch(red_social) {
		    case 1:		    	
		    	$(".parche_fb").html("<div class='plance_mensaje_red_social'></div>");		    
		        break;
		    case 2:
		    	$(".parche_mercado_libre").html("<div class='plance_mensaje_red_social'></div>");			    
		        break;
		    case 3:
		    	$(".parche_email").html("<div class='plance_mensaje_red_social'></div>");						
		        break;
		    case 4:
		    	$(".parche_linkedin").html("<div class='plance_mensaje_red_social'></div>");						
		        break;    

		    case 5:
		    	$(".parche_twitter").html("<div class='plance_mensaje_red_social'></div>");			    
		    	break;    

		   	case 6:
		    	$(".parche_gplus").html("<div class='plance_mensaje_red_social'></div>");			
		    	break;    
		    
		    case 7:
		    	$(".parche_pinterest").html("<div class='plance_mensaje_red_social'></div>");			
		    	break;    
		   	
		   	case 8:
		    	$(".parche_instagram").html("<div class='plance_mensaje_red_social'></div>");			
		    	break;    

		   	case 9:
		    	$(".parche_email").html("<div class='plance_mensaje_red_social'></div>");			
		    	break;     	
		    default:
		        
		} 
		/**/
		llenaelementoHTML(".plance_mensaje_red_social" , data);											
		$(".edicion_mensaje").click(carga_info_mensaje_form);
		/**/		
			
	}).fail(function(){
			show_error_enid(".plance_mensaje_red_social" , "Error ... al cargar portafolio.");
	});	
	
	

	

}
/**/
function set_servicio(n_servicio){
	servicio =  n_servicio;
}
/**/
function get_servicio(){
	return servicio;
}
/**/


function copiarAlPortapapeles(){
   
  text_info = $(".contenedor_msj_facebook").text();  


  $(".contenedor_msj_temporal").show();
  $(".contenedor_msj_temporal").val($.trim(text_info));
  $(".contenedor_msj_temporal").select();
  var successful = document.execCommand('copy');
  $(".contenedor_msj_temporal").hide();
}
/**/
function get_contador_mensaje(){
	return contador_mensaje;
}
/**/

function set_contador_mensaje(n_contador){
	contador_mensaje +=  parseInt(n_contador);

}
/**/
function cargar_perfiles_disponibles(){
	
	url =  "../base/index.php/api/perfiles/disponibles/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: {"solo_lectura":1}, 
			beforeSend: function(){
				show_load_enid(".place_perfiles_disponibles" , "Cargando ... ");
		}
	}).done(function(data){										
		
		llenaelementoHTML(".place_perfiles_disponibles" , data);											
		$(".tipo_servicio").click(actualiza_perfil_disponibles);
					
	}).fail(function(){
			show_error_enid(".place_perfiles_disponibles" , "Error ... al cargar portafolio.");
	});	

	e.preventDefault();
}
/**/
function set_btn_delete_mensaje(e){

	id_mensaje =  e.target.id	
	data_send =  {"id_mensaje":id_mensaje};

	$(".btn_confirm_delete").click(function(){

		url =  "../base/index.php/api/mensaje/red_social/format/json/";
		console.log(data_send);
		$.ajax({
				url : url , 
				type: "DELETE",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_delete_mensaje" , "Cargando ... ");
			}
		}).done(function(data){													
			
			show_response_ok_enid(".place_delete_mensaje" , "Mensaje eliminado con éxito!");
			$("#delete_mensaje_modal").modal("hide");
			carga_mensaje_red_social();

		}).fail(function(){
				show_error_enid(".place_delete_mensaje" , "Error ... al cargar portafolio.");
		});	

	});


}
/***/
function get_tipo_negocio(){
	return tipo_negocio;
}
/**/
function set_tipo_negocio(n_tipo_negocio){
	tipo_negocio = n_tipo_negocio;
}
/*
function cargar_comandos_ayuda(){

	url =  "../base/index.php/api/mensaje/comandos/format/json/";	
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_comandos" , "Cargando ... ");
		}
	}).done(function(data){							

		llenaelementoHTML(".place_comandos", data);
	}).fail(function(){
		show_error_enid(".place_comandos" , "Error ... al cargar portafolio.");
	});	
}
*/
/*
function registrar_comando(e){

	url =  "../base/index.php/api/mensaje/comandos/format/json/";	
	data_send =  $(".form_comando").serialize();		
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_comandos" , "Cargando ... ");
		}
	}).done(function(data){							

		
			llenaelementoHTML(".place_registro_comandos", data);		
			document.getElementById("form_comando").reset(); 
			
		

	}).fail(function(){
		show_error_enid(".place_registro_comandos" , "Error ... al cargar portafolio.");
	});	
	cargar_comandos_ayuda();
	e.preventDefault();
}
*/
/*
function registrar_actualizacion_correo(e){
	

	url =  "../base/index.php/api/base/prospecto/format/json/";	
	data_send =  $("#form_up_correo").serialize();

	$.ajax({
			url : url , 
			type: "PUT",
			data: $("#form_up_correo").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
			console.log(data);
			show_response_ok_enid(".place_registro" , "Correo actualizado");
			$(".correo_individual").val("");
			
		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();

}
*/
/**/
function mover_mensaje(e){
	
	url =  "../base/index.php/api/mensaje/red_social/format/json/";	
	data_send =  $("#form_mover_mensaje").serialize() + "&" +$.param({"id_mensaje":get_id_mensaje()});		
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_mover_mensaje" , "Cargando ... ", 1 );
			}
	}).done(function(data){																
			$("#mover_mensaje_modal").modal("hide");
			show_response_ok_enid(".place_mover_mensaje" , "Mensaje copiado!");			
			carga_mensaje_red_social();
		}).fail(function(){
			show_error_enid(".place_mover_mensaje" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();

}
/**/
function set_id_mensaje(n_mensaje){		

	id_mensaje =  n_mensaje;
	$(".id_mensaje").val(n_mensaje);
}
/**/

/**/
function get_id_mensaje(){
	return id_mensaje;
}
/**/
function cargar_correos_disponibles(){

	url =  "../base/index.php/api/perfiles/tipo_servicio_disponible/format/json/";	
	data_send =  {};			
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_repo_email" , "Cargando ... ", 1 );
			}
	}).done(function(data){																
			llenaelementoHTML(".place_repo_email" , data);
		}).fail(function(){
			
		show_error_enid(".place_repo_email" , "Error ... ");
	});
	
}
/**/
function set_select_registro_mensaje(){

	selecciona_select(".tipo_negocio" , get_tipo_negocio());					
	selecciona_select(".id_servicio" , get_servicio());
}
/**/
function configura_form_nuevo_mensaje(){
	

	
	document.getElementById("mensaje_red_social").reset();	
	red_social = get_red_social();  

	switch(red_social) {
	    case 1:	        
	        
	        llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-facebook'></i>Facebook");
			
			//id_servicio =  $(".contenedor_fb_servicios .id_servicio>option:selected").val();  				
			
			//set_servicio(id_servicio);
	        break;
	    case 2:

	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-shopping-cart'></i>Mercado Libre ");
	        
			//id_servicio =  $(".contenedor_ml_servicios .id_servicio>option:selected").val();  				
			
			//set_servicio(id_servicio);

	        break;

	    case 3:
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-envelope'></i> Email Marketing");
	       	
			//id_servicio =  $(".contenedor_email_servicios .id_servicio>option:selected").val();  				
			
			//set_servicio(id_servicio);

	        break;    

	    case 4:
	    		
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-linkedin'></i>Linkedin");
	    	
			//id_servicio =  $(".contenedor_linkedin_servicios .id_servicio>option:selected").val();  				

			
			//set_servicio(id_servicio);

	        break;

	    case 5:
	    		
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-twitter'> </i>Twitter");
	    	
			//id_servicio =  $(".contenedor_twitter_servicios .id_servicio>option:selected").val();  				
			
			///set_servicio(id_servicio);

	        break;

	    case 6:
	    		
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-google-plus-official'></i>Gplus");
	    	
			//id_servicio =  $(".contenedor_gplus_servicios .id_servicio>option:selected").val();  				
			
			//set_servicio(id_servicio);

	        break;

	    case 7:
	    		
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-pinterest'></i>Pinterest");
	    	
			//id_servicio =  $(".contenedor_pinterest_servicios .id_servicio>option:selected").val();  				
			
			//set_servicio(id_servicio);

	        break;

	    case 8:
	    		
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-instagram'> </i>Instagram");
	    	
			//id_servicio =  $(".contenedor_instagram_servicios .id_servicio>option:selected").val();  						
	    	
			//set_servicio(id_servicio);
	        break;    


	     case 8:
	    		
	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-instagram'> </i>Instagram");
	    	
			//id_servicio =  $(".contenedor_instagram_servicios .id_servicio>option:selected").val();  						
	    	//set_tipo_negocio(id_tipo_negocio);
			//set_servicio(id_servicio);
	        break;    
		

		case 9:
	    	

	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-envelope'> </i>E-mail");
	    	//id_tipo_negocio =  $(".contenedor_email_servicios .tipo_negocio>option:selected").val();  				
			//id_servicio =  $(".contenedor_email_servicios .id_servicio>option:selected").val();  						
	    	//set_tipo_negocio(id_tipo_negocio);
			//set_servicio(id_servicio);
	        break;           

	    case 10:
	    	

	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-whatsapp'> </i>Whatsapp");
	    	//id_tipo_negocio =  $(".contenedor_whatapp_servicios .tipo_negocio>option:selected").val();  				
			//id_servicio =  $(".contenedor_whatapp_servicios .id_servicio>option:selected").val();  						
	    	//set_tipo_negocio(id_tipo_negocio);
			//set_servicio(id_servicio);
	        break;               

	    case 11:
	    	

	    	llenaelementoHTML(".place_mensaje_mensaje_social" , "<i class='fa fa-tumblr'> </i>Tumblr");
	    	//id_tipo_negocio =  $(".contenedor_tumblr_servicios .tipo_negocio>option:selected").val();  				
			//id_servicio =  $(".contenedor_tumblr_servicios .id_servicio>option:selected").val();  						
	    	//set_tipo_negocio(id_tipo_negocio);
			//set_servicio(id_servicio);
	        break;                   


	        
	    default:
	        
	} 
	set_select_registro_mensaje();
}
/**/
function set_id_usuario(n_id_usuario){
	id_usuario =  n_id_usuario;
}
/**/
function get_id_usuario(){
	return  id_usuario;
}
/**/
function libera_active_menu(menu){

	var menu_social = ["", ".m_facebook" , ".m_mercado_libre" , ".m_linkedin" , ".m_twitter" , ".m_gplus" , ".m_pinteres" , ".m_instagram" , ".m_email" , ".m_whatsapp" , ".m_tumblr"];	
	for(var i = 0; i < menu_social.length; i++){	
		$(menu_social[i]).removeClass("blue_active");	
	}	
	$(menu_social[menu]).addClass("blue_active");	
}
/**/
function carga_metricas_productividad_usuario(e){
	
	url =  "../q/index.php/api/productividad/social_media/format/json/";	
	data_send =  $(".form_productividad_web").serialize();
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send,
			beforeSend: function(){
				show_load_enid(".place_productividad_usr" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
					
		llenaelementoHTML(".place_productividad_usr" , data);

	}).fail(function(){
		show_error_enid(".place_productividad_usr" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();
}
/**/
function carga_metricas_blog(e){

		id_usuario =  get_id_usuario();		
		data_send = $(".form_busqueda_blog").serialize()+"&"+$.param({"id_usuario" : id_usuario}); 	
		url =  "../q/index.php/api/productividad/faq/format/json/";	

		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_repo_faq" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_repo_faq", data ); 							
			$('th').click(ordena_table_general);



		}).fail(function(){
			show_error_enid(".place_repo_faq", "Error al actualizar incidencia");			
		});	

	e.preventDefault();
}

/**/
function carga_info_mensaje_form(e){


	usuario_registro = get_usuario_mensaje();  
	
	/**/			
	id_mensaje = e.target.id;
	set_id_mensaje(id_mensaje);


		data_send = {"id_mensaje" : get_id_mensaje()}; 	
		url =  "../base/index.php/api/mensaje/q/format/json/";	

		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				//show_load_enid(".place_repo_faq" , "Cargando..." );
			}  
		}).done(function(data){			
			
			mensaje=  data[0];  

			id_mensaje =  mensaje.id_mensaje;			
			descripcion=  mensaje.descripcion;  	 			
			nombre_producto_promocion =  mensaje.nombre_producto_promocion; 
			servicio = mensaje.servicio;
			
			set_servicio(servicio);
			set_tipo_negocio(111);
			$(".note-editable").html(descripcion);		
			set_nombre_servicio(nombre_producto_promocion );
			set_id_mensaje(id_mensaje);						
			

		}).fail(function(){
			show_error_enid(".place_repo_faq", "Error al actualizar incidencia");			
		});	

}
/**/
function carga_info_usuario(valor){
	set_usuario_mensaje(valor);
}
/**/
function set_usuario_mensaje(n_mensaje){
	usuario_mensaje = n_mensaje;
}
/**/
function get_usuario_mensaje(){
	return usuario_mensaje;
}
/**/
function  set_form_avanzado(){

	
	var lista_form = [".contenedor_email_servicios",".contenedor_fb_servicios",".contenedor_gplus_servicios" , ".contenedor_instagram_servicios" , ".contenedor_linkedin_servicios" , ".contenedor_ml_servicios" , ".contenedor_pinterest_servicios" ,".contenedor_twitter_servicios" , ".contenedor_whatsapp_servicios"];

	if (get_flag_busqueda() ==  0){
		
		for (var i = 0; i < lista_form.length; i++){		
			$(lista_form[i]).hide();		
		}
		
		set_flag_busqueda(1);	
	}else{
		
		for (var i = 0; i < lista_form.length; i++){		
			$(lista_form[i]).show();		
		}		
		set_flag_busqueda(0);	
	}
	
}
/**/
function set_flag_busqueda(n){
	fla_busqueda = n;	
}
/**/
function get_flag_busqueda(){
	return fla_busqueda;
}
/**/
function evalua_modalidad_social_media(){


	if(get_modalidad_social_media() ==  0){		

		/***/
		$(".contenedor_ciclo_facturacion").show();
		showonehideone( ".modo_productos_enid" , ".modo_servicios_enid" );		
		set_modalidad_social_media(1);

	}else{
		$(".contenedor_ciclo_facturacion").hide();
		
		showonehideone(  ".modo_servicios_enid" , ".modo_productos_enid");
		set_modalidad_social_media(0);
	}
}
/**/
function set_modalidad_social_media(n_modalidad){	
	modalidad_social_media = n_modalidad;
	/**/
	if (modalidad_social_media ==  1) {
		llenaelementoHTML(".text_info_modalidad" , "Servicio");	
	}else{
		llenaelementoHTML(".text_info_modalidad" , "Producto");	
	}
	
	
	
}
/**/
function get_modalidad_social_media() {
	return modalidad_social_media;
}
/**/
function get_contenido_mensaje(){
	return contenido_mensaje;
}
/**/
function  set_contenido_mensaje(n_contenido_mensaje) {
	contenido_mensaje =  n_contenido_mensaje;
}
/**/
function get_mensaje(){
	return mensaje;
}
/**/
function set_mensaje(n_mensaje){	
	mensaje =  n_mensaje; 
}
/**/

/**/
function cargar_metricas_trafico_web(e){

	url =  "../q/index.php/api/trafico/usuario/format/json/";	
	data_send =  $(".form_busqueda_trafico").serialize();

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send , 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
					
	}).fail(function(){
		//show_error_enid(".place_registro" , "Error ... al cargar portafolio.");		
	});
	e.preventDefault();	
}
/**/
function busqueda_servicio(){	
	/**/
	url =  "../q/index.php/api/mensajes/info_servicio/format/json/";	
	q= $(".nombre_producto").val();		
	data_send =  {q:q , modalidad :  get_modalidad_social_media()};


	if (q.length > 0 ) {

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send , 
				beforeSend: function(){
					show_load_enid(".place_busqueda_nombre_servicio" , "Cargando ... ", 1 );
				}
		}).done(function(data){		
			
			llenaelementoHTML(".place_busqueda_nombre_servicio" , data);
			$(".servicio").click(carga_configuracion_servicio_busqueda);
			$(".agregar_producto_servicio").click(carga_form_agregar_productos_servicios);
		}).fail(function(){
			//show_error_enid(".place_busqueda_nombre_servicio" , "Error ... al cargar portafolio.");		
		});
	}else{
		$(".place_busqueda_nombre_servicio").empty();
	}	

}
/**/
function carga_configuracion_servicio_busqueda(){		
	
	id_servicio =  jQuery(this).attr("id");
	nombre_servicio =  jQuery(this).attr("nombre_servicio");	
	if (id_servicio != null  ) {		
		set_servicio(id_servicio);
		set_nombre_servicio(nombre_servicio);
		$(".place_busqueda_nombre_servicio").empty();				
	}	
}
/**/
function get_nombre_servicio(){
	return nombre_servicio;
}
/***/
function set_nombre_servicio(n_nombre_servicio){
	nombre_servicio =  n_nombre_servicio;
	$(".nombre_producto").val(n_nombre_servicio);
	$(".nuevo_producto_nombre").val(n_nombre_servicio);
}
/**/
function  carga_form_agregar_productos_servicios(){	
	/*Mostrarmos la sección para agregar el producto o servicio */
	$(".menu_agregar_productos_servicios").tab("show");
	
	/**/
	
	set_nombre_servicio($(".nombre_producto").val());
	/**/
	if (get_modalidad_social_media() == 0 ) {
		llenaelementoHTML(".text_info_modalidad" , "Producto");
	}else{
		llenaelementoHTML(".text_info_modalidad" , "Servicio");
	}
	showonehideone(".contenedor_nombre" , ".contenedor_categorias");	
	carga_listado_categorias();	
	/**/
}
/**/
function  simula_envio(e){
	
	nombre_servicio =  $(".nuevo_producto_nombre").val();  
	precio =  $(".precio").val();
	showonehideone(".contenedor_categorias" , ".contenedor_nombre");	
	set_nombre_servicio(nombre_servicio);	
	set_precio(precio);
	e.preventDefault();	
}
/**/
function  carga_listado_categorias(){

	
	url =  "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";		
	set_nivel("primer_nivel");
	set_padre(0);	

	$(".segundo_nivel_seccion").empty();
	$(".tercer_nivel_seccion").empty();
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	data_send = {"modalidad": get_modalidad_social_media() , "padre":get_padre() , "nivel" : get_nivel()};

	
		$.ajax({
				url : url , 
				type: "GET",
				data: data_send , 
				beforeSend: function(){
					show_load_enid(".primer_nivel_seccion" , "Cargando ... ", 1 );
				}
		}).done(function(data){		
			
			llenaelementoHTML(".primer_nivel_seccion" , data);	
			/*Carga categorias segundo nivel */
			$(".primer_nivel .num_clasificacion").click(carga_listado_categorias_segundo_nivel);
			$(".nueva_categoria_producto").click(agregar_categoria_servicio);		

		}).fail(function(){
			show_error_enid(".primer_nivel_seccion" , "Error ... al cargar portafolio.");		
		});
	
}
/**/
function  carga_listado_categorias_segundo_nivel(e){
	padre  =  e.target.value;  
	url =  "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";		
	set_padre(padre);
	set_nivel("segundo_nivel");
	
	$(".tercer_nivel_seccion").empty();
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();


	data_send = {"modalidad": get_modalidad_social_media() , "padre":get_padre() , "nivel" : get_nivel()};

	$.ajax({
		url : url , 
		type: "GET",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".segundo_nivel_seccion" , "Cargando ... ", 1 );
		}
	}).done(function(data){		

		llenaelementoHTML(".segundo_nivel_seccion" , data);	
		$(".segundo_nivel .num_clasificacion").click(carga_listado_categorias_tercer_nivel);
		$(".nueva_categoria_producto").click(agregar_categoria_servicio);		

	}).fail(function(){
		show_error_enid(".segundo_nivel_seccion" , "Error ... al cargar portafolio.");		
	});

}
/**/
function carga_listado_categorias_tercer_nivel(e){
	
	padre  =  e.target.value;  
	url =  "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";		
	set_padre(padre);
	set_nivel("tercer_nivel");
	
	data_send = {"modalidad": get_modalidad_social_media() , "padre":get_padre() , "nivel" : get_nivel()};

	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	$.ajax({		
		url : url , 
		type: "GET",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".tercer_nivel_seccion" , "Cargando ... ", 1 );
		}
	}).done(function(data){		

		llenaelementoHTML(".tercer_nivel_seccion" , data);	
		$(".tercer_nivel .num_clasificacion").click(carga_listado_categorias_cuarto_nivel);
		$(".nueva_categoria_producto").click(agregar_categoria_servicio);		

	}).fail(function(){
		show_error_enid(".tercer_nivel_seccion" , "Error ... al cargar portafolio.");		
	});
	
}
/**/
function carga_listado_categorias_cuarto_nivel(e){
	
	padre  =  e.target.value; 	
	url =  "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";		
	set_padre(padre);
	set_nivel("cuarto_nivel");
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	data_send = {"modalidad": get_modalidad_social_media() , "padre":get_padre() , "nivel" : get_nivel()};

	$.ajax({		
		url : url , 
		type: "GET",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".cuarto_nivel_seccion" , "Cargando ... ", 1 );
		}
	}).done(function(data){		

		llenaelementoHTML(".cuarto_nivel_seccion" , data);	
		$(".cuarto_nivel .num_clasificacion").click(carga_listado_categorias_quinto_nivel);
		$(".nueva_categoria_producto").click(agregar_categoria_servicio);		

	}).fail(function(){
		show_error_enid(".cuarto_nivel_seccion" , "Error ... al cargar portafolio.");		
	});
	
}
/**/
function  carga_listado_categorias_quinto_nivel(e) {

	padre  =  e.target.value; 	
	url =  "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";		
	set_padre(padre);
	set_nivel("quinto_nivel");
	$(".sexto_nivel_seccion").empty();

	data_send = {"modalidad": get_modalidad_social_media() , "padre":get_padre() , "nivel" : get_nivel()};

	$.ajax({		
		url : url , 
		type: "GET",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".quinto_nivel_seccion" , "Cargando ... ", 1 );
		}
	}).done(function(data){		

		llenaelementoHTML(".quinto_nivel_seccion" , data);	
		$(".quinto_nivel .num_clasificacion").click(carga_listado_categorias_sexto_nivel);	
		$(".nueva_categoria_producto").click(agregar_categoria_servicio);		

	}).fail(function(){
		show_error_enid(".quinto_nivel_seccion" , "Error ... al cargar portafolio.");		
	});

}
function  carga_listado_categorias_sexto_nivel(e){

	padre  =  e.target.value; 	
	url =  "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";		
	set_padre(padre);
	set_nivel("sexto_nivel");
	$(".sexto_nivel").empty();	
	data_send = {"modalidad": get_modalidad_social_media() , "padre":get_padre() , "nivel" : get_nivel()};

	$.ajax({		
		url : url , 
		type: "GET",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".sexto_nivel_seccion" , "Cargando ... ", 1 );
		}
	}).done(function(data){		
		llenaelementoHTML(".sexto_nivel_seccion" , data);					
	}).fail(function(){
		show_error_enid(".sexto_nivel_seccion" , "Error ... al cargar portafolio.");		
	});

}
/**/
function  get_padre(){
	return padre;
}
/**/
function set_padre(n_padre){
	padre =  n_padre;
}
/**/
function get_nivel(){
	return nivel;
}
/**/
function set_nivel(n_nivel){
	nivel =  n_nivel;
}
function agregar_categoria_servicio(e){
	id_categoria =  e.target.id; 
	set_id_clasificacion(id_clasificacion);		
	/**/
	nombre_servicio =  get_nombre_servicio();	
	flag_servicio =  get_modalidad_social_media();
	precio =  get_precio();	

	/**/
	if (get_modalidad_social_media() == 0) {
		ciclo_facturacion  = 5;
	}else{
		ciclo_facturacion  = $("#ciclo").val();		
	}

	
	set_valores_categorias();
	data_send = {"nombre_servicio" : nombre_servicio , "flag_servicio" : flag_servicio , "precio" :precio , "ciclo_facturacion": ciclo_facturacion , "primer_nivel":get_categoria_primer_nivel() , "segundo_nivel":get_categoria_segundo_nivel() , "tercer_nivel":get_categoria_tercer_nivel() , "cuarto_nivel":get_categoria_primer_nivel() , "quinto_nivel":get_categoria_quinto_nivel()};
	url =  "../base/index.php/api/servicio/nuevo/format/json/";
	$.ajax({		
			url : url,
			type : "POST", 		
			data : data_send,  			
			beforeSend:function(){

			}
		}).done(function(data){
			
			/**/
			document.getElementById("form_nombre_producto").reset();	
			$(".tab_redes_s").tab("show");
			$(".btn_nuevo_mensaje").tab("show");
			busqueda_servicio();
			/**/

		}).fail(function(){		
			show_error_enid(".place_registro_servicio" , "Error ... ");
		});	


}
/**/
function get_id_clasificacion(){
	return id_clasificacion;	
}
/**/
function set_id_clasificacion(n_clasificacion){
	id_clasificacion = n_clasificacion;
}
/**/
function set_precio(n_precio){
	precio =  n_precio;
}
/**/
function get_precio(){
	return precio;
}
/**/
function set_valores_categorias(){
	
	set_categoria_primer_nivel(0);
	set_categoria_segundo_nivel(0);
	set_categoria_tercer_nivel(0);	
	set_categoria_cuarto_nivel(0);	
	set_categoria_quinto_nivel(0);	
	/**/
	primer_nivel = $(".primer_nivel_seccion option:selected").val();
	set_categoria_primer_nivel(primer_nivel);
	/***/
	segundo_nivel = $(".segundo_nivel option:selected").val();
	set_categoria_segundo_nivel(segundo_nivel);
	/***/
	tercer_nivel = $(".tercer_nivel option:selected").val();
	if(tercer_nivel != undefined) {
		set_categoria_tercer_nivel(tercer_nivel);	
	}
	cuarto_nivel = $(".cuarto_nivel option:selected").val();
	if(cuarto_nivel != undefined) {
		set_categoria_cuarto_nivel(cuarto_nivel);	
	}
	/**/
	quinto_nivel = $(".quinto_nivel option:selected").val();
	if(quinto_nivel != undefined) {
		set_categoria_quinto_nivel(quinto_nivel);	
	}
	/***/
}
/**/
function  set_categoria_primer_nivel(nivel){
	categoria_primer_nivel =  nivel;
}
/**/
function get_categoria_primer_nivel(){
	return categoria_primer_nivel;
}
/**/
function  set_categoria_segundo_nivel(nivel){
	categoria_segundo_nivel =  nivel;
}
/**/
function get_categoria_segundo_nivel(){
	return categoria_segundo_nivel;
}
/**/
function  set_categoria_tercer_nivel(nivel){
	categoria_tercer_nivel =  nivel;
}
/**/
function get_categoria_tercer_nivel(){
	return categoria_tercer_nivel;
}
/**/
function  set_categoria_cuarto_nivel(nivel){
	categoria_cuarto_nivel =  nivel;
}
/**/
function get_categoria_cuarto_nivel(){
	return categoria_cuarto_nivel;
}
/***/
function  set_categoria_quinto_nivel(nivel){
	categoria_quinto_nivel =  nivel;
}
/**/
function get_categoria_quinto_nivel(){
	return categoria_quinto_nivel;
}
