"use strict";
let $registro_usuario = $('.registro_usuario');
let $registro_valoracion = $('.registro_valoracion');
let $recomendaria = $(".recomendaria");
let $text_recomendarias = $('text_recomendarias');
let $estrella = $(".estrella");
let $form_valoracion = $('.form_valoracion');
$(document).ready(() => {

    set_option("recomendaria", 3);
    set_option("calificacion", 5);
    $recomendaria.click(configura_recomendaria);
    $estrella.click(configura_calificacion);
    $form_valoracion.submit(registra_valoracion);
    $("footer").ready(evalua_propietario);


});
let configura_recomendaria = function (e) {

    set_option("recomendaria", parseInt(get_parameter_enid($(this), "id")));
    $recomendaria.css("color", "black");
    $(this).css("color", "blue");
    empty_elements(".place_recomendaria");

};
let configura_calificacion = function (e) {


    let calificacion = get_parameter_enid($(this), "id");
    set_option("calificacion", parseInt(calificacion));
    /*DEJAMOS EN BLANCO TODAS PARA INICIAR*/
    for (let i = 1; i <= 5; i++) {

        let estrella_ = ".estrella_" + i;
        $(estrella_).css("-webkit-text-fill-color", "white");
        $(estrella_).css("-webkit-text-stroke-color", "#004afc");
        $(estrella_).css("-webkit-text-stroke-width", ".5px");
    }
    /*AHORA PINTAMOS HASTA DONDE SE SEÑALA*/
    for (let i = 1; i <= get_option("calificacion"); i++) {

        let estrella_ = ".estrella_" + i;
        $(estrella_).css("-webkit-text-fill-color", "#004afc");
        $(estrella_).css("-webkit-text-stroke-color", "#004afc");

    }
};
let registra_valoracion = (e) => {

    let recomendaria = get_option("recomendaria");
    if (recomendaria == 3) {
        $text_recomendarias.addClass('color_red');
        recorre('.text_recomendarias');
    } else {
        if (recomendaria == 0 || recomendaria == 1) {

            $text_recomendarias.removeClass('color_red');
            $(".place_recomendaria").empty();
            let url = "../q/index.php/api/valoracion/index/format/json/";
            let data_send = $form_valoracion.serialize() + "&" + $.param({
                "calificacion": get_option("calificacion"),
                "recomendaria": recomendaria
            });
            request_enid("POST", data_send, url, response_registro_valoracion, 0, before_registro_valoracion);

        } else {

            $text_recomendarias.addClass('color_red');
        }
    }

    e.preventDefault();
};
let before_registro_valoracion = () => {
    sload(".place_registro_valoracion", "Validando datos ", 1);
    bloquea_form(".form_valoracion");
};
let response_registro_valoracion = (data) => {

    if (data.existencia_usuario == 0) {

        $registro_usuario.removeClass('d-none');

    } else {

        $registro_valoracion.removeClass('d-none');
    }
    recorre(".format_action");
};
let evalua_propietario = () => {
    //Si el propietario quisiera registrar una recomendación se bloquea
    if (get_parameter(".propietario") == 1) {
        bloquea_form(".form_valoracion");
    }
};

