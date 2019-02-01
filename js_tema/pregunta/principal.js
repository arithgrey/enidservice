"use strict";
$(document).ready(function () {

    set_option("recomendaria", 3);
    set_option("calificacion", 5);
    set_option("servicio", $(".servicio").val());
    set_option("respuesta_valorada", 0);
    $(".form_valoracion").submit(registra_valoracion);

    let envio_pregunta = get_parameter(".envio_pregunta");
    if (envio_pregunta != 1) {
        bloquea_form(".form_valoracion");
        $(".contenedor_registro").show();
    }
    if (get_parameter(".propietario") == 1) {
        bloquea_form(".form_valoracion");
    }
    $("footer").ready(carga_productos_sugeridos);
    $("footer").ready(carga_valoraciones);

});

let registra_valoracion = function(e) {

    let flag = valida_text_form("#pregunta", ".place_area_pregunta", 5, "Pregunta");
    if (flag == 1) {
        let url = "../q/index.php/api/pregunta/index/format/json/";
        let data_send = $(".form_valoracion").serialize();
        request_enid("POST", data_send, url, response_registro_valoracion, ".place_registro_valoracion");
    }
    e.preventDefault();
}

let response_registro_valoracion = function(data) {


    if (data == 1) {
        if (get_option("in_session") == 1) {
            redirect("../area_cliente/?action=preguntas");
        }
        $(".registro_pregunta").show();
        $(".place_registro_valoracion").empty();
    }
}

let before_registro_valoracion = function() {
    bloquea_form(".form_valoracion");
}

let carga_productos_sugeridos = function() {
    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let data_send = {"id_servicio": get_option("servicio")};
    request_enid("GET", data_send, url, response_carga_productos_sugeridos, ".place_tambien_podria_interezar");
}

let response_carga_productos_sugeridos = function(data) {

    if (data["sugerencias"] == undefined) {
        llenaelementoHTML(".place_tambien_podria_interezar", data);

    }
}

let carga_valoraciones = function() {
    let url = "../q/index.php/api/valoracion/articulo/format/json/";
    let data_send = {"id_servicio": get_option("servicio"), "respuesta_valorada": get_option("respuesta_valorada")};
    request_enid("GET", data_send, url, response_carga_valoraciones, ".place_registro_afiliado");
}

let response_carga_valoraciones = function(data) {

    llenaelementoHTML(".place_valoraciones", data);

    if (get_option("desde_valoracion") == 1) {
        recorrepage(".place_valoraciones");
        set_option("desde_valoracion", 0);

    }
    $(".ordenar_valoraciones_button").click(ordenar_valoraciones);
    let valoracion_persona = $(".contenedor_promedios").html();
    llenaelementoHTML(".valoracion_persona", valoracion_persona);
    $(".valoracion_persona_principal .valoracion_persona .estrella").css("font-size", "1.2em");
    $(".valoracion_persona_principal .valoracion_persona .promedio_num").css("font-size", "1.2em");

}

let ordenar_valoraciones = function(e) {

    let tipo_ordenamiento = get_parameter_enid($(this), "id");
    switch (parseInt(tipo_ordenamiento)) {
        case 0:
            /*Ordenamos por los que tienen más votos*/
            let div = $(".contenedor_global_recomendaciones");
            let listitems = div.children('.contenedor_valoracion_info').get();
            listitems.sort(function (a, b) {

                return (+$(a).attr('numero_utilidad') > +$(b).attr('numero_utilidad')) ?
                    -1 : (+$(a).attr('numero_utilidad') < +$(b).attr('numero_utilidad')) ?
                        1 : 0;

            });
            llenaelementoHTML(".contenedor_global_recomendaciones", listitems);
            set_option("orden", "asc");


            break;
        case 1:

            let div = $(".contenedor_global_recomendaciones");

            let listitems = div.children('.contenedor_valoracion_info').get();
            listitems.sort(function (a, b) {

                return (+$(a).attr('fecha_info_registro') > +$(b).attr('fecha_info_registro')) ?
                    -1 : (+$(a).attr('fecha_info_registro') < +$(b).attr('fecha_info_registro')) ?
                        1 : 0;

            });

            llenaelementoHTML(".contenedor_global_recomendaciones", listitems);

            break;
        case 2:
            break;
        default:
    }
}