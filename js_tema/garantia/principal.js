let $id_ticket = $('.ticket');
let $form_garantia = $(".form_garantia");
$(document).ready(() => {
    
    $form_garantia.submit(envio_garantia);    
    ticket();
    carga_productos_sugeridos();

});

let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let data_send = {"id_servicio": 541};
    request_enid("GET", data_send, url, response_carga_productos_sugeridos, ".place_tambien_podria_interezar");
};

let response_carga_productos_sugeridos = (data) => {

    $(".place_tambien_podria_interezar").empty();
    if (data.sugerencias == undefined && data.sugerencias != 0) {

        render_enid(".place_tambien_podria_interezar", data);
        $('.agregar_deseos_sin_antecedente').click(agregar_deseos_sin_antecedente_gbl);
        $('.quitar_deseo_sin_antecedente').click(quitar_deseo_sin_antecedente_gbl);            
    }
};

let ticket = function () {

    let id_recibo = get_parameter_enid($(this), "id");
    if (id_recibo == undefined) {
        id_recibo = ($id_ticket.val() != undefined) ? $id_ticket.val() : get_option("id_recibo");
    }

    if (id_recibo > 0) {
        set_option("id_recibo", id_recibo);
        let url = "../q/index.php/api/recibo/resumen_desglose_pago/format/json/";
        let data_send = { "id_orden_compra": get_option("id_recibo"), "cobranza": 1 };
        request_enid("GET", data_send, url, response_desglose);
    }
};
let response_desglose = data => {


    $(".resumen_pagos_pendientes").tab("show");
    render_enid(".place_resumen_servicio", data);
    $(".seccion_pago").addClass("d-none");
    $(".seccion_resumen_compra").removeClass("col-sm-7").addClass("col-sm-12");
    $(".adicionales_venta").addClass("d-none");


};
let envio_garantia = function(e){

    advierte('Procesando ...', 1);
    let data_send = $form_garantia.serialize();    
    bloquea_form(".form_garantia");
    let url = "../q/index.php/api/tickets/garantia/format/json/";
    request_enid("PUT", data_send, url, function (data) {
        
        cerrar_modal();
        $(".notifcacion_garantia").removeClass("d-none");
        $(".seccion_compra").addClass("d-none");
        recorre(".notifcacion_garantia");

        
    });

    e.preventDefault();
}