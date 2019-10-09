window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.onpopstate = function (event) {

    if (event) {

        let fn = (parseInt(get_option("vista")) == 1) ? window.history.back() : valida_retorno();
    }
};


$(document).ready(() => {

    despliega([".base_compras", ".nav-sidebar", ".base_paginas_extra"]);
    recorre(".contenedor_compra");

    $(".form-miembro-enid-service").submit(registro);
    $(".form-cotizacion-enid-service").submit(solicitud_cotizacion);
    $(".form_cotizacion_enid_service").submit(registro_cotizacion);

    set_option({
        "id_servicio": get_parameter(".id_servicio"),
        "dominio": get_parameter(".dominio"),
        "num_ciclos": get_parameter(".num_ciclos"),
        "ciclo_facturacion": get_parameter(".ciclo_facturacion"),
        "descripcion_servicio": get_parameter(".resumen_producto"),
        "vista": 1,
    });


    $(".btn_procesar_pedido_cliente").click(procesar_pedido_usuario_activo);
    $(".link_acceso").click(set_link);
    $(".continuar_pedido").click(continuar_compra);
    formato_inicial_comentarios();
    $telefono.keypress(envia_formulario);


});

let registro = (e) => {

    let flag = 0;
    let text_password = $.trim($(".password").val());
    if (text_password.length > 7) {
        $(".place_password_afiliado").empty();
        let flag = valida_num_form(".telefono", ".place_telefono");
        if (flag == 1) {
            let flag2 = val_text_form(".telefono", ".place_telefono", 6, "Número telefónico");
            if (flag2 == 1) {


                $(".resumen_productos_solicitados").hide();
                recorre(".contenedor_formulario_compra");
                bloquea_form(".form-miembro-enid-service");
                let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
                let pw = $.trim($(".password").val());
                let pwpost = "" + CryptoJS.SHA1(pw);

                set_option({
                    "email": $(".email").val(),
                    "nombre": $(".nombre").val(),
                    "telefono": $(".telefono").val(),
                    "usuario_referencia": $(".q2").val(),
                    "talla": $(".talla").val(),
                });

                let data_send = {
                    "password": pwpost,
                    "email": get_option("email"),
                    "nombre": get_option("nombre"),
                    "telefono": get_option("telefono"),
                    "id_servicio": get_parameter(".id_servicio"),
                    "num_ciclos": get_option("num_ciclos"),
                    "descripcion_servicio": get_option("descripcion_servicio"),
                    "ciclo_facturacion": get_option("ciclo_facturacion"),
                    "usuario_referencia": get_option("usuario_referencia"),
                    "talla": get_option("talla"),
                    "tipo_entrega": 2,
                    "fecha_servicio": get_option("fecha_servicio"),
                };
                $(".informacion_extra").hide();
                bloquea_form(".form-miembro-enid-service");
                ;
                valida_load();
                request_enid("POST", data_send, url, respuesta_registro, 0);
            }
        }
    } else {
        desbloqueda_form(".form-miembro-enid-service");
        render_enid(".place_password_afiliado", "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
    }


    e.preventDefault();
};


let solicitud_cotizacion = e => {


    let flag = 0;
    let text_password = $.trim($(".password").val());
    if (text_password.length > 7) {
        $(".place_password_afiliado").empty();
        let flag = valida_num_form(".telefono", ".place_telefono");
        if (flag == 1) {
            let flag2 = val_text_form(".telefono", ".place_telefono", 6, "Número telefónico");
            if (flag2 == 1) {

                recorre(".contenedor_formulario_compra");
                bloquea_form(".form-cotizacion-enid-service");
                let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
                let pwpost = "" + CryptoJS.SHA1($.trim($(".password").val()));

                set_option("email", $(".email").val());
                set_option("nombre", $(".nombre").val());
                set_option("telefono", $(".telefono").val());
                set_option("usuario_referencia", $(".q2").val());
                set_option("talla", "");
                let data_send = {
                    "password": pwpost,
                    "email": get_option("email"),
                    "nombre": get_option("nombre"),
                    "telefono": get_option("telefono"),
                    "id_servicio": get_parameter(".id_servicio"),
                    "num_ciclos": 1,
                    "descripcion_servicio": get_parameter(".comentario"),
                    "ciclo_facturacion": get_parameter(".id_ciclo_facturacion"),
                    "usuario_referencia": get_option("usuario_referencia"),
                    "talla": "",
                    "tipo_entrega": 2,
                    "fecha_servicio": get_parameter(".fecha_servicio"),

                };
                $(".informacion_extra").hide();
                bloquea_form(".form-miembro-enid-service");
                valida_load();
                request_enid("POST", data_send, url, respuesta_registro_cotizacion, 0);
            }
        }
    } else {
        desbloqueda_form(".form-miembro-enid-service");
        render_enid(".place_password_afiliado", "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
    }


    e.preventDefault();
};
let registro_cotizacion = (e) => {

    let data_send = $(".form_cotizacion_enid_service").serialize();
    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    bloquea_form(".form_cotizacion_enid_service");
    valida_load();
    request_enid("POST", data_send, url, respuesta_proceso_usuario_activo);
    e.preventDefault();

};

let respuesta_registro = (data) => {

    empty_elements(".place_registro_afiliado");
    if (data != -1) {

        desbloqueda_form(".form-miembro-enid-service");
        if (data.usuario_existe > 0) {

            $('.usuario_existente').removeClass('some d-none');
            recorre(".usuario_existente");


        } else {

            redirect("../area_cliente/?action=compras");

        }

    } else {

        redirect("../");
    }

};

let respuesta_registro_cotizacion = (data) => {

    $(".place_registro_afiliado").empty();
    redirect("../area_cliente");

};
let procesar_pedido_usuario_activo = () => {

    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";

    let data_send = {
        "id_servicio": get_option("id_servicio"),
        "num_ciclos": get_option("num_ciclos"),
        "descripcion_servicio": get_option("descripcion_servicio"),
        "ciclo_facturacion": get_option("ciclo_facturacion"),
        "talla": get_option("talla"),
        "tipo_entrega": 2,
        "id_carro_compras": get_parameter(".id_carro_compras"),
        "carro_compras": get_parameter(".carro_compras"),
    };

    request_enid("POST", data_send, url, () => {
        redirect("../area_cliente/?action=compras");
    }, 0, before_pedido_activo);

};

let before_pedido_activo = () => {

    $('.btn_procesar_pedido_cliente').prop('disabled', true);
    sload(".place_proceso_compra", "Validando datos ", 1);

};

let respuesta_proceso_usuario_activo = (data) => {

    redirect("../area_cliente");

};
let quita_espacios_en_telefono = () => {

    $(".telefono").val(quitar_espacios_numericos(get_parameter(".telefono")));

};
let set_link = function () {

    let plan = get_parameter_enid($(this), "id_servicio");
    let extension_dominio = get_parameter_enid($(this), "extension_dominio");
    let ciclo_facturacion = get_parameter_enid($(this), "ciclo_facturacion");
    let is_servicio = get_parameter_enid($(this), "is_servicio");
    let q2 = get_parameter_enid($(this), "q2");
    let num_ciclos = get_parameter_enid($(this), "num_ciclos");

    let data_send = $.param({
        "id_servicio": plan,
        "extension_dominio": extension_dominio,
        "ciclo_facturacion": ciclo_facturacion,
        is_servicio: is_servicio,
        "q2": q2,
        "num_ciclos": num_ciclos
    });
    let url = "../login/index.php/api/sess/servicio/format/json/";
    request_enid("POST", data_send, url, response_set_link);

};
let continuar_compra = function () {

    showonehideone(".pr_compra", ".compra_resumen");
    set_option("vista", 2)
};
let response_set_link = (data) => redirect("../login");
let valida_retorno = () => {
    let vista = parseInt(get_option("vista"));
    switch (vista) {

        case 2:
            showonehideone(".compra_resumen", ".pr_compra");
            set_option("vista", 1);
            break;

        default:

            break;
    }
};
let formato_inicial_comentarios = function () {
    if (option["in_session"] < 1) {

        $('.agregar_commentario').click(function () {
            $('.text_comentarios').removeClass('d-none');
        });

        $('.nombre').keypress(envia_formulario);
        $('.email').keypress(envia_formulario);
        $('.password').keypress(envia_formulario);

    } else {

        $(".text_agregar_comentario").click(function () {
            $('.descripcion_comentario').removeClass("d-none").addClass("mt-5");
        });

    }
}
let envia_formulario = function (e) {
    let code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
        $(".form-cotizacion-enid-service").submit();
    }
};