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
let $form_registro = $(form_registro);

let $nombre_persona = $form_registro.find(nombre_persona);


let $texto_telefono = $form_registro.find('.texto_telefono');

let $registro_email = $form_registro.find('.registro_email');
let $registro_pw = $form_registro.find('.registro_pw');
let $botton_registro = $form_registro.find('.botton_registro');
let $perfil = $form_registro.find('.perfil');
let $input_correo_inicio = $form_inicio.find('.correo');
let $input_password_inicio = $form_inicio.find('#pw');
let $seccion_entrega = $form_registro.find('.seccion_entrega');

let $auto = $form_registro.find('.auto');
let $moto = $form_registro.find('.moto');
let $bicicleta = $form_registro.find('.bicicleta');
let $pie = $form_registro.find('.pie');

let $tiene_auto = $form_registro.find('.tiene_auto');
let $tiene_moto = $form_registro.find('.tiene_moto');
let $tiene_bicicleta = $form_registro.find('.tiene_bicicleta');
let $reparte_a_pie = $form_registro.find('.reparte_a_pie');
let $link_como_vender = $form_registro.find('.link_como_vender');


$(document).on('ready', () => {

    $('footer').ready(valida_seccion_inicial);
    $(soy_nuevo).click(mostrar_seccion_nuevo_usuario);
    $('.btn_soy_nuevo_simple').click(mostrar_seccion_nuevo_usuario);
    $(registrar).click(mostrar_seccion_nuevo_usuario);
    $form_inicio.submit(valida_form_session);
    $form_pass.submit(recupera_password);
    $olvide_pass.click(carga_mail);
    $form_registro.submit(agrega_usuario);
    $olvide_pass.click(muestra_contenedor_recuperacion);
    $('.btn_acceder_cuenta_enid').click(muestra_seccion_acceso);

    despliega('.extra_menu_simple', 1);
    despliega(['.base_compras', '.base_paginas_extra', '.info_metodos_pago'], 0);
    /*REGISTRO*/
    $nombre_persona.keyup(function (e) {
        transforma_mayusculas(this);
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_registro, 1);
    });

    $registro_email.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_registro, 1);
    });

    $registro_pw.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_registro, 1);
    });

    $email_recuperacion.keyup(() => {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_registro, 1);
    });
    /*Acceso*/
    $input_correo_inicio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_inicio, 1);
    });

    $input_password_inicio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_inicio, 1);
    });

    $perfil.change(seleccion_entrega);

    $auto.click(evaluacion_auto);
    $moto.click(evaluacion_moto);
    $bicicleta.click(evaluacion_bicicleta);
    $pie.click(evaluacion_pie);

});


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
        advierte('VERIFICA TUS DATOS DE ACCESO');
        $(selector_acceso_sistema).addClass('d-none');

    }
};

let valida_form_session = e => {

    let respuestas = [];
    respuestas.push(es_formato_password($input_password_inicio));
    respuestas.push(es_formato_email($input_correo_inicio));
    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {
        let str = "" + CryptoJS.SHA1($input_password_inicio.val());
        let action = $('#in').attr('action');
        set_option({
            'tmp_password': str,
            'url': action,
            'email': $input_correo_inicio.val()
        });
        inicio_session();
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
let agrega_usuario = (e) => {

    let url = '../q/index.php/api/usuario/vendedor/format/json/';
    let perfil = get_valor_selected('.perfil');
    let respuestas = [];
    respuestas.push(es_formato_password($registro_pw));
    respuestas.push(es_formato_email($registro_email));
    respuestas.push(es_formato_nombre($nombre_persona));
    respuestas.push(es_formato_telefono($texto_telefono));

    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {

        let tmp_password = '' + CryptoJS.SHA1($registro_pw.val());
        let nombre = $nombre_persona.val();
        let email = $registro_email.val();

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
            'perfil': perfil,
            'tiene_auto': $tiene_auto.val(),
            'tiene_moto': $tiene_moto.val(),
            'tiene_bicicleta': $tiene_bicicleta.val(),
            'reparte_a_pie': $reparte_a_pie.val(),
            'tel_contacto': $texto_telefono.val()
        };

        request_enid('POST', data_send, url, response_usuario_registro);

    }
    e.preventDefault();
};
let response_usuario_registro = data => {

    if (data.usuario_registrado === 1) {

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

let seleccion_entrega = () => {


    let $id_perfil = parseInt(get_valor_selected('.perfil'));


    if ($id_perfil !== 6) {

        $link_como_vender.addClass('d-none');
    } else {
        $link_como_vender.removeClass('d-none');
    }

    if ($id_perfil !== 21) {
        $seccion_entrega.addClass('d-none');
    } else {
        $seccion_entrega.removeClass('d-none');
    }
};

let evaluacion_auto = function (e) {

    let $id = parseInt(e.target.id);
    if ($id > 0) {

        $auto.removeClass('button_enid_eleccion_active');
        $(this).attr('id', 0);
        $tiene_auto.val(0);

    } else {

        $auto.addClass('button_enid_eleccion_active');
        $(this).attr('id', 1);
        $tiene_auto.val(1);
    }

};

let evaluacion_moto = function (e) {

    let $id = parseInt(e.target.id);
    if ($id > 0) {

        $moto.removeClass('button_enid_eleccion_active');
        $(this).attr('id', 0);
        $tiene_moto.val(0);

    } else {

        $moto.addClass('button_enid_eleccion_active');
        $(this).attr('id', 1);
        $tiene_moto.val(1);
    }

};

let evaluacion_bicicleta = function (e) {

    let $id = parseInt(e.target.id);
    if ($id > 0) {

        $bicicleta.removeClass('button_enid_eleccion_active');
        $(this).attr('id', 0);
        $tiene_bicicleta.val(0);

    } else {

        $bicicleta.addClass('button_enid_eleccion_active');
        $(this).attr('id', 1);
        $tiene_bicicleta.val(1);
    }
};

let evaluacion_pie = function (e) {

    let $id = parseInt(e.target.id);
    if ($id > 0) {

        $pie.removeClass('button_enid_eleccion_active');
        $(this).attr('id', 0);
        $reparte_a_pie.val(0);

    } else {

        $pie.addClass('button_enid_eleccion_active');
        $(this).attr('id', 1);
        $reparte_a_pie.val(1);
    }
};
