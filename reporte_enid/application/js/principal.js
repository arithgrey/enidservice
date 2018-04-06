var incidencia = 0;
$(document).ready(function(){
	set_option("page" , 0);
	$("#nuevos_miembros").click(carga_nuevos_miembros);
	$(".mail_marketing").click(carga_metricas_mail_marketing);
	$(".form_busqueda_mail_enid").submit(carga_metricas_mail_marketing);
	$(".usabilidad_btn").click(carga_uso_sistema);
	
	$("footer").ready(function(){
		$(".form_busqueda_global_enid").submit();
	});	

	
	$(".form_busqueda_global_enid").submit(carga_metricas_cotizaciones);
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();	
	$(".form_busqueda_actividad_enid").submit(busqueda_actividad_enid);
	$(".presentaciones").click(carga_presentaciones);
	$(".form_presentaciones").submit(carga_presentaciones);	
	$("#form_metas").submit(registra_metas);
	$(".cargar_perfiles_disponibles").click(cargar_perfiles_disponibles);
	$("#form_busqueda_tipo_negocio").submit(cargar_perfiles_disponibles);	
	$(".form_busqueda_desarrollo").submit(carga_metricas_desarrollo);
	$(".form_busqueda_desarrollo_solicitudes").submit(carga_solicitudes_cliente);
	$(".comparativa").click(carga_comparativas);
	$(".form_busqueda_afiliacion").submit(carga_repo_afiliacion);
	$(".form_busqueda_afiliacion_productividad").submit(carga_repo_afiliacion_productividad);	
	/**/
	$(".btn_repo_afiliacion").click(carga_productos_mas_solicitados);
	/**/
	$(".form_busqueda_productos_solicitados").submit(carga_productos_mas_solicitados);

});
/*
function set_inicidencia(new_inicidencia){	
	incidencia =  new_inicidencia;

}
function get_inicidencia(){
	return incidencia;
}
*/
function carga_uso_sistema(){

	url =  "../q/index.php/api/enid/usabilidad_landing_pages/format/json/";
	$.ajax({
		url : url , 
		type : "GET" ,
		data: $(".form_busqueda_actividad_enid").serialize(), 
		beforeSend: function(){
			show_load_enid( ".place_usabilidad" , "Cargando ..." , 1 );
		}
	}).done(function(data){


		//console.log(data);		
		llenaelementoHTML(".place_usabilidad" , data);
		$(".sitios_dia").click(carga_info_sitios_dia);
		$(".dispositivos_dis").click(carga_info_dispositivos_dia);
		
		$('th').click(ordena_table_general);
		
	}).fail(function(){

		show_error_enid(".place_usabilidad" , "Error en la usabilidad"); 

	});
}
/**/

