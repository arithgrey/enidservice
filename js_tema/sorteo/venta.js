"use strict";
$(document).ready(() => {

    $('.agregar_deseos_sin_antecedente').click(agregar_deseo_sorteo);
    $('.usuario_compra_ticket').click(ver_usuario_compra_ticket);
    valida_ticket_boleto();

});

let agregar_deseo_sorteo = function () {

    let $id_servicio = $(this).attr('id');
    let $numero_boleto = $(this).attr('numero_boleto');
    $numero_boleto = parseInt($numero_boleto);

    if ($numero_boleto > 0) {
        let $clase_boleto_append = _text('numero_boleto_apartado_', $numero_boleto);

        if (!$(this).hasClass("apartado")) {


            $(this).addClass("bg_black white apartado");
            if (parseInt($id_servicio) > 0) {

                $(".enviar_orden").removeClass('d-none');
                $(".simular_compra").addClass('d-none');

                let $boleto_append = d(_text_('Ticket número', $numero_boleto), 'borde_end mt-2 p-2 mb-2', $clase_boleto_append);
                $(".tickets_apartados").append($boleto_append);

                let data_send = { "id_servicio": $id_servicio, "articulos": 1, "numero_boleto": $numero_boleto };

                if (parseInt(get_option("in_session")) > 0) {

                    let url = "../q/index.php/api/usuario_deseo/lista_deseos/format/json/";
                    request_enid("PUT", data_send, url, adicionales);

                } else {

                    let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
                    request_enid("POST", data_send, url, adicionales);
                }
            }

        } else {

            $(this).removeClass("bg_black white apartado");
            $(_text("#", $clase_boleto_append)).remove();
            let data_send = { "id_servicio": $id_servicio, "numero_boleto": $numero_boleto };

            if (parseInt(get_option("in_session")) > 0) {

                let url = "../q/index.php/api/usuario_deseo/lista_deseos_boleto/format/json/";
                request_enid("DELETE", data_send, url, adicionales);

            } else {

                let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
                request_enid("DELETE", data_send, url, adicionales);
            }

        }

    }


}
let adicionales = function () {
    metricas_perfil();
    cerrar_modal();

}
let ver_usuario_compra_ticket = function () {


    let $usuario_compra = $(this).attr('usuario_compra');
    let $numero_boleto = $(this).attr('numero_boleto');   

    if (parseInt($usuario_compra) > 0) {
        
        $("#modal_usuario_compra").modal('show');
        $(".nombre_comprador").text("");
        $(".telefono_comprador").text("");
        $(".place_numero_boleto").text($numero_boleto);
        let url = "../q/index.php/api/usuario/q/format/json/";
        let data_send = {"id_usuario": $usuario_compra};
        request_enid("GET", data_send, url, response_usuario_compra_ticket);     

    }

};

let response_usuario_compra_ticket =  function(data){

    
    data = data[0];
    let nombre = data.name;
    let tel_contacto = data.tel_contacto;
    $(".nombre_comprador").text(nombre);
    $(".telefono_comprador").text(tel_contacto);

}
let valida_ticket_boleto = function(){

    let $boleto_comprado = $(".boleto_comprado").val();
    let $sorteo = $(".numero_sorteo").val();
    

    if(parseInt($boleto_comprado) > 0 && parseInt($sorteo) > 0 ){

        let url = "../q/index.php/api/servicio_sorteo/usuario_boleto/format/json/";
        let data_send = {"boleto": $boleto_comprado, "sorteo": $sorteo};
        request_enid("GET", data_send, url, response_usuario_compra_ticket);     
        $("#modal_usuario_compra").modal('show');
        $(".place_numero_boleto").text($boleto_comprado);

        
    }

}