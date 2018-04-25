function carga_info_validacion(){	

	url =  "../persona/index.php/api/validacion/q/format/json/";	
	data_send = {"tipo" : 4 , "id_usuario" : get_id_usuario() };					
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_clientes_validacion" , "Cargando ... ", 1 );
			}
	}).done(function(data){				
		/**/																		
		llenaelementoHTML(".place_info_clientes_validacion" , data);
		$(".info_persona").click(function(e){
			id_persona =  e.target.id;
			set_persona(id_persona);
			carga_info_persona();	
		});			
		$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);	

	}).fail(function(){			
		show_error_enid(".place_info_clientes_validacion" , "Error ... ");
	});		
	e.preventDefault();
}
/**/
function registrar_info_envio_validacion(e){

	url =  "../persona/index.php/api/validacion/envio_info/format/json/";	
	data_send =  $(".info_envio_valida").serialize()+"&"+$.param({ "id_persona" : get_persona() }); 

	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_usuario_validacion" , "Cargando ... ", 1 );
			}
	}).done(function(data){				

		document.getElementById("info_envio_valida").reset(); 
		show_response_ok_enid(".place_registro_usuario_validacion" , "Información actualizada.");					
		$(".base_tab_agendados").tab("show");
		$(".base_tab_clientes").tab("show");
		$(".enviados_a_validacion").tab("show");
		carga_info_persona();


		
	}).fail(function(){			
		show_error_enid(".place_registro_usuario_validacion" , "Error ... ");
	});		
	e.preventDefault();
}
/**/
function carga_formulario_servicios(e){

	
	url =  "../portafolio/index.php/api/proyecto/qform/format/json/";		
	data_send =  $(".form_q_servicios").serialize() +"&" +  $.param({"id_persona" : get_persona() , "usuario_validacion" : get_id_usuario()  });		
	set_servicio_requerido($(".select_tipo_negocio_servicio option:selected").text());

	

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_form_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){				

		/**/
		llenaelementoHTML(".place_form_renovacion", "");
		/**/
		llenaelementoHTML(".place_form_proyectos" , data );
		
		carga_ciclo_facturacion_servicio();
		$(".precios_form").change(carga_ciclo_facturacion_servicio);
		$(".forma_pago").change(evalua_info_facturacion);
		$(".select_opcion_facturacion").change(evalua_info_facturacion_requerida);
		$(".formulario_cliente_liberado").submit(liberar_servicio_paginas_web);
		



	}).fail(function(){			
		show_error_enid(".place_form_proyectos" , "Error ... ");
	});		
	
	e.preventDefault();
}
/**/
function carga_ciclo_facturacion_servicio(){	
	/**/
	precio_servicio = $(".precios_form option:selected").text();
	
	
	iva = parseInt(precio_servicio) * .16;
	iva_select ="<select class='form-control'><option>"+iva	+"</option></select>";
	llenaelementoHTML(".place_text_iva" , iva_select);

	/**/
	total =   parseInt(precio_servicio) + iva; 
	total_select ="<select class='form-control' name='total'><option>"+total +"</option></select>";
	llenaelementoHTML(".place_text_total" , total_select);
	/**/
	$(".saldo_cubierto").val(total);

	valor_ciclo_facturacion =  $(".precios_form").val();
	var ciclos = ["" , "Anual" , "Mensual" , "Semanal"];

	set_nombre_ciclo_facturacion( ciclos[valor_ciclo_facturacion] );  

	select =  "<select class='form-control ciclo_facturacion' name='ciclo_facturacion'><option value='"+valor_ciclo_facturacion+"'>"+ ciclos[valor_ciclo_facturacion]+"</option></select>";	
	llenaelementoHTML(".place_ciclo_facturacion" , select );
	/*Aquí se llena el select de próximo vencimiento*/

	fecha_anual = $("#vyear").val();
	fecha_mensual =  $("#vmonth").val();
	fecha_semanal = $("#vweek").val();

	proximas_fechas = ["" , fecha_anual , fecha_mensual , fecha_semanal];

	set_proxima_fecha_vencimiento(proximas_fechas[valor_ciclo_facturacion]);

	select_fecha_vencimiento =  "<select class='form-control' name='fecha_vencimiento'><option value='"+proximas_fechas[valor_ciclo_facturacion]+"'>"+proximas_fechas[valor_ciclo_facturacion]+"</option></select>";
	/**/	
	llenaelementoHTML(".place_siguiente_vencimiento" , select_fecha_vencimiento );
	carga_info_concepto_servicio();

}
/**/
function liberar_servicio_paginas_web(e){

	precio_num =  $(".precios_form option:selected").text();  
	id_servicio =  $(".select_tipo_negocio_servicio option:selected").val();  
	data_send =  $(".formulario_cliente_liberado").serialize() + "&" +$.param({"precio_num" : precio_num  , "id_servicio" : id_servicio });	
	url =  "../portafolio/index.php/api/proyecto/liberar_proyecto_validacion/format/json/";	
	
	
	$.ajax({
		url : url , 
		type: "POST",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".place_liberar_servicio" , "Cargando ... ", 1 );	
		}
	}).done(function(data){					
			
			
		llenaelementoHTML(".place_liberar_servicio" , data );
		document.getElementById("formulario_cliente_liberado").reset(); 						
		$(".base_tab_posiblies_clientes").tab("show");
		$(".btn_abrir_ticket").tab("show");
		
		get_proyectos_persona();

		
	}).fail(function(){			
		show_error_enid(".place_liberar_servicio" , "Error ... ");
	});		
	e.preventDefault();
}
/**/
function cargar_notificaciones_validacion(){

	data_send = "";	
	url =  "../portafolio/index.php/api/proyecto/num_validados/format/json/";	

	$.ajax({
		url : url , 
		type: "GET",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".place_pendientes_por_validar" , "Cargando ... ", 1 );	
		}
	}).done(function(data){						
		/**/		
		llenaelementoHTML(".place_pendientes_por_validar" , data);


	}).fail(function(){			

		show_error_enid(".place_pendientes_por_validar" , "Error ... ");

	});	

}
/**/
function evalua_info_facturacion(){
	
	forma_pago = $(".forma_pago").val(); 
	if (forma_pago != 3 ) {
		/*Se muestra form de facturación*/
		$(".seccion_facturacion").show();
		document.getElementById("select_opcion_facturacion").selectedIndex = "1"; 
		document.getElementById("select_opcion_facturacion").disabled = true;
		
	}else{
		$(".seccion_facturacion").hide();
		document.getElementById("select_opcion_facturacion").selectedIndex = "0"; 
		document.getElementById("select_opcion_facturacion").disabled = false;
	}
	
}
/**/
function evalua_info_facturacion_requerida(){

	set_facturar_servicio($(".select_opcion_facturacion").val());
	if (get_facturar_servicio() ==  1 ) {
		$(".seccion_facturacion").show();		
	}else{
		$(".seccion_facturacion").hide();		
	}
}
/**/
function set_servicio_requerido(n_servicio_requerido){
	servicio_requerido = n_servicio_requerido;
}
/**/
function get_servicio_requerido(){
	return servicio_requerido;
}
/**/
function set_nombre_ciclo_facturacion(n_nombre_ciclo_facturacion){
	nombre_ciclo_facturacion =  n_nombre_ciclo_facturacion;
}
/**/
function get_nombre_ciclo_facturacion(){
	return nombre_ciclo_facturacion;
}
/**/
function set_proxima_fecha_vencimiento(n_proxima_fecha_vencimiento){

	proxima_fecha_vencimiento =  n_proxima_fecha_vencimiento;
}
/**/
function get_proxima_fecha_vencimiento(){
	return proxima_fecha_vencimiento;
}
/**/
function carga_info_concepto_servicio(){
	
	pre_concepto = $.trim(get_servicio_requerido()) +"," +  " ciclo de facturación " + get_nombre_ciclo_facturacion() +", con fecha de vencimiento " + get_proxima_fecha_vencimiento(); 
	valorHTML(".concepto_servicio" , pre_concepto );	
}
/**/
function renovar_servicio(e){
	
	id_proyecto_persona  =  e.target.id;
	set_id_proyecto_persona(id_proyecto_persona);
	/*cargamos info del servicio*/
	carga_resumen_de_pagos_por_servicio();
}
/**/
function carga_resumen_de_pagos_por_servicio(){

	data_send = {"id_proyecto_persona" : get_id_proyecto_persona() };	
	url =  "../portafolio/index.php/api/proyecto/resumen_proyecto_persona/format/json/";	

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
		$(".btn_liquidar_servicio").click(carga_form_pago_servicio_adeudado);
		/**/
		id_servicio =  $(".id_servicio_facturacion").val();
		set_id_servicio(id_servicio);		
		

		$(".regresar_a_servicios").click(function(){		
			get_proyectos_persona();
		});
		/**/

		$(".renovar_servicio_btn").click(carga_form_renovacion_servicio);

	}).fail(function(){			

		show_error_enid(".place_resumen_servicio" , "Error ... ");

	});	


}
/**/
function carga_form_pago_servicio_adeudado(e){

	id_proyecto_persona_forma_pago= e.target.id;
	set_id_proyecto_persona_forma_pago(id_proyecto_persona_forma_pago);
	recorre_web_version_movil();
	carga_informacion_pagos_servicio();

}
function carga_informacion_pagos_servicio(){

	data_send = {"id_proyecto_persona_forma_pago" : get_id_proyecto_persona_forma_pago() , "id_servicio" : get_id_servicio() };		
	url =  "../portafolio/index.php/api/proyecto/resumen_proyecto_persona_forma_pago/format/json/";	

	
	
	$.ajax({
		url : url , 
		type: "GET",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".place_pago_vencido" , "Cargando ... ", 1 );	
		}
	}).done(function(data){						

		llenaelementoHTML(".place_pago_vencido" , data);
		/**/
		$(".form_liquidacion_adeudo").submit(abona_saldo_vencido);



	}).fail(function(){			

		show_error_enid(".place_pago_vencido" , "Error ... ");

	});	
}
/**/
function regresar_list_posible_cliente(){

	menu = get_menu_actual();  
	switch(menu){

		case "envios_a_validar":
				$(".form_busqueda_posibles_clientes").submit();			 			
			break; 

		case "clientes":
				$(".form_busqueda_clientes").submit();		
			break; 

		case "agendados":
				$(".form_busqueda_agendados").submit();
			break; 
			
		default: 
			
			break; 
		
	}
}
/**/
function carga_form_renovacion_servicio(){
	
	recorre_web_version_movil();		
	id_proyecto_persona = get_id_proyecto_persona();	

	data_send = {"id_proyecto_persona" : id_proyecto_persona, "id_persona" : get_persona()};		
	url =  "../portafolio/index.php/api/proyecto/form_renovacion/format/json/";	

	$.ajax({
		url : url , 
		type: "GET",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".place_form_renovacion" , "Cargando ... ", 1 );	
		}
	}).done(function(data){						
		

		llenaelementoHTML(".place_form_proyectos" , "" );
		/**/
		llenaelementoHTML(".place_form_renovacion", data);
		carga_ciclo_facturacion_servicio();
		$(".precios_form").change(carga_ciclo_facturacion_servicio);
		$(".forma_pago").change(evalua_info_facturacion);
		$(".select_opcion_facturacion").change(evalua_info_facturacion_requerida);		
		$(".formulario_renovacion_servicio_cliente").submit(renovar_servicio_cliente);		
	
	}).fail(function(){			

		show_error_enid(".place_form_renovacion" , "Error ... ");
	});		
	
}
/**/
function renovar_servicio_cliente(e){

	precio_num =  $(".precios_form option:selected").text();  
	id_servicio =  $(".select_tipo_negocio_servicio option:selected").val();  	
	data_send =  $(".formulario_renovacion_servicio_cliente").serialize()+"&"+$.param({"usuario_validacion": get_id_usuario() , "precio_num" : precio_num  , "id_servicio" : id_servicio  });	
	url =  "../portafolio/index.php/api/proyecto/renovar_servicio/format/json/";	

	$.ajax({
		url : url , 
		type: "POST",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".place_form_renovacion_status" , "Cargando ... ", 1 );	
		}
	}).done(function(data){								
				
		$(".base_tab_agendados").tab("show");	
		$("#btn_renovar_servicio").tab("show");
		carga_resumen_de_pagos_por_servicio();
		
	}).fail(function(){			

		show_error_enid(".place_form_renovacion_status" , "Error ... ");
	});	


	e.preventDefault();
}