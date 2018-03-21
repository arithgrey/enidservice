function pre_load_agendados(e){
	
	set_tipo_relacion(e.target.id);
	cargar_info_agendados();
}
/**/
function cargar_info_agendados(e){

	set_menu_actual("agendados");
	set_flag_estoy_en_agendado(0);
	url =  "../base/index.php/api/ventas_tel/agendados/format/json/";	
	data_send =  $(".form_busqueda_agendados").serialize()+"&"+$.param({"tipo_relacion":get_tipo_relacion()});				
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_agendados" , "Cargando ... ", 1 );
			}
	}).done(function(data){																				
		llenaelementoHTML(".place_info_agendados" , data);		
		/**/
		$(".info_persona_agendados").click(function(e){			
			id_persona =  e.target.id;
			set_persona(id_persona);
			carga_info_persona();	
		});			
		/**/
		$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);	
		$(".marcar_llamada_btn").click(marcar_llamada_hecha);
		/*Cargamos num agendados en notificación*/
		cargar_num_agendados();
		set_flag_estoy_en_agendado(1);
		/**/
	}).fail(function(){			
		show_error_enid(".place_info_agendados" , "Error ... ");
	});		
	e.preventDefault();
}
/**/
function  marcar_llamada_hecha(e){	

	/**/
	set_llamada(e.target.id);
	llenaelementoHTML(".place_llamada_hecha" , "");
}
/**/
function registrar_llamada_hecha(e){

	url =  "../base/index.php/api/ventas_tel/agendados_llamada_hecha/format/json/";		
	data_send =  {id_llamada :  get_llamada()};				
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																				
		
		show_response_ok_enid(".place_llamada_hecha" , "Llamada hecha!");
		$("#modal_llamada_efectuada").modal("hide");
		$(".form_busqueda_agendados").submit();
		recorre_web_version_movil();
		/**/
		mostrar_nueva_accion();
			
		/**/
	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
	e.preventDefault();	
}
/**/
function marca_llama_hecha_comentario(){	
	url =  "../base/index.php/api/ventas_tel/marca_llamada_hecha_posterior_comentario/format/json/";		
	data_send = {"id_persona" : get_persona() , "id_usuario" : get_id_usuario()};
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_cometario_posterior_llamada" , "Cargando ... ", 1 );
			}
	}).done(function(data){			

		show_response_ok_enid(".place_convertir_cliente" , "Información actualizada!");										
		cargar_num_agendados();
		set_flag_estoy_en_agendado(1);

	}).fail(function(){			
		show_error_enid(".place_registro_cometario_posterior_llamada" , "Error ... ");
	});		
}
/**/
function registrar_avance_llamar_despues(e){

	val_tipificacion =  $("#tipificacion_llamar_despues").val();		
	tmp_tel = get_tmp_tel();
	$("#telefono_info_contacto").val(tmp_tel);			
	set_telefono(tmp_tel);
	
	reset_form_agenda();
	recorre_web_version_movil();	

	/*Cuando se tiene que registrar la información de la persona */
	if (val_tipificacion ==  "1" || val_tipificacion ==  "9" ){				

		$('.agregar_posible_cliente_btn').tab('show'); 			
		
	}else if(val_tipificacion ==  "8"){
		/*Mostramos el form y seteamos a 1 sólo enviar referencia*/
		
		$('.agregar_posible_cliente_btn').tab('show'); 							
		
	}else if(val_tipificacion == "2" ){
		/*Cuando pide llamar después, lanzar formulario*/
		$('.btn_agendar_llamada_base_marcacion').tab('show'); 				
		/**/		
	}else{			
		/*Registra tipificación*/
		registra_tipificacion_llamada_seguimiento();
	}
	/**/
	e.preventDefault();
}
/***/
function registra_tipificacion_llamada_seguimiento(){

	url =  "../base/index.php/api/ventas_tel/prospecto/format/json/";	
	data_send = $(".form_tipificacion_llamar_despues").serialize()+"&" + $.param({"telefono" : get_telefono() , "id_usuario" : get_id_usuario() });

	$.ajax({
			url : url , 
			type : "PUT" ,
			data: data_send , 
			beforeSend: function(){
				show_load_enid(".place_update_prospecto" , "Cargando ..." , 1 );
			}
		}).done(function(data){	

			$('.tab_ejemplos_disponibles').tab('show'); 						
			$('.base_tab_agendados').tab('show'); 						
			
			recorre_web_version_movil();
			cargar_num_agendados();
			
		}).fail(function(){
			show_error_enid(".place_update_prospecto" , "Error al cargar ..."); 
	});	
}
/**/
function set_tipo_relacion(n_tipo_relacion){
	tipo_relacion  = n_tipo_relacion;
}
/**/
function get_tipo_relacion(){
	return  tipo_relacion;
}
function mostrar_nueva_accion(){	
	showonehideone( ".seccion_opciones_posterio_llamar_despues" , ".seccion_btn_confirmar_llamada" );	
	/**/
}
function mostrar_acciones_despues_llamada(){
	/**/
	accion =  $(".accion_posterior_llamada").val();
	
	switch(accion){
	    case "1":
	        
	        $(".base_tab_posiblies_clientes").tab("show");
			$(".btn_commentario").tab("show");
	        break;
	    case "2":
	        $(".base_tab_posiblies_clientes").tab("show");
			$(".btn_agenda_llamada_btn").tab("show");
	        break;

	    case "3":
	        $(".base_tab_posiblies_clientes").tab("show");
			$(".btn_post_correo").tab("show");
	        break;   


	    case "4":
	        
			$(".base_tab_posiblies_clientes").tab("show");
			$(".base_tab_agendados").tab("show");				
			$(".base_tab_clientes").tab("show");

	        break;
	           
	    default:
	    	showonehideone(".seccion_btn_confirmar_llamada", ".seccion_opciones_posterio_llamar_despues" );	
	        break;
	} 
	
	showonehideone(".seccion_btn_confirmar_llamada", ".seccion_opciones_posterio_llamar_despues" );	
}