function comparativa_dia(){


	url = "../q/index.php/api/enid/prospectos_comparativa_d/format/json/";
	$.ajax({
		url :  url , 
		type : "GET",
		beforeSend: function(){
			show_load_enid(".place_prospectos_comparativa" , "Cargando comparativa ..." , 1);
		}
	}).done(function(data){
		/**/	
		llenaelementoHTML(".place_prospectos_comparativa" , data);		
		$(".info-dia-p").click(data_miembros_g);
		$(".info-d").click(data_eventos_g);
		console.log(data);
	}).fail(function(){
		show_error_enid(".place_prospectos_comparativa" , "Error al cargar la comparativa"); 
	});

}
/**/
function carga_miembros_empresa(e){

		$(".place_miembros").empty();
		empresa = e.target.id;
		url =  "../q/index.php/api/enid/miembros_cuenta/format/json/";
		$.ajax({

			url : url ,
			type :  "GET", 
			data:  {"id_empresa" :  empresa}, 
			beforeSend: function(){
				show_load_enid(".place_miembros" , "Cargando ..." , 1);
			}
		}).done(function(data){
			llenaelementoHTML(".place_miembros" , data);

		}).fail(function(){
			show_error_enid(".place_miembros" , "Error al cargar miembros de la empresa, CORREGIR."); 
			console.log("Error al cargar");
		});

}
/**/
function data_miembros_g(e){

	periodo =  e.target.id;	
	url = "../q/index.php/api/enid/resumen_global_admin_p/format/json/";  
	$.ajax({
		url :  url , 
		data : {periodo :  periodo} , 
		beforeSend: function(){
			show_load_enid(".info-resumen-prospecto" , "Cargando ... " , 1 );
		}
	}).done(function(data){
		llenaelementoHTML(".info-resumen-prospecto" , data );
	}).fail(function(){
		show_error_enid(".info-resumen-prospecto", "Error al cargar ...");
	});	
}
/**/
function data_eventos_g(e){
	periodo =  e.target.id;	
	url =  "../q/index.php/api/enid/resumen_global_admin_e/format/json/";  
	$.ajax({
		url :  url , 
		data : {periodo :  periodo} , 
		beforeSend: function(){
			show_load_enid(".info-resumen-prospecto" , "Cargando ... " , 1 );
		}
	}).done(function(data){
		llenaelementoHTML(".info-resumen-prospecto" , data );
	}).fail(function(){
		show_error_enid(".info-resumen-prospecto", "Error al cargar ...");
	});	


}
/**/
function carga_info_sitios_dia(){
	$(".place_visitas").empty();
	url = "../q/index.php/api/enid/sitios_dia/format/json/";  ;
	$.ajax({
		url : url , 
		type: "GET", 
		beforeSend: function(){
			show_load_enid(".place_visitas" , "Cargando"  , 1 );
		}
	}).done(function(data){
		llenaelementoHTML(".place_visitas" , data );
		/**/
		$("th").click(ordena_table_general);

	}).fail(function(){
		show_error_enid(".place_visitas", "Error al cargar las visitas ...");
	});	

}
function carga_info_dispositivos_dia(){

	$(".place_visitas").empty();
	url = "../q/index.php/api/enid/dispositivos_dia/format/json/";  ;
	$.ajax({
		url : url , 
		type: "GET", 
		beforeSend: function(){
			show_load_enid(".place_visitas" , "Cargando"  , 1 );
		}
	}).done(function(data){
		llenaelementoHTML(".place_visitas" , data );
		$("th").click(ordena_table_general);
	}).fail(function(){
		show_error_enid(".place_visitas", "Error al cargar las visitas ...");
	});	

}
/**/
function carga_nuevos_miembros(){
	
	url = "../q/index.php/api/enid/nuevos_miembros/format/json/";
	$.ajax({
		url :  url , 
		type: "GET",
		data: {},
		beforeSend: function(){
			show_load_enid(".nuevos_miembros" , "Cargando"  , 1 );
		}
	}).done(function(data){

		llenaelementoHTML(".nuevos_miembros" , data);
	}).fail(function(){

		show_error_enid(".nuevos_miembros", "Error al cargar los nuevos miembros");
	});


}
/*
function carga_bugs_enid(){
	
	url =  "../q/index.php/api/enid/bugs/format/json/";	
	$.ajax({
		url :  url , 
		type: "GET",
		data: {estado_incidencia : $("#estado_incidencia").val()},
		beforeSend: function(){
			show_load_enid(".bugs_enid_service" , "Cargando"  , 1 );
		}
	}).done(function(data){

		llenaelementoHTML(".bugs_enid_service" , data);		
		$(".evaluar_incidencia").click(evaluar);
	}).fail(function(){

		show_error_enid(".bugs_enid_service", "Error al cargar los nuevos miembros");
	});

}
*/
/**/
function evaluar(e){

	incidencia = e.target.id;
	set_inicidencia(incidencia);
}
/*
//function modifica_inicidencia(e){
	
	data_send = $("#form-calificacion-incidencia").serialize()+ "&"+$.param({"id_incidencia" : get_inicidencia()}); 	
	url =  $("#form-calificacion-incidencia").attr("action");	
	$.ajax({
		url : url , 
		type : "PUT", 
		data :  data_send , 
		beforeSend: function(){

			show_load_enid(".place_info_calificacion_incidencia" , ""  , 1 );
		}  
	}).done(function(data){
			
			show_response_ok_enid( ".place_info_calificacion_incidencia", "Status  actualizado!"); 
			$("#evalua_bug").modal("hide");
			carga_bugs_enid();
	}).fail(function(){
		show_error_enid(".place_info_calificacion_incidencia", "Error al actualizar incidencia");
	});	
	
	e.preventDefault();
}
*/
/**/
function carga_metricas_mail_marketing(e){
	
	data_send = $(".form_busqueda_mail_enid").serialize(); 	
	url =  "../q/index.php/api/mail/reporte_mail_marketing/format/json/";	
	$.ajax({
		url : url , 
		type : "GET", 
		data :  data_send , 
		beforeSend: function(){
			show_load_enid(".place_usabilidad" , "Cargando..." );
		}  
	}).done(function(data){		
		llenaelementoHTML(".place_usabilidad", data ); 			
	}).fail(function(){
		show_error_enid(".place_usabilidad", "Error al actualizar incidencia");
	});	
	e.preventDefault();
	
}
/**/
function carga_metricas_cotizaciones(e){

	data_send = $(".form_busqueda_global_enid").serialize()+"&"+$.param({"vista" :"1"}); 	
	url =  "../q/index.php/api/enid/metricas_cotizaciones/format/json/";	
	$.ajax({
		url : url , 
		type : "GET", 
		data :  data_send , 
		beforeSend: function(){
			show_load_enid(".place_usabilidad" , "Cargando..." );
		}  
	}).done(function(data){			

		llenaelementoHTML(".place_usabilidad", data ); 		

		$(".usuarios").click(resumen_usuarios);		
		$(".contactos").click(resumen_mensajes);	
		$(".solicitudes").click(resumen_compras);	
		$(".valoraciones").click(resumen_valoracion);
		$(".servicios").click(resumen_servicios);



		/*
		$(".proyectos_registrados").click(carga_info_proyectos);		
		$(".cotizaciones_registradas").click(carga_info_cotizaciones);	

			$(".clientes_info").click(cargar_info_clientes);
			$(".posibles_clientes_contacto").click(cargar_info_clientes_prospecto);
			$(".num_prospectos_sistema").click(cargar_info_sistema);
			$(".num_afiliados").click(cargar_info_afiliados);		
			$(".num_contactos_promociones").click(cargar_contactos_promociones);
			
		$(".base_registrada").click(carga_info_registros);
		$(".base_enviados").click(carga_info_enviados);
		$('th').click(ordena_table_general);
		*/
		
	}).fail(function(){
		
	});		
	e.preventDefault();

}
/*Data proyectos*/
function carga_info_proyectos(e){

	num_proyectos = $(this).attr("num_proyectos"); 	
	if(num_proyectos > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	

		url =  "../portafolio/index.php/api/portafolio/info_proyectos_fecha/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){		
			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}
	
}

