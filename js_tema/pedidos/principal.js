$(document).ready(function(){
	display_elements([".selector_estados_ventas" , ".form_cantidad", ".form_cantidad_post_venta"] , 0);
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();						
	$(".form_busqueda_pedidos").submit(busqueda_pedidos);
	$(".editar_estado").click(cambio_estado);
	$(".status_venta").change(modidica_estado);
	$(".form_cantidad").submit(registra_saldo_cubierto);
	$(".saldo_cubierto").keyup();
	
	$(".saldo_cubierto_pos_venta").keyup(function(e) {
  
    var code = (e.keyCode ? e.keyCode : e.which);
	    if (code==13) {
	    	
	    	modifica_status(get_valor_selected(".status_venta"));
	    }
    
	});


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
	$('th').click(ordena_table_general);
	$(".desglose_orden").click(function(){		
		var recibo  =  	get_parameter_enid($(this) , "id");
		$(".numero_recibo").val(recibo);

		$(".form_search").submit();
	});
	
}
var cambio_estado = function(){
	
	var recibo  =  	get_parameter_enid($(this) , "id");	
	$(".selector_estados_ventas").show();	
}
var modidica_estado = function(){

	var status_venta 	= parseInt(get_valor_selected(".status_venta"));	
	$(".form_cantidad").hide();
	switch(status_venta) {
	    case 0:
	        
	        break;
	    case 1:
	        $(".form_cantidad").show();
	        break;
	    case 7:
	        modifica_status(status_venta);
	        break;

	    default:
	    break;
	        
	}
}
var modifica_status = function(status_venta){

	var saldo_cubierto =  get_parameter(".saldo_actual_cubierto");
	if (saldo_cubierto 	> 0 ||  get_parameter(".saldo_cubierto_pos_venta") > 0 ) {
		
		var data_send	=  $.param({"recibo" : get_parameter(".recibo") , "status":status_venta , "saldo_cubierto":get_parameter(".saldo_cubierto_pos_venta")});		
		var  url 		= "../q/index.php/api/recibo/status/format/json/";		
		request_enid( "PUT",  data_send, url, response_status_venta)	

	}else{

		$(".form_cantidad_post_venta").show();

	}
}

var registra_saldo_cubierto = function(e){

	var is_num =  valida_num_form(".saldo_cubierto" , ".mensaje_saldo_cubierto" );

	if (is_num == 1) {
		var data_send	=  $(".form_cantidad").serialize();
		$(".mensaje_saldo_cubierto").empty();
		var  url 		= "../q/index.php/api/recibo/saldo_cubierto/format/json/";
		bloquea_form(".form_cantidad");
		request_enid( "PUT",  data_send, url, response_saldo_cubierto)	

	}
	e.preventDefault();
}
var response_saldo_cubierto = function(data){
	
	if (data ==  true) {
		
		var url = "../pedidos/?recibo="+get_parameter(".recibo");
		redirect(url);

	}else{

		desbloqueda_form(".form_cantidad");
		llenaelementoHTML(".mensaje_saldo_cubierto", data);
	}	
}
var response_status_venta = function(data){
	
	if (data ==  true) {
		
		var url = "../pedidos/?recibo="+get_parameter(".recibo");
		redirect(url);

	}else{
		
		llenaelementoHTML(".mensaje_saldo_cubierto_post_venta", data);
	}	
}
