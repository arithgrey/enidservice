function  cargar_num_agendados(){
	
	url =  "../base/index.php/api/ventas_tel/num_agendados/format/json/";		
	data_send =  {"id_usuario" : get_id_usuario()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																						
		llenaelementoHTML(".place_num_agendados" , data);
	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
}
/**/
function  cargar_num_agendados_email(){
	
	url =  "../base/index.php/api/ventas_tel/num_agendados_email/format/json/";		
	data_send =  {"id_usuario" : get_id_usuario()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){			

		
		llenaelementoHTML(".place_numero_agendados_email" , data);
		/**/	
	}).fail(function(){			
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});		
}
/**/
function carga_num_pagos_notificados(){

	url =  "../base/index.php/api/ventas_tel/num_pagos_notificados_persona/format/json/";		
	data_send =  {"id_persona" : get_id_usuario()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){			
		
		llenaelementoHTML(".place_num_pagos_notificados" , data);
		/**/	
	}).fail(function(){			
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});			
}
/**/
function carga_num_cobranza(){
	
	url =  "../pagos/index.php/api/cobranza/resumen_num_pendientes_persona/format/json/";		
	data_send =  {"id_persona" : get_persona()};				
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){			
		
		llenaelementoHTML(".place_num_pagos_notificados" , data);		

	}).fail(function(){			
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});			
}