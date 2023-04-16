let $selector_modal_asistencia = $("#modal_asistencia");
let $accion_confirmar_asistencia = $(".accion_confirmar_asistencia");
let $form_registro_asistencia = $(".form_registro_asistencia");
let $action_format_invitacion = $(".action_format_invitacion");
let $nombre = $(".nombre");

$(document).ready(() => {

    var nombreAsistente = localStorage.getItem("nombre_asistente");
    if (nombreAsistente !== null) {
        var divNombreAsistente = document.getElementById("nombre_asistente");
        divNombreAsistente.innerHTML = nombreAsistente;
        $(".nombre_asistente").removeClass("d-none");
    }

    $accion_confirmar_asistencia.click(confirma_asistencia);
    $(".modal-body").removeClass("mt-5");
    $(".modal-content").removeClass("borde_end").removeClass("rounded-0");
    $form_registro_asistencia.submit(registro_asistencia);

    $nombre.keypress(function (e) {
        transforma_mayusculas(this);
        if (e.which == 13) {
            let nombre = $(this).val();
            error_enid_input($(this).attr("id"));
            if (nombre.length > 3) {

                oculta_contenedor_input_enid($(this).attr("id"));
            }
        }
    });


    $action_format_invitacion.click(function () {

        $nombre.trigger(jQuery.Event("keypress", { which: 13 }));

    });


});

let confirma_asistencia = function () {

    $selector_modal_asistencia.modal("show");
}
let registro_asistencia = function (e) {

    let data_send = $form_registro_asistencia.serialize();
    let url = "../q/index.php/api/asistencia/index/format/json/";
    request_enid("POST", data_send, url, response_asistencia, ".place_compras");

    e.preventDefault();

}
let response_asistencia = function (data) {

    $(".te_esperamos").removeClass("d-none");
    $(".form_asistencia").addClass("d-none");
    $(".te_esperamos_nombre").text($nombre.val());
    localStorage.setItem("nombre_asistente", $nombre.val());
}
