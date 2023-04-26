let $form_busqueda = $(".form_busqueda_pedidos_hidden");
let $contenedor_perfil = $('.contenedor_perfil');
let $contenedor_encuesta_estrellas = $('.contenedor_encuesta_estrellas');
let $contenedor_encuesta_tipificcion = $('.contenedor_encuesta_tipificcion');
let $estrella = $('.estrella');
let $calificame = $('.calificame');
let $calificacion_usuario = 0;
let $tipificacion_seleccion = 0;
let $texto_calificacion = $('.texto_calificacion');
let $tipificacion = $('.tipificacion');
let $enviar_formulario_boton = $('.enviar_formulario_boton');
let $input_comentario = $('.input_comentario');
let $form_articulo_interes = $('.form_articulo_interes_entrega');
let $input_id_usuario = $('.input_id_usuario');
let $input_id_servicio = $('.input_id_servicio');
let $input_id_usuario_califica = $('.input_id_usuario_califica');
let $input_deseos_cliente = $(".deseos_cliente");
let $nombre_usuario = $();
let $boton_accion_seguimiento = $(".boton_accion_seguimiento");
let $accion_seguimiento_usuario = $(".accion_seguimiento_usuario");
let $modal_accion_seguimiento_descubrimiento = $("#modal_accion_seguimiento_descubrimiento");
let $ya_envie = $(".ya_envie");
let $form_comentarios_accion_seguimiento = $('.form_comentarios_accion_seguimiento');
let $form_comentarios_accion_seguimiento_notificado = $(".form_comentarios_accion_seguimiento_notificado");
let $lista_acciones_seguimiento_opciones = $(".lista_acciones_seguimiento_opciones");
let $input_id_accion_seguimiento = $('.input_id_accion_seguimiento');
let $input_id_recibo = $(".input_id_recibo");
let $input_tel_contacto = $(".input_tel_contacto");

let $place_area_comentario = $(".place_area_comentario");
let $cargando_modal = $(".cargando_modal");
let $modal_recordatorio_accion = $("#modal_recordatorio_accion");
let $estructura_fechas = $(".estructura_fechas");
let $estructura_hecho = $(".estructura_hecho");
let $envio_fecha_evento = $(".envio_fecha_evento");
let $form_recordatorio_seguimiento = $(".form_recordatorio_seguimiento");
let $modal_cambio_estado_evento = $("#modal_cambio_estado_evento");
let $confirmacion_evento = $(".confirmacion_evento");
let $confirmacion_evento_comentario = $(".confirmacion_evento_comentario");
let $envio_lista_negra = $(".envio_lista_negra");


if (parseInt($('.nombre_usuario').length) > 0) {
    $nombre_usuario = $('.nombre_usuario');
}


$(document).ready(function () {

    $envio_fecha_evento.click(envio_fecha_evento_accion);
    $form_recordatorio_seguimiento.submit(registro_evento_agenda);
    $calificame.click(formulario_calificacion);
    $estrella.click(formulario_tipificacion);
    $estrella.hover(valida_color_calificacion);
    $tipificacion.click(selecciona_tipificacion);
    $enviar_formulario_boton.removeClass('bg_black');
    $enviar_formulario_boton.click(enviar_puntuacion);
    set_option("estado_usuario", 1);
    set_option("depto", 0);
    set_option("page", 1);

    $nombre_usuario.keypress(function (e) {

        let keycode = e.keyCode;
        if (keycode === 13) {
            busqueda_usuarios();
        }
    });

    $input_deseos_cliente.click(function () {

        $('#modal_otros').modal("show");
    });

    $boton_accion_seguimiento.click(function () {

        $('#modal_accion_seguimiento').modal("show");
    });

    $form_articulo_interes.submit(registro_articulo_interes);
    $form_busqueda.submit(busqueda_pedidos);
    $form_busqueda.submit();
    $accion_seguimiento_usuario.click(descubre_accion_seguimiento);

    $('#texto-a-copiar').click(function () {

        var texto = $(this).text();
        var input = $('<input>').val(texto);
        $('body').append(input);
        input.select();
        document.execCommand('copy');
        input.remove();
    });

    $ya_envie.click(notificacion_envio_accion_seguimiento);
    $form_comentarios_accion_seguimiento_notificado.submit(comentario_accion_seguimiento_notificado);
    acciones_seguimiento();
    $confirmacion_evento.click(notificar_evento_realizado);
    $confirmacion_evento_comentario.click(notificar_evento_realizado_comentario);
    $envio_lista_negra.click(envio_lista_negra);

});
let busqueda_pedidos = function (e) {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {
        let data_send = $form_busqueda.serialize();
        let url = "../q/index.php/api/recibo/pedidos/format/json/";
        request_enid("GET", data_send, url, response_pedidos);

    }
    e.preventDefault();
};
let response_pedidos = function (data) {

    render_enid(".place_pedidos", data);
};

