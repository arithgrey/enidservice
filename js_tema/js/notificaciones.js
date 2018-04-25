var depto =0;
function cargar_num_envios_a_validacion(){

	url =  "../base/index.php/api/ventas_tel/num_agendados_validacion/format/json/";		
	data_send =  {"id_usuario" : get_option("id_usuario")};				
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){																								
		llenaelementoHTML(".place_num_envios_a_validacion" , data);
		recorre_web_version_movil();
		/**/	
	}).fail(function(){			
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});	
}
/**/
/**/
function  cargar_num_agendados(){
	
	
	url =  "../base/index.php/api/ventas_tel/num_agendados/format/json/";		
	data_send =  {"id_usuario" : get_option("id_usuario") };				
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																						
		

		/**/		
			llenaelementoHTML(".place_num_agendados" , data.num_agendados_posibles_clientes);		
			//llenaelementoHTML(".place_num_agendados_totales" , data.totales);
			//llenaelementoHTML(".place_num_agendados_llamar_despues" , data.num_agendados_llamar_despues);
			//llenaelementoHTML(".place_num_agendados_contactos" , data.num_agendados_contactos);
			//llenaelementoHTML(".place_num_nuevos_usuarios_subscritos" , data.num_contactos_nuevos_subscritos);				
			llenaelementoHTML(".place_num_tareas_pendientes" , data.num_tareas_pendientes);
		/**/

	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
}
/**/
function  cargar_num_clientes_restantes(){

	url =  "../base/index.php/api/ventas_tel/num_clientes_restantes/format/json/";		
	data_send =  {"id_usuario" : get_option("id_usuario")};				
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																						
		llenaelementoHTML(".place_num_productividad" , data);

	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
}
function carga_num_pendientes(){

	url =  "../q/index.php/api/desarrollo/num_tareas_pendientes/format/json/";		

	data_send =  {"id_usuario" : get_option("id_usuario") , "id_departamento" :  get_depto() };				

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
function set_depto(new_depto){
	depto = new_depto;
}
/**/
function get_depto(){
	return depto;
}
/**/