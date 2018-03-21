/**/
function num_accesos_afiliados(){
	
	url =  "../q/index.php/api/productividad/accesos_afiliados/format/json/";		
	data_send =  {};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
			}
	}).done(function(data){																								
		
		llenaelementoHTML(".num_visitas" , data.num_accesos);
		llenaelementoHTML(".num_contactos" , data.num_contactos);		
		llenaelementoHTML(".num_efectivo" , data.num_efectivo);	
		llenaelementoHTML(".num_ventas_por_recomendacion" , data.num_ventas_por_recomendacion);	
		

		/**/	
	}).fail(function(){			
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});	
	/**/
}
/**/