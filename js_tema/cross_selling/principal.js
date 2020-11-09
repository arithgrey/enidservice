"use strict";
let $modal_opciones_reventa = $('#modal_opciones_reventa');
let $servicio_sugerencia = $('.servicio_sugerencia');
let $servicio_intento_reventa = $('.servicio_intento_reventa');
let $id_usuario_cliente = $('.id_usuario_cliente');
let $id_servicio_relacion = $('.id_servicio_relacion');
let $selector_sugerido = $('.selector_sugerido');
let $marcar_sugerencia_seccion = $(".marcar_sugerencia_seccion");
let $total_seleccion = 0;

$(document).ready(() => {

    $servicio_sugerencia.click(opciones_reventa);
    $servicio_intento_reventa.click(marcar_intento_reventa);
    $selector_sugerido.click(marca_selector_sugerido);
    $marcar_sugerencia_seccion.click(enviar_productos_sugerencias);

});

let opciones_reventa = function () {

    let $id = $(this).attr("id");

    if (parseInt($id) > 0) {

        $id_servicio_relacion.val($id);
        $modal_opciones_reventa.modal('show');

    }

};
let marcar_intento_reventa = function () {


    let $id_usuario = $id_usuario_cliente.val();
    let url = "../q/index.php/api/usuario_servicio_propuesta/index/format/json/";
    let data_send = {'id_usuario': $id_usuario, 'id_servicio': $id_servicio_relacion.val()};
    $modal_opciones_reventa.modal('hide');
    modal('Notificando ...', 1);
    request_enid("POST", data_send, url, response_intento_reventa);


}
let marca_selector_sugerido = function () {

    let $a =0;
    for (let x in $selector_sugerido){
        let $item = $selector_sugerido[x];
        if ($item.checked){
            $a ++;
        }
    }

    if ($a > 0 ){

        $marcar_sugerencia_seccion.removeClass('d-none');

    }else{

        $marcar_sugerencia_seccion.addClass('d-none');
    }

}

let response_intento_reventa = function (data) {

    redirect(path_enid('reventa'));
}
let enviar_productos_sugerencias = function (){


    let ids  =  [];
    for (let x in $selector_sugerido){
        let $item = $selector_sugerido[x];
        if ($item.checked){
             let id = $item.id;
             ids.push(id);
        }
    }


    if (ids.length > 0){


        let $id_usuario = $id_usuario_cliente.val();
        let url = "../q/index.php/api/usuario_servicio_propuesta/ids/format/json/";
        let data_send = {'id_usuario': $id_usuario, 'ids': ids};
        $modal_opciones_reventa.modal('hide');
        modal('Notificando ...', 1);
        request_enid("POST", data_send, url, response_intento_reventa);


    }


}