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

let $input_id_usuario = $('.input_id_usuario');
let $input_id_usuario_califica = $('.input_id_usuario_califica');

$(document).ready(function () {

    $calificame.click(formulario_calificacion);
    $estrella.click(formulario_tipificacion);
    $estrella.hover(valida_color_calificacion);
    $tipificacion.click(selecciona_tipificacion);
    $enviar_formulario_boton.removeClass('bg_black');
    $enviar_formulario_boton.click(enviar_puntuacion);

});

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
        'id_usuario_califica': $input_id_usuario_califica.val()
    });
    let url = "../q/index.php/api/puntuacion/index/format/json/";
    $input_comentario.prop('disabled', true);
    $enviar_formulario_boton.prop('disabled', true).removeClass('bg_black');
    modal('Procesando...',1);
    request_enid("POST", data_send, url, response_puntuacion);

}
let response_puntuacion = function (data) {

    redirect('?encuesta=1');
    cerrar_modal();

}