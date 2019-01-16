"use strict";
function num_accesos_afiliados(){
	
	var url =  "../q/index.php/api/productividad/accesos_afiliados/format/json/";		
	var data_send =  {};				
	request_enid( "GET",  data_send, url, response_num_accesos);
}
/**/
function response_num_accesos(data){
	llenaelementoHTML(".num_visitas" , data.num_accesos);
	llenaelementoHTML(".num_contactos" , data.num_contactos);		
	llenaelementoHTML(".num_efectivo" , data.num_efectivo);	
	llenaelementoHTML(".num_ventas_por_recomendacion" , data.num_ventas_por_recomendacion);	
}
/**/