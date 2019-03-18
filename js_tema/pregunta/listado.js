let carga_respuestas = function (id, es_vendedor) {

    let url = "../q/index.php/api/respon/pregunta/format/json/";
    let data_send = $.param({"v": 1, "id_pregunta": id , "es_vendedor" : es_vendedor});
    request_enid("GET", data_send, url, function (data) {
        response_respuestas(data, id);
    });

}
let response_respuestas = function (data, id) {


    let p = ".comentarios_" + id;
    llenaelementoHTML(p, data);
    $('.summernote').summernote({
        placeholder: '--',
        tabsize: 2,
        height: 100
    });

    if (get_parameter(".final") != undefined && get_parameter('.contenedor_respuestas') != undefined) {

        $('.contenedor_respuestas').animate({scrollTop: $(".final").offset().top - 100}, 'slow');
    }

    $(".form_comentario").submit(envia_respuesta);

}

let envia_respuesta = function (e) {

    let l = $(".note-editable").html().trim();

    if (l.length > 10) {

        let url = "../q/index.php/api/respon/index/format/json/";
        let data_send = $(".form_comentario").serialize() + "&" + $.param({"respuesta": l});
        request_enid("POST", data_send, url, function () {

            carga_respuestas(get_parameter(".id_pregunta"));

        });

    } else {

        format_error(".place_repuesta_pregunta", "Mensaje muy corto");

    }

    e.preventDefault();

}