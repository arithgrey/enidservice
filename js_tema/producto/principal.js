"use strict";
$(document).ready(function(){
	/**/
	set_option("servicio" , get_parameter(".servicio"));
	set_option("respuesta_valorada" , 0);		
	$("footer").ready(carga_productos_sugeridos);
	$("footer").ready(carga_valoraciones);
	set_option("desde_valoracion", get_parameter(".desde_valoracion"));
	set_option("orden" ,"desc");	
	$(".agregar_a_lista_deseos").click(agregar_a_lista_deseos);	
	$(".talla").click(agregar_talla);

});
/**/
function carga_productos_sugeridos(){

	var url 		=  "../q/index.php/api/servicio/sugerencia/format/json/";		
	var q 			=  get_parameter(".qservicio");  	
	var data_send 	= {"id_servicio" : get_option("servicio") , "q" :  q};
	request_enid( "GET",  data_send, url, response_carga_productos);
}
/**/
function response_carga_productos(data){
	if (data["sugerencias"] == undefined ){				
		llenaelementoHTML(".place_tambien_podria_interezar" , data);						
	}
}
/**/
function carga_valoraciones(){
	var url 		=  "../q/index.php/api/valoracion/articulo/format/json/";		
	var data_send	= {"id_servicio" : get_option("servicio") , "respuesta_valorada" : get_option("respuesta_valorada")};
	request_enid( "GET",  data_send, url, response_carga_valoraciones);
}
/**/
function response_carga_valoraciones(data){
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
			
}
/**/
function agrega_valoracion_respuesta(valoracion , num){

	var url =  "../q/index.php/api/valoracion/utilidad/format/json/";			
	var data_send = {"valoracion" : valoracion,  "utilidad" :  num};
	set_option("respuesta_valorada" , valoracion);		
	request_enid( "PUT",  data_send, url, carga_valoraciones);
}
/**/
function ordenar_valoraciones(e){

	tipo_ordenamiento=  get_parameter_enid($(this) , "id");  
	switch(parseInt(tipo_ordenamiento)){
		case 0:
			/*Ordenamos por los que tienen más votos*/			
			var div = $(".contenedor_global_recomendaciones");			
			var listitems = div.children('.contenedor_valoracion_info').get();			
			listitems.sort(function (a, b) {

					 return (+$(a).attr('numero_utilidad') > +$(b).attr('numero_utilidad')) ?
					  -1 : (+$(a).attr('numero_utilidad') < +$(b).attr('numero_utilidad')) ? 
					   1 : 0;

					});
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

				});
			llenaelementoHTML(".contenedor_global_recomendaciones" , listitems);
			
		break;
		case 2:
		break;
		default:
	}
}
/**/
function agregar_a_lista_deseos(){	
	var url =  "../q/index.php/api/usuario_deseo/lista_deseos/format/json/";		
	var data_send = {"id_servicio" : get_option("servicio")};
	request_enid( "PUT",  data_send, url, respuesta_add_valoracion);
}
/**/
function respuesta_add_valoracion(data){	
	
	
	$("#agregar_a_lista_deseos_add").empty();	
	llenaelementoHTML("#agregar_a_lista_deseos_add" , "<div class='btn_add_list'>AÑADISTE A TU LISTA DE DESEOS ESTE PRODUCTO! <i class='fa fa-gift'></i></div><br>");
	redirect("../lista_deseos");
	
	
}
/**/
function  agregar_talla(){
	
	var id_seleccion  =  get_attr(this, "id");
	$(".talla ").each(function(index) {      
		$(this).removeClass("talla_select");
		if (id_seleccion ==  get_attr(this, "id")) {
			$(this).addClass("talla_select");
			$(".producto_talla").val(id_seleccion);
		}      
  	});
}
