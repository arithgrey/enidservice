"use strict";
function carga_info_persona(){

	let url =  "../persona/index.php/api/clientes/persona/format/json/";
	let data_send =  {"id_persona" : get_persona()};

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				sload(".place_info_posibles_clientes" , "Cargando ... ", 1 );
			}
	}).done(function(data){			

		recorre_web_version_movil();
		
		render_enid(".place_info_posibles_clientes" , data);
		render_enid(".place_info_agendados" , data);
		render_enid(".place_info_clientes" , data);	
		render_enid(".place_info_clientes_validacion" , data);
		render_enid(".place_info_correos_agendados" , data);


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