"use strict";

let $ubicacion_delegacion = $('.ubicacion_delegacion');
let $adicionales_seccion = $(".adicionales_seccion");
let $modal_costo_entrega = $("#modal_costo_entrega");
let $modal_costo_entrega_alcaldia = $("#modal_costo_entrega_alcaldia");
let $form_costo_entrega_alcaldia = $(".form_costo_entrega_alcaldia");
let $costo_alcaldia = $(".costo_alcaldia");


$(document).ready(() => {

    $(".menu_notificaciones_progreso_dia").addClass("d-none");
    $(".drop-left-enid").addClass("d-none");
    $ubicacion_delegacion.change(busqueda_colonia_ubicacion);
    $costo_alcaldia.click(registra_costo_por_alcaldia);
    $form_costo_entrega_alcaldia.submit(registro_costos_alcaldia);
    carga_productos_sugeridos();
});
let busqueda_colonia_ubicacion = () => {

    let id_delegacion = $ubicacion_delegacion.val();
    if (parseInt(id_delegacion) > 0) {

        let $nombre = $(".ubicacion_delegacion option:selected").text();
        $(".text_delegacion").val($nombre);
        let url = "../q/index.php/api/colonia/delegacion_cotizador/format/json/";
        let data_send = { "delegacion": $nombre, 'auto': 1, "edicion": $(".es_administrador").val() };
        request_enid("GET", data_send, url, response_colonias);
    }

};
let response_colonias = (data) => {

    $(".place_colonia").removeClass("d-none");
    render_enid(".place_colonia", data);
    $(".costo_entrega_colonia").click(costo_entrega_colonia);

};

let costo_entrega_colonia = function (e) {

    let $id = parseInt(e.target.id);
    reset_form("form_costo_entrega");
    if ($id > 0) {


        let $colonia = get_parameter_enid($(this), "colonia");
        let $costo = get_parameter_enid($(this), "costo");

        $(".texto_costo").html(_text_("Costo actual", $costo, "MXN"));
        $(".texto_colonia").html(_text_($colonia));

        $(".id_codigo_postal").val(parseInt(e.target.id));
        $modal_costo_entrega.modal("show");
        $(".form_costo_entrega").submit(costo_entrega);
    }

}
let registra_costo_por_alcaldia = function () {

    $modal_costo_entrega_alcaldia.modal("show");
    reset_form("form_costo_entrega_alcaldia");

}
let costo_entrega = (e) => {

    let data_send = $(".form_costo_entrega").serialize();
    let url = "../q/index.php/api/codigo_postal/costo_entrega/format/json/";
    request_enid("PUT", data_send, url, response_actualizacion);

    e.preventDefault();
}
let registro_costos_alcaldia = (e) => {

    let $nombre = $(".alcaldia option:selected").text();
    let data_send = $form_costo_entrega_alcaldia.serialize() + "&" + $.param({ "nombre": $nombre });
    let url = "../q/index.php/api/codigo_postal/costo_entrega_alcaldia/format/json/";
    request_enid("PUT", data_send, url, response_actualizacion_alcaldia);

    e.preventDefault();

}
let response_actualizacion_alcaldia = (e) => {

    $modal_costo_entrega_alcaldia.modal("hide");    
    
    let $nombre = $(".alcaldia option:selected").text();    
    let url = "../q/index.php/api/colonia/delegacion_cotizador/format/json/";
    let data_send = { "delegacion": $nombre, 'auto': 1, "edicion": $(".es_administrador").val() };
    request_enid("GET", data_send, url, response_colonias);
}

let response_actualizacion = (e) => {

    $modal_costo_entrega.modal("hide");
    busqueda_colonia_ubicacion();
}

let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let q = get_parameter(".qservicio");
    let data_send = {"id_servicio": 1537};
    request_enid("GET", data_send, url, response_carga_productos);
};
let response_carga_productos = data => {

    if (data["sugerencias"] == undefined) {
        $('.sugerencias_titulo').removeClass('d-none');
        $(".text_interes").removeClass("hidden");
        render_enid(".place_tambien_podria_interezar", data);
        
        $('.agregar_deseos_sin_antecedente').click(agregar_deseos_sin_antecedente_gbl);
        $('.quitar_deseo_sin_antecedente').click(quitar_deseo_sin_antecedente_gbl);            
    }
};