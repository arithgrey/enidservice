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


		/**/																					
		llenaelementoHTML(".place_resumen_servicio" , data);		
		$(".cancelar_compra").click(confirmar_cancelacion_compra);		
		$(".btn_direccion_envio").click(carga_informacion_envio);
		/**/

	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}
/**/
function confirmar_cancelacion_compra(e){
		
	set_option("modalidad_ventas" , $(this).attr("modalidad"));
	set_option("id_recibo" , $(this).attr("id"));	
	if(get_option("id_recibo")>0) {
		
		url =  "../pagos/index.php/api/tickets/cancelar_form/format/json/";		
		data_send =  {"id_recibo" : get_option("id_recibo") , "modalidad" :  get_option("modalidad_ventas")};							
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

}
/**/
function cancela_compra(e){
	
	id_recibo=  e.target.id;
	set_option(id_recibo);
	url =  "../pagos/index.php/api/tickets/cancelar/format/json/";	
	data_send =  {"id_recibo" : get_option("id_recibo") , "modalidad" : get_option("modalidad_ventas") };					
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_resumen_servicio" , "Cargando ... ", 1 );
			}
	}).done(function(data){	
			
		$("#mi_buzon").tab("show");		
		if(get_option("modalidad_ventas") ==  1){			
			$("#mis_ventas").tab("show");
		}else{
			$("#mis_compras").tab("show");
		}
		carga_compras_usuario();
		/*Cargamos notificaciones*/
		metricas_perfil();		
		
	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}