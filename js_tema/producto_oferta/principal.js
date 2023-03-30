let $form_registro = $(".form_lead");
let $form_ubicacion = $(".form_ubicacion");

let $registro_nombre = $form_registro.find('.nombre_registro');
let $registro_pw = $form_registro.find('.pw_registro');
let $registro_email = $form_registro.find('.email_registro');

let $icono_mostrar_password = $form_registro.find('.mostrar_password');
let $icono_ocultar_password = $form_registro.find('.ocultar_password');
let $accion_continuar_registro = $(".accion_continuar_registro");
let $accion_continuar_registro_ubicacion = $(".accion_continuar_registro_ubicacion");

let $direccion_registro = $form_ubicacion.find('.direccion_registro');
let $telefono_registro = $form_ubicacion.find('.telefono_registro');

$(document).ready(function () {

    $(".quiero_oferta").click(quiero_oferta);
    $icono_mostrar_password.click(mostrar_password);
    $icono_ocultar_password.click(ocultar_password);
    $form_registro.submit(registro_lead);
    $form_ubicacion.submit(registro_lead_ubicacion);

    $registro_nombre.keypress(function (e) {
        if (e.which == 13) {
            let len = $(this).val();
            if (len.length > 3) {

                $(".input_nombre").addClass("d-none");
                $(".input_email").removeClass("d-none");
                $(".place_input_form_nombre").addClass("d-none");
            } else {

                $(".place_input_form_nombre").removeClass("d-none");
            }
        }
    });



    $registro_email.keypress(function (e) {
        if (e.which == 13) {
            let email = $(this).val();                        
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;  
            if (!emailRegex.test(email)) {
                $(".place_input_form_correo").removeClass("d-none");

            } else {

                $(".input_email").addClass("d-none");
                $(".input_password").removeClass("d-none");
                $(".place_input_form_correo").addClass("d-none");
            }
        }
    });

    $registro_pw.keypress(function (e) {
        if (e.which == 13) {
            let len = $(this).val();

            if (len.length > 3) {
                $(".place_input_form_password").addClass("d-none");

            } else {

                $(".place_input_form_password").removeClass("d-none");
            }
        }
    });

    $direccion_registro.keypress(function (e) {
        if (e.which == 13) {

            let direccion = $(this).val();
            if (!/^[a-zA-Z0-9\s,'-]*$/.test(direccion)) {
                $(".place_input_form_ubicacion").removeClass("d-none");
            } else {
                $(".place_input_form_ubicacion").addClass("d-none");
            }

        }
    });

    $telefono_registro.keypress(function (e) {
        if (e.which == 13) {
            let telefono = $(this).val();
            var regexTelefono = /^\+[0-9]{1,3}[0-9]{4,14}(?:x.+)?$/;
            if (!regexTelefono.test(telefono)) {

                $(".place_input_form_telefono").addClass("d-none");
            } else {

                $(".place_input_form_telefono").removeClass("d-none");
                
            }
        }
    });


    $accion_continuar_registro.click(registro_validacion);
    $accion_continuar_registro_ubicacion.click(registro_validacion_ubicacion);


});

let quiero_oferta = function () {
    $(".contenedor_promocion").addClass("d-none");
    $(".navegacion_principal").addClass("d-none");
    $(".cerrar_modal").addClass("d-none");
    $("#lead_modal").modal("show");
}
let mostrar_password = function () {


    $registro_pw.attr('type', 'text');
    $(this).addClass("d-none");
    $icono_ocultar_password.removeClass("d-none");
}

let ocultar_password = function () {

    $registro_pw.attr('type', 'password');
    $(this).addClass("d-none");
    $icono_mostrar_password.removeClass('d-none');

}

let registro_validacion = (e) => {

    $registro_nombre.trigger(jQuery.Event("keypress", { which: 13 }));
    $registro_email.trigger(jQuery.Event("keypress", { which: 13 }));
    $registro_pw.trigger(jQuery.Event("keypress", { which: 13 }));

}

let registro_validacion_ubicacion = (e) => {

    $direccion_registro.trigger(jQuery.Event("keypress", { which: 13 }));
    $telefono_registro.trigger(jQuery.Event("keypress", { which: 13 }));


}
let registro_lead = (e) => {

    let url = '../q/index.php/api/lead_producto/index/format/json/';
    let respuestas = [];

    respuestas.push(es_formato_nombre($registro_nombre));
    respuestas.push(es_formato_password($registro_pw));
    respuestas.push(es_formato_email($registro_email));

    let $tiene_formato = (!respuestas.includes(false));
    $(".cargando_modal").removeClass("d-none");
    if ($tiene_formato) {

        let data_send = {
            'nombre': $registro_nombre.val(),
            'email': $registro_email.val(),
            'password': $registro_pw.val(),
        };

        request_enid('POST', data_send, url, response_registro_lead);
    }
    e.preventDefault();
};


let response_registro_lead = function (data) {

    $(".cargando_modal").addClass("d-none");
    $(".pasos").addClass("d-none");
    $(".form_ubicacion").removeClass("d-none");
    $(".form_lead").addClass("d-none");
    $(".id_lead").val(data);
    $(".paso_2").addClass("bg_black").removeClass("bg_gray");
}

let registro_lead_ubicacion = (e) => {

    let url = '../q/index.php/api/lead_producto/id/format/json/';
    let $data_send = $form_ubicacion.serialize();
    request_enid('PUT', $data_send, url, response_registro_lead_ubicacion);

    e.preventDefault();
};

let response_registro_lead_ubicacion = function (data) {
    $(".paso_3").addClass("bg_black").removeClass("bg_gray");
    $(".input_telefono").addClass("d-none");
    $(".input_direccion").addClass("d-none");
    $accion_continuar_registro_ubicacion.addClass("d-none");
    $(".envio").removeClass("d-none");

}