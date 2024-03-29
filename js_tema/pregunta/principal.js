"use strict";
$(document).ready(() => {

    set_option("recomendaria", 3);
    set_option("calificacion", 5);
    set_option("servicio", $(".servicio").val());
    set_option("respuesta_valorada", 0);
    $(".form_valoracion").submit(registra_valoracion);

    if (get_parameter(".propietario") == 1) {
        bloquea_form(".form_valoracion");
    }
    $("footer").ready(carga_productos_sugeridos);
    $("footer").ready(carga_valoraciones);

});

let registra_valoracion = (e) => {

    let flag = val_text_form("#pregunta", ".place_area_pregunta", 5, "Pregunta");
    if (flag == 1) {

        let url = "../q/index.php/api/pregunta/index/format/json/";
        let data_send = $(".form_valoracion").serialize();

        $(".registro_pregunta").show();
        $(".place_registro_valoracion").empty();
        recorre(".place_valoraciones");
        bloquea_form(".form_valoracion");
        request_enid("POST", data_send, url, response_registro_valoracion, ".place_registro_valoracion");
    }
    e.preventDefault();
};

let response_registro_valoracion = data => {

    let fn = (data > 0) ? redirect("../pregunta/?action=hechas&id=" + data + "&#pregunta86") : "";

};

let before_registro_valoracion = () => {

    bloquea_form(".form_valoracion");
};

let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let data_send = {"id_servicio": get_option("servicio")};
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

let carga_valoraciones = () => {

    let url = "../q/index.php/api/valoracion/articulo/format/json/";
    let data_send = {
        "id_servicio": get_option("servicio"),
        "respuesta_valorada": get_option("respuesta_valorada"),

    };
    request_enid("GET", data_send, url, response_carga_valoraciones, ".place_registro_afiliado");
};

let response_carga_valoraciones = (data) => {

    render_enid(".place_valoraciones", data);
    if (get_option("desde_valoracion") == 1) {
        recorre(".place_valoraciones");
        set_option("desde_valoracion", 0);

    }
    $(".ordenar_valoraciones_button").click(ordenar_valoraciones);
    let valoracion_persona = $(".contenedor_promedios").html();
    render_enid(".valoracion_persona", valoracion_persona);

};

let ordenar_valoraciones = function (e) {

    let tipo_ordenamiento = get_parameter_enid($(this), "id");
    let div = $(".contenedor_global_recomendaciones");
    let listitems = div.children('.contenedor_valoracion_info').get();
    switch (parseInt(tipo_ordenamiento)) {
        case 0:
            /*Ordenamos por los que tienen más votos*/
            listitems.sort(function (a, b) {

                return (+$(a).attr('numero_utilidad') > +$(b).attr('numero_utilidad')) ?
                    -1 : (+$(a).attr('numero_utilidad') < +$(b).attr('numero_utilidad')) ?
                        1 : 0;

            });
            render_enid(".contenedor_global_recomendaciones", listitems);
            set_option("orden", "asc");
            break;

        case 1:

            listitems.sort(function (a, b) {

                return (+$(a).attr('fecha_info_registro') > +$(b).attr('fecha_info_registro')) ?
                    -1 : (+$(a).attr('fecha_info_registro') < +$(b).attr('fecha_info_registro')) ?
                        1 : 0;

            });
            render_enid(".contenedor_global_recomendaciones", listitems);
            break;

        case 2:

            break;
        default:
    }
};