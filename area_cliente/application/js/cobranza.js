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
			
		
		if(get_option("modalidad_ventas") ==  1){			
			$("#mi_buzon").tab("show");		
			$("#mis_ventas").tab("show");
			carga_compras_usuario();			
		}else{

			id_servicio=  data.registro.id_servicio; 
			href ="../valoracion/?servicio="+id_servicio;
			btn_cuenta_historia =  "<a href='"+href+"' class='a_enid_blue'>CUENTANOS TU EXPERIENCIA</a>";
			btn_ir_a_compras =  "<a class='a_enid_black mis_compras_btn' id='mis_compras' href='#tab_mis_pagos' data-toggle='tab'>VER MIS COMPRAS</a>";
			div= "<div class='cuenta_tu_experiencia'>"+btn_cuenta_historia+btn_ir_a_compras+"</div>";
			div2="<div class='titulo_enid'>¿NOS AYUDARÍAS A EVALUAR EL PRODUCTO QUE CANCELASTE?</div>";
			div2 +="<div class='desc_ayuda'>Con esto otros clientes podrán mantenerse informados sobre el vendedor y su atención al cliente</div>";
			llenaelementoHTML(".place_resumen_servicio" ,  div2 +""+div);
			$(".mis_compras_btn").click(carga_compras_usuario);
			
		}		
		metricas_perfil();		
		
	}).fail(function(){			
		show_error_enid(".place_resumen_servicio" , "Error ... ");
	});	
}