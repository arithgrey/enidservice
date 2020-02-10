"use strict";
let form_punto_encuentro = '.form_punto_encuentro';
let form_punto_encuentro_horario = '.form_punto_encuentro_horario';
let ksearch = '.ksearch';
let desglose_estaciones = '.desglose_estaciones';
let place_lineas = '.place_lineas';
let contenedor_estaciones = '.contenedor_estaciones';
let text_seleccion_linea = '.text_seleccion_linea';
let seccion_horarios_entrega = '.seccion_horarios_entrega';
let place_estaciones_metro = '.place_estaciones_metro';
let text_seleccion_estacion = '.text_seleccion_estacion';
let punto_encuentro = '.punto_encuentro';

let secciones_default = [
    ".informacion_del_cliente",
    seccion_horarios_entrega,
    desglose_estaciones,
    ".formulario_quien_recibe"
];
let secciones_estaciones_metro = [
    place_lineas,
    contenedor_estaciones,
    text_seleccion_linea
];

/*global*/
let $es_regreso = 0;

/*global selectores*/
let $form_punto_encuentro = $(form_punto_encuentro);
let $input_nombre = $form_punto_encuentro.find('.nombre');
let $input_correo = $form_punto_encuentro.find('.correo');
let $input_telefono = $form_punto_encuentro.find('.telefono');
let $input_pw = $form_punto_encuentro.find('.pw');
let $fecha_entrega = $('.fecha_entrega');
let $form_punto_encuentro_horario = $(form_punto_encuentro_horario);
let $desglose_estaciones = $(desglose_estaciones);
let $linea_metro = $('.linea_metro');
let $link_acceso = $(".link_acceso");
let $boton_enviar_solicitud = $('.botton_enviar_solicitud');


window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.history.pushState({page: 4}, "", "");
window.history.pushState({page: 5}, "", "");
window.onpopstate = function (event) {

    if (event) {
        valida_retorno();
    }
};

$(document).ready(() => {

    $('footer').addClass('d-none');
    oculta_acceder();
    $boton_enviar_solicitud.click(() => {

        despliega([seccion_horarios_entrega], 0);
        despliega([".informacion_del_cliente"], 1);
        add_class(".continuar", "mt-5");
        set_option("vista", 4);
        verifica_formato_default_inputs(0);
    });

    $form_punto_encuentro.submit(registra_usuario);
    $form_punto_encuentro_horario.submit(notifica_punto_entrega);
    $link_acceso.click(set_link);
    $linea_metro.click(muestra_estaciones);

    set_option({"vista": 1, "punto_encuentro_previo": 0});
    despliega(secciones_default, 0);
    $desglose_estaciones.removeClass('d-lg-flex');
    $input_nombre.keypress(envia_formulario);
    $input_telefono.keypress(envia_formulario);
    $input_pw.keypress(envia_formulario);
    $input_correo.keypress(envia_formulario);
});

let estaciones = function (id, q) {

    let url = "../q/index.php/api/punto_encuentro/linea_metro/format/json/";
    set_option("id_linea", id);

    let data_send = [{}];
    if (parseInt(get_parameter(".primer_registro")) == 1) {

        data_send = {
            "id": id,
            "v": 1,
            "servicio": get_parameter(".servicio"),
            "q": q
        };

    } else {
        data_send = {
            "id": id,
            "v": 2,
            "recibo": get_parameter(".recibo"),
            "q": q
        };
    }

    request_enid("GET", data_send, url, response_estaciones);
};

let muestra_estaciones = function () {

    let q = texto_buscador();
    let id = 0;
    let id_linea = get_option("id_linea");
    if ($es_regreso < 1 && parseInt(id_linea) > 0) {

        id = id_linea;

    } else {

        id = get_parameter_enid($(this), "id");
        let $nombre_linea = get_parameter_enid($(this), "nombre_linea");
        set_option("nombre_linea", $nombre_linea);
        $es_regreso--;
    }

    if (parseInt(id) > 0) {
        estaciones(id, q);
    }
};


let response_estaciones = (data) => {

    set_option("vista", 2);
    despliega(secciones_estaciones_metro, 0);
    let secciones_estaciones = [
        seccion_horarios_entrega,
        desglose_estaciones,
        place_estaciones_metro,
        text_seleccion_estacion
    ];
    despliega(secciones_estaciones, 1);
    $desglose_estaciones.addClass('d-lg-flex');
    render_enid(place_estaciones_metro, data);
    $(punto_encuentro).click(muestra_horarios);
    buscador_estaciones_disponibles();

};
let muestra_horarios = function () {

    let id = get_parameter_enid($(this), "id");
    if (id > 0) {
        set_option({"punto_encuentro_previo": id, "vista": 3, "id_punto_encuentro": id});
        set_parameter(punto_encuentro, id);
        $desglose_estaciones.removeClass('d-lg-flex');
        showonehideone(".formulario_quien_recibe", ".desglose_estaciones");
    }
};

