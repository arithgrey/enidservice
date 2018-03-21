function descargar_contactos(e){

	/**/
	$(".btn_descargar_email").hide();
	url =  "../base/index.php/api/base/prospectos/format/json/";	
	$.ajax({
			url : url , 
			type: "GET",
			data: $("#form_descargar_contactos").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_contactos_disponibles" , "Cargando ... ", 1 );
		}
	}).done(function(data){												
		llenaelementoHTML(".place_contactos_disponibles" , data);														
		$(".form_update_correo").submit(actualiza_contactos);
		/**/
	}).fail(function(){
			show_error_enid(".place_contactos_disponibles" , "Error ... al cargar portafolio.");
	});	
	
	e.preventDefault();
}
/**/
function actualiza_contactos(e){

	url =  "../base/index.php/api/base/prospectos/format/json/";	
	data_send =  $(".form_update_correo").serialize();

	$.ajax({
			url : url , 
			type: "PUT" ,
			data: data_send , 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			

			/*******************************************/
			llenaelementoHTML(".place_registro" , data );						
			$(".text_info").val("");			
			
				/**/	
				$(".btn_descargar_email").show();
				$(".btn_registro_actualizacion").hide();

			carga_info_registros();				
			carga_notificacion_email_enviados();

		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();
}