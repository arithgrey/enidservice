"use strict";
let $selector_carga_modal = $('#propuesta_servicio_modal');
let $boton_agregar_propuesta =  $(".boton_agregar_propuesta");
let form_propuesta_servicio = '.form_propuesta_servicio';
let $form_propuesta_servicio = $(form_propuesta_servicio);

$(document).ready(() => {

    $('#summernote').summernote();
    $boton_agregar_propuesta.click(agregar);
    $form_propuesta_servicio.submit(registrar);
});

let agregar = function () {
    
    $selector_carga_modal.remove('d-none');
    $selector_carga_modal.modal("show");
    
};

let registrar = function (e) {

    bloquea_form(form_propuesta_servicio);
    let url = "../q/index.php/api/propuesta/index/format/json/";
    let data_send = $.param({        
        "propuesta": $(".note-editable").html(),
        "id_servicio" : $(".id_servicio").val()
    });
    request_enid("POST", data_send, url, propuesta_servicio);
    e.preventDefault();

};
let propuesta_servicio = function (data) { 

    redirect("");
}

