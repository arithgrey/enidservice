$(document).ready(function(){
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();					
	
	$(".form_busqueda_pedidos").submit(busqueda_pedidos);
});
var busqueda_pedidos =  function(e){
	
	var fecha_inicio 	=  get_parameter("#datetimepicker4");  
	var fecha_termino 	=  get_parameter("#datetimepicker5");  			
	if (fecha_inicio.length > 8 && fecha_termino.length > 8 ) {
		
		var data_send 		=  $(".form_busqueda_pedidos").serialize();
		var url 			=  "../q/index.php/api/recibo/pedidos/format/json/";  
		request_enid( "GET",  data_send, url, response_pedidos, ".place_pedidos");
			
	}
	e.preventDefault();
}
var response_pedidos =  function(data){	

	llenaelementoHTML(".place_pedidos" ,data );
	
}
