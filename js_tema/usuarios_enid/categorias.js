"use strict";

let simula_envio_categoria = e =>  {

    valida_existencia_clasificacion();
    e.preventDefault();
}

let valida_existencia_clasificacion = () => {

    let data_send = $(".form_categoria").serialize();
    let url = "../q/index.php/api/clasificacion/existencia/format/json/";
    $.ajax({
        url: url,
        type: "GET",
        data: data_send,
        beforeSend: function () {
        }
    }).done(next_step_add_clasificacion).fail(function () {
    });
}
let next_step_add_clasificacion = data  => {

    if (data.existencia < 1 ) {
        /**Se cargan los padres*/
        load_niveles();

    } else {

        render_enid(".msj_existencia", "<span class='alerta_enid'>ÉSTA CATEGORÍA YA SE ENCUENTRA REGISTRADA</span>");
    }
}

let load_niveles = () =>  {

    $(".msj_existencia").empty();
    $(".form_categoria").hide();
    let es_servicio = get_parameter(".servicio option:selected");
    set_option("es_servicio", es_servicio);
    let nivel = 1;
    let padre = 0;

    let data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
    let url = "../q/index.php/api/clasificacion/nivel/format/json/";
    $.ajax({
        url: url,
        type: "GET",
        data: data_send
    }).done(muestra_sugerencias_primer_nivel).fail(function () {
    });

}

let muestra_sugerencias_primer_nivel = (data)  => {

    render_enid(".primer_nivel", data);
    $(".primer_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones);
}

let muestra_mas_opciones = (e)  => {

    clean_categorias(0);

    let padre = e.target.value;
    if (padre > 0) {
        let nivel = 2;
        let es_servicio = get_option("es_servicio");
        let data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        let url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_segundo_nivel).fail(function () {
        });

    }
}
let muestra_sugerencias_segundo_nivel = (data)  => {


    render_enid(".segundo_nivel", data);
    $(".seleccion_2").click(function () {
        add_categoria(2, get_parameter(".primer_nivel option:selected"), get_parameter(".servicio option:selected"));
    });
    $(".segundo_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_segundo);
}

let muestra_mas_opciones_segundo = (e) =>  {

    clean_categorias(1);

    let padre = e.target.value;
    if (padre > 0) {
        let nivel = 3;
        let es_servicio = get_option("es_servicio");
        let data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        let url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_tercer_nivel).fail(function () {
        });

    }
}

let muestra_sugerencias_tercer_nivel = (data) => {

    render_enid(".tercer_nivel", data);
    $(".seleccion_3").click(function () {
        add_categoria(3, get_parameter(".segundo_nivel option:selected"), get_parameter(".servicio option:selected"));
    });
    $(".seleccion_2").hide();
    $(".tercer_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_tercer);
}

let muestra_mas_opciones_tercer = (e) =>  {

    clean_categorias(2);
    let padre = e.target.value;
    if (padre > 0) {
        let nivel = 4;
        let es_servicio = get_option("es_servicio");
        let data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        let url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_cuarto).fail(function () {
        });

    }
}

let muestra_sugerencias_cuarto = (data)  => {

    render_enid(".cuarto_nivel", data);
    $(".seleccion_4").click(function () {
        add_categoria(4, get_parameter(".tercer_nivel option:selected"), get_parameter(".servicio option:selected"));
    });

    $(".seleccion_3").hide();
    $(".cuarto_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_quinto);
}

let muestra_mas_opciones_quinto = (e) =>  {
    clean_categorias(3);
    let padre = e.target.value;
    if (padre > 0) {
        let nivel = 5;
        let es_servicio = get_option("es_servicio");
        let data_send = {es_servicio: es_servicio, nivel: nivel, padre: padre};
        let url = "../q/index.php/api/clasificacion/nivel/format/json/";
        $.ajax({
            url: url,
            type: "GET",
            data: data_send
        }).done(muestra_sugerencias_quinto).fail(function () {
        });

    }
}

let muestra_sugerencias_quinto =  (data)  => {
    clean_categorias(4);
    $(".seleccion_4").hide();
    render_enid(".quinto_nivel", data);
    $(".seleccion_5").click(function () {
        add_categoria(5, get_parameter(".cuarto_nivel option:selected"), get_parameter(".servicio option:selected"));
    });
}

let clean_categorias = (inicio)  => {

    let categorias = [".primer_nivel",
        ".segundo_nivel",
        ".tercer_nivel",
        ".cuarto_nivel",
        ".quinto_nivel"];

    for (let x in categorias) {
        if (x > inicio) {
            $(categorias[x]).empty();
        }
    }
}
let add_categoria =  (nivel, padre, tipo) => {


    let clasificacion = get_parameter(".clasificacion");
    let data_send = {clasificacion: clasificacion, tipo: tipo, padre: padre, nivel: nivel};
    let url = "../q/index.php/api/clasificacion/nivel/format/json/";

    $.ajax({
        url: url,
        type: "POST",
        data: data_send,
        beforeSend: function () {
        }
    }).done(next_add).fail(function () {
    });
}

let next_add =  (data) => {

    clean_categorias(-1);
    $(".form_categoria").show();
    reset_form("form_categoria");
    render_enid(".msj_existencia", "<a class='a_enid_black'>CATEGORÍA AGREGADA!</a>");
}