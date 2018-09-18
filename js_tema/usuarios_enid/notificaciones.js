function cargar_num_envios_a_validacion(){
	
	url =  "../q/index.php/api/ventas_tel/num_agendados_validacion/format/json/";		
	data_send =  {"id_usuario" : get_id_usuario()};				

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
	/**/

}
/**/
function  cargar_num_agendados_email(){
	
	url =  "../q/index.php/api/ventas_tel/num_agendados_email/format/json/";		
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
function  cargar_num_agendados(){
	
	url =  "../q/index.php/api/ventas_tel/num_agendados/format/json/";		
	data_send =  {"id_usuario" : get_id_usuario()};				
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																						

		llenaelementoHTML(".place_num_agendados" , data.num_agendados_posibles_clientes);
		llenaelementoHTML(".place_num_agendados_totales" , data.totales);
		llenaelementoHTML(".place_num_agendados_llamar_despues" , data.num_agendados_llamar_despues );

		
	

	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
}
/**/
function  cargar_num_clientes_restantes(){

	url =  "../q/index.php/api/ventas_tel/num_clientes_restantes/format/json/";		
	data_send =  {"id_usuario" : get_id_usuario()};				
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