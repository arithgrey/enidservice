function carga_buzon(){

	$(".contenedor_opciones_buzon").show();
	var url =  "../q/index.php/api/pregunta/buzon/format/json/";		
	var data_send =  {"modalidad" : get_option("modalidad_ventas")};	
	request_enid( "GET",  data_send, url, response_buzon, ".place_buzon" );	
}
/**/
function response_buzon(data){
	llenaelementoHTML(".place_buzon"  , data);										
	$(".pregunta").click(carga_respuestas);		
}
/**/
function carga_respuestas(){	

	var id_pregunta 		=  	parseInt(get_attr(this, "id"));	
	var pregunta 			=  	get_attr(this, "pregunta");		
	var registro 			=  	get_attr(this, "registro");		
	var nombre_servicio 	= 	get_attr(this, "nombre_servicio");
	var usuario_pregunta	=  	get_attr(this, "usuario");		
	var servicio 			= 	get_attr(this, "servicio");			
	if( id_pregunta > 0 ){
		
		set_option("pregunta" , id_pregunta);		
		var data_send = {"id_pregunta":id_pregunta , "pregunta" : pregunta, "registro" : registro , "usuario_pregunta" : usuario_pregunta , "modalidad" : get_option("modalidad_ventas") , "nombre_servicio":nombre_servicio , "id_servicio" :servicio}		
		set_option("data_pregunta" , data_send);		
		carga_respuesta_complete();		
	}
	
}
/**/
function carga_respuesta_complete(){		

	var data_send	 	=  get_option("data_pregunta");
	console.log(data_send);
	var url 			=  "../q/index.php/api/respuesta/respuesta_pregunta/format/json/";		
	request_enid( "GET",  data_send, url, response_respuesta_complete,".place_buzon" );
}
/**/
function response_respuesta_complete(data){

	$(".contenedor_opciones_buzon").hide();
	llenaelementoHTML(".place_buzon" , data);
	$(".form_valoracion_pregunta").submit(enviar_respuesta);
	carga_num_preguntas();
}
/**/
function enviar_respuesta(e){
	
	var data_send 	=  $(".form_valoracion_pregunta").serialize()+"&"+$.param({"pregunta" : get_option("pregunta") , "modalidad" : get_option("modalidad_ventas")});				
	var url 		=  "../q/index.php/api/respuesta/respuesta_pregunta/format/json/";			
	request_enid( "POST",  data_send, url, carga_respuesta_complete); 
	e.preventDefault();
}