'use strict';
let $botton_registro_usuario_nuevo = $(".botton_registro_usuario_nuevo");
let $email_recuperacion = $('#email_recuperacion');
let $mail_acceso = $('#mail_acceso');
let $registrar_cuenta_botton = $('.registrar_cuenta');
let form_inicio = '.form_sesion_enid';
let form_pass = '.form-pass';
let $form_pass = $(form_pass);
let form_registro = '.form-miembro-enid-service';
let email = '#mail';
let pw = '#pw';
let place_recuperacion = '.place_recuperacion_pw';
let $olvide_pass = $('.olvide_pass');
let wr = '.wrapper_login';
let contenedor_recuperacion_password = '.contenedor_recuperacion_password';
let seccion_registro_usuario = '.seccion_registro_nuevo_usuario_enid_service';

let $form_registro = $(form_registro);
let $registro_nombre = $form_registro.find(".nombre");
let $registro_telefono = $form_registro.find('.texto_telefono');
let $registro_email = $form_registro.find('#email');
let $registro_pw = $form_registro.find('.registro_pw');
let $perfil = $form_registro.find('.perfil');

let $form_inicio = $(form_inicio);
let $input_correo_inicio = $form_inicio.find('.correo');
let $input_password_inicio = $form_inicio.find('#pw');

let $seccion_entrega = $form_registro.find('.seccion_entrega');
let $icono_mostrar_password = $form_inicio.find('.mostrar_password');
let $icono_ocultar_password = $form_inicio.find('.ocultar_password');
let $link_como_vender = $form_registro.find('.link_como_vender');
let $label_mail_acceso = $(".label_mail_acceso");
let $label_pw = $(".label_pw");
let $btn_acceder_cuenta_enid = $(".btn_acceder_cuenta_enid");
let $accion_iniciar_session = $(".accion_iniciar_session");
let $q_enid = $(".q_enid");

$(document).ready(function () {


    $('#sticky-footer').addClass("d-none");
    $(".base_enid_web").removeClass("top_150").addClass("mt-3");
    $(".anuncio_registro_descuento").addClass('d-none');

    $registrar_cuenta_botton.click(mostrar_seccion_nuevo_usuario);
    $form_inicio.submit(valida_form_session);
    $form_pass.submit(recupera_password);
    $olvide_pass.click(carga_mail);
    $form_registro.submit(agrega_usuario);
    $olvide_pass.click(muestra_contenedor_recuperacion);
    $btn_acceder_cuenta_enid.click(muestra_seccion_acceso);
    $botton_registro_usuario_nuevo.click(intento_registro_accion);

    valida_registro_usuario();

    $registro_nombre.keypress(function (e) {

        transforma_mayusculas(this);
        $(".registro_google").addClass("d-none").removeClass("d-block");
        $(".accion_acceder_cuenta_enlace").addClass("d-none");
        $(".tambien_puedes").addClass("d-none");
        if (e.which == 13) {
            let nombre = $(this).val();
            error_enid_input($(this).attr("id"));

            if (nombre.length > 3) {

                $(".contenedor_input_registro_email").removeClass("d-none");
                oculta_contenedor_input_enid($(this).attr("id"));
            }
        }
    });

    $registro_email.keypress(function (e) {
        if (e.which == 13) {
            let email = $(this).val();
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {

                error_enid_input($(this).attr("id"));


            } else {

                oculta_contenedor_input_enid($(this).attr("id"));
                $(".contenedor_input_registro_tel").removeClass("d-none");
            }
        }
    });

    $registro_telefono.keypress(function (e) {

        if (e.which == 13) {
            let $telefono = $(this).val();
            var regexTelefono = /^([0-9]{8}|[0-9]{10}|[0-9]{12})$/;
            if (!regexTelefono.test($telefono)) {

                error_enid_input($(this).attr("id"));

            } else {

                oculta_contenedor_input_enid($(this).attr("id"));
                $(".contenedor_input_registro_pw").removeClass("d-none");

            }
        }
    });

    $registro_pw.keypress(function (e) {
        if (e.which == 13) {
            let len = $(this).val();

            if (len.length < 4) {
                error_enid_input($(this).attr("id"));


            } else {

                oculta_contenedor_input_enid($(this).attr("id"));

            }
        }
    });

    $input_correo_inicio.keypress(function (e) {
        if (e.which == 13) {
            let email = $(this).val();
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            error_enid_input($(this).attr("id"));
            if (!emailRegex.test(email)) {


                error_enid_input($(this).attr("id"));


            } else {


                oculta_error_enid_input($(this).attr("id"));
            }
        }
    });

    $input_password_inicio.keypress(function (e) {
        if (e.which == 13) {
            let len = $(this).val();
            if (len.length < 4) {
                error_enid_input($(this).attr("id"));

            } else {

                oculta_error_enid_input($(this).attr("id"));

            }
        }
    });


    $mail_acceso.keypress(function (e) {
        $(".boton_iniciar_google_seccion").addClass("d-none");
        $(".tambien_puedes_iniciar").addClass("d-none");
    });
    $input_password_inicio.keypress(function (e) {
        $(".boton_iniciar_google_seccion").addClass("d-none");
        $(".tambien_puedes_iniciar").addClass("d-none");
    });



    $icono_mostrar_password.click(mostrar_password);
    $icono_ocultar_password.click(ocultar_password);

    $accion_iniciar_session.click(function () {

        $mail_acceso.trigger(jQuery.Event("keypress", { which: 13 }));
        $input_password_inicio.trigger(jQuery.Event("keypress", { which: 13 }));
    });

});


