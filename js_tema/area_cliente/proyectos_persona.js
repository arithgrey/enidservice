"use strict";
let get_lugar_por_stus_compra= function(){

	let nuevo_place ="";	
	if(get_option("modalidad_ventas") == 0){		

		switch(parseFloat(get_option("estado_compra"))){
			case 10:
		        nuevo_place = ".place_resumen_servicio";	        
		        break;
		    case 6:
		        nuevo_place = ".place_servicios_contratados";	        
		        break;
		    case 1:	    	
		        nuevo_place = ".place_servicios_contratados_y_pagados";
		        break;
		    default:  
		    	nuevo_place = ".place_servicios_contratados";	             
		    	break;
		} 	
	}else{
		nuevo_place = ".place_ventas_usuario";
	}
	return nuevo_place;
}
let carga_compras_usuario = function(){

	recorrepage();
	let modalidad 	=  get_option("modalidad_ventas");
	let url 		=  "../q/index.php/api/recibo/proyecto_persona_info/format/json/";		
	let data_send 	=  { "status": get_option("estado_compra") , "modalidad" : modalidad };
	request_enid( "GET",  data_send, url, response_carga_compras_usuario);

}
let response_carga_compras_usuario = function(data){
	
	let place 	= get_lugar_por_stus_compra(); 	
	llenaelementoHTML(place  , data);								
	$(".solicitar_desarrollo").click(function(e){
		
		let id_proyecto 	=  get_parameter_enid($(this) , "id");	
		set_option("id_proyecto" , id_proyecto);
		carga_tikets_usuario_servicio();
	});				
	$(".form_q_servicios").submit();		
	$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);
	$(".btn_direccion_envio").click(carga_informacion_envio);
	$(".ver_mas_compras_o_ventas").click(carga_compras_o_ventas_concluidas);
	carga_num_preguntas();
}
let carga_informacion_envio = function(e){
	
	let id_recibo =  get_parameter_enid($(this) , "id");	
	set_option("recibo" , id_recibo);	
	carga_informacion_envio_complete();
}
let carga_compras_o_ventas_concluidas = function(){

	let modalidad 	=  	get_option("modalidad_ventas"); 
	let page 		= 	get_option("page");	
	let url 		=  	"../q/index.php/api/recibo/compras_efectivas/format/json/";		
	let data_send 	=  	{"modalidad" : modalidad, "page" : page };				
	request_enid( "GET",  data_send, url, reponse_carga_compras_o_ventas_concluidas);
}
let reponse_carga_compras_o_ventas_concluidas = function(data){


	let place 		= get_lugar_por_stus_compra();  		
	llenaelementoHTML(place  , data);
	$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);
	$(".pagination > li > a, .pagination > li > span").css("color" , "white");	
	$(".pagination > li > a, .pagination > li > span").click(function(e){				
		set_option("page", $(this).text());
		carga_compras_o_ventas_concluidas();
		e.preventDefault();				
	});
	recorrepage(place);

}