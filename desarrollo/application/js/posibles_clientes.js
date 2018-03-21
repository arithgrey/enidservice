function carga_posibles_clientes(e){	
		
	set_menu_actual("envios_a_validar");		
	set_flag_base_telefonica(0);
	url =  "../persona/index.php/api/clientes/posibles_clientes_validacion/format/json/";	
	data_send =  $(".form_busqueda_posibles_clientes").serialize()+"&"+$.param({"tipo" : 4 , usuario_validacion : 1 });
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_posibles_clientes" , "Cargando ... ", 1 );
			}
	}).done(function(data){				
		/**/																		
		llenaelementoHTML(".place_info_posibles_clientes" , data);
		$(".info_persona").click(function(e){
			id_persona =  e.target.id;
			set_persona(id_persona);
			carga_info_persona();	
		});			
		$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);	
		/**/
		cargar_notificaciones_validacion();
		
	}).fail(function(){			
		show_error_enid(".place_info_posibles_clientes" , "Error ... ");
	});		
	e.preventDefault();
}
/**/
function carga_info_persona(){
	/**/
	url =  "../persona/index.php/api/clientes/persona/format/json/";	
	data_send =  {"id_persona" : get_persona()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_posibles_clientes" , "Cargando ... ", 1 );
			}
	}).done(function(data){			

		recorre_web_version_movil();
		
		llenaelementoHTML(".place_info_posibles_clientes" , data);
		llenaelementoHTML(".place_info_agendados" , data);
		llenaelementoHTML(".place_info_clientes" , data);	
		llenaelementoHTML(".place_info_clientes_validacion" , data);
		llenaelementoHTML(".place_info_correos_agendados" , data);

		/**/
		$(".btn_agregar_comentario").click(function(){
			recorre_web_version_movil();
		});

		$(".btn_agendar_llamada").click(function(){
			recorre_web_version_movil();
		});

		$(".btn_agendar_correo").click(agenda_correo_usuario_registrado);
		/**/
		$(".btn_convertir_persona").click(recorre_web_version_movil);

		$(".regresar_btn_posible_cliente").click(regresar_list_posible_cliente);

	}).fail(function(){			
		show_error_enid(".place_info_posibles_clientes" , "Error ... ");
	});		
	
}
/**/
function registra_comentarios_usuario(e){

	
	url =  "../msj/index.php/api/comentario/comentario_persona_usuario/format/json/";		
	data_send =  $(".form_comentarios").serialize()+"&"+ $.param({"id_persona" : get_persona()});

	
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_nuevo_comentario" , "Cargando ... ", 1 );
			}
	}).done(function(data){			

		document.getElementById("form_comentarios").reset(); 
		show_response_ok_enid(".place_nuevo_comentario" , "Comentario registrado!");				
		/**/
		$(".tab_ejemplos_disponibles").tab("show");
		$(".base_tab_posiblies_clientes").tab("show");		
		carga_info_persona();
	
	}).fail(function(){			
		show_error_enid(".place_nuevo_comentario" , "Error ... ");
	});		
	
	e.preventDefault();
}
/**/
function set_persona(n_persona){
	persona =  n_persona;
}
/**/
function get_persona(){
	return  persona;
}
/**/
/**/
function agenda_llamada(e){
	/**/
	

	flag_fecha_agenda =  valida_text_form(".contenedor_persona_registrada .input_f_agenda" , ".contenedor_persona_registrada .place_place_validador_fecha_agenda" , 5 , "Formato de fecha" );
	flag_hora_agenda =  valida_text_form(".contenedor_persona_registrada .input_h_agenda" , ".contenedor_persona_registrada .place_place_validador_hora_agenda" , 3 , "Formato de hora" );

	if (flag_fecha_agenda ==  1) {

		if (flag_hora_agenda == 1 ) {

			url =  "../persona/index.php/api/persona/agendar/format/json/";		
			data_send =  $(".form_agendar_llamada").serialize()+"&"+$.param({id_persona : get_persona() ,  "tipo_llamada" :  1 });	
			$.ajax({
					url : url , 
					type: "POST",
					data: data_send, 
					beforeSend: function(){
						show_load_enid(".place_info_registro_agenda" , "Cargando ... ", 1 );
					}
			}).done(function(data){						

				
				show_response_ok_enid(".place_info_registro_agenda" , "Llamada agendada!");					
				$('.tab_base_marcacion').tab('show'); 						
				$(".base_tab_posiblies_clientes").tab("show");
				$(".form_busqueda_posibles_clientes").submit();
				document.getElementById("form_agendar_llamada").reset(); 				
				cargar_num_agendados();
				
			}).fail(function(){			
				show_error_enid(".place_info_registro_agenda" , "Error ... ");
			});
		
		}
	}
	
	e.preventDefault();
}
/**/
function agenda_llamada_recicle(e){
	/**/

	flag_fecha_agenda =  valida_text_form(".contenedor_persona_recicle .input_f_agenda" , ".contenedor_persona_recicle .place_place_validador_fecha_agenda" , 5 , "Formato de fecha" );
	flag_hora_agenda =  valida_text_form(".contenedor_persona_recicle .input_h_agenda" , ".contenedor_persona_recicle .place_place_validador_hora_agenda" , 3 , "Formato de hora" );
	
	if (flag_hora_agenda ==  1) {
		if (flag_fecha_agenda ==  1 ) {

			url =  "../base/index.php/api/ventas_tel/prospecto/format/json/";	
			data_send =  $(".form_agendar_llamada_recicle").serialize()+"&"+$.param({"tipificacion":2});		

			$.ajax({
					url : url , 
					type: "PUT",
					data: data_send, 
					beforeSend: function(){
						show_load_enid(".place_info_registro_agenda_recicle" , "Cargando ... ", 1 );
					}
			}).done(function(data){								

				/*Aquií se muestra el tab deposibles clientes*/
				$(".place_info_registro_agenda_recicle").empty();
				$('.tab_base_marcacion').tab('show'); 						
				$("#registro_prospecto").tab("hide");
				

				$(".place_contactos_disponibles").empty();
				$("#contenedor_formulario_contactos").show();
				show_response_ok_enid(".place_resultado_final" , "<div class='row'><span class='white'> Listo! siguiente contacto </span></div>");						
				/*Aquí se resetea el formulario de agendados*/
				document.getElementById("form_agendar_llamada_recicle").reset(); 					
				/**/
			}).fail(function(){			
				show_error_enid(".place_info_registro_agenda_recicle" , "Error ... ");
			});				


		}
	}
	
	e.preventDefault();
}
/**/
function asigna_valor_persona_agendado(e){
	id_persona =  e.target.id;
	set_persona(id_persona);		
}
/**/
function evalua_menu_tipificacion(){
	tipificacion =  $(".tipificacion").val();
	if (tipificacion ==  2 ) {
		$('.btn_agendar_llamada').tab('show'); 										
	}
}
/**/
function  set_tipo_negocio(n_tipo_negocio){	
	tipo_negocio =  n_tipo_negocio;
	selecciona_select(".tipo_negocio" , tipo_negocio);
}
/**/
function get_tipo_negocio(){
	return tipo_negocio;
}
/**/
function  get_fuente() {
	return fuente; 
}
/**/
function set_fuente(n_fuente){	
	fuente =  n_fuente;
	selecciona_select(".fuente" , fuente);
}
/**/
function  get_telefono(){
	return telefono;
}
/**/
function set_telefono(n_telefono) {
	telefono = n_telefono;
	$(".telefono").val(telefono);
}
/**/
function  get_flag_base_telefonica() {
	return  flag_base_telefonica;
}
/**/
function set_flag_base_telefonica(n_flag_base_telefonica){
	flag_base_telefonica =  n_flag_base_telefonica;
}
/**/
function  get_llamada(){
	return llamada;
}
/**/
function set_llamada(n_llamada ){
	llamada =  n_llamada;  	
}
/**/
function set_nombre_tipo_negocio(n_nombre_tipo_negocio){
	nombre_tipo_negocio =  n_nombre_tipo_negocio;
	llenaelementoHTML(".place_info_tipo_negocio" , nombre_tipo_negocio);
}
/**/
function get_nombre_tipo_negocio(){
	return nombre_tipo_negocio;
}
/**/
function get_facturar_servicio(){
	return facturar_servicio;
}
/**/
function set_facturar_servicio(nfacturar_servicio){
	facturar_servicio = nfacturar_servicio;
}
/**/
function set_id_proyecto_persona_forma_pago(n_id_proyecto_persona_forma_pago){
	id_proyecto_persona_forma_pago =  n_id_proyecto_persona_forma_pago;
}
/**/
function get_id_proyecto_persona_forma_pago(){
	return id_proyecto_persona_forma_pago;
}