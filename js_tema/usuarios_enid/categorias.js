"use strict";

function simula_envio_categoria(e) {

    valida_existencia_clasificacion();
    e.preventDefault();
}

var valida_existencia_clasificacion = function () {

    var data_send = $(".form_categoria").serialize();
    var url = "../q/index.php/api/clasificacion/existencia/format/json/";
    $.ajax({
        url: url,
        type: "GET",
        data: data_send,
        beforeSend: function () {
        }
    }).done(next_step_add_clasificacion).fail(function () {
    });
}
var next_step_add_clasificacion = function (data) {

    if (data.existencia == 0) {
        /**Se cargan los padres*/
        load_niveles();
    } else {

        llenaelementoHTML(".msj_existencia", "<span class='alerta_enid'>ÉSTA CATEGORÍA YA SE ENCUENTRA REGISTRADA</span>");
    }
}

var load_niveles = function () {

    $(".msj_existencia").empty();
    $(".form_categoria").hide();
    var es_servicio = get_parameter(".servicio option:selected");
    set_option("es_servicio", es_servicio);
    var nivel = 1;
    var padre = 0;

    var data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
    var url = "../q/index.php/api/clasificacion/nivel/format/json/";
    $.ajax({
        url: url,
        type: "GET",
        data: data_send
    }).done(muestra_sugerencias_primer_nivel).fail(function () {
    });

}

var muestra_sugerencias_primer_nivel = function (data) {

    llenaelementoHTML(".primer_nivel", data);
    $(".primer_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones);
}

var muestra_mas_opciones = function (e) {

    clean_categorias(0);

    var padre = e.target.value;
    if (padre > 0) {
        var nivel = 2;
        var es_servicio = get_option("es_servicio");
        var data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        var url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_segundo_nivel).fail(function () {
        });

    }
}
var muestra_sugerencias_segundo_nivel = function (data) {


    llenaelementoHTML(".segundo_nivel", data);
    $(".seleccion_2").click(function () {
        add_categoria(2, get_parameter(".primer_nivel option:selected"), get_parameter(".servicio option:selected"));
    });
    $(".segundo_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_segundo);
}

var muestra_mas_opciones_segundo = function (e) {

    clean_categorias(1);

    var padre = e.target.value;
    if (padre > 0) {
        var nivel = 3;
        var es_servicio = get_option("es_servicio");
        var data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        var url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_tercer_nivel).fail(function () {
        });

    }
}

var muestra_sugerencias_tercer_nivel = function (data) {

    llenaelementoHTML(".tercer_nivel", data);
    $(".seleccion_3").click(function () {
        add_categoria(3, get_parameter(".segundo_nivel option:selected"), get_parameter(".servicio option:selected"));
    });
    $(".seleccion_2").hide();
    $(".tercer_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_tercer);
}

var muestra_mas_opciones_tercer = function (e) {

    clean_categorias(2);
    var padre = e.target.value;
    if (padre > 0) {
        var nivel = 4;
        var es_servicio = get_option("es_servicio");
        var data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        var url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_cuarto).fail(function () {
        });

    }
}

var muestra_sugerencias_cuarto = function (data) {

    llenaelementoHTML(".cuarto_nivel", data);
    $(".seleccion_4").click(function () {
        add_categoria(4, get_parameter(".tercer_nivel option:selected"), get_parameter(".servicio option:selected"));
    });

    $(".seleccion_3").hide();
    $(".cuarto_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_quinto);
}

var muestra_mas_opciones_quinto = function (e) {
    clean_categorias(3);
    var padre = e.target.value;
    if (padre > 0) {
        var nivel = 5;
        var es_servicio = get_option("es_servicio");
        var data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        var url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_quinto).fail(function () {
        });

    }
}

var muestra_sugerencias_quinto = function (data) {
    clean_categorias(4);
    $(".seleccion_4").hide();
    llenaelementoHTML(".quinto_nivel", data);
    $(".seleccion_5").click(function () {
        add_categoria(5, get_parameter(".cuarto_nivel option:selected"), get_parameter(".servicio option:selected"));
    });
}

var clean_categorias = function (inicio) {

    var categorias = [".primer_nivel",
        ".segundo_nivel",
        ".tercer_nivel",
        ".cuarto_nivel",
        ".quinto_nivel"];

    for (var x in categorias) {
        if (x > inicio) {
            $(categorias[x]).empty();
        }
    }
}
var add_categoria = function (nivel, padre, tipo) {


    var clasificacion = get_parameter(".clasificacion");
    var data_send = {clasificacion: clasificacion, tipo: tipo, padre: padre, nivel: nivel};
    var url = "../q/index.php/api/clasificacion/nivel/format/json/";

    $.ajax({
        url: url,
        type: "POST",
        data: data_send,
        beforeSend: function () {
        }
    }).done(next_add).fail(function () {
    });
}

var next_add = function (data) {

    clean_categorias(-1);
    $(".form_categoria").show();
    reset_form("form_categoria");
    llenaelementoHTML(".msj_existencia", "<a class='a_enid_black'>CATEGORÍA AGREGADA!</a>");
}