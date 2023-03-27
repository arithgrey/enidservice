"use strict";
let $num_ciclos = $('#num_ciclos');
let $se_agrego = $('.se_agrego');
let $se_agregara = $('.se_agregara');
let $bottom_carro_compra_recompensa = $(".bottom_carro_compra_recompensa");
let $costos_precios_servicio = $(".costos_precios_servicio");
let $form_precio = $(".form_precio");
let $form_costo = $(".form_costo");
let $en_lista_deseos = $(".en_lista_deseos");
let $ubicacion_delegacion = $(".ubicacion_delegacion");

$(document).ready(function () {

    $(".productos_en_carro_compra").removeClass("d-none");
    $(".agregar_a_lista_deseos").click(agregar_a_lista_deseos);
    
    $en_lista_deseos.click(function () {

        $(".en_lista_deseos_producto").val(1);
    });

    $('.agregar_deseos_sin_antecedente').click(agregar_deseos_sin_antecedente_gbl);
    $('.quitar_deseo_sin_antecedente').click(quitar_deseo_sin_antecedente_gbl);


});

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


let agregar_a_lista_deseos = () => {

    let $numero_articulos = get_valor_selected("#num_ciclos");
    if ($numero_articulos > 0) {

        $(".cargando").removeClass("d-none");
        $se_agrego.removeClass('d-none');
        $se_agregara.addClass('d-none');
        let url = "../q/index.php/api/usuario_deseo/lista_deseos/format/json/";
        let data_send = { "id_servicio": get_option("servicio"), "articulos": $numero_articulos };
        request_enid("PUT", data_send, url, respuesta_add_valoracion);

    }
};

let respuesta_add_valoracion = data => {

    redirect("../lista_deseos");

};

let agregar_deseos = function () {

    let $id_servicio = $(this).attr('id');

    if (parseInt($id_servicio) > 0) {

        let $articulos = $num_ciclos.val();
        let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
        let data_send = { "id_servicio": $id_servicio, "articulos": $articulos };
        request_enid("POST", data_send, url, respuesta_add_valoracion);
    }
}