let registra_usuario = (e) => {

    verifica_formato_default_inputs(0);
    let len_telefono = $input_telefono.val().length;
    let len_pw = $input_pw.val().length;
    reset_posibles_errores();
    if (len_telefono > MIN_TELEFONO_LENGTH && len_pw > MIN_PW_LENGTH && regular_email($input_correo)) {
        advierte('Procesando tu pedido', 1);
        let password = "" + CryptoJS.SHA1($input_pw.val());
        let data_send = $form_punto_encuentro.serialize() + "&" + $.param({
            "password": password,
            "id_servicio": get_parameter(".servicio")
        });
        let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
        $boton_enviar_solicitud.attr("disabled", true);
        bloquea_form(form_punto_encuentro);
        request_enid("POST", data_send, url, response_registro_usuario);

    } else {

        focus_inputs_form(len_telefono, len_pw);

    }
    e.preventDefault();

};
let reset_posibles_errores = function () {

    $input_telefono.next().next().addClass('d-none');
    $input_pw.next().next().addClass('d-none');

};
let focus_inputs_form = (len_telefono, len_pw) => {


    if (len_telefono <= MIN_TELEFONO_LENGTH || len_telefono != TELEFONO_MOBILE_LENGTH) {

        $input_telefono.next().next().removeClass('d-none');
    }
    if (len_pw <= MIN_PW_LENGTH) {

        $input_pw.next().next().removeClass('d-none');
    }
};


let response_registro_usuario = (data) => {


    $("#modal-error-message").modal("hide");
    if (data.hasOwnProperty('usuario_existe') && parseInt(data.usuario_existe) > 0) {

        $('.continuar, .informacion_del_cliente').addClass('d-none');
        $('.usuario_existente').removeClass('d-none');
        set_option("vista", 5);

    } else {

        if (data.hasOwnProperty('id_recibo') && parseInt(data.id_recibo) > 0) {
            if (data.hasOwnProperty('session_creada') && parseInt(data.session_creada) > 0) {
                redirect_forma_pago(data.id_recibo);
            } else {
                console.log("No se creo la session, repara esto!");
            }
        } else {
            console.log("No se creo la orden, repara esto!");
        }
    }
};
let set_link = function () {

    let data_send = $.param({
        "id_servicio": get_parameter_enid($(this), "id_servicio"),
        "num_ciclos": get_parameter_enid($(this), "num_ciclos"),
        "punto_encuentro": get_option("punto_encuentro")
    });
    let url = "../login/index.php/api/sess/servicio/format/json/";
    request_enid("POST", data_send, url, go_login);

};

let notifica_punto_entrega = e => {

    let url = "../q/index.php/api/cobranza/solicitud_cambio_punto_entrega/format/json/";
    if (get_parameter(".primer_registro") > 0) {
        url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    }
    let data_send = $form_punto_encuentro_horario.serialize() + "&" + $.param({"tipo_entrega": 1});
    bloquea_form(form_punto_encuentro_horario);
    advierte('Procesando pedido', 1);
    request_enid("POST", data_send, url, response_notificacion_punto_entrega);
    e.preventDefault();
};
let response_notificacion_punto_entrega = (data) => {

    despliega([".place_notificacion_punto_encuentro", form_punto_encuentro_horario], 0);
    if (parseInt(get_parameter(".primer_registro")) == 1) {
        redirect_forma_pago(data.id_recibo);
    } else {
        redirect_forma_pago(get_parameter(".recibo"));

    }
};
let agregar_nota = () => {

    recorre(".comentarios");
    showonehideone(".input_notas", ".text_agregar_nota");

};
let valida_retorno = function () {
    let v = parseInt(get_option("vista"));

    switch (v) {
        case 1:

            break;
        case 2:
            $es_regreso++;
            despliega(secciones_estaciones_metro, 1);
            despliega([place_estaciones_metro, ksearch, text_seleccion_estacion], 0);
            break;
        case 3:

            set_option("vista", 2);
            $desglose_estaciones.addClass('d-lg-flex');
            showonehideone(contenedor_estaciones, ".formulario_quien_recibe");

            break;

        case 4:

            set_option("vista", 3);
            despliega([seccion_horarios_entrega], 1);
            despliega([".informacion_del_cliente"], 0);
            rm_class(".continuar", "mt-5");

            break;

        case 5:
            //Cuando se muestra que el usuario con el cual se quiere realizar la compra ya existe
            set_option("vista", 4);
            despliega(['.continuar', '.informacion_del_cliente'], 1);
            $('.usuario_existente').addClass('d-none');
            $boton_enviar_solicitud.attr("disabled", false);
            desbloqueda_form(form_punto_encuentro);

            break;
        default:

            break;
    }
};

let horarios_disponibles = () => {

    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = {"dia": $fecha_entrega.val()};
    request_enid("GET", data_send, url, response_horario);

};
let response_horario = (data) => {

    if (!isArray(data)) {
        render_enid(".horario_entrega", data);
    }
};


let texto_buscador = () => {
    let q = "";
    if (document.body.querySelector(".ksearch")) {
        let $ksearch = $(ksearch);
        let text_busqueda = $ksearch.val();
        if (typeof text_busqueda !== undefined) {

            let simple = text_busqueda.substring(1, text_busqueda.length);
            let elementoIdW = document.getElementById(simple);
            let elementoClassW = document.getElementsByClassName(simple);
            if (elementoClassW != undefined || elementoClassW != null || elementoIdW != null || elementoIdW != undefined) {

                q = text_busqueda;
            }
        }
    }
    return q;
};

let buscador_estaciones_disponibles = () => {
    if (document.body.querySelector(".ksearch")) {
        $(ksearch).keypress(function (e) {
            let code = (e.keyCode ? e.keyCode : e.which);
            if (code === 13) {
                muestra_estaciones();
            }
        });
    }
};

let redirect_forma_pago = (id_recibo) => {

    redirect("../area_cliente/?action=compras&ticket=" + id_recibo);
};

let envia_formulario = function (e) {
    let code = (e.keyCode ? e.keyCode : e.which);
    if (code === 13) {
        $form_punto_encuentro.submit();
    }
};
