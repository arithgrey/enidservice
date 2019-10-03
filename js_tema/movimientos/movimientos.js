let cargar_ultimos_movimientos = () =>{
	let data_send 	= 	$.param({q:1});
	let url 		=  	"../q/index.php/api/tickets/movimientos_usuario/format/json/";
	request_enid( "GET",  data_send, url, 1, ".place_movimientos" , 0 , ".place_movimientos");
};