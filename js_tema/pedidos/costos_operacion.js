$(document).ready(() => {
    $('.costo_operativo').keyup(envia_costo_operativo);
    $(".form_costos").submit(registro_costo_operativo);
    valida_pago_comision();
    $('.select_gastos').change(valida_pago_comision);
});
let registro_costo_operativo = e => {

    let data_send = $(".form_costos").serialize();
    let url = "../q/index.php/api/costo_operacion/index/format/json/";
    bloquea_form(".form_costos");
    request_enid("POST", data_send, url, response_costo, ".notificacion_registro_costo");
    e.preventDefault();
};
let response_costo = data => {

    if (data.num > 0) {

        desbloqueda_form(".form_costos");
        advierte("Ya registraste un costos de operación de este tipo!");

    } else {

        $(".notificacion_registro_costo").empty();
        redirect("");
    }

};
let muestra_formulario_costo = () => {

    showonehideone(".contenedor_form_costos_operacion", ".contenedor_costos_registrados");
    $('.link_agregar').addClass('d-none').removeClass('d-block');

};
let valida_pago_comision = function () {

    let $tipo_costo = get_valor_selected('.select_gastos');
    let costo_comision_venta = $('.costo_comision_venta').val();
    if (parseInt($tipo_costo) == 12) {

        $('.costo_operativo').val(costo_comision_venta);
    }
    verifica_formato_default_inputs();
};
let envia_costo_operativo = function (e) {
    let code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13 && $('.costo_operativo').val() > 0) {
        $(".form_costos").submit();
    }
};
let confirma_eliminar_concepto = id => {

    show_confirm("¿Seguro deseas eliminar este concepto?", "", "Eliminar", function () {

        elimina_costo_operacion(id);
    });
};
let elimina_costo_operacion = id => {

    let data_send = $.param({"id": id});
    let url = "../q/index.php/api/costo_operacion/index/format/json/";
    request_enid("DELETE", data_send, url, function () {
        redirect("");
    });

};