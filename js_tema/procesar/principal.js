window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.onpopstate = function (event) {

    if (event) {

        let fn = (parseInt(get_option("vista")) == 1) ? window.history.back() : valida_retorno();
    }
}
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
    $(".telefono").keyup(quita_espacios_en_telefono);
    $(".link_acceso").click(set_link);
    $(".email").keyup(() => {
        sin_espacios(".email");
    });
    $(".continuar_pedido").click(continuar_compra);


    if (option["in_session"] < 1) {

        if ($('.form-cotizacion-enid-service #nombre').val().length > 0) {
            $('.form-cotizacion-enid-service #nombre').next('label').addClass('focused_input');
        }
        if ($('.form-cotizacion-enid-service .email').val().length > 0) {
            $('.form-cotizacion-enid-service .email').next('label').addClass('focused_input');
        }
        if ($('.form-cotizacion-enid-service  #password ').val().length > 0) {
            $('.form-cotizacion-enid-service  #password ').next('label').addClass('focused_input');
        }
        if ($('.form-cotizacion-enid-service  #telefono').val().length > 0) {
            $('.form-cotizacion-enid-service  #telefono').next('label').addClass('focused_input');
        }
        if ($('.form-cotizacion-enid-service  #fecha_servicio').val().length > 0) {
            $('.form-cotizacion-enid-service  #fecha_servicio').next('label').addClass('focused_input');
        }

        $(".form-cotizacion-enid-service #nombre").focus(function () {
            $('.form-cotizacion-enid-service #nombre').next('label').addClass('focused_input');
            $(this).addClass('input_focus');
        });
        $(".form-cotizacion-enid-service #nombre").focusout(function () {
            if ($('.form-cotizacion-enid-service #nombre').val() === '') {
                $('.form-cotizacion-enid-service #nombre').next('label').removeClass('focused_input');
                $(this).removeClass('input_focus');
            }
        });

        $(".form-cotizacion-enid-service .email").focus(function () {
            $('.form-cotizacion-enid-service .email').next('label').addClass('focused_input');
            $(this).addClass('input_focus');
        });
        $(".form-cotizacion-enid-service .email").focusout(function () {
            if ($('.form-cotizacion-enid-service .email').val() === '') {
                $('.form-cotizacion-enid-service .email').next('label').removeClass('focused_input');
                $(this).removeClass('input_focus');
            }
        });

        $(".form-cotizacion-enid-service .password").focus(function () {
            $('.form-cotizacion-enid-service .password').next('label').addClass('focused_input');
            $(this).addClass('input_focus');
        });
        $(".form-cotizacion-enid-service .password").focusout(function () {
            if ($('.form-cotizacion-enid-service .password').val() === '') {
                $('.form-cotizacion-enid-service .password').next('label').removeClass('focused_input');
                $(this).removeClass('input_focus');
            }
        });

        $(".form-cotizacion-enid-service .telefono").focus(function () {
            $('.form-cotizacion-enid-service .telefono').next('label').addClass('focused_input');
            $(this).addClass('input_focus');
        });
        $(".form-cotizacion-enid-service .telefono").focusout(function () {
            if ($('.form-cotizacion-enid-service .telefono').val() === '') {
                $('.form-cotizacion-enid-service .telefono').next('label').removeClass('focused_input');
                $(this).removeClass('input_focus');
            }
        });

        $('.agregar_commentario').click(function () {
            $('.text_comentarios').removeClass('d-none');
        });





    } else {

        $(".text_agregar_comentario").click(function () {
            $('.descripcion_comentario').removeClass("d-none").addClass("mt-5");
        });
    }


});


