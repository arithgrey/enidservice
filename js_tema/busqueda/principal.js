"use strict";
$(document).ready(() => {

    otras_conexiones();
    noticias();

});

let otras_conexiones = function () {

    let url = "../q/index.php/api/usuario_conexion/sugerencias/format/json/";
    let data_send = {tipo: get_parameter_enid($(this), "id")};
    request_enid("GET", data_send, url, function (data) {

        render_enid('.seccion_sugerencias', data);

        $(".descarte").click(descarte_conexion);
        $(".conexion").click(conexion);

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


let noticias = function () {

    let url = "../q/index.php/api/usuario_conexion/noticias_seguimiento/format/json/";
    let data_send = $.param({"v":1});
    request_enid("GET", data_send, url, function (data) {

        render_enid('.seccion_noticias', data);

    });
}
