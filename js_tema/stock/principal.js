"use strict";
let $editar_fecha = $('.editar_fecha');
let $form_fecha_ingreso = $('.form_fecha_ingreso');
let $form_unidades_disponibles = $('.form_unidades_disponibles');
let $input_stock = $form_fecha_ingreso.find('.id_stock');
let $input_hora_fecha = $form_fecha_ingreso.find('.hora_fecha');
let $stock_unidades = $('.stock_unidades');
let $modal_form_calendario = $("#modal_form_calendario");
let $modal_unidades_disponibles = $('#modal_unidades_disponibles');
let $unidades_disponibles_select = $form_unidades_disponibles.find('.unidades');
let $input_stock_disponibilidad = $form_unidades_disponibles.find('.id_stock');
let $modal_cambio_almacen = $("#modal_cambio_almacen");
let $nombre_almacen_cambio = $(".nombre_almacen_cambio");
let $confirmar_stock = $(".confirmar_stock");

$(document).ready(function () {

    $editar_fecha.click(form_fecha);
    $stock_unidades.click(modifica_unidades_stock);
    $form_unidades_disponibles.submit(unidades_stock_stock);


    $(".draggable").draggable({
        drag: function (event, ui) {
            let id_almacen = $(this).attr("id_almacen");
            set_option("id_almacen", id_almacen);
            if ($(this).attr('id_kit') !== undefined) {

                let $id_kit = $(this).attr('id_kit');
                set_option("id_kit", $id_kit);

            } else {

                let id = $(this).attr("id");
                let piezas_disponibles = $(this).attr("piezas_disponibles");


                set_option("id_servicio", id);
                set_option("piezas_disponibles", piezas_disponibles);
                set_option("id_kit", 0);
            }

        }

    });
    $(".droppable").droppable({
        drop: function (event, ui) {

            let $id = $(this).attr("id");
            set_option("id_almacen_asignado", $id);

            if (parseInt(get_option("id_kit")) > 0) {

                asignacion_kit_a_almacen();

            } else {


                let $piezas_disponibles = get_option("piezas_disponibles");
                let $id_almacen = get_option("id_almacen");

                if ($id !== $id_almacen && $piezas_disponibles > 0) {

                    $modal_cambio_almacen.modal("show");
                    crear_select($piezas_disponibles);

                }


            }



        }
    });

    $confirmar_stock.click(asigan_stock_almacen);

});
let asigan_stock_almacen = function () {

    let $id_servicio = get_option("id_servicio");
    let $id_almacen_baja = get_option("id_almacen");
    let $id_almacen_asignado = get_option("id_almacen_asignado");


    let data_send = $.param({
        "id_servicio": $id_servicio,
        "id_almacen_baja": $id_almacen_baja,
        "id_almacen_asignado": $id_almacen_asignado,
        "cantidad": get_valor_selected(".piezas_disponibles")
    });


    $(".confirmar_stock").prop("disabled", true);
    let url = "../q/index.php/api/stock/almacen/format/json/";
    $modal_cambio_almacen.modal("hide");
    request_enid("POST", data_send, url, response_asiganacion_almacen);



}
let response_asiganacion_almacen = function (data) {

    redirect("");
}
let crear_select = function (numeroOpciones) {

    var select = $("<select class='select_disponibles piezas_disponibles'>");
    for (var i = 1; i <= numeroOpciones; i++) {
        var opcion = $("<option value='" + i + "'>").text(i);
        select.append(opcion);
    }

    $(".place_disponibilidad").html(select);
}
let form_fecha = function (e) {

    let $id_stock = get_parameter_enid($(this), "id");
    let $fecha_registro = get_parameter_enid($(this), "fecha_registro");
    if (parseInt($id_stock) > 0) {

        $input_hora_fecha.val($fecha_registro);
        $input_stock.val($id_stock);
        $modal_form_calendario.modal("show");
        $form_fecha_ingreso.submit(fecha_ingreso);
    }


};
let modifica_unidades_stock = function (e) {

    let $unidades_disponibles = get_parameter_enid($(this), "unidades_disponibles");
    let $id = get_parameter_enid($(this), "id");

    $unidades_disponibles_select.find('option').remove();
    for (let x = 0; x <= 100; x++) {
        $unidades_disponibles_select.append(new Option(x, x));
    }

    $modal_unidades_disponibles.modal("show");
    let select = '.form_unidades_disponibles .unidades';
    $input_stock_disponibilidad.val($id);
    selecciona_valor_select(select, $unidades_disponibles);
};
let fecha_ingreso = function (e) {


    let url = "../q/index.php/api/stock/fecha_ingreso/format/json/";
    let data_send = $form_fecha_ingreso.serialize();
    bloquea_form('.form_fecha_ingreso');
    request_enid("PUT", data_send, url, response_fecha_ingreso);

    e.preventDefault();
};
let response_fecha_ingreso = function (data) {

    redirect('');
};
let unidades_stock_stock = function (e) {

    let $id_stock = $input_stock_disponibilidad.val();
    if (parseInt($id_stock) > 0) {
        let url = "../q/index.php/api/stock/descuento/format/json/";
        let data_send = $form_unidades_disponibles.serialize();
        bloquea_form('.form_unidades_disponibles');
        request_enid("PUT", data_send, url, response_unidades);
    }

    e.preventDefault();
};
let response_unidades = function (data) {

    redirect('');
};
let asignacion_kit_a_almacen = function () {

    let $id_kit = get_option("id_kit");
    let $id_almacen_baja = get_option("id_almacen");
    let $id_almacen_asignado = get_option("id_almacen_asignado");
    

    
    let data_send = $.param({
        "id_kit": $id_kit,
        "id_almacen_baja": $id_almacen_baja,
        "id_almacen_asignado": $id_almacen_asignado,        
    });
    
    let url = "../q/index.php/api/stock/almacen_kit/format/json/";
 
    request_enid("POST", data_send, url, response_asiganacion_almacen);
}