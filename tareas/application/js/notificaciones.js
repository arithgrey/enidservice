/**/
function carga_notificacion_email_enviados(){
	

	url =  "../q/index.php/api/notificaciones/email_enviados/format/json/";	
	data_send = {id_usuario : get_id_usuario()};	

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){																
			llenaelementoHTML(".place_notificacion_email_enviados" , data.meta_cubierta);			
		}).fail(function(){
			show_error_enid(".place_notificacion_email_enviados" , "Error ... al cargar portafolio.");
	});
}
/**/
function carga_notificacion_accesos_sitios_web(){

	url =  "../q/index.php/api/notificaciones/accesos_sitios_web/format/json/";	
	data_send = {id_usuario : get_id_usuario()};	
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){													
			
			llenaelementoHTML(".place_notificacion_accesos_dia" , data.meta_cubierta);						
			
		}).fail(function(){
			show_error_enid(".place_notificacion_accesos_sitios_web" , "Error ... al cargar portafolio.");
	});
}
/**
function carga_blog_creados(){
	
	url =  "../q/index.php/api/notificaciones/blogs_dia/format/json/";	
	data_send = {id_usuario : get_id_usuario()};	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){													
			
				
			llenaelementoHTML(".place_num_blogs_creados" , data);
		}).fail(function(){
			show_error_enid(".place_notificacion_accesos_sitios_web" , "Error ... al cargar portafolio.");
	});	
}
**/
/**/
function carga_ranking_mensajes(){
		
		
	url =  "../q/index.php/api/mensajes/ranking_usuarios_mensajes/format/json/";	
	data_send = {};	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){																
				
			llenaelementoHTML(".place_ranking_mensajes" , data);

		}).fail(function(){
			show_error_enid(".place_ranking_mensajes" , "Error ... al cargar portafolio.");
	});		
}
/**/
function carga_ranking_blog(){

	url =  "../q/index.php/api/mensajes/ranking_usuarios_blog/format/json/";	
	data_send = {};	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){																
			llenaelementoHTML(".place_ranking_blog" , data);

		}).fail(function(){
			show_error_enid(".place_ranking_blog" , "Error ... al cargar portafolio.");
	});	
}
/**/
function carga_ranking_personal(){

	
	url =  "../q/index.php/api/mensajes/ranking_posts/format/json/";	
	data_send = {};	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){																				
			
			llenaelementoHTML(".place_ranking_personal" , data);

		}).fail(function(){
			show_error_enid(".place_ranking_personal" , "Error ... al cargar portafolio.");
	});	
}
