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

let place_recuperacion = '.place_recuperacion_pw';
let $olvide_pass = $('.olvide_pass');
let wr = '.wrapper_login';
let contenedor_recuperacion_password = '.contenedor_recuperacion_password';
let seccion_registro_usuario = '.seccion_registro_nuevo_usuario_enid_service';
let $form_inicio = $(form_inicio);
let $form_registro = $(form_registro);
let $nombre_persona = $form_registro.find(nombre_persona);
let $texto_telefono = $form_registro.find('.texto_telefono');
let $registro_email = $form_registro.find('.registro_email');
let $registro_pw = $form_registro.find('.registro_pw');
let $perfil = $form_registro.find('.perfil');
let $input_correo_inicio = $form_inicio.find('.correo');
let $input_password_inicio = $form_inicio.find('#pw');
let $seccion_entrega = $form_registro.find('.seccion_entrega');
let $icono_mostrar_password = $form_inicio.find('.mostrar_password');
let $icono_ocultar_password = $form_inicio.find('.ocultar_password');

let $link_como_vender = $form_registro.find('.link_como_vender');
let $label_mail_acceso = $(".label_mail_acceso");
let $label_pw = $(".label_pw");
$(document).ready(function () {
    
    $('#sticky-footer').addClass("d-none");
    $(".base_enid_web").removeClass("top_150").addClass("mt-3");    
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

    $nombre_persona.keyup(function (e) {
        transforma_mayusculas(this);        
    });
    
    $icono_mostrar_password.click(mostrar_password);
    $icono_ocultar_password.click(ocultar_password);

});

let inicio_session = () => {

    let data_send = {secret: get_option('tmp_password'), 'email': get_option('email')};
    let $min_mail = get_parameter('#mail_acceso').length > MIN_CORREO_LENGTH;
    let $min_pw = get_parameter(pw).length > MIN_PW_LENGTH;
    if ($min_mail && $min_pw) {
        modal('Vamos comprobar si ya tienes una cuenta ...', 1);
        let url = '../login/index.php/api/sess/start/format/json/';
        bloquea_form(form_inicio);
        request_enid('POST', data_send, url, response_inicio_session);

    }
};

let response_inicio_session = data => {
    
    $("#modal-error-message").modal("hide");
    if (data.login === false) {

        desbloqueda_form(form_inicio);
        advierte('Ups! esos datos son incorrectos!');
        $('.place_acceso_sistema').addClass('d-none');

    } else {
        
        redirect(path_enid("url_home"));
        
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
        bloquea_form(".form-miembro-enid-service");    
        modal('Registrando tu cuenta ...', 1);
        
        $(".form-miembro-enid-service").addClass("d-none");
        $(".formulario_registro").addClass("d-none");
        
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
            'tiene_auto': 0,
            'tiene_moto': 0,
            'tiene_bicicleta': 0,
            'reparte_a_pie': 0,
            'tel_contacto': 0
        };
        
        request_enid('POST', data_send, url, response_usuario_registro);
    }
    e.preventDefault();
};
let response_usuario_registro = data => {    
    
    if ( array_key_exists("id_usuario", data) ) {
        
        redirect(path_enid("url_home"));

    } else {

        $("#modal-error-message").modal("hide");
        $(".formulario_registro").removeClass("d-none");

        if (parseInt(data.usuario_existe) > 0) {
                        
            redirect("?action=registro");
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
    $(".base_enid_web").removeClass("top_100");
    switch (get_parameter('.action')) {
        case 'nuevo':
            mostrar_seccion_nuevo_usuario();
            break;
        case 'sin_usuario':
            $(".texto_registro").removeClass("d-none");
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

let mostrar_password = function (){

    $input_password_inicio.attr('type', 'text');
    $(this).addClass("d-none");
    $icono_ocultar_password.removeClass("d-none");
}

let ocultar_password = function (){

    $input_password_inicio.attr('type', 'password');
    $(this).addClass("d-none");
    $icono_mostrar_password.removeClass('d-none');

}