let editar_stock_disponible = function () {

    desbloqueda_form('.form_stock_servicio');
    let $id = get_parameter_enid($(this), "id");
    if (parseInt($id) > 0) {
        $input_id_servicio.val($id);
        if (parseInt($id) > 0) {

            $selector_carga_modal.remove('d-none');
            $selector_carga_modal.modal("show");
            $form_stock_servicio.submit(agregar_stock_servicio);
        }
    }

};

let agregar_stock_servicio = function (e) {

    let respuestas = [];
    let $es_stock= es_formato_cantidad($input_stock);
    respuestas.push($es_stock);
    if ($es_stock){

        $('.input_costo_producto_stock').removeClass('d-none');
        $('.input_unidades_producto_stock').addClass('d-none');
    }

    respuestas.push(es_formato_cantidad($input_costo));
    let $tiene_formato = (!respuestas.includes(false));


    if ($tiene_formato) {

        let data_send = $form_stock_servicio.serialize();
        let url = "../q/index.php/api/stock/ingresos/format/json/";
        bloquea_form('.form_stock_servicio');
        request_enid("POST", data_send, url, response_form_stock_registro);
    }

    e.preventDefault();
};

let response_form_stock_registro = function () {

    $selector_carga_modal.modal("hide");
    $input_costo.val(0);
    $input_stock.val(0);
    $('.input_costo_producto_stock').addClass('d-none');
    $('.input_unidades_producto_stock').removeClass('d-none');
    carga_informacion_servicio(4);

};