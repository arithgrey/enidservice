set_option("check", 1);
let $texto_seleccionar = $(".texto_seleccionar");
let $texto_deseleccionar = $(".texto_deseleccionar");
let $seleccion_producto_carro_compra = $(".seleccion_producto_carro_compra");
let $carro_compras_total = $(".carro_compras_total");
let $subtotal_carrito = $(".subtotal_carrito");
let $seccion_enviar_orden = $(".seccion_enviar_orden");
let $form_segunda_compra = $(".form_segunda_compra");
let $cobro_monto_mayor = $(".cobro_monto_mayor");
let $cobro_secundario = $(".cobro_secundario");
let $cobro_texto = $(".cobro_texto");
let $cobro_visible = $(".cobro_visible");
let $texto_comision_venta = $(".texto_comision_venta");


$(document).ready(function () {

    $(".cupon_seccion_footer").removeClass("d-block").addClass("d-none");
    $(".seccion_menu_comunes").removeClass("d-block").addClass("d-none");
    $(".barra_categorias_ab").removeClass("d-block").addClass("d-none");
    $('.cantidad_articulos_deseados').change(modifica_cantidad_articulos_deseados);
    $texto_deseleccionar.click(deseleccionar);
    $texto_seleccionar.click(seleccionar);
    $seleccion_producto_carro_compra.click(check_producto_carro_compra);
    $cobro_monto_mayor.click(cobro_monto_mayor);
    $form_segunda_compra.submit(segunda_compra);
    $cobro_secundario.keyup(cobro_secundario);
    $('#sticky-footer').addClass("d-none");
    $("footer").ready(log_intento_conversion);


});
let log_intento_conversion = function () {

    let $en_carro = $(".en_carro").val();
    if(parseInt($en_carro) > 0){

        let $ip = $(".ip_referer_enid").val();    
        let url = "../q/index.php/api/intento_conversion/index/format/json/";
        let data_send = {
            "in_session": get_option("in_session"),                    
            "ip" : $ip,
        };
    
        request_enid("POST", data_send, url, response_log_conversion);
    }
    
}
let response_log_conversion = function (data) {
    
    
    if(parseInt(data) > 0){

        $(".total_con_descuento_conversion").removeClass("d-none");
        $(".total_sin_descuento").addClass("d-none");

    }    
}

let segunda_compra = function (e) {

    e.preventDefault();

    let $data_send = $form_segunda_compra.serialize();
    let url = "../q/index.php/api/cobranza/siguiente_compra/format/json/";
    request_enid("POST", $data_send, url, response_segunda_compra);

}
let response_segunda_compra = function (data) {

    if (data.hasOwnProperty('id_orden_compra') && parseInt(data.id_orden_compra) > 0) {

        let id = data.id_orden_compra;

        redirect(path_enid("procesar_ubicacion",id));

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
    debugger;
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
let cobro_monto_mayor = function(){



    if (parseFloat($cobro_visible.val()) >  0) {

        $cobro_secundario.addClass("d-none");
        $cobro_texto.addClass("border-bottom");
        $cobro_visible.val(0);

    }else{

        $cobro_secundario.removeClass("d-none");
        $cobro_texto.removeClass("border-bottom");    
        $cobro_visible.val(1);
    }
    

}

let cobro_secundario = function(e){

    let $form_pre_pedido =  $(".form_pre_pedido");
    escucha_submmit_selector(e, $form_pre_pedido, 1);

    let $cobro = parseFloat($(this).val());
    let $comision = parseFloat($(".comision_venta").val());
    let $monto_por_cobrar = parseFloat($carro_compras_total.val());
    
    if ($monto_por_cobrar < $cobro ) {

        let $diferencia = ($cobro - $monto_por_cobrar);

        if ($diferencia >= 0 ) {
            
            let $nueva_comision = $comision + $diferencia;    
            $texto_comision_venta.text(_text($nueva_comision,'MXN'));

        }
    
    }else{

        $texto_comision_venta.text(_text($comision,'MXN'));

    }
}

let response_carga_productos = (data) => redirect("");
