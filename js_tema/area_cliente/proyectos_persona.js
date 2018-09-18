function get_lugar_por_stus_compra(){	

	var nuevo_place ="";	
	if(get_option("modalidad_ventas") == 0){		
		/**/
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
/**/
function carga_compras_usuario(){
	
	var modalidad 	=  get_option("modalidad_ventas");  	
	var url 		=  "../q/index.php/api/recibo/proyecto_persona_info/format/json/";		
	var data_send 	=  { "status": get_option("estado_compra") , "modalidad" : modalidad };				
	request_enid( "GET",  data_send, url, response_carga_compras_usuario);
}
/**/
function response_carga_compras_usuario(data){
	
	
	var place 	= get_lugar_por_stus_compra(); 	
	llenaelementoHTML(place  , data);								
	$(".solicitar_desarrollo").click(function(e){
		
		var id_proyecto 	=  e.target.id;	
		set_option("id_proyecto" , id_proyecto);
		carga_tikets_usuario_servicio();
	});				
	$(".form_q_servicios").submit();		
	$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);
	$(".btn_direccion_envio").click(carga_informacion_envio);
	$(".ver_mas_compras_o_ventas").click(carga_compras_o_ventas_concluidas);
	carga_num_preguntas();
	

}
/**/
function carga_informacion_envio(e){
	
	var id_recibo =  e.target.id;	
	set_option("recibo" , id_recibo);
	debugger;
	carga_informacion_envio_complete();
}
function carga_compras_o_ventas_concluidas(){	

	var modalidad 	=  	get_option("modalidad_ventas"); 
	var page 		= 	get_option("page");	
	var url 		=  	"../q/index.php/api/recibo/compras_efectivas/format/json/";		
	var data_send 	=  	{"modalidad" : modalidad, "page" : page };				
	request_enid( "GET",  data_send, url, reponse_carga_compras_o_ventas_concluidas);
}
/**/
function reponse_carga_compras_o_ventas_concluidas(data){


	var place 		= get_lugar_por_stus_compra();  		
	llenaelementoHTML(place  , data);								
	$(".pagination > li > a, .pagination > li > span").css("color" , "white");	
	$(".pagination > li > a, .pagination > li > span").click(function(e){				
		set_option("page", $(this).text());
		carga_compras_o_ventas_concluidas();
		e.preventDefault();				
	});
	recorrepage(place);

}