"use strict";
let carga_buzon = function(){

	$(".contenedor_opciones_buzon").show();
	let url =  "../q/index.php/api/pregunta/buzon/format/json/";		
	let data_send =  {"modalidad" : get_option("modalidad_ventas")};	
	request_enid( "GET",  data_send, url, response_buzon, ".place_buzon" );	
}
let response_buzon = function(data){
	llenaelementoHTML(".place_buzon"  , data);										
	$(".pregunta").click(carga_respuestas);		
}
let carga_respuestas = function(){

	let id_pregunta 		=  	parseInt(get_attr(this, "id"));	
	let pregunta 			=  	get_attr(this, "pregunta");		
	let registro 			=  	get_attr(this, "registro");		
	let nombre_servicio 	= 	get_attr(this, "nombre_servicio");
	let usuario_pregunta	=  	get_attr(this, "usuario");		
	let servicio 			= 	get_attr(this, "servicio");			
	if( id_pregunta > 0 ){
		
		set_option("pregunta" , id_pregunta);		
		let data_send = {"id_pregunta":id_pregunta , "pregunta" : pregunta, "registro" : registro , "usuario_pregunta" : usuario_pregunta , "modalidad" : get_option("modalidad_ventas") , "nombre_servicio":nombre_servicio , "id_servicio" :servicio};
		set_option("data_pregunta" , data_send);		
		carga_respuesta_complete();		
	}
	
}
let carga_respuesta_complete = function(){

	let data_send	 	=  get_option("data_pregunta");
	console.log(data_send);
	let url 			=  "../q/index.php/api/respuesta/respuesta_pregunta/format/json/";		
	request_enid( "GET",  data_send, url, response_respuesta_complete,".place_buzon" );
}
let response_respuesta_complete = function(data){

	$(".contenedor_opciones_buzon").hide();
	llenaelementoHTML(".place_buzon" , data);
	$(".form_valoracion_pregunta").submit(enviar_respuesta);
	carga_num_preguntas();
}
let enviar_respuesta = function(e){
	
	let data_send 	=  $(".form_valoracion_pregunta").serialize()+"&"+$.param({"pregunta" : get_option("pregunta") , "modalidad" : get_option("modalidad_ventas")});				
	let url 		=  "../q/index.php/api/respuesta/respuesta_pregunta/format/json/";			
	request_enid( "POST",  data_send, url, carga_respuesta_complete); 
	e.preventDefault();
}