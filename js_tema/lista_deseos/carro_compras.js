set_option("check", 1);
let $texto_seleccionar = $(".texto_seleccionar");
let $texto_deseleccionar = $(".texto_deseleccionar");
let $seleccion_producto_carro_compra = $(".seleccion_producto_carro_compra");
let $carro_compras_total = $(".carro_compras_total");
let $subtotal_carrito = $(".subtotal_carrito");
let $seccion_enviar_orden = $(".seccion_enviar_orden");
let $form_segunda_compra = $(".form_segunda_compra");

$(document).ready(function () {

    $('.cantidad_articulos_deseados').change(modifica_cantidad_articulos_deseados);
    $texto_deseleccionar.click(deseleccionar);
    $texto_seleccionar.click(seleccionar);
    $seleccion_producto_carro_compra.click(check_producto_carro_compra);
    $form_segunda_compra.submit(segunda_compra);
});

let segunda_compra = function (e) {

    e.preventDefault();

    let $data_send = $form_segunda_compra.serialize();
    let url = "../q/index.php/api/cobranza/siguiente_compra/format/json/";
    request_enid("POST", $data_send, url, response_segunda_compra);

}
let response_segunda_compra = function (data) {

    if (data.hasOwnProperty('id_orden_compra') && parseInt(data.id_orden_compra) > 0) {

        let id = data.id_orden_compra;

        redirect(_text("../pedidos/?seguimiento=", id, "&domicilio=1&asignacion_horario_entrega=1"))

    }

}
let modifica_cantidad_articulos_deseados = function () {

    let $cantidad = $(this).val();
    let $id = $(this).attr("identificador");

    if ($cantidad > 0) {

        let url = "../q/index.php/api/usuario_deseo/cantidad/format/json/";
        let data_send = {"id": $id, "cantidad": $cantidad};
        request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");
    }


}

let cancela_productos = id => {

    let url = "../q/index.php/api/usuario_deseo/status/format/json/";
    let data_send = {"id": id, "status": 2};
    request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");

};

let cancela_productos_deseados = id => {

    let url = "../q/index.php/api/usuario_deseo_compra/id/format/json/";
    let data_send = {"id": id, "status": 2};
    request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");

};

let deseleccionar = () => {


    $texto_seleccionar.removeClass("d-none");
    $texto_deseleccionar.addClass("d-none");
    let $seleccion_producto_carro_compra = $(".seleccion_producto_carro_compra");
    $seleccion_producto_carro_compra.each(function () {
        $(this).prop('checked', false);

        let $id = $(this).val();
        let $identificador = _text(".producto_", $id);
        $($identificador).remove();

    });

}
let seleccionar = () => {

    $texto_seleccionar.addClass("d-none");
    $texto_deseleccionar.removeClass("d-none");

    let $seleccion_producto_carro_compra = $(".seleccion_producto_carro_compra");
    $seleccion_producto_carro_compra.each(function () {

        $(this).prop('checked', true);

        let $id = $(this).val();
        let $class = _text("producto_", $id);
        let $identificador = _text(".producto_", $id);
        $($identificador).remove();

        let $name = "producto_carro_compra[]";
        let $input = $("<input type=\"hidden\" " +
            "class=\"" + $class + "\" " +
            "value=\"" + $id + "\"" + " name=\"" + $name + "\" />");

        $(".form_pre_pedido").append($input);


    });

}
let check_producto_carro_compra = function () {

    let $id = this.value;
    let $identificador = _text(".producto_", $id);
    let $class = _text("producto_", $id);
    let $total = $(this).attr("total");
    $total = parseFloat($total);
    let $subtotal_carro_compras = parseFloat($carro_compras_total.val());

    if ($(this).is(":checked")) {

        let $name = "producto_carro_compra[]";
        let $input = $("<input type=\"hidden\" " +
            "class=\"" + $class + "\" " +
            "value=\"" + $id + "\"" + " name=\"" + $name + "\" />");

        $(".form_pre_pedido").append($input);
        let $nuevo_subtotal = $subtotal_carro_compras + $total;
        $carro_compras_total.val($nuevo_subtotal);
        $subtotal_carrito.text(_text_($nuevo_subtotal, 'MXN'));
        if ($nuevo_subtotal > 0) {
            $seccion_enviar_orden.removeClass("d-none");
        }


    } else {

        let $nuevo_subtotal = $subtotal_carro_compras - $total;
        $carro_compras_total.val($nuevo_subtotal);
        $subtotal_carrito.text(_text($nuevo_subtotal, 'MXN'));
        $($identificador).remove();

        if ($nuevo_subtotal < 1) {
            $seccion_enviar_orden.addClass("d-none");
        }

    }


}

let response_carga_productos = (data) => redirect("");

