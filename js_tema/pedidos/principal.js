$(document).ready(function(){
	display_elements([".selector_estados_ventas" , ".form_cantidad", ".form_cantidad_post_venta"] , 0);
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();						
	$(".form_busqueda_pedidos").submit(busqueda_pedidos);
	$(".editar_estado").click(cambio_estado);
	$(".editar_tipo_entrega").click(pre_tipo_entrega);
	$(".status_venta").change(modidica_estado);
	$(".form_cantidad").submit(registra_saldo_cubierto);
	$(".saldo_cubierto").keyup();	
	$(".saldo_cubierto_pos_venta").keyup(function(e) {
  
    var code = (e.keyCode ? e.keyCode : e.which);
	    if (code==13) {	    	
	    	modifica_status(get_valor_selected(".status_venta"));
	    }
    
	});

	$(".form_edicion_tipo_entrega").change(cambio_tipo_entrega);


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
};
var response_pedidos =  function(data){	

	llenaelementoHTML(".place_pedidos" ,data );
	$('th').click(ordena_table_general);
	$(".desglose_orden").click(function(){		
		var recibo  =  	get_parameter_enid($(this) , "id");
		$(".numero_recibo").val(recibo);

		$(".form_search").submit();
	});
	
};
var cambio_estado = function(){
	
	var recibo  =  	get_parameter_enid($(this) , "id");	
	$(".selector_estados_ventas").show();		
	var  status_venta_actual =  get_parameter(".status_venta_registro");
	selecciona_valor_select(".selector_estados_ventas .status_venta" ,  status_venta_actual);
	var status_venta_registro = parseInt(get_parameter(".status_venta_registro"));
	

	$(".status_venta_registro option[value='"+status_venta_registro+"']").attr("disabled", "disabled");
	

};
var modidica_estado = function(){


	if(get_parameter(".status_venta_registro") != 9){

		guarda_nuevo_estado();
		
	}else{
		var text = "ESTE PEDIDO YA FUÉ NOTIFICADO COMO ENTREGADO, ¿AÚN ASÍ DESEAS MODIFICAR SU ESTADO?";
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
};
var guarda_nuevo_estado = function(){
	var status_venta 			= parseInt(get_valor_selected(".selector_estados_ventas .status_venta"));		
	var status_venta_registro	= parseInt(get_parameter(".status_venta_registro"));		
	
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
};
var modifica_status = function(status_venta , es_proceso_compra_sin_filtro = 0){


	var saldo_cubierto  =  get_parameter(".saldo_actual_cubierto");

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
};

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
};
var response_saldo_cubierto = function(data){
	
	if (data ==  true) {
		
		var url = "../pedidos/?recibo="+get_parameter(".recibo");
		redirect(url);

	}else{

		desbloqueda_form(".form_cantidad");
		$(".mensaje_saldo_cubierto").show();
		llenaelementoHTML(".mensaje_saldo_cubierto", data);
	}	
};
var response_status_venta = function(data){


	desbloqueda_form(".selector_estados_ventas");
	if (data ==  true) {		

		var url = "../pedidos/?recibo="+get_parameter(".recibo");
		redirect(url);

	}else{
		
		llenaelementoHTML(".mensaje_saldo_cubierto_post_venta", data);
	}

};
var pre_cancelacion = function(){
		
	var tipo 		=	0;	
	switch(parseInt( get_parameter(".tipo_entrega_def"))) {
		
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

	var data_send 	= {"v":1 , tipo: tipo , "text":"MOTIVO DE CANCELACIÓN" };
	var url 		= "../q/index.php/api/tipificacion/index/format/json/";	
	request_enid( "GET",  data_send, url, response_pre_cancelacion)		

};
var response_pre_cancelacion = function(data){

	llenaelementoHTML(".place_tipificaciones" , data);
	$(".tipificacion").change(registra_motivo_cancelacion);
};
var registra_motivo_cancelacion  = function(){
	
	var status_venta 	= 	get_valor_selected(".status_venta");
	var tipificacion 	=  	get_valor_selected(".tipificacion");  
	var data_send		=  	$.param({"recibo" : get_parameter(".recibo") , "status":status_venta , "tipificacion": tipificacion , "cancelacion":1});		
	var url 			= 	"../q/index.php/api/recibo/status/format/json/";		
	bloquea_form(".selector_estados_ventas");
	request_enid( "PUT",  data_send, url, response_status_venta);	
};
var cambio_tipo_entrega = function(){

	var tipo_entrega 			=  get_valor_selected(".form_edicion_tipo_entrega .tipo_entrega");
	var tipo_entrega_actual 	=  get_parameter(".tipo_entrega_def");
	

	
	if (tipo_entrega > 0 && tipo_entrega != tipo_entrega_actual) {
		var text 	= "¿REALMENTE DESEAS MODIFICAR EL TIPO DE ENTREGA?";
		var mensaje = "ACTUAL: " + get_parameter(".text_tipo_entrega");
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

};
var set_tipo_entrega = function(tipo_entrega , tipo_entrega_actual){
	
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

};
var registra_tipo_entrega = function(tipo_entrega, recibo){

	var text_tipo_entrega=  get_parameter(".text_tipo_entrega"); 
	var data_send = {"tipo_entrega" : tipo_entrega ,  recibo: recibo , text_tipo_entrega:text_tipo_entrega};
	var url 	  = "../q/index.php/api/recibo/tipo_entrega/format/json/";  
	request_enid( "PUT",  data_send, url, response_tipo_entrega);
};
var response_tipo_entrega = function(data){
	var url = "../pedidos/?recibo="+get_parameter(".recibo");
	redirect(url);
};
var pre_tipo_entrega = function(){
	$(".form_edicion_tipo_entrega").show();	
	var tipo_entrega_actual 	=  get_parameter(".tipo_entrega_def");
	selecciona_valor_select(".form_edicion_tipo_entrega .tipo_entrega" ,  tipo_entrega_actual);
};
var verifica_pago_previo = function(){
	var saldo_cubierto =  get_parameter(".saldo_actual_cubierto");	
	if (saldo_cubierto > 0 ) {
		var text 		     =  "ESTA ORDEN  CUENTA CON UN SALDO REGISTRADO DE "+saldo_cubierto+"MXN ¿AUN ASÍ DESEAS NOTIFICAR SU FALTA DE PAGO?";		
		var text_complemento =  "EL SALDO DE LA ORDEN PASARÁ A 0 MXN AL REALIZAR ESTA ACCIÓN";
		var text_continuar	 = 	"DEJAR EN 0MXN";
		show_confirm(text ,  text_complemento , text_continuar, procesa_cambio_estado, oculta_opciones_estados );
	}else{
		modifica_status(6 , 1);
	}
};
var oculta_opciones_estados =  function(){
	display_elements([".selector_estados_ventas" , 0]);
};
var procesa_cambio_estado = function(){
	set_option("es_proceso_compra" , 1);
	modifica_status(6 , 1);	
};
var registra_data_nuevo_estado = function(status_venta){

	bloquea_form(".selector_estados_ventas");
	var data_send	=  $.param({"recibo" : get_parameter(".recibo") , "status":status_venta , "saldo_cubierto":get_parameter(".saldo_cubierto_pos_venta") , "es_proceso_compra" : get_option("es_proceso_compra")});		
	set_option("es_proceso_compra" , 0);
	var  url 		= "../q/index.php/api/recibo/status/format/json/";		
	request_enid( "PUT",  data_send, url, response_status_venta)	
};