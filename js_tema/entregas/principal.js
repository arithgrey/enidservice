let $mostrar_todo = $('.mostrar_todo');
let $opciones_ocultas = $('.opciones_ocultas');
let $filtro_menos_opciones = $('.filtro_menos_opciones');
let $filtro_mas_opciones = $('.filtro_mas_opciones');
let $filtro_sin_ubicacion = $('.filtro_sin_ubicacion');
let $filtro_ubicacion = $('.filtro_ubicacion');
$(document).ready(function () {

    $mostrar_todo.click(muestra_franja_horaria);
    $filtro_menos_opciones.click(menos_opciones);
    $filtro_mas_opciones.click(mas_opciones);
    $filtro_sin_ubicacion.click(sin_ubicacion);
    $filtro_ubicacion.click(ubicacion);
});
let busqueda_ordenes_franja_horaria = (franja) => {

    modal('Busqueda', 1);
    let data_send = {"franja_horaria": franja, 'v': 1};
    let url = "../q/index.php/api/recibo/franja_horaria/format/json/";
    request_enid("GET", data_send, url, response_entregas_franja_horaria);

};
let response_entregas_franja_horaria = (data) => {

    modal(data);

};
let muestra_franja_horaria = () => {

    $opciones_ocultas.removeClass('d-none');
    $('.mostrar_todo').removeClass('fa-chevron-circle-down mostrar_todo').addClass('ocultar_ordenes_pasadas fa fa-arrow-circle-up');
    $('.ocultar_ordenes_pasadas').click(oculta_franja_horaria);

};
let oculta_franja_horaria = () => {


    $('.ocultar_ordenes_pasadas').addClass('fa-chevron-circle-down mostrar_todo').removeClass('ocultar_ordenes_pasadas fa-arrow-circle-up');
    $opciones_ocultas.addClass('d-none');
    $('.mostrar_todo').click(muestra_franja_horaria);

};
let menos_opciones = () => {

    $('.reparto_asignado').addClass('d-none').removeClass('d-block');
    $('.filtro_mas_opciones').removeClass('d-none');
    $('.filtro_menos_opciones').addClass('d-none');

}
let mas_opciones = () => {

    $('.reparto_asignado').removeClass('d-none').addClass('d-block');
    $('.filtro_mas_opciones').addClass('d-none');
    $('.filtro_menos_opciones').removeClass('d-none');

}
let sin_ubicacion = () => {

    $('.ubicacion_asignada').addClass('d-none');
    $filtro_sin_ubicacion.addClass('d-none');
    $filtro_ubicacion.removeClass('d-none');

}
let ubicacion = () => {

    $('.ubicacion_asignada').removeClass('d-none');
    $filtro_sin_ubicacion.removeClass('d-none');
    $filtro_ubicacion.addClass('d-none');

}