function agregas_comentio_a_usuario(){
	
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
		
		$(".tab_ejemplos_disponibles").tab("show");
		$(".base_tab_clientes").tab("show");			
		carga_info_persona();
	}).fail(function(){			
		show_error_enid(".place_nuevo_comentario" , "Error ... ");
	});			
}
/**/
function carga_info_persona(){
	/**/
	oculta_formularios_busqueda();
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
		//llenaelementoHTML(".place_info_agendados" , data);
		llenaelementoHTML(".place_info_clientes" , data);	
		/**/
		$(".btn_agendar_correo").hide();
		/**/
		$(".btn_agregar_comentario").click(function(){
			recorre_web_version_movil();
		});

		$(".btn_agendar_llamada").click(function(){
			recorre_web_version_movil();
		});
		/**/
		$(".btn_convertir_persona").click(recorre_web_version_movil);
		$(".regresar_btn_posible_cliente").click(regresar_list_posible_cliente);
		/**/
		
	}).fail(function(){			
		show_error_enid(".place_info_posibles_clientes" , "Error ... ");
	});		
	
}
/**/
function oculta_formularios_busqueda(){
	$(".form_busqueda_clientes").hide();
	$(".form_busqueda_posibles_clientes").hide();
}
/**/
function muestra_formularios_busqueda(){
	$(".form_busqueda_clientes").show();
	$(".form_busqueda_posibles_clientes").show();
}
/**/
function recorre_web_version_movil(){
	recorrepage(".tab-content");
}
/**/
function convertir_cliente(e){
	
	if(get_flag_estoy_en_agendado() == 1){
		marca_llama_hecha_comentario();		
	}	

	url =  "../persona/index.php/api/clientes/convertir/format/json/";	
	data_send = $(".form_convertir_cliente").serialize()+"&"+$.param({"id_persona" : id_persona});									
	valor_tipo_actual =  $('input:radio[name=tipo]:checked').val();
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_convertir_cliente" , "Cargando ... ", 1 );
			}
	}).done(function(data){						
	
		if (valor_tipo_actual == 4 ) {
			
			llenaelementoHTML(".place_convertir_cliente" , "");
			/**/				
		}else{

			show_response_ok_enid(".place_convertir_cliente" , "Información actualizada!");										
			$(".base_tab_clientes").tab("show");
			$(".base_tab_posiblies_clientes").tab('show'); 					
			$(".form_busqueda_posibles_clientes").submit();
			recorre_web_version_movil();
		}
		/**/
		cargar_num_envios_a_validacion();

	}).fail(function(){			
		show_error_enid(".place_convertir_cliente" , "Error ... ");
	});
	
	e.preventDefault();	
}

function verifica_tipo_negocio(e){

	url =  "../q/index.php/api/ventas/negocio_q/format/json/";		
	data_send = {"q" :  $(".tipo_negocio_b").val()};		
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_metricas_labor_venta" , "Cargando ... ", 1 );
			}
	}).done(function(data){						

		tipo_negocio =  data[0].idtipo_negocio;		
		set_tipo_negocio(tipo_negocio);					
		registrar_posiblie_cliente();

		/**/
	}).fail(function(){		
		//show_error_enid(".place_metricas_labor_venta" , "Error ... ");

	});	
	
	e.preventDefault();
}
/**/

/*******/
function set_tipo_registro(n_tipo_registro){
	tipo_registro = n_tipo_registro;
}
	/*******/
function get_tipo_registro(){
	return tipo_registro;
}
/**/
function carga_data_contactos_efectivos(e){
	/**/		
	fecha_registro =  e.target.id;			
	url =  "../persona/index.php/api/posiblesclientes/tipificacion/format/json/";		
	data_send = {"fecha_registro" : fecha_registro ,  "tipificacion" :  get_tipificacion() , "id_usuario": get_id_usuario()}	

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
			
		}).fail(function(){			
			show_error_enid(".place_info_posibles_clientes" , "Error ... ");
		});		
		e.preventDefault();	
}
/**/
function set_id_tipo_registro(n_id_tipo_registro){
	id_tipo_registro =  n_id_tipo_registro;
	
	if (n_id_tipo_registro ==  1 ) {
		$(".correo").attr("required", false);
	}else{
		$(".correo").attr("required", true);
	}
}
/**/
function get_id_tipo_registro(){
	return id_tipo_registro;
}