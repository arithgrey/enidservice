function carga_metricas_clientes_usuario(){

	var url 		=  "../q/index.php/api/ventas/laborventa/format/json/";	
	var data_send 	=  $(".form_busqueda_labor_venta").serialize()+"&"+$.param({"id_usuario" : get_id_usuario() });	
	request_enid( "GET",  data_send , url , call_back , ".place_metricas_labor_venta");		
	
}
/**/
function response_carga_metricas_cliente_usuario(data){
	llenaelementoHTML(".place_metricas_labor_venta" , data);			
	
	$(".ventas_info").click(function(){
		set_tipificacion(2);
	});
		/**/
	$(".contactos_info").click(function(){
		set_tipificacion(1);
	});
	$(".tipificacion").click(carga_data_contactos_efectivos);	
}
/**/