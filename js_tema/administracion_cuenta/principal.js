"use strict";
let input_telefono = ".form_telefono_usuario #telefono_usuario";
let form_telefono = ".form_telefono_usuario";
let form_nombre_usuario = ".form_nombre_usuario";
let form_password = '#form_password';
let $form_telefono = $(form_telefono);
let $form_nombre_usuario = $(form_nombre_usuario);
let $input_telefono_usuario = $form_telefono.find('#telefono_usuario');
let $input_nombre_usuario = $form_nombre_usuario.find('#nombre_usuario');
let $form_password = $(form_password);
let $input_password = $form_password.find("#password");
let $input_nueva = $form_password.find("#pw_nueva");
let $input_nueva_confirmacion = $form_password.find("#pw_nueva_confirm");

let $auto = $(".auto");
let $moto = $(".moto");
let $bicicleta = $(".bicicleta");
let $pie = $(".pie");
let $form_orden_productos = $(".form_orden_productos");


$(document).ready(() => {

    $(".btn_direccion").click(() => {
        set_option("v", 1);
        direccion_usuario();
    });
    $form_nombre_usuario.submit(nombre);
    $(".tab_privacidad_seguridad").click(get_conceptos);
    $form_password.submit(password);
    $(".editar_imagen_perfil").click(carga_form_imagenes_usuario);

    $form_telefono.submit(actualiza_telefono);
    $input_telefono_usuario.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_telefono, 1);
    });
    $input_nombre_usuario.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_nombre_usuario, 1);
    });

    $auto.click(auto);
    $moto.click(moto);
    $bicicleta.click(bicicleta);
    $pie.click(pie);
    $form_orden_productos.submit(orden_productos);


});
let auto = function (e) {

    let url = "../q/index.php/api/usuario/auto/format/json/";
    let id = get_parameter_enid($(this), "id");
    let data_send = {
        auto: id,
    };

    request_enid("PUT", data_send, url, response_tipos_entregas);
}
let moto = function (e) {

    let url = "../q/index.php/api/usuario/moto/format/json/";
    let id = get_parameter_enid($(this), "id");
    let data_send = {
        moto: id,
    };
    
    request_enid("PUT", data_send, url, response_tipos_entregas);
}
let bicicleta = function (e) {

    let url = "../q/index.php/api/usuario/bicicleta/format/json/";
    let id = get_parameter_enid($(this), "id");

    let data_send = {
        bicicleta: id,
    };

    request_enid("PUT", data_send, url, response_tipos_entregas);
}
let pie = function (e) {

    let url = "../q/index.php/api/usuario/pie/format/json/";
    let id = get_parameter_enid($(this), "id");

    let data_send = {
        pie: id,
    };

    request_enid("PUT", data_send, url, response_tipos_entregas);
}
let response_tipos_entregas = function (data) {

    redirect('');
}
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

    if (get_option("existe_codigo_postal") === 1) {

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
let nombre = e => {

    let respuestas = [];
    respuestas.push(es_formato_nombre($input_nombre_usuario));
    let $tiene_formato = (!respuestas.includes(false));
    if ($tiene_formato) {

        let data_send = $form_nombre_usuario.serialize();
        let url = "../q/index.php/api/usuario/nombre_usuario/format/json/";
        request_enid("PUT", data_send, url, response_actualizacion);
    }

    e.preventDefault();
};
let actualiza_telefono = e => {

    let respuestas = [];
    respuestas.push(es_formato_telefono($input_telefono_usuario));
    let $tiene_formato = (!respuestas.includes(false));
    if ($tiene_formato) {

        let data_send = $form_telefono.serialize();
        let url = "../q/index.php/api/usuario/telefono/format/json/";
        bloquea_form(form_telefono);
        request_enid("PUT", data_send, url, response_actualizacion);

    } else {

        desbloqueda_form(form_telefono);
    }

    e.preventDefault();
};
let response_actualizacion = function (data) {

    if (data === true) {

        redirect('');
    } else {

        desbloqueda_form(form_telefono);
    }
};

let password = e => {

    let respuestas = [];
    respuestas.push(es_formato_password($input_password));
    respuestas.push(es_formato_password($input_nueva));
    respuestas.push(es_formato_password($input_nueva_confirmacion));

    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {

        let password = $input_password.val();
        let nueva = $input_nueva.val();
        let confirmacion = $input_nueva_confirmacion.val();
        if (nueva === confirmacion) {

            if (password !== nueva) {

                let anterior = "" + CryptoJS.SHA1(password);
                let nuevo = "" + CryptoJS.SHA1(nueva);
                let confirma = "" + CryptoJS.SHA1(confirmacion);
                s_password(anterior, nuevo, confirma);

            } else {
                modal('Las contraseñas son las mismas');
            }

        } else {

            modal('Las nuevas contraseña no coinciden');
            $input_nueva.next().next().removeClass('d-none');
            $input_nueva_confirmacion.next().next().removeClass('d-none');
        }

    }

    e.preventDefault();
};
let s_password = (anterior, nuevo, confirma) => {

    let url = "../q/index.php/api/usuario/pass/format/json/";
    let data_send = {"nuevo": nuevo, "anterior": anterior, "confirma": confirma, "type": 2};
    bloquea_form(form_password);
    request_enid("PUT", data_send, url, response_password);
};
let response_password = data => {

    if (data === true) {

        let $inicio = "Contraseña actualizada, inicia sessión para verificar el cambio.";
        seccess_enid(".msj_password", $inicio);
        setInterval('termina_session()', 3000);

    } else {

        modal(data);

    }
};
let orden_productos = function (e) {

    let data_send = $(this).serialize();
    let url = "../q/index.php/api/usuario/orden_producto/format/json/";
    advierte('Procesando', 1);
    bloquea_form("form_orden_productos");
    request_enid("PUT", data_send, url, response_orden_productos);

    e.preventDefault();
}
let response_orden_productos = function (data) {

    redirect(path_enid("galeria"));
}