let registro_articulo_interes = function (e) {

    let data_send = $(this).serialize();
    let url = "../q/index.php/api/tag_arquetipo/interes_compra/format/json/";
    advierte('Procesando', 1);
    $('#modal_otros').modal("hide");
    request_enid("POST", data_send, url, response_tag_arquetipo);

    e.preventDefault();
};

let response_tag_arquetipo = function (data) {

    redirect("");
};
let valida_color_calificacion = function () {

    let $texto = get_parameter_enid($(this), "texto_calificacion");
    $texto_calificacion.text($texto);

}

let formulario_calificacion = () => {

    $contenedor_perfil.addClass('d-none');
    $contenedor_encuesta_estrellas.removeClass('d-none');

}

let formulario_tipificacion = function () {

    $calificacion_usuario = get_parameter_enid($(this), "id");
    if (parseInt($calificacion_usuario) > 0) {

        $contenedor_encuesta_estrellas.addClass('d-none');
        $contenedor_encuesta_tipificcion.removeClass('d-none');

    }

}
let selecciona_tipificacion = function () {

    $tipificacion_seleccion = get_parameter_enid($(this), "id");
    if (parseInt($tipificacion_seleccion) > 0) {

        $tipificacion.removeClass('tipificacion_seleccion');
        $(this).addClass('tipificacion_seleccion');
        $enviar_formulario_boton.addClass('bg_black');

    }
}
let enviar_puntuacion = function () {

    let data_send = $.param({
        'tipo_puntuacion': $tipificacion_seleccion,
        'cantidad': $calificacion_usuario,
        'comentario': $input_comentario.val(),
        'id_usuario': $input_id_usuario.val(),
        'id_usuario_califica': $input_id_usuario_califica.val(),
        'id_servicio': $input_id_servicio.val()
    });
    let url = "../q/index.php/api/puntuacion/index/format/json/";
    $input_comentario.prop('disabled', true);
    $enviar_formulario_boton.prop('disabled', true).removeClass('bg_black');
    modal('Procesando...', 1);
    request_enid("POST", data_send, url, response_puntuacion);

}
let response_puntuacion = function (data) {

    redirect('?encuesta=1');
    cerrar_modal();

}
let busqueda_usuarios = () => {

    let url = "../q/index.php/api/usuario/miembros_activos/format/json/";
    let data_send = {
        "status": get_option("estado_usuario"),
        "id_departamento": get_option("depto"),
        "page": get_option("page"),
        "q": $nombre_usuario.val(),
        "v": 2,
    };
    request_enid("GET", data_send, url, carga_usuario);

};

let carga_usuario = (data) => {

    render_enid('.seccion_usuarios', data);
    $(".pagination > li > a, .pagination > li > span").click(function (e) {

        e.preventDefault();
        set_option("page", $(this).text());
        busqueda_usuarios();

    });
    $(".pagination > li > a, .pagination > li > span").css("color", "white");

};

let descubre_accion_seguimiento = function (e) {

    $(".tarjeta_opcion_seguimiento").addClass("d-none");
    $(".tarjeta_opcion_seguimiento .selector-del-div-a-copiar").addClass("mx-auto");

    let $id = $(this).attr("id");
    $id = parseInt($id);
    if ($id > 0) {

        switch ($id) {

            case 3:
                $('#modal_accion_seguimiento').modal("hide");
                $modal_recordatorio_accion.modal("show");

                break;
            default:

                $(_text(".tarjeta_accion_seguimiento_", $id)).removeClass("d-none");
                $('#modal_accion_seguimiento').modal("hide");
                $modal_accion_seguimiento_descubrimiento.modal("show");

        }

    }
};
let notificacion_envio_accion_seguimiento = function () {

    let $id = $(this).attr("id");
    $input_id_accion_seguimiento.val($id);

    $form_comentarios_accion_seguimiento_notificado.find(".cargando_modal").removeClass("d-none");
    let data_send = $form_comentarios_accion_seguimiento.serialize();
    let url = "../q/index.php/api/users_accion_seguimiento/index/format/json/";
    request_enid("POST", data_send, url, response_comentario_accion_seguimiento);

}

