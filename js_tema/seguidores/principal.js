"use strict";
let $siguiendo = $(".siguiendo");
let $seccion_usuarios_seguimiento = $(".seccion_usuarios_seguimiento");
let $seccion_usuarios_seguidores = $(".seccion_usuarios_seguidores");

let $boton_siguiendo = $(".boton_siguiendo");
let $boton_seguidores = $(".boton_seguidores");

let $form_dejar_seguimiento = $(".form_dejar_seguimiento");
$(document).ready(() => {

    $siguiendo.click(dejar_seguimiento);
    $boton_siguiendo.click(seleccionar_siguiendo);
    $boton_seguidores.click(seleccionar_seguidores);
    $form_dejar_seguimiento.submit(quitar_seguimiento);


});
let seleccionar_seguidores = function () {

    $seccion_usuarios_seguimiento.addClass("d-none");
    $boton_seguidores.addClass("solid_bottom_2");
    $boton_siguiendo.removeClass("solid_bottom_2");
    $seccion_usuarios_seguidores.removeClass("d-none");

}

let seleccionar_siguiendo = function () {

    $seccion_usuarios_seguimiento.removeClass("d-none");
    $boton_seguidores.removeClass("solid_bottom_2");
    $boton_siguiendo.addClass("solid_bottom_2");
    $seccion_usuarios_seguidores.addClass("d-none");
}
let dejar_seguimiento = function (e) {

    let $id = e.target.id;

    $form_dejar_seguimiento.find(".usuario_conexion").val($id);
    show_confirm(
        "¿DEJAR DE SEGUIR?",
        "",
        "Confirmar", confirmacion_dejar_seguimiento);

}
let confirmacion_dejar_seguimiento = function ($id) {

    $form_dejar_seguimiento.submit();
}
let quitar_seguimiento = function (e) {

    e.preventDefault();
    let url = "../q/index.php/api/usuario_conexion/quitar_seguimiento/format/json/";
    let data_send = $form_dejar_seguimiento.serialize();
    request_enid("PUT", data_send, url, response_quitar_seguimiento);

}
let response_quitar_seguimiento = function (data){

    redirect("");
}
