"use strict";

$(document).ready(() => {

    otras_conexiones();
    noticias();

});

let otras_conexiones = function () {


    let url = "../q/index.php/api/usuario_conexion/sugerencias/format/json/";
    let $id_usuario = $(".id_usuario").val();
    let data_send = {id_usuario : $id_usuario};
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
    let data_send = $.param({"v": 1});
    request_enid("GET", data_send, url, function (data) {

        render_enid('.seccion_noticias', data);
        $(".like_actividad").click(like_actividad);

    });
}
let like_actividad = function (e) {

    let $id = e.target.id;
    let data_send = $.param({"id_recibo": $id});
    let url = "../q/index.php/api/venta_like/index/format/json/";
    request_enid("POST", data_send, url, response_like_actividad);
    e.preventDefault();

}
let response_like_actividad = function (data) {

}
