"use strict";
function carga_info_persona(){

	var url =  "../persona/index.php/api/clientes/persona/format/json/";
	var data_send =  {"id_persona" : get_persona()};

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


		$(".btn_agregar_comentario").click(function(){
			recorre_web_version_movil();
		});

		$(".btn_agendar_llamada").click(function(){
			recorre_web_version_movil();
		});

		$(".btn_agendar_correo").click(agenda_correo_usuario_registrado);

		$(".agregar_info_validacion").click(agrega_info_form);

		$(".btn_convertir_persona").click(recorre_web_version_movil);
		$(".regresar_btn_posible_cliente").click(regresar_list_posible_cliente);
		
		
	}).fail(function(){			
		show_error_enid(".place_info_posibles_clientes" , "Error ... ");
	});		
	
}
function asigna_valor_persona_agendado(e){
	id_persona =  get_parameter_enid($(this) , "id");
	set_option("persona", id_persona);		
}



/*
function carga_posibles_clientes(e){

	set_option("flag_base_telefonica",0);
	url =  "../persona/index.php/api/clientes/cliente/format/json/";
	data_send =  $(".form_busqueda_posibles_clientes").serialize()+"&"+$.param({"tipo" : 1 , usuario_validacion : 0 , "mensual" : 0});

	$.ajax({
			url : url ,
			type: "GET",
			data: data_send,
			beforeSend: function(){
				show_load_enid(".place_info_posibles_clientes" , "Cargando ... ", 1 );
			}
	}).done(function(data){

		llenaelementoHTML(".place_info_posibles_clientes" , data);
		$(".info_persona").click(function(e){
			id_persona =  get_parameter_enid($(this) , "id");
			set_option("persona", id_persona);
			carga_info_persona();
		});
		$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);

	}).fail(function(){
		show_error_enid(".place_info_posibles_clientes" , "Error ... ");
	});
	e.preventDefault();
}

function registra_comentarios_usuario(e){

	if(get_flag_estoy_en_agendado() == 1){
		marca_llama_hecha_comentario();
	}
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
		$(".base_tab_posiblies_clientes").tab("show");
		carga_info_persona();


	}).fail(function(){
		show_error_enid(".place_nuevo_comentario" , "Error ... ");
	});

	e.preventDefault();
}

function agenda_llamada(e){


	if(get_flag_estoy_en_agendado() == 1){
		marca_llama_hecha_comentario();
	}

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
function agenda_llamada_recicle(e){


	flag_fecha_agenda =  valida_text_form(".contenedor_persona_recicle .input_f_agenda" , ".contenedor_persona_recicle .place_place_validador_fecha_agenda" , 5 , "Formato de fecha" );
	flag_hora_agenda =  valida_text_form(".contenedor_persona_recicle .input_h_agenda" , ".contenedor_persona_recicle .place_place_validador_hora_agenda" , 3 , "Formato de hora" );

	if (flag_hora_agenda ==  1) {
		if (flag_fecha_agenda ==  1 ) {

			url =  "../q/index.php/api/ventas_tel/prospecto/format/json/";
			data_send =  $(".form_agendar_llamada_recicle").serialize()+"&"+$.param({"tipificacion":2});

			$.ajax({
					url : url ,
					type: "PUT",
					data: data_send,
					beforeSend: function(){
						show_load_enid(".place_info_registro_agenda_recicle" , "Cargando ... ", 1 );
					}
			}).done(function(data){

				cargar_num_agendados();

				$(".place_info_registro_agenda_recicle").empty();
				$('.tab_base_marcacion').tab('show');
				$("#registro_prospecto").tab("hide");


				$(".place_contactos_disponibles").empty();
				$("#contenedor_formulario_contactos").show();
				show_response_ok_enid(".place_resultado_final" , "<div class='row'><span class='white'> Listo! siguiente contacto </span></div>");

				document.getElementById("form_agendar_llamada_recicle").reset();

			}).fail(function(){
				show_error_enid(".place_info_registro_agenda_recicle" , "Error ... ");
			});


		}
	}

	e.preventDefault();
}
function evalua_menu_tipificacion(){
	var tipificacion =  get_parameter(".tipificacion");
	if (tipificacion ==  2 ) {
		$('.btn_agendar_llamada').tab('show');
	}
}

function  set_tipo_negocio(n_tipo_negocio){
	tipo_negocio =  n_tipo_negocio;
	selecciona_select(".tipo_negocio" , tipo_negocio);
}
function carga_info_ventas_mensuales(){

	set_option(menu_actual, "envios_a_validar");
	var url =  "../persona/index.php/api/clientes/cliente/format/json/";
	var data_send =  $(".form_busqueda_clientes").serialize()+"&"+$.param({"tipo" : 2 , "usuario_validacion" : 0 , "mensual":1});

	$.ajax({
			url : url ,
			type: "GET",
			data: data_send,
			beforeSend: function(){
				show_load_enid(".place_info_clientes_del_mes" , "Cargando ... ", 1 );
			}
	}).done(function(data){

		llenaelementoHTML(".place_info_clientes_del_mes" , data);
		$(".info_persona").click(function(e){
			id_persona =  get_parameter_enid($(this) , "id");
			set_option("persona", id_persona);
			carga_info_persona();
		});
		$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);

$(".btn_abrir_ticket").click(set_info_persona_ticket);
recorre_web_version_movil();

}).fail(function(){
    show_error_enid(".place_info_clientes_del_mes" , "Error ... ");
});


}
* */
