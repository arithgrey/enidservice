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
let editar_fecha_stock_disponible = function () {


    $ultima_fecha_disponible.empty();
    desbloqueda_form('form_fecha_stock');
    let $id = get_parameter_enid($(this), "id");

    let $muestra_fecha_disponible = $('.muestra_fecha_disponible');
    let $fecha_disponible = $('.fecha_disponible');

    let muestra_fecha_disponible = $muestra_fecha_disponible.val();
    if (parseInt(muestra_fecha_disponible) > 0) {

        let fecha_disponible = $fecha_disponible.val();
        let str = _text_('Ultima fecha señanada', fecha_disponible);
        $ultima_fecha_disponible.html(str)

    }


    if (parseInt($id) > 0) {
        $ocultar_fecha_stock.click(function () {
            oculta_fecha_stock($id);
        });

        $definir_feche_disponible.click(function () {
            definicion_disponibilidad($id);
        });

        $input_id_servicio.val($id);
        if (parseInt($id) > 0) {

            $stock_fecha_servicio_modal.remove('d-none');
            $stock_fecha_servicio_modal.modal("show");
            precio_pasado($id);
            $form_fecha_stock.find('.id_servicio').val($id);
            $form_fecha_stock.submit(agregar_fecha_servicio);
        }
    }

};
let oculta_fecha_stock = function (id) {

    let data_send = $.param({'id_servicio': id, 'muestra_fecha_disponible': 0});
    let url = "../q/index.php/api/servicio/stock_disponibilidad/format/json/";
    request_enid("PUT", data_send, url, response_form_stock_fecha);
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
let response_form_stock_fecha = function () {

    $stock_fecha_servicio_modal.modal("hide");
    carga_informacion_servicio(4);

};
let definicion_disponibilidad = function () {

    $opciones_definicion.addClass('d-none');
    $form_fecha_stock.removeClass('d-none');

};
let agregar_fecha_servicio = function (e) {

    let data_send = $form_fecha_stock.serialize();
    let url = "../q/index.php/api/servicio/stock_disponibilidad/format/json/";
    request_enid("PUT", data_send, url, response_form_stock_fecha);

    e.preventDefault();
};