function carga_metricas_clientes_usuario(){

	url =  "../q/index.php/api/ventas/laborventa/format/json/";	
	data_send =  $(".form_busqueda_labor_venta").serialize()+"&"+$.param({"id_usuario" : get_id_usuario() });			
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_metricas_labor_venta" , "Cargando ... ", 1 );
			}
	}).done(function(data){						

		llenaelementoHTML(".place_metricas_labor_venta" , data);			
	
		/**/
		$(".ventas_info").click(function(){
			set_tipificacion(2);
		});
		/**/
		$(".contactos_info").click(function(){
			set_tipificacion(1);
		});

		$(".tipificacion").click(carga_data_contactos_efectivos);		
		/**/
	}).fail(function(){		
		//show_error_enid(".place_metricas_labor_venta" , "Error ... ");
	});	
}
/**/