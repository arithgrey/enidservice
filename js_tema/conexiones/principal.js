"use strict";
$(document).ready(() => {

    otras_conexiones();
    $(".otras_cuentas").click(otras_cuentas);

});

let otras_cuentas = function () {

    $(".seccion_sugerencias_disponibles").removeClass('d-none');
    $(".otras_cuentas").addClass("d-none");
    $(".link_estadisticas").removeClass("d-none");
}
let otras_conexiones = function () {

    let url = "../q/index.php/api/usuario_conexion/sugerencias/format/json/";
    let data_send = {tipo: get_parameter_enid($(this), "id")};
    request_enid("GET", data_send, url, function (data) {

        render_enid('.seccion_sugerencias', data);

        $(".descarte").click(descarte_conexion);
        $(".conexion").click(conexion);
        $(".titulo_otras_cuentas").addClass('d-none');

    });
}

let descarte_conexion = function (e) {

    let $id = e.target.id;
    let data_send = $.param({"id_usuario": $id, "status": 0});
    let url = "../q/index.php/api/usuario_conexion/index/format/json/";
    request_enid("POST", data_send, url, function () {
        otras_conexiones();
    });

    e.preventDefault();
}
let conexion = function (e) {

    let $id = e.target.id;
    let data_send = $.param({"id_usuario": $id, "status": 1});
    let url = "../q/index.php/api/usuario_conexion/index/format/json/";
    request_enid("POST", data_send, url, function () {
        otras_conexiones();
    });

    e.preventDefault();
}
