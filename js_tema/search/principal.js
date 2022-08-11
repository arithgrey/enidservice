"use strict";
/*Sin session*/
let $agregar_deseos_sin_antecedente = $('.agregar_deseos_sin_antecedente');
let $quitar_deseo_sin_antecedente = $('.quitar_deseo_sin_antecedente');

$(document).ready(() => {
    $(".order").change(filtro);
    $("footer").ready(carga_promociones_sugerencias);

    $agregar_deseos_sin_antecedente.click(agregar_deseos_sin_antecedente);
    $quitar_deseo_sin_antecedente.click(quitar_deseo_sin_antecedente);
    
});

let filtro = () => {

    let url_actual = window.location;
    let new_url = url_actual + "&order=" + get_parameter("#order option:selected");
    redirect(new_url);
};


let carga_promociones_sugerencias = () => {

    let url = "../q/index.php/api/recompensa/sugeridos/format/json/";
    let data_send = {"antecedente_compra": parseInt(get_option("in_session"))};
    request_enid("GET", data_send, url, function (data) {
        render_enid(".promociones_sugeridas", data);

        $(".bottom_carro_compra_recompensa").click(carro_compra_recompensa);


    });
};

let carro_compra_recompensa = function () {

    let $id = $(this).attr('id');
    let $antecedente_compra = $(this).attr('antecedente_compra');

    if (parseInt($id) > 0) {

        $("#modal-error-message").modal("show");

        let $selector_carga_modal = $('.cargando_modal');
        $selector_carga_modal.removeClass('d-none');
        $(".text-order-name-error").text("Procesando ...");
        $(this).addClass("d-none");
        let url = "../q/index.php/api/recompensa/deseo_compra/index/format/json/";
        let data_send = { "id": $id, "antecedente_compra": $antecedente_compra };
        request_enid("POST", data_send, url, response_deseo_compra_recompensa);


    }
}
let response_deseo_compra_recompensa = function (data) {
    $("#modal-error-message").modal("hide");
    redirect("../lista_deseos");

}

let agregar_deseos_sin_antecedente = function () {

    let $id_servicio = $(this).attr('id');
    $(_text(".por_agregar_", $id_servicio)).addClass("d-none");
    $(_text(".agregado_", $id_servicio)).removeClass("d-none");


    if (parseInt($id_servicio) > 0) {
        advierte('Agregado a tu lista de deseos!', 1);
        let data_send = { "id_servicio": $id_servicio, "articulos": 1 };

        if (parseInt(get_option("in_session")) > 0) {

            let url = "../q/index.php/api/usuario_deseo/lista_deseos/format/json/";
            request_enid("PUT", data_send, url, adicionales);

        } else {

            let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
            request_enid("POST", data_send, url, adicionales);
        }

    }
}
let quitar_deseo_sin_antecedente = function () {

    let $id_servicio = $(this).attr('id');
    $(_text(".por_agregar_", $id_servicio)).removeClass("d-none");
    $(_text(".agregado_", $id_servicio)).addClass("d-none");
    
    

    if (parseInt($id_servicio) > 0) {
        advierte('Lo sacamos de tu lista de deseos!', 1);
        let data_send = { "id_servicio": $id_servicio, "servicio" : $id_servicio};
        if (parseInt(get_option("in_session")) > 0) {

            /*En session*/
            let url = "../q/index.php/api/usuario_deseo/servicio/format/json/";            
            request_enid("DELETE", data_send, url, adicionales);


        } else {

            let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
            request_enid("DELETE", data_send, url, adicionales);

        }
    }
}
let adicionales = function () {
    metricas_perfil();
    cerrar_modal();

}

