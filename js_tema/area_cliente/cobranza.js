"use strict";
let cargar_info_resumen_pago_pendiente = function(e){
	
	
	recorrepage();
	let id_recibo  	= get_parameter_enid($(this) , "id");	
	if (id_recibo == undefined) {
		id_recibo 	= get_parameter(".ticket");  		
	}

	if (id_recibo > 0) {

		set_option("id_recibo" ,  id_recibo);	
		let url 		=  "../q/index.php/api/recibo/resumen_desglose_pago/format/json/";	
		let data_send 	=  {"id_recibo" : get_option("id_recibo") , "cobranza" : 1};				
		request_enid( "GET",  data_send, url, response_carga_info_resumen_pago_pendiente , ".place_resumen_servicio");
	}
}
let response_carga_info_resumen_pago_pendiente = function(data){

	
	$(".resumen_pagos_pendientes").tab("show");
	llenaelementoHTML(".place_resumen_servicio" , data);		
	$(".cancelar_compra").click(confirmar_cancelacion_compra);
	$(".btn_direccion_envio").click(carga_informacion_envio);
}
let resposponse_confirma_cancelacion = function(data){
	llenaelementoHTML(".place_resumen_servicio" , data);				
	$(".cancelar_orden_compra").click(cancela_compra);
}
let cancela_compra = function(e){
	
	let id_recibo 	=  get_parameter_enid($(this) , "id");
	set_option(id_recibo);
	let url 		=  "../q/index.php/api/tickets/cancelar/format/json/";	
	let data_send 	=  {"id_recibo" : get_option("id_recibo") , "modalidad" : get_option("modalidad_ventas") };					
	request_enid( "PUT",  data_send, url, response_cancelacion_compra);
}
let response_cancelacion_compra = function(data){
	
	debugger;
	if(get_option("modalidad_ventas") ==  1){			
		$("#mi_buzon").tab("show");		
		$("#mis_ventas").tab("show");
		carga_compras_usuario();			
	}else{

		let id_servicio=  data.registro.id_servicio; 
		let href ="../valoracion/?servicio="+id_servicio;
		let btn_cuenta_historia =  "<a href='"+href+"' class='a_enid_blue'>CUENTANOS TU EXPERIENCIA</a>";

		let div= "<div class='cuenta_tu_experiencia'>"+btn_cuenta_historia+"</div>";
		let div2="<h3>¿NOS AYUDARÍAS A EVALUAR EL PRODUCTO QUE CANCELASTE?</h3>";


		let response =  "<div class='col-lg-8 col-lg-offset-2 text-center'>"+div2 +""+div+"</div>";
		llenaelementoHTML(".place_resumen_servicio" , response  );
		$(".mis_compras_btn").click(carga_compras_usuario);
			
	}		
	metricas_perfil();
}
let confirmar_cancelacion_compra = function(){

	set_option("modalidad_ventas" 	, get_attr(this, "modalidad"));
	set_option("id_recibo" 			, get_attr(this, "id"));
	if( get_option("id_recibo")>0) {
		let url 		=  "../q/index.php/api/tickets/cancelar_form/format/json/";
		let data_send 	=  {"id_recibo" : get_option("id_recibo") , "modalidad" :  get_option("modalidad_ventas")};
		request_enid( "GET",  data_send, url, resposponse_confirma_cancelacion);
	}
}
