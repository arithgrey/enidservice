let editar_stock_disponible = function () {

    desbloqueda_form('.form_stock_servicio');
    let $id = get_parameter_enid($(this), "id");
    if (parseInt($id) > 0) {
        $input_id_servicio.val($id);
        if (parseInt($id) > 0) {

            $selector_carga_modal.remove('d-none');
            $selector_carga_modal.modal("show");
            precio_pasado($id);

            $form_stock_servicio.submit(agregar_stock_servicio);
        }
    }

};
let precio_pasado = function ($id_servicio) {

    let data_send = $.param({'id_servicio': $id_servicio, 'costo': 1});
    let url = "../q/index.php/api/stock/servicio/format/json/";
    request_enid("GET", data_send, url, response_precio_pasado);
};
let response_precio_pasado = function (data) {
    $input_costo.val(data);
};
let agregar_stock_servicio = function (e) {

    let respuestas = [];
    let $es_stock = es_formato_cantidad($input_stock);
    respuestas.push($es_stock);

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
    carga_informacion_servicio(4);

};