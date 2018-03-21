function  abona_saldo_vencido(e) {

	data_send  = $(".form_liquidacion_adeudo").serialize() +"&"+$.param({"id_usuario" : get_id_usuario()});	

	url =  "../portafolio/index.php/api/proyecto/registrar_pago_vencido/format/json/";	
	$.ajax({
		url : url , 
		type: "POST",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".pllace_registro_adeudo" , "Cargando ... ", 1 );	
		}
	}).done(function(data){						
		
		llenaelementoHTML(".pllace_registro_adeudo" , data);		
		$(".btn_tab_info_validacion").tab("show");
		$(".btn_renovar_servicio").tab("show");
		/**/
		carga_resumen_de_pagos_por_servicio();

	}).fail(function(){			
		show_error_enid(".pllace_registro_adeudo" , "Error ... ");
	});	
	e.preventDefault();
}