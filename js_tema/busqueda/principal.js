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

let nuevos_ingresos = function () {
    
    let url = "../q/index.php/api/usuario_conexion/nuevos_ingresos/format/json/";
    let $id_usuario = $(".id_usuario").val();
    let data_send = {id_usuario : $id_usuario};
    request_enid("GET", data_send, url, function (data) {

        render_enid('.seccion_nuevos_ingresos', data);

        $(".descarte_nuevo_ingreso").click(descarte_conexion_nuevo_ingreso);
        $(".conexion_nuevo_ingreso").click(conexion_nuevo_ingreso);

    });
}

let descarte_conexion_nuevo_ingreso = function (e) {

    let $id = e.target.id;
    let data_send = $.param({"id_usuario": $id, "status": 0});
    let url = "../q/index.php/api/usuario_conexion/index/format/json/";
    request_enid("POST", data_send, url, function () {
        nuevos_ingresos();
    });

    e.preventDefault();
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

let conexion_nuevo_ingreso = function (e) {

    let $id = e.target.id;
    let data_send = $.param({"id_usuario": $id, "status": 1});
    let url = "../q/index.php/api/usuario_conexion/index/format/json/";
    request_enid("POST", data_send, url, function () {
        nuevos_ingresos();
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
        nuevos_ingresos();
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

    redirect("");
}