/*Data cotizaciones */
function carga_info_cotizaciones(e){
	num_cotizaciones = $(this).attr("num_cotizaciones"); 
	if (num_cotizaciones > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/cotizaciones/cotizaciones_sitios_web/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}
	
}

/**/

/**/
function carga_info_descarga_paginas_web(e){

	num_contactos = $(this).attr("num_contactos"); 
	if (num_contactos > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/cotizaciones/sitios_web/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}
	
}
/**/
function carga_info_descarga_adwords(e){

	num_contactos = $(this).attr("num_contactos"); 
	if (num_contactos > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/cotizaciones/adwords/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}
	
}
/**/
function carga_info_descarga_tienda_linea(e){

	num_contactos = $(this).attr("num_contactos"); 
	if (num_contactos > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/cotizaciones/tienda_en_linea/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}
	
}

/**/
function carga_info_descarga_crm(e){

	num_contactos = $(this).attr("num_contactos"); 
	if (num_contactos > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/cotizaciones/crm/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}
	
}




/**/
function carga_info_registros(e){
	
	num_registros = $(this).attr("num_registros"); 
	if (num_registros > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../base/index.php/api/base/registros/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}	
}
/**/

function carga_info_enviados(e){
	
	num_enviados = $(this).attr("num_enviados"); 
	if (num_enviados > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../base/index.php/api/base/enviados/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	}	
}
/**/
function carga_info_blogs(e){

	
	num_blogs = $(this).attr("num_blogs"); 
	if (num_blogs > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/blog/fecha/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			llenaelementoHTML(".place_mas_info", data ); 					
		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");
		});	
	
}

}
/*
function lanzar_mensajeria(){

	url =  "../msj/index.php/api/marketing/blaster/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_envios" , "Cargando..." );
			}  
		}).done(function(data){			

			llenaelementoHTML(".place_envios", "Correos enviados: "+data.data_email_enviados ); 					

		}).fail(function(){
			show_error_enid(".place_envios", "Error al actualizar incidencia");
		});	
}
*/
/**/
function busqueda_actividad_enid(e){

	
	url =  "../q/index.php/api/enid/usabilidad_landing_pages/format/json/";
	$.ajax({
		url : url , 
		type : "GET" ,
		data: $(".form_busqueda_actividad_enid").serialize() , 
		beforeSend: function(){
			show_load_enid( ".place_usabilidad" , "Cargando ..." , 1 );
		}
	}).done(function(data){
		

		llenaelementoHTML(".place_usabilidad" , data);
		$(".sitios_dia").click(carga_info_sitios_dia);
		$(".dispositivos_dis").click(carga_info_dispositivos_dia);
		$('th').click(ordena_table_general);

	}).fail(function(){

		show_error_enid(".place_usabilidad" , "Error en la usabilidad"); 

	});
	

	

	e.preventDefault();
}


