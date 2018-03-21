/**/
function carga_num_pendientes(){

	url =  "../q/index.php/api/desarrollo/num_tareas_pendientes/format/json/";		

	data_send =  {"id_usuario" : get_id_usuario() , "id_departamento" :  get_depto() };				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_tareas_pendientes" , "Cargando ... ", 1 );
			}
	}).done(function(data){		
		
		
		llenaelementoHTML(".place_tareas_pendientes" , data);

	}).fail(function(){			
		show_error_enid(".place_tareas_pendientes" , "Error ... ");
	});		

}
/**/
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