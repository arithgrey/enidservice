"use strict";
$(document).ready(() => {
    $(".selector").click(muestra_opciones);
    $(".form_correo").submit(envia_correo);
    $(".form_whatsapp").submit(envia_whatsapp);

});
let muestra_opciones = function() {

    $(".text_selector").hide();
    switch (get_parameter_enid($(this), "id")) {

        case 1:

            showonehideone(".contenedor_eleccion_correo_electronico", ".contenedor_eleccion");

            break;
        case 2:

            showonehideone(".contenedor_eleccion_whatsapp", ".contenedor_eleccion");
            break;

        default:

            break;
    }
};
let envia_correo = e => {


    let nombre = get_parameter(".nombre");
    let correo = get_parameter(".correo_electronico");

    if (nombre.length > 5 && correo.length > 5) {

        let pw = "" + CryptoJS.SHA1(randomString(8));
        let data_send = $(".form_correo").serialize() + "&" + $.param({"password": pw});
        let url = "../q/index.php/api/usuario/vendedor/format/json/";
        bloquea_form(".form_correo");
        request_enid("POST", data_send, url, r_send_email);

    } else {

        focus_input([".correo_electronico", ".nombre_correo"]);
    }
    e.preventDefault();

};
let r_send_email = data => redirect("../contact/?ubicacion=1#direccion");

let envia_whatsapp = (e) => {

    let nombre = get_parameter(".nombre_whatsapp").length;
    let tel = get_parameter(".tel").length;

    if (nombre > 5 && tel > 5) {


        let password = "" + CryptoJS.SHA1(randomString(8));
        let data_send = $(".form_whatsapp").serialize() + "&" + $.param({"password": password});
        let url = "../q/index.php/api/usuario/whatsapp/format/json/";
        bloquea_form(".form_whatsapp");
        request_enid("POST", data_send, url, r_send_whatsApp);

    } else {

        let inputs = [".tel", ".nombre_whatsapp"];
        focus_input(inputs);

    }
    e.preventDefault();
};
let r_send_whatsApp = data => {

    let usuario = data.id_usuario;
    set_parameter(".usuario", usuario);
    $(".form_proceso_compra").submit();
};