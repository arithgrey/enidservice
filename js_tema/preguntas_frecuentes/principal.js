"use strict";
let $form_busqueda = $(".form_busqueda");
let $boton_ingresos = $(".boton_ingresos");
let $form_ingreso_modal = $("#form_ingreso_modal");
let $form_preguntas_frecuentes = $(".form_preguntas_frecuentes");
let $summernote = $('#summernote');
let $selector_carga_modal = $('.cargando_modal');
let $form_tags = $(".form_tags");
let $form_tags_modal = $("#form_tags_modal");
let $respuesta_id = $(".respuesta_id");
let $tags = $("#tags");

$(document).ready(() => {


    $form_busqueda.submit(busqueda);
    $form_preguntas_frecuentes.submit(registro)
    $boton_ingresos.click(function () {

        $form_ingreso_modal.find("#id_respuesta").val(0);
        $form_ingreso_modal.modal("show");

    });

    $summernote.summernote();
    $form_busqueda.submit();
    $form_tags.submit(tags);

});

let busqueda = function (e) {

    let url = "../q/index.php/api/pregunta_frecuente/q/format/json/";
    let data_send = $(this).serialize();
    request_enid("GET", data_send, url, function (data) {
        render_enid('.respuestas', data);

        $(".eliminar_respuesta").click(elimina_pregunta_frecuente);
        $(".editar_respuesta").click(editar_pregunta_frecuente);

        $(".etiqueta").click(function (e) {
            $form_tags_modal.modal("show");
            $tags.val("");
            let $id_pregunta_frecuente = e.target.id;
            $respuesta_id.val($id_pregunta_frecuente);

            let $tags_pregunta = $(this).attr("tags_pregunta");
            let $array_tags = $tags_pregunta.split(",");
            formato_tags($array_tags);
            $(".eliminar_tag").click(elimina_tag);

        });

    });

    e.preventDefault();
}
let elimina_pregunta_frecuente = function (e) {

    let id = e.target.id;

    show_confirm("¿Seguro deseas eliminar este concepto?", "", "Eliminar", function () {

        let url = "../q/index.php/api/pregunta_frecuente/index/format/json/";
        let data_send = $.param({id: id});
        advierte("Registrando ...", 1);

        request_enid("DELETE", data_send, url, function (data) {

            $(".text-order-name-error").text("Se eliminó!");
            redirect("");

        });
    });

}
let editar_pregunta_frecuente = function (e) {

    let $id = e.target.id;
    $form_ingreso_modal.modal("show");
    let url = "../q/index.php/api/pregunta_frecuente/index/format/json/";
    let data_send = $.param({"id": $id});

    $form_ingreso_modal.find("#edicion").val(1);
    request_enid("GET", data_send, url, function (data) {

        if (isArray(data)) {

            let $titulo = data[0].titulo;
            let $respuesta = data[0].respuesta;
            let $id_respuesta = data[0].id;

            $form_ingreso_modal.find("#id_respuesta").val($id_respuesta);
            $form_ingreso_modal.find("#titulo").val($titulo);
            $form_ingreso_modal.find(".note-editable").html($respuesta);
            verifica_formato_default_inputs();
        }

    });

}
let registro = function (e) {


    let url = "../q/index.php/api/pregunta_frecuente/index/format/json/";
    let $respuesta = $form_ingreso_modal.find(".note-editable").html();
    $form_ingreso_modal.find("#edicion").val(0);
    let data_send = $(this).serialize() + "&" + $.param({"respuesta": $respuesta});
    $form_ingreso_modal.modal("hide");
    advierte("Registrando ...", 1);

    request_enid("POST", data_send, url, function (data) {

        $(".text-order-name-error").text("Se registro!");
        redirect("");

    });

    e.preventDefault();
}

let tags = function (e) {

    let url = "../q/index.php/api/pregunta_frecuente/tags/format/json/";
    let data_send = $(this).serialize();
    let texto_tag = $form_tags.find("#tags").val();
    agrega_tag(texto_tag);


    request_enid("PUT", data_send, url, function (data) {
        cerrar_modal();
        $tags.val("");
        $form_busqueda.submit();


    });

    e.preventDefault();
}

let agrega_tag = function (texto_tag) {

    let $icono = d("", "fa fa-times eliminar_tag", texto_tag);
    let tag = d(texto_tag, 'tag_asociado');
    let $id_texto = texto_tag.trim();
    let _id = '_' + $id_texto.replace(' ', '') + '_';
    let tag_control = _text(
        "<div class='d-flex justify-content-between align-items-center w-100' id='", _id, "'>",
        tag,
        $icono,
        "</div>");

    $(".tags_asociados").append(tag_control);
    $(".eliminar_tag").click(elimina_tag);


}

let formato_tags = function ($array_tags) {

    let $seccion_tag = '';
    for (let x in $array_tags) {

        let $tag = $array_tags[x];
        let $icono = d("", "fa fa-times eliminar_tag", $tag);
        let tag = d($tag, 'tag_asociado');
        let $id_texto = $tag.trim();
        let _id = '_' + $id_texto.replace(' ', '') + '_';
        let tag_control = _text(
            "<div class='d-flex justify-content-between align-items-center w-100' id='", _id, "'>",
            tag,
            $icono,
            "</div>");
        $seccion_tag = _text_($seccion_tag, tag_control);

    }

    render_enid(".tags_asociados", $seccion_tag);

}
let elimina_tag = function (e) {

    let $tag = e.target.id;
    let $id = $respuesta_id.val();

    let url = "../q/index.php/api/pregunta_frecuente/tags/format/json/";
    let data_send = $.param({"id": $id, "tag": $tag});
    let $id_texto = $tag.trim();

    let _id = _text("#_", $id_texto.replace(' ', ''), '_');
    let _idtags = _text("#_", $tag.replace(' ', ''), '_');

    $(_id).addClass("d-none").removeClass('d-flex');
    $(_idtags).addClass("d-none").removeClass('d-flex');

    request_enid("DELETE", data_send, url, function (data) {

        $("#modal-error-message").modal("hide");
        $form_busqueda.submit();

    });


}