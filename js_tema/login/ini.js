//"use strict";
$(document).on("ready", () => {

    $("footer").ready(valida_seccion_inicial);
    $(".btn_soy_nuevo").click(mostrar_seccion_nuevo_usuario);
    $(".btn_soy_nuevo_simple").click(mostrar_seccion_nuevo_usuario);
    $(".registrar-cuenta").click(mostrar_seccion_nuevo_usuario);
    $(".form_sesion_enid").submit(valida_form_session);
    $(".form-pass").submit(recupera_password);
    $("#olvide-pass").click(carga_mail);
    $(".form-miembro-enid-service").submit(agrega_usuario);
    $(".recupara-pass").click(muestra_contenedor_recuperacion);
    $(".btn_acceder_cuenta_enid").click(muestra_seccion_acceso);
    $(".nombre_persona").keyup(() => {
        transforma_mayusculas(this);
    });
    despliega(".extra_menu_simple", 1);
    despliega([".base_compras", ".base_paginas_extra", ".info_metodos_pago"], 0);

    $("#mail").keyup(() => {
        sin_espacios("#mail");
    });

    $("#email_recuperacion").keyup(() => {
        sin_espacios("#email_recuperacion");
    });

});
let inicio_session = () => {


    let url = get_option("url");
    let data_send = {secret: get_option("tmp_password"), "email": get_option("email")};
    if (get_parameter("#mail").length > 5 && get_parameter("#pw").length > 5) {

        request_enid("POST", data_send, url, response_inicio_session, 1, before_inicio_session);

    } else {

        focus_input(["#email", "#pw"]);
    }
}
let before_inicio_session = () => {
    desabilita_botones();
    sload(".place_acceso_sistema", "Validando datos ", 1);
}
let response_inicio_session = data => {

    if (data !== 0) {

        redirect(data);

    } else {

        habilita_botones();
        format_error(".place_acceso_sistema", "Error en los datos de acceso");
    }
}
let valida_form_session = e => {

    let pw = $.trim(get_parameter("#pw"));
    let email = get_parameter('#mail');
    if (valida_formato_pass(pw) == valida_formato_email(email)) {

        let tmp_password = "" + CryptoJS.SHA1(pw);
        set_option("tmp_password", tmp_password);
        set_option("url", $("#in").attr("action"));
        set_option("email", email);
        inicio_session();
    }
    e.preventDefault();
}
let recupera_password = e => {

    let flag = valida_email_form("#email_recuperacion", ".place_recuperacion_pw");
    if (flag == 1) {
        $(".place_recuperacion_pw").empty();
        let url = $(".form-pass").attr("action");
        let data_send = $(".form-pass").serialize();
        bloquea_form(".form-pass");
        request_enid("POST", data_send, url, response_recupera_password, ".place_status_inicio");
    }
    e.preventDefault();
}
let response_recupera_password = data => {

    if (data > 0) {

        $('#contenedor-form-recuperacion').find('input, textarea, button, select').attr('disabled', 'disabled');
        let newDiv = document.createElement("div");
        newDiv.setAttribute("class", "envio_correcto");
        let newContent = document.createTextNode("El correo de recuperación se ha enviado con éxito.!");
        newDiv.appendChild(newContent);
        render_enid(".place_recuperacion_pw", newDiv);
        seccess_enid(".place_status_inicio", newDiv);
    }

}
let carga_mail = () => $("#email_recuperacion").val(get_parameter("#mail"));

let valida_formato_pass = text => {

    let estado = 0;
    if (text.length >= 8) {

        estado = 1;

    } else {

        format_error(".place_acceso_sistema", "Contraseña muy corta!");
    }
    return estado;
}

let valida_formato_email = email => {

    let estado = 1;
    let expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (valEmail(email)) {
        estado = 0;
        format_error(".place_acceso_sistema", "Correo no valido");
    }
    return estado;
}
let habilita_botones = function () {

    for (a = 0; a < document.getElementsByTagName('input').length; a++) {
        document.getElementsByTagName('input')[a].disabled = false;
    }
}
let desabilita_botones = () => {

    for (a = 0; a < document.getElementsByTagName('input').length; a++) {
        document.getElementsByTagName('input')[a].disabled = true;
    }
}
let mostrar_seccion_nuevo_usuario = () => {

    despliega([".contenedor_recuperacion_password", ".wrapper_login"], 0);
    despliega([".seccion_registro_nuevo_usuario_enid_service"]);

}
let agrega_usuario = (e) => {

    let url = "../q/index.php/api/usuario/vendedor/format/json/";
    let password = get_parameter(".form-miembro-enid-service .password");
    let email = get_parameter(".form-miembro-enid-service .email");
    let nombre = get_parameter(".form-miembro-enid-service .nombre");

    if (valida_formato_email(email) == valida_formato_pass(password)) {
        if (val_text_form(".nombre", ".place_registro_miembro", 5, "Nombre") == 1) {

            let tmp_password = "" + CryptoJS.SHA1(password);
            set_option({
                "tmp_password": tmp_password,
                "email": email,
                "nombre": nombre,

            });

            let data_send = {"nombre": nombre, "email": email, "password": tmp_password, "simple": 1};
            request_enid("POST", data_send, url, response_usuario_registro);
        }
    }
    e.preventDefault();
}
let response_usuario_registro = data => {


    if (data.usuario_registrado == 1) {

        let srt = "<a class='acceder_btn'> Registro correcto! ahora puedes acceder aquí!</a>";
        render_enid(".place_acceso_sistema", str);
        habilita_botones();
        redirect("?action=registro");
    } else {

        if (data.usuario_existe == 1) {
            let str = "<span class='alerta_enid'> Este usuario ya se encuentra registrado, " +
                "<span class='acceso_a_cuenta'> accede a tu cuenta aquí " +
                "</span> " +
                "</span>";

            render_enid(".place_registro_miembro", str);
            $(".acceso_a_cuenta").click(muestra_seccion_acceso);
            habilita_botones();

        }
    }
}
let muestra_seccion_acceso = () => {

    despliega(".wrapper_login");
    despliega([".contenedor_recuperacion_password", ".seccion_registro_nuevo_usuario_enid_service"], 0);
}
let muestra_contenedor_recuperacion = () => {

    despliega([".wrapper_login", ".seccion_registro_nuevo_usuario_enid_service"], 0);
    despliega(".contenedor_recuperacion_password");
}
let valida_seccion_inicial = () => {
    switch (get_parameter(".action")) {
        case "nuevo":
            mostrar_seccion_nuevo_usuario();
            break;
        case "recuperar":
            muestra_contenedor_recuperacion();
            break;
        case "registro":
            facilita_acceso();
            break;
        default:
    }
}
let facilita_acceso = () => {

    let secciones = [
        ".olvide_pass",
        ".registrar_cuenta",
        ".btn_soy_nuevo",
        ".iniciar_sesion_lateral",
        ".call_to_action_anuncio",
        ".contenedor-lateral-menu"
    ];
    despliega(secciones, 0);
};
