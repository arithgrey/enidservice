"use strict";
$(document).ready(() => {
    $(".btn_direccion").click(() =>{
        set_option("v", 1);
        direccion_usuario();
    });
    $(".form_nombre_usuario").submit(u_nombre);
    $(".tab_privacidad_seguridad").click(get_conceptos);
    $(".nombre_usuario").keyup(elimina_espacio);
    $(".tel2").keyup(() => {
        quita_espacios(".tel2");
    });
    $(".lada2").keyup(() => {
        quita_espacios(".lada2");
    });
    $("#form_update_password").submit(set_password);
    $(".editar_imagen_perfil").click(carga_form_imagenes_usuario);
    $(".form_telefono_usuario").submit(actualiza_telefono);
    $(".f_telefono_usuario_negocio").submit(set_tel);


});
let direccion_usuario = () => {

    let url = "../q/index.php/api/usuario_direccion/index/format/json/";
    let data_send = $(".form_notificacion").serialize() + "&" + $.param({"v": get_option("v")});
    request_enid("GET", data_send, url, response_direccion_usuario);

};
let response_direccion_usuario = data => {

    render_enid(".direcciones", data);
    $(".codigo_postal").keyup(auto_completa_direccion);
    $(".numero_exterior").keyup(() => {
        quita_espacios(".numero_exterior");
    });
    $(".numero_interior").keyup(() => {
        quita_espacios(".numero_interior");
    });
    $(".form_direccion_envio").submit(registra_direccion_usuario);
    $(".editar_direccion_persona").click(() => {
        set_option("v", 2);
        direccion_usuario();

    });

};
let registra_direccion_usuario = e => {

    if (get_option("existe_codigo_postal") == 1) {

        let url = "../q/index.php/api/codigo_postal/direccion_usuario/format/json/";
        let data_send = $(".form_direccion_envio").serialize() + "&" + $.param({"direccion_principal": 1});
        let asentamiento = get_parameter(".asentamiento");
        if (asentamiento != 0) {
            request_enid("POST", data_send, url, response_registra_direccion_usuario, ".place_proyectos");
            $(".place_asentamiento").empty();
        } else {
            recorre("#asentamiento");
            render_enid(".place_asentamiento", "<span class='alerta_enid'>Seleccione</span>");
        }
    }
    e.preventDefault();
};
let response_registra_direccion_usuario = data => {
    set_option("v", 1);
    direccion_usuario();
};
let u_nombre = e => {

    let data_send = $(".form_nombre_usuario").serialize();
    let url = "../q/index.php/api/usuario/nombre_usuario/format/json/";
    request_enid("PUT", data_send, url, function () {
        seccess_enid(".registro_nombre_usuario", "Tu nombre de usuario fue actualizado!");
    }, ".registro_nombre_usuario");
    e.preventDefault();
};
let actualiza_telefono = e => {

    let data_send = $(".form_telefono_usuario").serialize();
    let url = "../q/index.php/api/usuario/telefono/format/json/";
    request_enid("PUT", data_send, url, function () {
        seccess_enid(".registro_telefono_usuario", "Tu teléfono fue actualizado!");
    }, ".registro_telefono_usuario");

    e.preventDefault();
};
let set_tel = e => {

    if (get_parameter(".tel2").length > 4 && get_parameter(".lada2").length > 1) {

        let data_send = $(".f_telefono_usuario_negocio").serialize();
        let url = "../q/index.php/api/usuario/telefono_negocio/format/json/";
        request_enid("PUT", data_send, url, function () {
            seccess_enid(".registro_telefono_usuario_negocio", "Tu teléfono fue actualizado!");
        }, ".registro_telefono_usuario_negocio");

    } else {

        focus_input([".tel2", ".lada2"]);
    }
    e.preventDefault();
};
let elimina_espacio = function () {

    $(this).val(quita_espacios_text($(this).val().toLowerCase()));
};
let quita_espacios_text = v => {

    let valor = "";
    for (let a = 0; a < v.length; a++) {
        if (v[a] != " ") {
            valor += v[a];
        }
    }
    return valor;
};
let set_password = e => {

    let flag = val_text_form("#password", ".place_pw_1", 7, "Texto ");
    let flag2 = val_text_form("#pw_nueva", ".place_pw_2", 7, "Texto ");
    let flag3 = val_text_form("#pw_nueva_confirm", ".place_pw_3", 7, "Texto ");
    let npw = 0;

    if (flag === flag2 && flag === flag3) {
        let npw = (get_parameter("#password") != get_parameter("#pw_nueva")) ? 1 : 2;
        npw = (get_parameter("#password") != get_parameter("#pw_nueva_confirm")) ? 1 : 2;
    }

    switch (npw) {
        case 1:

            let anterior = "" + CryptoJS.SHA1(get_parameter("#password"));
            let nuevo = "" + CryptoJS.SHA1(get_parameter("#pw_nueva"));
            let confirma = "" + CryptoJS.SHA1(get_parameter("#pw_nueva_confirm"));
            s_password(anterior, nuevo, confirma);

            break;
        case 2:
            render_enid(".msj_password", "La nueva contraseña no puede ser igual a la actual ");
            break;
        default:
            break;
    }

    e.preventDefault();
};
let s_password = (anterior, nuevo, confirma) => {

    let url = "../q/index.php/api/usuario/pass/format/json/";
    let data_send = {"nuevo": nuevo, "anterior": anterior, "confirma": confirma, "type": 2};
    request_enid("PUT", data_send, url, r_password, ".msj_password");
};
let r_password = data => {

    if (data) {

        seccess_enid(".msj_password", "Contraseña actualizada, inicia sessión para verificar el cambio.");
        setInterval('termina_session()', 3000);

    } else {

        render_enid(".msj_password", data);

    }
};