let registro = (e) => {


    let flag = 0;
    let clases = [
        ".form-miembro-enid-service .telefono",
        ".form-miembro-enid-service .email",
        ".form-miembro-enid-service .password",
        ".form-miembro-enid-service .nombre"
    ];

    clases.forEach(function (element) {
        $(element).removeClass("focus_error");
    });

    if (get_parameter(".form-miembro-enid-service .telefono").length < 8) {
        $(".form-miembro-enid-service .telefono").addClass("focus_error");
        flag++;
    }
    if (get_parameter(".form-miembro-enid-service .email").length < 6) {

        $(".form-miembro-enid-service .email").addClass("focus_error");
        flag++;
    }
    if (get_parameter(".form-miembro-enid-service .password").length < 6) {

        $(".form-miembro-enid-service .password").addClass("focus_error");
        flag++;

    }
    if (get_parameter(".form-miembro-enid-service .nombre").length < 8) {

        $(".form-miembro-enid-service .nombre").addClass("focus_error");
        flag++;
    }

    if (flag < 1) {

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
                    request_enid("POST", data_send, url, respuesta_registro, 0, before_registro_afiliado);
                }
            }
        } else {
            desbloqueda_form(".form-miembro-enid-service");
            render_enid(".place_password_afiliado", "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
        }

    }

    e.preventDefault();
}


let solicitud_cotizacion = e => {


    let flag = 0;
    let clases = [".form-cotizacion-enid-service .telefono", ".form-cotizacion-enid-service .email", ".form-cotizacion-enid-service .password", ".form-cotizacion-enid-service .nombre"];

    for (var x in clases) {

        $(clases[x]).removeClass("focus_error");

    }

    if (get_parameter(".form-cotizacion-enid-service .telefono").length < 8) {
        $(".form-cotizacion-enid-service .telefono").addClass("focus_error");
        flag++;
    }
    if (get_parameter(".form-cotizacion-enid-service .email").length < 6) {

        $(".form-cotizacion-enid-service .email").addClass("focus_error");
        flag++;
    }
    if (get_parameter(".form-cotizacion-enid-service .password").length < 6) {

        $(".form-cotizacion-enid-service .password").addClass("focus_error");
        flag++;

    }
    if (get_parameter(".form-cotizacion-enid-service .nombre").length < 8) {

        $(".form-cotizacion-enid-service .nombre").addClass("focus_error");
        flag++;
    }

    if (flag < 1) {


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
                    request_enid("POST", data_send, url, respuesta_registro_cotizacion, 0, before_registro_afiliado);
                }
            }
        } else {
            desbloqueda_form(".form-miembro-enid-service");
            render_enid(".place_password_afiliado", "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
        }

    }

    e.preventDefault();
}
let registro_cotizacion = (e) => {

    let data_send = $(".form_cotizacion_enid_service").serialize();
    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    bloquea_form(".form_cotizacion_enid_service");
    request_enid("POST", data_send, url, respuesta_proceso_usuario_activo);
    e.preventDefault();

}
let before_registro_afiliado = () => {

    bloquea_form(".form-miembro-enid-service");
    sload(".place_registro_afiliado", "Validando datos ", 1);
}

let respuesta_registro = (data) => {

    $(".place_registro_afiliado").empty();
    if (data != -1) {

        desbloqueda_form(".form-miembro-enid-service");
        if (data.usuario_existe > 0) {

            flex(".usuario_existente");
            empty_elements(".place_registro_afiliado")

            recorre(".usuario_existente");
            $(".informacion_extra").show();

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

}
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

}

let before_pedido_activo = () => {

    $('.btn_procesar_pedido_cliente').prop('disabled', true);
    sload(".place_proceso_compra", "Validando datos ", 1);

}

let respuesta_proceso_usuario_activo = (data) => {

    redirect("../area_cliente");

}
let quita_espacios_en_telefono = () => {

    $(".telefono").val(quitar_espacios_numericos(get_parameter(".telefono")));

}
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
}
let response_set_link = (data) => redirect("../login");
let valida_retorno = () => {
    let vista = parseInt(get_option("vista"));
    switch (vista) {

        case 2:
            showonehideone(".compra_resumen", ".pr_compra");
            set_option("vista", 1)
            break;

        default:

            break;
    }
}