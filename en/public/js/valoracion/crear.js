"use strict";
let $form_valoracion = $('.form_valoracion');
let $input_recomendaria = $form_valoracion.find('.input_recomendaria');
let $selector_recomendacion = $form_valoracion.find('.recomendaria');
let $selector_sin_recomendacion = $form_valoracion.find('.sin_recomendacion');

$(document).ready(() => {

    $selector_recomendacion.click(selector_recomendacion);
    $selector_sin_recomendacion.click(selector_sin_recomendacion);

});
let selector_recomendacion = function () {

    $(this).removeClass('format_selector').addClass('format_selector_seleccionado');
    $input_recomendaria.val(1);
    $selector_sin_recomendacion.removeClass('format_selector_seleccionado').addClass('format_selector');

}
let selector_sin_recomendacion = function () {

    $(this).removeClass('format_selector').addClass('format_selector_seleccionado');
    $input_recomendaria.val(0);
    $selector_recomendacion.removeClass('format_selector_seleccionado').addClass('format_selector');
}
