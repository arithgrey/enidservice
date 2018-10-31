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
	    	var url = "../producto/?producto="+id_servicio+"&proceso=1";
	    	   
	        break;
	    case 2:
	        var url = "../contact/?producto="+id_servicio+"&proceso=1";
	    	
	        break;
	    case 3:
	        
	        break;
	    default:
        
	} 

	redirect(url); 
}
