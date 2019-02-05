"use strict";
$(document).ready(function(){
	display_elements([".selector_estados_ventas" , ".form_cantidad", ".form_cantidad_post_venta"] , 0);
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();						
	$(".form_busqueda_pedidos").submit(busqueda_pedidos);
	$(".form_fecha_entrega").submit(editar_horario_entrega);
	$(".form_fecha_recordatorio").submit(crea_recordatorio);
	$(".editar_estado").click(cambio_estado);
	$(".editar_tipo_entrega").click(pre_tipo_entrega);
	$(".status_venta").change(modidica_estado);
	$(".form_cantidad").submit(registra_saldo_cubierto);

	$(".saldo_cubierto_pos_venta").keyup(function(e) {
    	let code = (e.keyCode ? e.keyCode : e.which);
	    if (code==13) {	    	
	    	modifica_status(get_valor_selected(".status_venta"));
	    }
	});
	$(".form_edicion_tipo_entrega").change(cambio_tipo_entrega);
	$(".form_notas").submit(registrar_nota);

});
let editar_horario_entrega = function(e){

	let data_send 		=  $(".form_fecha_entrega").serialize();
	let url 			=  "../q/index.php/api/recibo/fecha_entrega/format/json/";
	bloquea_form(".form_fecha_entrega");
	request_enid( "PUT",  data_send, url, response_horario_entrega , ".place_fecha_entrega");
	e.preventDefault();
}
let crea_recordatorio = function(e){

	let data_send 		=  $(".form_fecha_recordatorio").serialize();
	let url 			=  "../q/index.php/api/recordatorio/index/format/json/";
	bloquea_form(".form_fecha_recordatorio");
	request_enid( "POST",  data_send, url, response_recordatorio , ".place_recordatorio");
	e.preventDefault();
}
let response_recordatorio = function(data){

	if(data ==  true){
		$(".place_recordatorio").empty();
		let url = "../pedidos/?recibo="+get_parameter(".recibo");
		redirect(url);
	}else{
		desbloqueda_form(".form_fecha_recordatorio");
	}
}
let response_horario_entrega = function(data){

	$(".place_fecha_entrega").empty();
	let url = "../pedidos/?recibo="+get_parameter(".recibo");
	desbloqueda_form(".form_fecha_entrega");
	redirect(url);

}
let busqueda_pedidos =  function(e){
	
	let fecha_inicio 	=  get_parameter("#datetimepicker4");  
	let fecha_termino 	=  get_parameter("#datetimepicker5");  			
	if (fecha_inicio.length > 8 && fecha_termino.length > 8 ) {
		
		let data_send 		=  $(".form_busqueda_pedidos").serialize();
		let url 			=  "../q/index.php/api/recibo/pedidos/format/json/";  
		request_enid( "GET",  data_send, url, response_pedidos, ".place_pedidos");

	}
	e.preventDefault();
}
let response_pedidos =  function(data){	

	llenaelementoHTML(".place_pedidos" , data );
	$('th').click(ordena_table_general);
	$(".desglose_orden").click(function(){		
		let recibo  =  	get_parameter_enid($(this) , "id");
		$(".numero_recibo").val(recibo);
		$(".form_search").submit();
	});
	
}
let cambio_estado = function(){
	
	let recibo  =  	get_parameter_enid($(this) , "id");	
	$(".selector_estados_ventas").show();		
	let  status_venta_actual =  get_parameter(".status_venta_registro");
	selecciona_valor_select(".selector_estados_ventas .status_venta" ,  status_venta_actual);
	let status_venta_registro = parseInt(get_parameter(".status_venta_registro"));
	$(".status_venta_registro option[value='"+status_venta_registro+"']").attr("disabled", "disabled");

}
let modidica_estado = function(){


	if(get_parameter(".status_venta_registro") != 9){

		guarda_nuevo_estado();
		
	}else{
		let text = "ESTE PEDIDO YA FUÉ NOTIFICADO COMO ENTREGADO, ¿AÚN ASÍ DESEAS MODIFICAR SU ESTADO?";
		$.confirm({
		    title: text,
		    content: '',
		    type: 'green',
		    buttons: {   
		        ok: {
		            text: "CONTINUAR Y MODIFICAR",
		            btnClass: 'btn-primary',
		            keys: ['enter'],
		            action: function(){
		                guarda_nuevo_estado();
		            }
		        },
		        cancel: function(){
		            $(".selector_estados_ventas").hide();	
		        }
		    }
		});
	} 
}
let guarda_nuevo_estado = function(){
	let status_venta 			= parseInt(get_valor_selected(".selector_estados_ventas .status_venta"));		
	let status_venta_registro	= parseInt(get_parameter(".status_venta_registro"));		
	
	if (status_venta != status_venta_registro ) {
		$(".form_cantidad").hide();
		$(".place_tipificaciones").empty();
		switch(status_venta) {
		    case 0:		        
		        break;
		    case 1:
		        $(".form_cantidad").show();
		        break;

		    case 6:
		        /*Cuando no ha registrado algún pago*/
		        verifica_pago_previo();
		        break;

		    case 7:
		        modifica_status(status_venta);
		        break;
		    case 9:
		        modifica_status(status_venta);
		        break;
		    case 10:
		        pre_cancelacion();
		        break;
		    case 11:
		        modifica_status(status_venta);
		        break;
		    default:
		    break;	
		}
	}       
}
let modifica_status = function(status_venta , es_proceso_compra_sin_filtro = 0){

	debugger;
	let saldo_cubierto  =  get_parameter(".saldo_actual_cubierto");

	if (es_proceso_compra_sin_filtro == 0) {

		if (saldo_cubierto 	> 0 ||  get_parameter(".saldo_cubierto_pos_venta") > 0 ) {
			
			registra_data_nuevo_estado(status_venta);
		}else{

			$(".form_cantidad_post_venta").show();
		}

	}else{
		set_option("es_proceso_compra"  , 1);
		registra_data_nuevo_estado(status_venta);
	}
}
let registra_saldo_cubierto = function(e){

	if (valida_num_form(".saldo_cubierto" , ".mensaje_saldo_cubierto" ) == 1) {

		let data_send	=  $(".form_cantidad").serialize();
		$(".mensaje_saldo_cubierto").empty();
		let  url 		= "../q/index.php/api/recibo/saldo_cubierto/format/json/";
		bloquea_form(".form_cantidad");
		request_enid( "PUT",  data_send, url, response_saldo_cubierto)	

	}
	e.preventDefault();
}
let response_saldo_cubierto = function(data){

	debugger;
	if (data ==  true) {

		let status_venta 	= 	get_valor_selected(".status_venta");
		//alert(status_venta);
		if(status_venta == 6 || status_venta == 9 ){
			next_status();
		}else{
			show_confirm("¿QUIERES DESCONTAR LOS ARTICULOS DEL STOCK?" ,  "" , 0 , descontar_articulos_stock, next_status );
		}


	}else{

		desbloqueda_form(".form_cantidad");
		$(".mensaje_saldo_cubierto").show();
		llenaelementoHTML(".mensaje_saldo_cubierto", data);
	}	
}
let next_status = function(){

	let url = "../pedidos/?recibo="+get_parameter(".recibo");
	redirect(url);
}
let descontar_articulos_stock =  function(){

	let id_servicio = 	 	get_parameter(".id_servicio");
	let stock 		= 	 	get_parameter(".articulos");
	let data_send 	=		$.param({"id_servicio" : id_servicio,  "stock" : stock , "compra" : 1});
	let  url 		= 		"../q/index.php/api/servicio/stock/format/json/";
	request_enid( "PUT",  data_send, url, response_articulos_stock);

}
let response_articulos_stock = function(data){
	let url = "../pedidos/?recibo="+get_parameter(".recibo");
	redirect(url);
}
let response_status_venta = function(data){


	desbloqueda_form(".selector_estados_ventas");
	if (data ==  true) {

		show_confirm("¿QUIERES DESCONTAR LOS ARTICULOS DEL STOCK?" ,  "" , 0 , descontar_articulos_stock, next_status );

	}else{
		
		llenaelementoHTML(".mensaje_saldo_cubierto_post_venta", data);
	}

}
let pre_cancelacion = function(){
		
	let tipo 		=	0;	
	switch(parseInt( get_parameter(".tipo_entrega_def")) ) {
		
		/*opciones en punto de encuentro*/
	    case 1:
	        tipo = 2;
	        break;
	    /*opciones en mensajeria por  enid*/	   
	    case 2:
	        tipo = 4;

	        break;
	    /*Visita en el negocio*/
	    case 3:

	        tipo = 6;
	        break;
	    /*opciones en mensajeria por  mercado libre*/	   	    
	    case 4:
			tipo = 5;	        
	        break;	    

	    default:
	    break;
	        
	}

	let data_send 	= {"v":1 , tipo: tipo , "text":"MOTIVO DE CANCELACIÓN" };
	let url 		= "../q/index.php/api/tipificacion/index/format/json/";	
	request_enid( "GET",  data_send, url, response_pre_cancelacion)		

}
let response_pre_cancelacion = function(data){

	llenaelementoHTML(".place_tipificaciones" , data);
	$(".tipificacion").change(registra_motivo_cancelacion);
}
let registra_motivo_cancelacion  = function(){
	
	let status_venta 	= 	get_valor_selected(".status_venta");
	let tipificacion 	=  	get_valor_selected(".tipificacion");  
	let data_send		=  	$.param({"recibo" : get_parameter(".recibo") , "status":status_venta , "tipificacion": tipificacion , "cancelacion":1});		
	let url 			= 	"../q/index.php/api/recibo/status/format/json/";		
	bloquea_form(".selector_estados_ventas");
	request_enid( "PUT",  data_send, url, response_status_venta);	
}
let cambio_tipo_entrega = function(){

	let tipo_entrega 			=  get_valor_selected(".form_edicion_tipo_entrega .tipo_entrega");
	let tipo_entrega_actual 	=  get_parameter(".tipo_entrega_def");
	
	if (tipo_entrega > 0 && tipo_entrega != tipo_entrega_actual) {
		let text 	= "¿REALMENTE DESEAS MODIFICAR EL TIPO DE ENTREGA?";
		let mensaje = "ACTUAL: " + get_parameter(".text_tipo_entrega");
		$.confirm({
			    title: text,
			    content: mensaje,
			    type: 'green',
			    buttons: {   
			        ok: {
			            text: "CONTINUAR",
			            btnClass: 'btn-primary',
			            keys: ['enter'],
			            action: function(){
			                set_tipo_entrega(tipo_entrega , tipo_entrega_actual);
			            }
			        },
			        cancel: function(){
			            
			        }
			    }
		});		
		
	}

}
let set_tipo_entrega = function(tipo_entrega , tipo_entrega_actual){
	
	if (tipo_entrega != tipo_entrega_actual) {
		switch(tipo_entrega) {
			
			/*opciones en punto de encuentro*/
		    case 1:
		       	 
		        break;
		    /*opciones en mensajeria por  enid*/	   
		    case 2:

		        break;
		    /*VISITA EN NEGOCIO*/
		    case 3:
		        
		        break;
		    /*opciones en mensajeria por  mercado libre*/	   	    
		    case 4:
				
		        break;	    

		    default:

		    break;
		        
		}
		registra_tipo_entrega(tipo_entrega, get_parameter(".recibo"));
	}

}
let registra_tipo_entrega = function(tipo_entrega, recibo){

	let text_tipo_entrega=  get_parameter(".text_tipo_entrega"); 
	let data_send = {"tipo_entrega" : tipo_entrega ,  recibo: recibo , text_tipo_entrega:text_tipo_entrega};
	let url 	  = "../q/index.php/api/recibo/tipo_entrega/format/json/";  
	request_enid( "PUT",  data_send, url, response_tipo_entrega);
}
let response_tipo_entrega = function(data){
	let url = "../pedidos/?recibo="+get_parameter(".recibo");
	redirect(url);
}
let pre_tipo_entrega = function(){
	$(".form_edicion_tipo_entrega").show();	
	let tipo_entrega_actual 	=  get_parameter(".tipo_entrega_def");
	selecciona_valor_select(".form_edicion_tipo_entrega .tipo_entrega" ,  tipo_entrega_actual);
}
let verifica_pago_previo = function(){
	let saldo_cubierto =  get_parameter(".saldo_actual_cubierto");	
	if (saldo_cubierto > 0 ) {
		let text 		     =  "ESTA ORDEN  CUENTA CON UN SALDO REGISTRADO DE "+saldo_cubierto+"MXN ¿AUN ASÍ DESEAS NOTIFICAR SU FALTA DE PAGO?";		
		let text_complemento =  "EL SALDO DE LA ORDEN PASARÁ A 0 MXN AL REALIZAR ESTA ACCIÓN";
		let text_continuar	 = 	"DEJAR EN 0MXN";
		show_confirm(text ,  text_complemento , text_continuar, procesa_cambio_estado, oculta_opciones_estados );
	}else{
		modifica_status(6 , 1);
	}
}
let oculta_opciones_estados =  function(){
	display_elements([".selector_estados_ventas" , 0]);
}
let procesa_cambio_estado = function(){
	set_option("es_proceso_compra" , 1);
	modifica_status(6 , 1);	
}
let registra_data_nuevo_estado = function(status_venta){

	bloquea_form(".selector_estados_ventas");
	let data_send	=  $.param({"recibo" : get_parameter(".recibo") , "status":status_venta , "saldo_cubierto":get_parameter(".saldo_cubierto_pos_venta") , "es_proceso_compra" : get_option("es_proceso_compra")});		
	set_option("es_proceso_compra" , 0);
	let  url 		= "../q/index.php/api/recibo/status/format/json/";		
	request_enid( "PUT",  data_send, url, response_status_venta)	
}
let confirma_cambio_horario = function(id_recibo , status  , saldo_cubierto_envio , monto_a_pagar , se_cancela , fecha_entrega){

	debugger;
	let text = "¿DESEAS EDITAR EL HORARIO DE ENTREGA DEL PEDIDO?";
	let text_confirmacion = "";
	switch(parseInt(status)) {
		case 9:
			text = "LA ORDEN YA FUÉ ENTREGADA!";
			text_confirmacion = "¿EDITAR HORARIO DE ENTREGA AÚN ASÍ?";

			break;
		case 10:
			text = "LA ORDEN FUÉ CANCELADA!";
			text_confirmacion = "¿EDITAR HORARIO DE ENTREGA AÚN ASÍ?";
			break;

		default:
			text = "¿DESEAS EDITAR EL HORARIO DE ENTREGA DEL PEDIDO?";
			text_confirmacion = "";
			break;
	}

	show_confirm(text ,  text_confirmacion , "SI" , function(){
		let url =  "../pedidos/?recibo="+id_recibo+"&fecha_entrega=1";
		redirect(url);
	});


}
let agregar_nota = function(){
	showonehideone(".form_notas", ".agregar_comentario");
	recorrepage(".form_nota");
}
let registrar_nota = function(e){

	debugger;
	let url 		=  "../q/index.php/api/recibo_comentario/index/format/json/";
	let comentario 	=  	get_parameter(".comentarios");
	let texto  		= 	comentario.trim().length;
	if( texto > 10 ){

		let data_send 	=  $(".form_notas").serialize();
		request_enid( "POST",  data_send, url, response_registro_nota , ".place_nota");

	}else{

		format_error( ".place_nota", "comentario muy corto");

	}

	e.preventDefault();
}
let response_registro_nota = function(data){
	$(".place_nota").empty();
	redirect("");
	debugger;
}
let modifica_status_recordatorio = function(id_recordatorio , status){
	if(id_recordatorio > 0){

		let url 		=  	"../q/index.php/api/recordatorio/status/format/json/";
		let data_send 	= 	{id_recordatorio:id_recordatorio  , status:status};
		request_enid( "PUT",  data_send, url);
	}
}