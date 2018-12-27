function cargar_ultimos_movimientos(){
	var data_send 	= {}
	var url 		=  "../q/index.php/api/tickets/movimientos_usuario/format/json/";
	request_enid( "GET",  data_send, url, 1, ".place_movimientos" , 0 , ".place_movimientos");
}