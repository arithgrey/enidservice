'use strict';
let email_recuperacion = '#email_recuperacion';
let $email_recuperacion = $(email_recuperacion);
let $mail_acceso = $('#mail_acceso');
let soy_nuevo = '.btn_soy_nuevo';
let registrar = '.registrar_cuenta';
let form_inicio = '.form_sesion_enid';
let form_pass = '.form-pass';
let $form_pass = $(form_pass);
let form_registro = '.form-miembro-enid-service';
let nombre_persona = '.nombre_persona';
let email = '#mail';
let pw = '#pw';
let $pw = $('#pw');
let selector_acceso_sistema = '.place_acceso_sistema';
let place_recuperacion = '.place_recuperacion_pw';
let $olvide_pass = $('.olvide_pass');
let wr = '.wrapper_login';
let contenedor_recuperacion_password = '.contenedor_recuperacion_password';
let seccion_registro_usuario = '.seccion_registro_nuevo_usuario_enid_service';
let registro_pw = '.registro_pw';
let $form_inicio = $(form_inicio);
$(document).on('ready', () => {


    $('footer').ready(valida_seccion_inicial);
    $(soy_nuevo).click(mostrar_seccion_nuevo_usuario);
    $('.btn_soy_nuevo_simple').click(mostrar_seccion_nuevo_usuario);
    $(registrar).click(mostrar_seccion_nuevo_usuario);
    $form_inicio.submit(valida_form_session);
    $form_pass.submit(recupera_password);
    $olvide_pass.click(carga_mail);
    $(form_registro).submit(agrega_usuario);
    $olvide_pass.click(muestra_contenedor_recuperacion);
    $('.btn_acceder_cuenta_enid').click(muestra_seccion_acceso);

    despliega('.extra_menu_simple', 1);
    despliega(['.base_compras', '.base_paginas_extra', '.info_metodos_pago'], 0);

    $(nombre_persona).keyup(function () {
        transforma_mayusculas(this);
    });

    $email_recuperacion.keyup(() => {
        sin_espacios(email_recuperacion);
    });

    $form_inicio.find('.correo').keyup(submit_inputs);
    $form_inicio.find('#pw').keyup(submit_inputs);

});

let submit_inputs = (e) => {

    let keycode = e.keyCode;
    if (keycode === 13) {

        $form_inicio.submit();
    }

};

let inicio_session = () => {

    let data_send = {secret: get_option('tmp_password'), 'email': get_option('email')};
    if (get_parameter('#mail_acceso').length > 5 && get_parameter(pw).length > 5) {
        let url = get_option('url');
        bloquea_form(form_inicio);
        sload(selector_acceso_sistema);
        request_enid('POST', data_send, url, response_inicio_session);

    } else {
        focus_input(['#email', pw]);
    }
};

let response_inicio_session = data => {

    if (data !== 0) {

        redirect(data);

    } else {

        desbloqueda_form(form_inicio);
        advierte('Verifica tus datos de acceso');
        $(selector_acceso_sistema).addClass('d-none');

    }
};

let valida_form_session = e => {
    let pass = $.trim($pw.val());
    let str_email = $mail_acceso.val();
    if (regular_email($mail_acceso)) {
        if (valida_formato_pass(pass) === valida_formato_email(str_email)) {
            let str = "" + CryptoJS.SHA1(pass);
            let action = $('#in').attr('action');
            set_option({
                'tmp_password': str,
                'url': action,
                'email': str_email
            });
            inicio_session();
        }
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

let valida_formato_pass = text => {

    let response = 1;
    if (text.length < 8) {
        advierte('Ups la contaseña es muy corta!');
        response--;
    }
    return response;

};

let valida_formato_email = email => {

    let response = 1;
    if (valEmail(email)) {
        response--;
        format_error(selector_acceso_sistema, 'Correo no valido');
    }
    return response;
};

let mostrar_seccion_nuevo_usuario = () => {

    despliega([contenedor_recuperacion_password, wr], 0);
    despliega([seccion_registro_usuario]);
    recorre('#flipkart-navbar');

};
let agrega_usuario = (e) => {

    let url = '../q/index.php/api/usuario/vendedor/format/json/';
    let password = get_parameter(registro_pw);
    let email = get_parameter('.registro_email');
    let nombre = get_parameter(nombre_persona);
    let formato_email = valida_formato_email(email);
    let perfil = get_valor_selected('.perfil');

    if (formato_email === valida_formato_pass(password) && parseInt(formato_email) > 0) {
        if (val_text_form(nombre_persona, '.place_registro_miembro', 3, 'Nombre')) {

            let tmp_password = '' + CryptoJS.SHA1(password);
            set_option({
                'tmp_password': tmp_password,
                'email': email,
                'nombre': nombre,

            });

            let data_send = {
                'nombre': nombre,
                'email': email,
                'password': tmp_password,
                'simple': 1,
                'perfil': perfil
            };
            request_enid('POST', data_send, url, response_usuario_registro);
        }
    }
    e.preventDefault();
};
let response_usuario_registro = data => {

    if (data.usuario_registrado == 1) {

        redirect('?action=registro');

    } else {

        if (data.usuario_existe > 0) {

            let str_usuario = 'Este usuario ya se encuentra registrado';
            let str = `<span class="alerta_enid d-block text-center p-3">${str_usuario}</span>`;
            let place = '.place_registro_miembro';
            render_enid(place, str);
            $(place).addClass('mt-5');
            $('.acceso_a_cuenta').click(muestra_seccion_acceso);
            desbloqueda_form(form_registro);

        }
    }
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
let valida_seccion_inicial = () => {
    switch (get_parameter('.action')) {
        case 'nuevo':
            mostrar_seccion_nuevo_usuario();
            break;
        case 'recuperar':
            muestra_contenedor_recuperacion();
            break;
        case 'registro':
            facilita_acceso();
            break;
        default:
    }
};
let facilita_acceso = () => {

    let secciones = [
        '.olvide_pass',
        registrar,
        soy_nuevo,
        '.iniciar_sesion_lateral',
        '.call_to_action_anuncio',
        '.contenedor-lateral-menu'
    ];
    despliega(secciones, 0);
};
