/**/
function cargar_info_resumen_pago_pendiente(e){	
	/**/
	id_recibo =  e.target.id;		
	set_option("id_recibo" ,  id_recibo);	
	url =  "../pagos/index.php/api/cobranza/resumen_desglose_pago/format/json/";	
	data_send =  {"id_recibo" : get_option("id_recibo")};					
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_resumen_servicio" , "Cargando ... ", 1 );
			}
	}).done(function(data){																									
		llenaelementoHTML(".place_resumen_servicio" , data);		
	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}
