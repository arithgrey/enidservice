"use strict";
let agenda_correo =  (e) =>  {


    if (get_flag_estoy_en_agendado() == 1) {
        marca_llama_hecha_comentario();
    }
    let flag_fecha_agenda = val_text_form(".contenedor_persona_registrada_correo .input_f_agenda", ".contenedor_persona_registrada_correo .place_place_validador_fecha_agenda", 5, "Formato de fecha");
    let flag_hora_agenda = val_text_form(".contenedor_persona_registrada_correo .input_h_agenda", ".contenedor_persona_registrada_correo .place_place_validador_hora_agenda", 3, "Formato de hora");

    if (flag_fecha_agenda == 1) {

        if (flag_hora_agenda == 1) {


            let url = "../persona/index.php/api/persona/agendar_email/format/json/";
            let data_send = $(".form_agendar_correo_electronico").serialize() + "&" + $.param({id_persona: get_persona()});

            $.ajax({
                url: url,
                type: "POST",
                data: data_send,
                beforeSend: function () {
                    sload(".place_info_registro_agenda_correo", "Cargando ... ", 1);
                }
            }).done(function (data) {


                cargar_num_agendados_email();
                seccess_enid(".place_info_registro_agenda_correo", "Correo Agendado con éxito!");
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

let agenda_correo_usuario_registrado = (e) =>  {

    id_persona = get_parameter_enid($(this), "id");
    set_option("persona", id_persona);
    recorre_web_version_movil();
}