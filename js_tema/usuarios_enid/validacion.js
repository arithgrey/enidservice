"use strict";
function agrega_info_form(e){
	recorre_web_version_movil();	
}

/**
 *
 *
 * function carga_info_form(dominio_deseado , plantilla_sugerida , comentario_previo_a_venta){

	document.getElementById("info_envio_valida").reset();
valorHTML("#dominio_deseado" , dominio_deseado );
valorHTML("#plantilla_sugerida" , plantilla_sugerida );
valorHTML("#comentario_previo_a_venta" , comentario_previo_a_venta );

}

function carga_info_validacion(){


	var url =  "../persona/index.php/api/validacion/q/format/json/";
	var data_send = {"tipo" : 4 , "id_usuario" : get_id_usuario() };


	$.ajax({
			url : url ,
			type: "GET",
			data: data_send,
			beforeSend: function(){
				show_load_enid(".place_info_clientes_validacion" , "Cargando ... ", 1 );
			}
	}).done(function(data){

llenaelementoHTML(".place_info_clientes_validacion" , data);
$(".info_persona").click(function(e){
    id_persona =  get_parameter_enid($(this) , "id");
    set_persona(id_persona);
    carga_info_persona();
});
$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);

}).fail(function(){
    show_error_enid(".place_info_clientes_validacion" , "Error ... ");
});
e.preventDefault();
}
 function registrar_info_envio_validacion(e){

	var url =  "../persona/index.php/api/validacion/envio_info/format/json/";
	var data_send =  $(".info_envio_valida").serialize()+"&"+$.param({ "id_persona" : get_persona() });

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


 */
/