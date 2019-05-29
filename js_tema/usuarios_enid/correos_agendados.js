"use strict";
let agenda_correo = function (e) {


    if (get_flag_estoy_en_agendado() == 1) {
        marca_llama_hecha_comentario();
    }
    let flag_fecha_agenda = valida_text_form(".contenedor_persona_registrada_correo .input_f_agenda", ".contenedor_persona_registrada_correo .place_place_validador_fecha_agenda", 5, "Formato de fecha");
    let flag_hora_agenda = valida_text_form(".contenedor_persona_registrada_correo .input_h_agenda", ".contenedor_persona_registrada_correo .place_place_validador_hora_agenda", 3, "Formato de hora");

    if (flag_fecha_agenda == 1) {

        if (flag_hora_agenda == 1) {


            let url = "../persona/index.php/api/persona/agendar_email/format/json/";
            let data_send = $(".form_agendar_correo_electronico").serialize() + "&" + $.param({id_persona: get_persona()});

            $.ajax({
                url: url,
                type: "POST",
                data: data_send,
                beforeSend: function () {
                    show_load_enid(".place_info_registro_agenda_correo", "Cargando ... ", 1);
                }
            }).done(function (data) {


                cargar_num_agendados_email();
                show_response_ok_enid(".place_info_registro_agenda_correo", "Correo Agendado con éxito!");
                $('.tab_base_marcacion').tab('show');
                $(".base_tab_posiblies_clientes").tab("show");

                document.getElementById("form_agendar_correo_electronico").reset();

                carga_info_persona();

            }).fail(function () {
                show_error_enid(".place_info_registro_agenda_correo", "Error ... ");
            });

        }
    }

    e.preventDefault();

}

let agenda_correo_usuario_registrado = function (e) {

    id_persona = get_parameter_enid($(this), "id");
    set_option("persona", id_persona);
    recorre_web_version_movil();
}


/*
let cargar_info_agendados_email = function(){

	let     url =  "../q/index.php/api/ventas_tel/agendadosemail/format/json/";
	let  data_send =  $(".form_busqueda_agendados").serialize();

	$.ajax({
			url : url ,
			type: "GET",
			data: data_send,
			beforeSend: function(){
				show_load_enid(".place_info_correos_agendados" , "Cargando ... ", 1 );
			}
	}).done(function(data){
		render_enid(".place_info_correos_agendados" , data);

			$(".info_persona_agendados").click(function(e){
				id_persona =  get_parameter_enid($(this) , "id");
				set_option("persona", id_persona);
				carga_info_persona();
			});

			$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);
			$(".marcar_llamada_btn").click(marcar_llamada_hecha);

			$(".marcar_correo_btn").click(function(e){

				id_persona =  get_parameter_enid($(this) , "id");
				set_option("persona", id_persona);
			});
			recorre_web_version_movil();

	}).fail(function(){
		show_error_enid(".place_info_correos_agendados" , "Error ... ");
	});


}

* function registrar_correo_hecho(e){

	url =  "../q/index.php/api/ventas_tel/agendados_correo_hecho/format/json/";
	data_send =  {"id_persona" :  get_persona() , "id_usuario" : get_id_usuario() };


	$.ajax({
			url : url ,
			type: "PUT",
			data: data_send,
			beforeSend: function(){
				show_load_enid(".place_correo_envio" , "Cargando ... ", 1 );
			}
	}).done(function(data){


		show_response_ok_enid(".place_correo_envio" , "Tarea realizada!");
		$("#modal_correo_enviado").modal("hide");
		cargar_info_agendados_email();
		recorre_web_version_movil();
		cargar_num_agendados_email();




	}).fail(function(){
		show_error_enid(".place_correo_envio" , "Error ... ");
	});
	e.preventDefault();
}
*/
