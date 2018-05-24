function carga_buzon(){
	$(".contenedor_opciones_buzon").show();
	url =  "../portafolio/index.php/api/valoracion/preguntas/format/json/";		
	data_send =  {"modalidad" : get_option("modalidad_ventas")};				
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_buzon" , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		/**/
		llenaelementoHTML(".place_buzon"  , data);										
		$(".pregunta").click(carga_respuestas);
		
	}).fail(function(){			
		show_error_enid(".place_buzon"  , "Error ... ");
	});	
}
/**/
function carga_respuestas(e){	
	id_pregunta =  parseInt(e.target.id);
	var elemento =  $(this);
	pregunta =  $(elemento).attr("pregunta");
	registro =  $(elemento).attr("registro");		
	nombre_servicio = $(elemento).attr("nombre_servicio");
	usuario_pregunta =  $(elemento).attr("usuario");		
	servicio =  $(elemento).attr("servicio");			

	if(id_pregunta>0){
		/**/
		set_option("pregunta" , id_pregunta);		
		data_send = {"id_pregunta":id_pregunta , "pregunta" : pregunta, "registro" : registro , "usuario_pregunta" : usuario_pregunta , "modalidad" : get_option("modalidad_ventas") , "nombre_servicio":nombre_servicio , "servicio" :servicio}		
		set_option("data_pregunta" , data_send);
		carga_respuesta_complete();		
	}
	/**/
}
/**/
function carga_respuesta_complete(){		
		data_send =  get_option("data_pregunta");
		url =  "../portafolio/index.php/api/valoracion/respuesta_pregunta/format/json/";		

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_buzon" , "Cargando ... ", 1 );
				}}).done(function(data){									
					$(".contenedor_opciones_buzon").hide();
					llenaelementoHTML(".place_buzon" , data);
					$(".form_valoracion_pregunta").submit(enviar_respuesta);

			}).fail(function(){			
				show_error_enid(".place_buzon"  , "Error ... ");
		});			
}
/**/
function enviar_respuesta(e){
	
	data_send =  $(".form_valoracion_pregunta").serialize()+"&"+$.param({"pregunta" : get_option("pregunta") , "modalidad" : get_option("modalidad_ventas")});				
	url =  "../portafolio/index.php/api/valoracion/respuesta_pregunta/format/json/";			
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
		beforeSend: function(){
			//show_load_enid(".place_buzon" , "Cargando ... ", 1 );
		}}).done(function(data){									
			
			carga_respuesta_complete();

		}).fail(function(){			
			//show_error_enid(".place_buzon"  , "Error ... ");
		});	
	e.preventDefault();
}