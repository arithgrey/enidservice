/**/
function cargar_info_resumen_pago_pendiente(e){	
	/**/
	id_recibo =  e.target.id;		
	set_option("id_recibo" ,  id_recibo);	
	url =  "../pagos/index.php/api/cobranza/resumen_desglose_pago/format/json/";	
	data_send =  {"id_recibo" : get_option("id_recibo") , "cobranza" : 1};					
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_resumen_servicio" , "Cargando ... ", 1 );
			}
	}).done(function(data){																									
		llenaelementoHTML(".place_resumen_servicio" , data);		
		$(".cancelar_compra").click(confirmar_cancelacion_compra);
	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}
/**/
function confirmar_cancelacion_compra(e){
	id_recibo =  e.target.id; 
	set_option(id_recibo);
	url =  "../pagos/index.php/api/tickets/cancelar_form/format/json/";	
	data_send =  {"id_recibo" : get_option("id_recibo")};					
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_resumen_servicio" , "Cargando ... ", 1 );
			}
	}).done(function(data){	
		
		llenaelementoHTML(".place_resumen_servicio" , data);		
		$(".cancelar_orden_compra").click(cancela_compra);

	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}
/**/
function cancela_compra(e){
	id_recibo=  e.target.id;	
	
	set_option(id_recibo);
	url =  "../pagos/index.php/api/tickets/cancelar/format/json/";	
	data_send =  {"id_recibo" : get_option("id_recibo")};					
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_resumen_servicio" , "Cargando ... ", 1 );
			}
	}).done(function(data){	

		$("#mi_buzon").tab("show");
		$("#mis_compras").tab("show");
		carga_compras_usuario();
		
	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}