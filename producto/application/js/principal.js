$(document).ready(function(){
	/**/
	set_option("servicio" , $(".servicio").val());
	set_option("respuesta_valorada" , 0);		
	$("footer").ready(carga_productos_sugeridos);
	$("footer").ready(carga_valoraciones);
	set_option("desde_valoracion", $(".desde_valoracion").val());
	set_option("orden" ,"desc");	
	$(".agregar_a_lista_deseos").click(agregar_a_lista_deseos);
});
/**/
function carga_productos_sugeridos(){


	url =  "../tag/index.php/api/sugerencia/servicio/format/json/";		
	data_send = {"servicio" : get_option("servicio")}	
	
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
function agrega_valoracion_respuesta(valoracion , num){

	url =  "../portafolio/index.php/api/valoracion/utilidad/format/json/";			
	data_send = {"valoracion" : valoracion,  "utilidad" :  num}	
	set_option("respuesta_valorada" , valoracion);		
	/************************************************************************************/
	$.ajax({
		url : url , 
		type : "PUT" , 
		data: data_send, 
			beforeSend : function(){} 					
		}).done(function(data){				
			carga_valoraciones();			
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
/**/
function agregar_a_lista_deseos(){	
	url =  "../tag/index.php/api/producto/lista_deseos/format/json/";		
	data_send = {"servicio" : get_option("servicio")}		
	$.ajax({
		url : url , 
		type : "PUT" , 
		data: data_send				
	}).done(respuesta_add_valoracion).fail(function(){});	
}
/**/
function respuesta_add_valoracion(data){	
	$("#agregar_a_lista_deseos_add").empty();	
	llenaelementoHTML("#agregar_a_lista_deseos_add" , "<div class='btn_add_list'>AÑADISTE A TU LISTA DE DESEOS ESTE PRODUCTO! <i class='fa fa-gift'></i></div><br>");
	redirect("../lista_deseos");
}
