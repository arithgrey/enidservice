$(document).ready(function(){
	/*Valores por default*/
	set_option("recomendaria", 3);
	set_option("calificacion", 5);
	set_option("servicio" , $(".servicio").val());
	set_option("respuesta_valorada" , 0);		
	$(".form_valoracion").submit(registra_valoracion);
	envio_pregunta =  $(".envio_pregunta").val();
	if (envio_pregunta !=1){
		bloquea_form(".form_valoracion");
		$(".contenedor_registro").show();
	}	
	$("footer").ready(carga_productos_sugeridos);
	$("footer").ready(carga_valoraciones);
});
/**/
function registra_valoracion(e){

	flag =  valida_text_form("#pregunta" , ".place_area_pregunta" , 5 , "Pregunta" );
	if (flag == 1) {
		url ="../portafolio/index.php/api/valoracion/pregunta/format/json/";
		data_send =  $(".form_valoracion").serialize();		
		console.log(data_send);
		/**/
			$.ajax({
					url : url , 
					type : "POST" , 
					data: data_send, 
					beforeSend : function(){						
						show_load_enid(".place_registro_valoracion" ,  "Validando datos " , 1 );						
						bloquea_form(".form_valoracion");
					}
			}).done(function(data){
									
				if (data ==  1 ){
					$(".registro_pregunta").show();		
					$(".place_registro_valoracion").empty();
				}
				/**/
			}).fail(function(){							
				show_error_enid(".place_registro_valoracion" , "Error al iniciar sessión");				
			});		
	}
	e.preventDefault();
}
/**/
function carga_productos_sugeridos(){
	
	url =  "../tag/index.php/api/sugerencia/servicio/format/json/";		
	data_send = {"servicio" : get_option("servicio") }	

	$.ajax({
		url : url , 
		type : "GET" , 
		data: data_send, 
			beforeSend : function(){} 					
		}).done(function(data){			
			console.log(data);
			if (data["sugerencias"] == undefined ){				
				llenaelementoHTML(".place_tambien_podria_interezar" , data);		
				/**/
			}
		}).fail(function(){							
			show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");				
	});
}
/**/
function carga_valoraciones(){
	url =  "../portafolio/index.php/api/valoracion/articulo/format/json/";		
	data_send = {"servicio" : get_option("servicio") , "respuesta_valorada" : get_option("respuesta_valorada")}	
	/************************************************************************************/
	$.ajax({
		url : url , 
		type : "GET" , 
		data: data_send, 
			beforeSend : function(){} 					
		}).done(function(data){			
			
			llenaelementoHTML(".place_valoraciones" , data);

			if(get_option("desde_valoracion") ==  1){
				recorrepage(".place_valoraciones");				
				set_option("desde_valoracion" , 0);

			}
			$(".ordenar_valoraciones_button").click(ordenar_valoraciones);			
			valoracion_persona=  $(".contenedor_promedios").html();
			llenaelementoHTML(".valoracion_persona" , valoracion_persona);
			$(".valoracion_persona_principal .valoracion_persona .estrella").css("font-size" , "1.2em");
			$(".valoracion_persona_principal .valoracion_persona .promedio_num").css("font-size" , "1.2em");
			
		}).fail(function(){							
			show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");				
		});
}
/**/
function ordenar_valoraciones(e){

	tipo_ordenamiento=  e.target.id;  
	switch(parseInt(tipo_ordenamiento)){
		case 0:
			/*Ordenamos por los que tienen más votos*/			
			var div = $(".contenedor_global_recomendaciones");			
			var listitems = div.children('.contenedor_valoracion_info').get();			
			listitems.sort(function (a, b) {

					 return (+$(a).attr('numero_utilidad') > +$(b).attr('numero_utilidad')) ?
					  -1 : (+$(a).attr('numero_utilidad') < +$(b).attr('numero_utilidad')) ? 
					   1 : 0;

					})
				llenaelementoHTML(".contenedor_global_recomendaciones" , listitems);
				set_option("orden" , "asc");
			
			

			

		break;
		case 1:
			
			var div = $(".contenedor_global_recomendaciones");
			
			var listitems = div.children('.contenedor_valoracion_info').get();			
			listitems.sort(function (a, b) {

				 return (+$(a).attr('fecha_info_registro') > +$(b).attr('fecha_info_registro')) ?
				  -1 : (+$(a).attr('fecha_info_registro') < +$(b).attr('fecha_info_registro')) ? 
				   1 : 0;

				})

			llenaelementoHTML(".contenedor_global_recomendaciones" , listitems);
			
		break;
		case 2:
		break;
		default:
	}
}