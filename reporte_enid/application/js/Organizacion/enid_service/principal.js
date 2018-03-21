var incidencia = 0;
$(document).ready(function(){
	
	$("#nuevos_miembros").click(carga_nuevos_miembros);
	$("#seccion_bugs").click(carga_bugs_enid);
	$("#form-calificacion-incidencia").submit(modifica_inicidencia);
	$("#estado_incidencia").change(carga_bugs_enid);
	$(".mail_marketing").click(carga_metricas_mail_marketing);
	$(".form_busqueda_mail_enid").submit(carga_metricas_mail_marketing);
	$(".usabilidad_btn").click(carga_uso_sistema);
	$(".cotizaciones").ready(carga_metricas_cotizaciones);
	$(".cotizaciones").click(carga_metricas_cotizaciones);
	$(".form_busqueda_global_enid").submit(carga_metricas_cotizaciones);

	$(".btn_mensajeria_camp").click(lanzar_mensajeria);	
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();	

	$(".form_busqueda_actividad_enid").submit(busqueda_actividad_enid);
});
/**/
function set_inicidencia(new_inicidencia){	
	incidencia =  new_inicidencia;

}
/**/
function get_inicidencia(){
	return incidencia;

}
/**/
function carga_uso_sistema(){
	url =  "../q/index.php/api/enid/usabilidad_landing_pages/format/json/";
	$.ajax({
		url : url , 
		type : "GET" ,
		data: {} , 
		beforeSend: function(){
			show_load_enid( ".place_usabilidad" , "Cargando ..." , 1 );
		}
	}).done(function(data){

		//console.log(data);

		llenaelementoHTML(".place_usabilidad" , data);
		$(".sitios_dia").click(carga_info_sitios_dia);
		$(".dispositivos_dis").click(carga_info_dispositivos_dia);

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
/**/
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

/**/
function evaluar(e){

	incidencia = e.target.id;
	set_inicidencia(incidencia);
}
/**/
function modifica_inicidencia(e){
	
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
/**/
function carga_metricas_mail_marketing(e){
	
	data_send = $(".form_busqueda_mail_enid").serialize(); 	
	url =  "../q/index.php/api/enid/reporte_mail_marketing/format/json/";	
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

	data_send = $(".form_busqueda_global_enid").serialize(); 	
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
		$(".proyectos_registrados").click(carga_info_proyectos);
		$(".cotizaciones_registradas").click(carga_info_cotizaciones);	
		
			$(".contactos_registrados").click(carga_info_contactos);	
			$(".contactos_registrados_descarga_sitios_web").click(carga_info_descarga_paginas_web);	
			$(".contactos_registrados_adwords").click(carga_info_descarga_adwords);	
			$(".contactos_registrados_tienda_linea").click(carga_info_descarga_tienda_linea);	
			$(".contactos_registrados_crm").click(carga_info_descarga_crm);	
			

			

		$(".base_registrada").click(carga_info_registros);
		$(".base_enviados").click(carga_info_enviados);
		$(".blogs_creados").click(carga_info_blogs);
		
	}).fail(function(){
		show_error_enid(".place_usabilidad", "Error al actualizar incidencia");
	});	
	e.preventDefault();
	
}
/*Data proyectos*/
function carga_info_proyectos(e){
	num_proyectos = $(this).attr("num_proyectos"); 
	if (num_proyectos > 0 ) {

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
function carga_info_contactos(e){

	num_contactos = $(this).attr("num_contactos"); 
	if (num_contactos > 0 ) {

		$("#mas_info").modal("show");
		fecha =  e.target.id;
		data_send = {"fecha" : fecha}; 	
		url =  "../q/index.php/api/cotizaciones/contactos/format/json/";	
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
/**/
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

	}).fail(function(){

		show_error_enid(".place_usabilidad" , "Error en la usabilidad"); 

	});
	

	

	e.preventDefault();
}