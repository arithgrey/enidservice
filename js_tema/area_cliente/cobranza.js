/**/
function cargar_info_resumen_pago_pendiente(e){	
		
	var id_recibo  	= get_parameter_enid($(this) , "id");
	
	if (id_recibo > 0) {
		set_option("id_recibo" ,  id_recibo);	
		var url 		=  "../q/index.php/api/recibo/resumen_desglose_pago/format/json/";	
		var data_send 	=  {"id_recibo" : get_option("id_recibo") , "cobranza" : 1};				
		request_enid( "GET",  data_send, url, response_carga_info_resumen_pago_pendiente , ".place_resumen_servicio");
	}
}
/**/
function response_carga_info_resumen_pago_pendiente(data){

	llenaelementoHTML(".place_resumen_servicio" , data);		
	$(".cancelar_compra").click(confirmar_cancelacion_compra);		
	$(".btn_direccion_envio").click(carga_informacion_envio);
}
/**/
function confirmar_cancelacion_compra(){
		
	set_option("modalidad_ventas" 	, get_attr(this, "modalidad"));
	set_option("id_recibo" 			, get_attr(this, "id"));	
	if( get_option("id_recibo")>0) {
		var url 		=  "../q/index.php/api/tickets/cancelar_form/format/json/";		
		var data_send 	=  {"id_recibo" : get_option("id_recibo") , "modalidad" :  get_option("modalidad_ventas")};							
		request_enid( "GET",  data_send, url, resposponse_confirma_cancelacion);
	}
}
/**/
function resposponse_confirma_cancelacion(data){
	llenaelementoHTML(".place_resumen_servicio" , data);				
	$(".cancelar_orden_compra").click(cancela_compra);
}
/**/
function cancela_compra(e){
	
	var id_recibo 	=  e.target.id;
	set_option(id_recibo);
	var url 		=  "../q/index.php/api/tickets/cancelar/format/json/";	
	var data_send 	=  {"id_recibo" : get_option("id_recibo") , "modalidad" : get_option("modalidad_ventas") };					
	request_enid( "PUT",  data_send, url, response_cancelacion_compra);
}
/**/
function response_cancelacion_compra(data){
	
	debugger;
	if(get_option("modalidad_ventas") ==  1){			
		$("#mi_buzon").tab("show");		
		$("#mis_ventas").tab("show");
		carga_compras_usuario();			
	}else{

		var id_servicio=  data.registro.id_servicio; 
		var href ="../valoracion/?servicio="+id_servicio;
		var btn_cuenta_historia =  "<a href='"+href+"' class='a_enid_blue'>CUENTANOS TU EXPERIENCIA</a>";
		var btn_ir_a_compras =  "<a class='a_enid_black mis_compras_btn' id='mis_compras' href='#tab_mis_pagos' data-toggle='tab'>VER MIS COMPRAS</a>";
		var div= "<div class='cuenta_tu_experiencia'>"+btn_cuenta_historia+btn_ir_a_compras+"</div>";
		var div2="<div class='titulo_enid'>¿NOS AYUDARÍAS A EVALUAR EL PRODUCTO QUE CANCELASTE?</div>";
		div2 +="<div class='desc_ayuda'>Con esto otros clientes podrán mantenerse informados sobre el vendedor y su atención al cliente</div>";
		llenaelementoHTML(".place_resumen_servicio" ,  div2 +""+div);
		$(".mis_compras_btn").click(carga_compras_usuario);
			
	}		
	metricas_perfil();
}