let comentario_accion_seguimiento_notificado = function (e) {

    var contenido = $form_comentarios_accion_seguimiento_notificado.find(".comentario_seguimiento").val();

    if (contenido.length > 0) {

        $place_area_comentario.addClass("d-none");
        $form_comentarios_accion_seguimiento_notificado.find(".cargando_modal").removeClass("d-none");

        let data_send = $form_comentarios_accion_seguimiento_notificado.serialize();
        let url = "../q/index.php/api/users_accion_seguimiento/comentario/format/json/";
        bloquea_form($form_comentarios_accion_seguimiento_notificado);
        request_enid("PUT", data_send, url, response_comentario_accion_seguimiento_notificado);

    } else {

        $place_area_comentario.removeClass("d-none");

    }

    e.preventDefault();

}
let response_comentario_accion_seguimiento_notificado = function (data) {

    desbloqueda_form($form_comentarios_accion_seguimiento_notificado);
    reset_form("form_comentarios_accion_seguimiento_notificado");
    $modal_accion_seguimiento_descubrimiento.modal("hide");
    acciones_seguimiento();


}
let response_comentario_accion_seguimiento = function (data) {

    $form_comentarios_accion_seguimiento_notificado.find(".id_accion_en_seguimiento").val(data);
    acciones_seguimiento();
    $cargando_modal.addClass("d-none");
    $lista_acciones_seguimiento_opciones.addClass("d-none");
    $form_comentarios_accion_seguimiento_notificado.removeClass("d-none");
}

let acciones_seguimiento = function () {
    $lista_acciones_seguimiento_opciones.removeClass("d-none");
    $form_comentarios_accion_seguimiento_notificado.addClass("d-none");
    let data_send = $.param({ "id": $input_id_usuario.val() });
    let url = "../q/index.php/api/users_accion_seguimiento/usuario/format/json/";
    request_enid("GET", data_send, url, acciones_seguimiento_response);

}
let acciones_seguimiento_response = function (data) {

    render_enid(".tarjetas_acciones_seguimiento", data);

    $(".evento_seguimiento_pendiente").click(cambio_seguimiento_evento);
    let $id_usuario = $input_id_usuario.val();
    let $id_recibo = $input_id_recibo.val();

    let url = "../q/index.php/api/recibo/ficha_relacion/format/json/";
    let data_send = { "id_usuario": $id_usuario, "id_recibo": $id_recibo };

    request_enid("PUT", data_send, url, function (data) { });

}
let envio_fecha_evento_accion = function () {

    $estructura_fechas.addClass("d-none");
    $estructura_hecho.removeClass("d-none");

}

let registro_evento_agenda = function (e) {

    let fecha_inicio = get_parameter("#fecha_evento");
    var comentario = $form_recordatorio_seguimiento.find(".comentario_seguimiento").val();

    if (comentario.length < 1) {
        $place_area_comentario.removeClass("d-none");
    }
    if (fecha_inicio.length > 8 && comentario.length > 0) {

        $place_area_comentario.addClass("d-none");
        let data_send = $form_recordatorio_seguimiento.serialize();
        let url = "../q/index.php/api/users_accion_seguimiento/index/format/json/";
        request_enid("POST", data_send, url, response_registro_evento);
        bloquea_form($form_recordatorio_seguimiento);

    }
    e.preventDefault();
};
let response_registro_evento = function (data) {

    $estructura_fechas.removeClass("d-none");
    $estructura_hecho.addClass("d-none");

    desbloqueda_form($form_recordatorio_seguimiento);
    reset_form("form_recordatorio_seguimiento");
    $modal_recordatorio_accion.modal("hide");
    acciones_seguimiento();
}