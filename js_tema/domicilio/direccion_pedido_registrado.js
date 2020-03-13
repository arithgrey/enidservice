"use strict";
$(document).ready(() => {

    $('footer').addClass('d-none');
    $(".codigo_postal").keyup(auto_completa_direccion);
    $(".numero_exterior").keyup(() => quita_espacios(".numero_exterior"));
    $(".numero_interior").keyup(() => quita_espacios(".numero_interior"));
    $(".form_direccion_envio").submit(registra_nueva_direccion);

    if ($('.fecha_entrega').length) {

        $('.fecha_entrega').change(horarios_disponibles);
    }

});
let horarios_disponibles = () => {

    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = {"dia": $('.fecha_entrega').val()};
    request_enid("GET", data_send, url, response_horario);

};

let response_horario = (data) => {

    if (!isArray(data)) {
        render_enid(".horario_entrega", data);
    }
};