function carga_presentaciones(e){

	url =  "../q/index.php/api/objetivos/presentaciones/format/json/";
	data_send =  $(".form_presentaciones").serialize();
	

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send, 
		beforeSend: function(){
			show_load_enid( ".place_presentaciones" , "Cargando ..." , 1 );
		}
	}).done(function(data){
		

		llenaelementoHTML(".place_presentaciones" , data);

	}).fail(function(){

		show_error_enid(".place_presentaciones" , "Error en la usabilidad"); 

	});
	
	e.preventDefault();
}
/**/
/*
function carga_objetivos_dia(){
	
	data_send =  {}; 
	url =  "../q/index.php/api/objetivos/usuario/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_objetivos" , "Cargando ... ");
		}
	}).done(function(data){										
		
		llenaelementoHTML(".place_objetivos" , data);											
					
	}).fail(function(){
			show_error_enid(".place_objetivos" , "Error ... al cargar portafolio.");
	});	
	
}
*/	
/**/
function registra_metas(e){
	

	data_send =  $("#form_metas").serialize(); 	
	url =  "../q/index.php/api/objetivos/meta/format/json/";
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_metas" , "Cargando ... ");
		}
	}).done(function(data){										
		
		show_response_ok_enid(".place_registro_metas" , "Meta registrada!");											
		$("#fijar_metas_equipo").modal("hide");

		//carga_objetivos_dia();
					
	}).fail(function(){
			show_error_enid(".place_registro_metas" , "Error ... al cargar portafolio.");
	});	
	e.preventDefault();
}
/***/

