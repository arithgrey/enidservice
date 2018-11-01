$(document).ready(function(){	
	set_option("flag_carga" , 0);
});
var carga_opcion_entrega = function(id , id_servicio){

	if (get_option("flag_carga") == 0 ) {
		set_option("id_servicio" , id_servicio);
		set_option("tipo" , id);
		var data_send  = $.param({"tipo" : id , "id_servicio" : id_servicio});
		var url 	   = "../q/index.php/api/servicio/tipo_entrega/format/json/";
		request_enid( "PUT",  data_send, url, response_opcion_entrega);
	}
}

var response_opcion_entrega = function(data){
	set_option("flag_carga" , 1);
	var id_servicio = 	get_option("id_servicio");
	var url 		=	"";
	switch(get_option("tipo")) {
	    case 1:

	    
	    var plan 				= get_parameter(".plan");
		var extension_dominio 	= get_parameter(".extension_dominio");
		var ciclo_facturacion 	= get_parameter(".ciclo_facturacion");
		var is_servicio 		= get_parameter(".is_servicio");
		var q2 					= get_parameter(".q2");
		var num_ciclos 			= get_parameter(".num_ciclos");
	    
	    var url = "../procesar/?plan="+id_servicio+"&extension_dominio="+extension_dominio+"&ciclo_facturacion="+ciclo_facturacion+"&is_servicio="+is_servicio+"&q2="+q2+"&num_ciclos="+num_ciclos;
	    	   
	        break;
	    case 2:
	        var url = "../contact/?plan="+id_servicio+"&proceso=1";
	    	
	        break;
	    case 3:
	        
	        break;
	    default:
        
	} 

	redirect(url); 
}
