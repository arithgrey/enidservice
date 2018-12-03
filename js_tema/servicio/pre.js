$(document).ready(function(){	
	set_option("flag_carga" , 0);
});
var carga_opcion_entrega = function(id , id_servicio ,  orden_pedido ){

	
	if (get_option("flag_carga") == 0 ) {

		set_option("id_servicio" , id_servicio);
		set_option("tipo" , id);
		set_option("orden_pedido" , orden_pedido);
		var data_send  = $.param({"tipo" : id , "id_servicio" : id_servicio});
		var url 	   = "../q/index.php/api/intento_tipo_entrega/index/format/json/";
		request_enid( "POST",  data_send, url, response_opcion_entrega);
	}
}

var response_opcion_entrega = function(data){
	
	
	set_option("flag_carga" , 1);
	var id_servicio = 	get_option("id_servicio");
	var url 		=	"";

	
	
	if (get_option("orden_pedido") == 1 ) {
		
		switch(get_option("tipo")) {
		    case 1:	    	
		    	
		    	$(".form_pre_puntos_medios").submit();	        				    	
		        break;

		    case 2:

		    	$(".form_pre_pedido").submit();	         			
		        break;

		    case 3:
		        
		        $(".form_pre_pedido_contact").submit();	  	   
		        break;
		        
		    default:        
		} 

	}else{
		/*Indicar el tipo de entrega al pedido*/
		switch(get_option("tipo")) {
		    case 1:	    	
				
		    	$(".form_pre_puntos_medios").submit();	        				    	
		        break;

		    case 2:
		    	//alert($(".form_orden_direccion").serialize());
		    	$(".form_orden_direccion").submit();	         			
		        break;
		       
		    default:        
		} 
	}

}