/**/
function cargar_perfiles_disponibles(e){
	
	url =  "../base/index.php/api/perfiles/disponibles/format/json/";
	data_send =  $("#form_busqueda_tipo_negocio").serialize() +"&"+ $.param({"solo_lectura":0});

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_perfiles_disponibles" , "Cargando ... ");
		}
	}).done(function(data){										
		
		llenaelementoHTML(".place_perfiles_disponibles" , data);											
		$(".tipo_servicio").click(actualiza_perfil_disponibles);
		$(".limpiar_perfiles_dia").click(limpia_perfiles_disponibles);
					
	}).fail(function(){
			show_error_enid(".place_perfiles_disponibles" , "Error ... al cargar portafolio.");
	});	

	e.preventDefault();
}
/**/
function actualiza_perfil_disponibles(e){
	
	url =  "../base/index.php/api/perfiles/disponibles/format/json/";
	id_tipo_negocio =  e.target.id; 	
	flag =  e.target.value; 

	data_send = {"id_tipo_negocio" : id_tipo_negocio ,  "flag" : flag  }
	$.ajax({url : url , 
			type: "PUT",			
			data: data_send , 			
			beforeSend: function(){
	
			}
	}).done(function(data){												
	
		cargar_perfiles_disponibles();

	}).fail(function(){
			show_error_enid(".place_perfiles_disponibles" , "Error ... al cargar portafolio.");
	});	
}
/**/
function limpia_perfiles_disponibles(){

	url =  "../base/index.php/api/perfiles/disponible/format/json/";
	data_send =  {};
	$.ajax({
			url : url , 
			type: "DELETE",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_perfiles_disponibles" , "Cargando ... ");
		}
	}).done(function(data){												
		cargar_perfiles_disponibles();					
	}).fail(function(){
			show_error_enid(".place_perfiles_disponibles" , "Error ... al cargar portafolio.");
	});	
}
/**/
function cargar_info_clientes(e){

	valor =  $(this).attr("num_proyectos"); 	
	if (valor>0) {
				
		fecha =  e.target.id;
		set_fecha(fecha);	
		data_send = {fecha : get_fecha() , "tipo" : 2}; 	
	
		url =  "../q/index.php/api/productividad/num_clientes/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			
			$("#mas_info").modal("show");		
			llenaelementoHTML(".place_mas_info" , data);			

		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");			
		});

	}
}
/**/
function cargar_info_clientes_prospecto(e){
		
	valor =  $(this).attr("num_proyectos"); 	

	if (valor>0) {

		fecha =  e.target.id;
		set_fecha(fecha);	
		data_send = {fecha : get_fecha() , "tipo": 1}; 	
	
		url =  "../q/index.php/api/productividad/num_clientes/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			
			$("#mas_info").modal("show");		
			llenaelementoHTML(".place_mas_info" , data);			

		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");			
		});

	}
}
/**/
function cargar_contactos_promociones(e){


	valor =  $(this).attr("num_contactos"); 		

	if(valor>0){

		fecha =  e.target.id;
		set_fecha(fecha);	
		data_send = {fecha : get_fecha() , "tipo": 15}; 	
	
		url =  "../q/index.php/api/productividad/contactos_lead/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			
			
			$("#mas_info").modal("show");		
			llenaelementoHTML(".place_mas_info" , data);			

		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");			
		});

	}


}
/**/
function cargar_info_sistema(e){
		
	valor =  $(this).attr("num_proyectos"); 		
	if (valor>0) {
		
		fecha =  e.target.id;
		set_fecha(fecha);	
		data_send = {fecha : get_fecha() , "tipo": 1}; 	
	
		url =  "../q/index.php/api/productividad/num_clientes_sistema/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			

			$("#mas_info").modal("show");		
			llenaelementoHTML(".place_mas_info" , data);			

		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");			
		});

	}
}
/**/
function cargar_info_afiliados(e){

	valor =  $(this).attr("num_afiliados"); 			
	if (valor>0) {
		
		fecha =  e.target.id;
		set_fecha(fecha);	
		data_send = {fecha : get_fecha() , "tipo": 1}; 	
	
		url =  "../q/index.php/api/productividad/num_afiliados/format/json/";	
		$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_mas_info" , "Cargando..." );
			}  
		}).done(function(data){			

			$("#mas_info").modal("show");		
			llenaelementoHTML(".place_mas_info" , data);			

		}).fail(function(){
			show_error_enid(".place_mas_info", "Error al actualizar incidencia");			
		});

	}
}
/**/