let response_inicio_session = data => {

    $("#modal-error-message").modal("hide");
    if (data.login === false) {

        desbloqueda_form(form_inicio);
        $(".notificacion_datos_incorrectos").removeClass("d-none");
        $('.place_acceso_sistema').addClass('d-none');

    } else {

        redirect(path_enid("url_home"));

    }
};

let valida_form_session = e => {

    let respuestas = [];
    respuestas.push(es_formato_email($input_correo_inicio));
    respuestas.push(es_formato_password($input_password_inicio));
    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {

        let secret = "" + CryptoJS.SHA1($input_password_inicio.val());
        let data_send = { "secret": secret, 'email': $input_correo_inicio.val() };
        modal('Vamos comprobar si ya tienes una cuenta ...', 1);
        let url = '../login/index.php/api/sess/start/format/json/';
        bloquea_form(form_inicio);
        request_enid('POST', data_send, url, response_inicio_session);

    }

    e.preventDefault();

};
let recupera_password = e => {

    if (valida_email_form(email_recuperacion, place_recuperacion)) {
        $(place_recuperacion).empty();
        let url = $form_pass.attr('action');
        let data_send = $form_pass.serialize();
        bloquea_form(form_pass);
        request_enid('POST', data_send, url, response_recupera_password, '.place_status_inicio');
    }
    e.preventDefault();
};

let response_recupera_password = data => {

    if (data > 0) {
        let newDiv = document.createElement('div');
        newDiv.setAttribute('class', 'envio_correcto');
        let newContent = document.createTextNode('El correo de recuperación se ha enviado con éxito.!');
        newDiv.appendChild(newContent);
        render_enid(place_recuperacion, newDiv);
        seccess_enid('.place_status_inicio', newDiv);
    }
};

let carga_mail = () => $email_recuperacion.val(get_parameter(email));

let mostrar_seccion_nuevo_usuario = () => {

    despliega([contenedor_recuperacion_password, wr], 0);
    despliega([seccion_registro_usuario]);
    recorre('#flipkart-navbar');

};

let muestra_seccion_acceso = () => {

    despliega(wr);
    despliega([contenedor_recuperacion_password, seccion_registro_usuario], 0);
};
let muestra_contenedor_recuperacion = () => {

    despliega([wr, seccion_registro_usuario], 0);
    despliega(contenedor_recuperacion_password);
    recorre('#flipkart-navbar');
};

let mostrar_password = function () {

    $input_password_inicio.attr('type', 'text');
    $(this).addClass("d-none");
    $icono_ocultar_password.removeClass("d-none");
}

let ocultar_password = function () {

    $input_password_inicio.attr('type', 'password');
    $(this).addClass("d-none");
    $icono_mostrar_password.removeClass('d-none');

}
let agrega_usuario = (e) => {

    let url = '../q/index.php/api/usuario/vendedor/format/json/';
    let perfil = get_valor_selected('.perfil');
    let respuestas = [];
    respuestas.push(es_formato_email($registro_email));
    respuestas.push(es_formato_telefono($registro_telefono));
    let $tiene_formato = (!respuestas.includes(false));
    if ($tiene_formato) {

        bloquea_form(".form-miembro-enid-service");
        modal('Registrando tu cuenta ...', 1);

        $(".form-miembro-enid-service").addClass("d-none");
        $(".formulario_registro").addClass("d-none");

        let tmp_password = '' + CryptoJS.SHA1($registro_pw.val());
        let nombre = $registro_nombre.val();
        let email = $registro_email.val();

        let data_send = {
            'nombre': nombre,
            'email': email,
            'password': tmp_password,
            'simple': 1,
            'perfil': perfil,
            'tiene_auto': 0,
            'tiene_moto': 0,
            'tiene_bicicleta': 0,
            'reparte_a_pie': 0,
            'tel_contacto': $registro_telefono.val()
        };

        request_enid('POST', data_send, url, response_usuario_registro);
    }
    e.preventDefault();
};
let response_usuario_registro = data => {


    if (array_key_exists("id_usuario", data)) {

        redirect(path_enid("url_home"));

    } else {

        $("#modal-error-message").modal("hide");
        $(".formulario_registro").removeClass("d-none");

        if (parseInt(data.usuario_existe) > 0) {

            redirect("?action=registro");
        }
    }
};
let intento_registro_accion = function () {

    $registro_nombre.trigger(jQuery.Event("keypress", { which: 13 }));
    $registro_email.trigger(jQuery.Event("keypress", { which: 13 }));
    $registro_telefono.trigger(jQuery.Event("keypress", { which: 13 }));
    $registro_pw.trigger(jQuery.Event("keypress", { which: 13 }));

}
let valida_registro_usuario = function () {

    let $q = $q_enid.val();
    if ($q > 0) {
        $registrar_cuenta_botton.click();
    }

}