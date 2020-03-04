let $mostrar_todo = $('.mostrar_todo');
let $opciones_ocultas = $('.opciones_ocultas');

$(document).ready(function () {

    $mostrar_todo.click(muestra_franja_horaria);

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