/**/
function get_fecha(){
	return fecha;
}
/**/
function set_fecha(n_fecha){
	fecha =  n_fecha;

}
function carga_metricas_desarrollo(e){

	url =  "../q/index.php/api/desarrollo/global/format/json/";	
	data_send =  $(".form_busqueda_desarrollo").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_metricas_desarrollo" , "Cargando ..." , 1 );
		}
	}).done(function(data){	

		
		llenaelementoHTML(".place_metricas_desarrollo" , data);
			$('th').click(ordena_table_general);		
	}).fail(function(){
		show_error_enid(".place_metricas_desarrollo" , "Error al cargar ..."); 
	});
	
	e.preventDefault();
}
/**/
function carga_comparativas(){
	
	url =  "../q/index.php/api/desarrollo/comparativas/format/json/";	
	data_send =  {};

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_metricas_comparativa" , "Cargando ..." , 1 );
		}
	}).done(function(data){	
		
		llenaelementoHTML(".place_metricas_comparativa" , data);

			$('th').click(ordena_table_general);		
	}).fail(function(){
		show_error_enid(".place_metricas_comparativa" , "Error al cargar ..."); 
	});
	
	e.preventDefault();	
}
/**/
function carga_solicitudes_cliente(e){

	url =  "../q/index.php/api/desarrollo/global_calidad/format/json/";	
	data_send =  $(".form_busqueda_desarrollo_solicitudes").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_metricas_servicio" , "Cargando ..." , 1 );
		}
	}).done(function(data){	
		
		llenaelementoHTML(".place_metricas_servicio" , data);
			$('th').click(ordena_table_general);		
	}).fail(function(){
		show_error_enid(".place_metricas_servicio" , "Error al cargar ..."); 
	});
	
	e.preventDefault();
} 
/**/
function carga_repo_afiliacion(e){	
	url =  "../q/index.php/api/afiliacion/metricas/format/json/";	
	data_send =  $(".form_busqueda_afiliacion").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_repo_afiliacion" , "Cargando ..." , 1 );
		}
	}).done(function(data){			
		/**/
		llenaelementoHTML(".place_repo_afiliacion" , data);	
	}).fail(function(){
		show_error_enid(".place_repo_afiliacion" , "Error al cargar ..."); 
	});	
	e.preventDefault();
}
/**/
function carga_repo_afiliacion_productividad(e){
	
	url =  "../q/index.php/api/afiliacion/afiliados_productividad/format/json/";	
	data_send =  $(".form_busqueda_afiliacion_productividad").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_repo_afiliacion_productividad" , "Cargando ..." , 1 );
		}
	}).done(function(data){			
		/**/
		llenaelementoHTML(".place_repo_afiliacion_productividad" , data);
		/**/		
	}).fail(function(){
		show_error_enid(".place_repo_afiliacion_productividad" , "Error al cargar ..."); 
	});	
	e.preventDefault();	
}
/**/
function carga_productos_mas_solicitados(e){

	url =  "../q/index.php/api/productos/metricas_productos_solicitados/format/json/";	
	data_send =  $(".form_busqueda_productos_solicitados").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_keywords" , "Cargando ..." , 1 );
		}
	}).done(function(data){			

		llenaelementoHTML(".place_keywords" , data);
	
	}).fail(function(){
		show_error_enid(".place_keywords" , "Error al cargar ..."); 
	});	
	e.preventDefault();	
}
/**/
function resumen_usuarios(){

	fecha_inicio =  $(this).attr("fecha_inicio"); 
	fecha_termino = $(this).attr("fecha_termino"); 
	
	url =  "../persona/index.php/api/equipo/usuarios/format/json/";	
	data_send =  {"fecha_inicio":fecha_inicio , "fecha_termino":  fecha_termino ,  "page" : get_option("page")};

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_reporte" , "Cargando ..." , 1 );
		}
	}).done(function(data){			
		llenaelementoHTML(".place_reporte" , data);
		$(".pagination > li > a, .pagination > li > span").css("color" , "white");
		
		/**/
		$(".pagination > li > a, .pagination > li > span").click(function(e){				

				var page_html =   $(this);				
				num_paginacion =  $(page_html).attr("data-ci-pagination-page");
				/**/
				
				if (validar_si_numero(num_paginacion) ==  true){
					set_option("page", num_paginacion);	
				}else{
					num_paginacion =  $(this).text();					
					set_option("page", num_paginacion);	
				}				
				resumen_usuarios();
				e.preventDefault();				
		});

		
		
	}).fail(function(){
		show_error_enid(".place_reporte" , "Error al cargar ..."); 
	});	
}
/**/
function resumen_mensajes(){

	fecha_inicio =  $(this).attr("fecha_inicio"); 
	fecha_termino = $(this).attr("fecha_termino"); 	
	data_send =  {"fecha_inicio":fecha_inicio , "fecha_termino":  fecha_termino};
	url =  "../q/index.php/api/cotizaciones/contactos/format/json/";	
	$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_reporte" , "Cargando..." );
			}  
	}).done(function(data){			
			llenaelementoHTML(".place_reporte", data ); 					
	}).fail(function(){
			show_error_enid(".place_reporte", "Error al actualizar incidencia");
	});		
}
/**/
function resumen_compras(){

	fecha_inicio =  $(this).attr("fecha_inicio"); 
	fecha_termino = $(this).attr("fecha_termino"); 	
	tipo =  $(this).attr("tipo_compra");
	data_send =  {"fecha_inicio":fecha_inicio , "fecha_termino":  fecha_termino , "tipo" : tipo};
	url =  "../pagos/index.php/api/tickets/compras/format/json/";	

	$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_reporte" , "Cargando..." );
			}  
	}).done(function(data){			
			llenaelementoHTML(".place_reporte", data ); 					
	}).fail(function(){
			show_error_enid(".place_reporte", "Error al actualizar incidencia");
	});			
}
/**/
function resumen_valoracion(){
	
	fecha_inicio =  $(this).attr("fecha_inicio"); 
	fecha_termino = $(this).attr("fecha_termino"); 	

	data_send =  {"fecha_inicio":fecha_inicio , "fecha_termino":  fecha_termino };
	url =  "../portafolio/index.php/api/valoracion/resumen_valoraciones_periodo/format/json/";	

	$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_reporte" , "Cargando..." );
			}  
	}).done(function(data){			
			llenaelementoHTML(".place_reporte", data ); 					
	}).fail(function(){
			show_error_enid(".place_reporte", "Error al actualizar incidencia");
	});				
}
/**/
function resumen_servicios(){
	
	/***/
	fecha_inicio =  $(this).attr("fecha_inicio"); 
	fecha_termino = $(this).attr("fecha_termino"); 	

	data_send =  {"fecha_inicio":fecha_inicio , "fecha_termino":  fecha_termino };
	url =  "../tag/index.php/api/producto/periodo/format/json/";	

	$.ajax({
			url : url , 
			type : "GET", 
			data :  data_send , 
			beforeSend: function(){
				show_load_enid(".place_reporte" , "Cargando..." );
			}  
	}).done(function(data){			
			llenaelementoHTML(".place_reporte", data ); 					
	}).fail(function(){
			show_error_enid(".place_reporte", "Error al actualizar incidencia");
	});				
}

