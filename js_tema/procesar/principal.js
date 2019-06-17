"use strict";
$(document).ready(function () {

    $(".base_compras").hide();
    $(".nav-sidebar").hide();
    $(".base_paginas_extra").hide();
    recorrepage(".contenedor_compra");
    $(".form-miembro-enid-service").submit(registro);
    $(".form-cotizacion-enid-service").submit(solicitud_cotizacion);
    $(".form_cotizacion_enid_service").submit(registro_cotizacion);

    set_option("plan", $(".plan").val());
    set_option("dominio", $(".dominio").val());
    set_option("num_ciclos", $(".num_ciclos").val());
    set_option("ciclo_facturacion", $(".ciclo_facturacion").val());
    set_option("descripcion_servicio", $(".resumen_producto").val());

    $(".btn_procesar_pedido_cliente").click(procesar_pedido_usuario_activo);
    $(".telefono").keyup(quita_espacios_en_telefono);
    $(".link_acceso").click(set_link);
    $(".email").keyup(function () {
        sin_espacios(".email");
    });

});


let registro = (e) => {


    let flag = 0;
    let clases = [".form-miembro-enid-service .telefono", ".form-miembro-enid-service .email", ".form-miembro-enid-service .password", ".form-miembro-enid-service .nombre"];

    for (var x in clases) {

        $(clases[x]).removeClass("focus_error");

    }

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
                let flag2 = valida_text_form(".telefono", ".place_telefono", 6, "Número telefónico");
                if (flag2 == 1) {


                    $(".resumen_productos_solicitados").hide();
                    recorrepage(".contenedor_formulario_compra");
                    bloquea_form(".form-miembro-enid-service");
                    let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
                    let pw = $.trim($(".password").val());
                    let pwpost = "" + CryptoJS.SHA1(pw);

                    set_option("email", $(".email").val());
                    set_option("nombre", $(".nombre").val());
                    set_option("telefono", $(".telefono").val());
                    set_option("usuario_referencia", $(".q2").val());
                    set_option("talla", $(".talla").val());
                    let data_send = {
                        "password": pwpost,
                        "email": get_option("email"),
                        "nombre": get_option("nombre"),
                        "telefono": get_option("telefono"),
                        "plan": get_option("plan"),
                        "num_ciclos": get_option("num_ciclos"),
                        "descripcion_servicio": get_option("descripcion_servicio"),
                        "ciclo_facturacion": get_option("ciclo_facturacion"),
                        "usuario_referencia": get_option("usuario_referencia"),
                        "talla": get_option("talla"),
                        "tipo_entrega": 2
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
                let flag2 = valida_text_form(".telefono", ".place_telefono", 6, "Número telefónico");
                if (flag2 == 1) {

                    recorrepage(".contenedor_formulario_compra");
                    bloquea_form(".form-cotizacion-enid-service");
                    let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
                    let pw = $.trim($(".password").val());
                    let pwpost = "" + CryptoJS.SHA1(pw);

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
                        "plan": get_parameter(".id_servicio"),
                        "num_ciclos": 1,
                        "descripcion_servicio": get_parameter(".comentario"),
                        "ciclo_facturacion": get_parameter(".id_ciclo_facturacion"),
                        "usuario_referencia": get_option("usuario_referencia"),
                        "talla": "",
                        "tipo_entrega": 2
                    };
                    debugger;
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
    request_enid("POST", data_send, url, respuesta_proceso_cotizacion_usuario_activo, ".place_config_usuario");

    e.preventDefault();


}


let before_registro_afiliado = () => {

    bloquea_form(".form-miembro-enid-service");
    show_load_enid(".place_registro_afiliado", "Validando datos ", 1);
}

let respuesta_registro = (data) => {

    $(".place_registro_afiliado").empty();
    if (data != -1) {

        desbloqueda_form(".form-miembro-enid-service");
        if (data.usuario_existe > 0) {

            flex(".usuario_existente");
            $(".place_registro_afiliado").empty();
            recorrepage(".usuario_existente");
            $(".informacion_extra").show();

        } else {

            set_option("data_registro", data);
            set_option("registro", 1);
            set_option("usuario_nuevo", 1);
            config_direccion();
        }

    } else {
        redirect("../");
    }

};

let respuesta_registro_cotizacion = () => {

    $(".place_registro_afiliado").empty();
    redirect("../area_cliente");

}
let procesar_pedido_usuario_activo = () => {

    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";

    let data_send = {
        "plan": get_option("plan"),
        "num_ciclos": get_option("num_ciclos"),
        "descripcion_servicio": get_option("descripcion_servicio"),
        "ciclo_facturacion": get_option("ciclo_facturacion"),
        "talla": get_option("talla"),
        "tipo_entrega": 2,
        "id_carro_compras": get_parameter(".id_carro_compras"),
        "carro_compras": get_parameter(".carro_compras"),
    };

    request_enid("POST", data_send, url, respuesta_proceso_venta_usuario_activo, "", before_procesar_pedido_activo);

}

let before_procesar_pedido_activo = () => {
    $('.btn_procesar_pedido_cliente').prop('disabled', true);
    show_load_enid(".place_proceso_compra", "Validando datos ", 1);
}

let respuesta_proceso_venta_usuario_activo = (data) => {

    set_option("data_registro", data);
    set_option("registro", 0);
    set_option("usuario_nuevo", 0);
    config_direccion();
}
let respuesta_proceso_cotizacion_usuario_activo = (data) => {

    div_enid("place_config_usuario", "TU SOLICITUD SE ENVIÓ!", "texto_solicitud_enviada top_30  border white padding_5 shadow ");
    redirect("../area_cliente");

}
let quita_espacios_en_telefono = () => {

    let valor = get_parameter(".telefono");
    let nuevo = quitar_espacios_numericos(valor);
    $(".telefono").val(nuevo);
}
let config_direccion = () => {

    let data_registro = get_option("data_registro");
    let ficha = "";
    if (get_option("usuario_nuevo") == 1) {

        ficha = data_registro.ficha;
    } else {
        data_registro = get_option("data_registro");
        ficha = data_registro.ficha;
    }

    $(".contenedo_compra_info").show();
    render_enid(".contenedo_compra_info", ficha);
    recorrepage(".contenedor_compra");
    $(".codigo_postal").keyup(auto_completa_direccion);
    $(".numero_exterior").keyup(function () {
        quita_espacios(".numero_exterior");
    });
    $(".numero_interior").keyup(function () {
        quita_espacios(".numero_interior");
    });
    $(".form_direccion_envio").submit(registra_nueva_direccion);

}
let set_link = function() {

    let plan = get_parameter_enid($(this), "plan");
    let extension_dominio = get_parameter_enid($(this), "extension_dominio");
    let ciclo_facturacion = get_parameter_enid($(this), "ciclo_facturacion");
    let is_servicio = get_parameter_enid($(this), "is_servicio");
    let q2 = get_parameter_enid($(this), "q2");
    let num_ciclos = get_parameter_enid($(this), "num_ciclos");

    let data_send = $.param({
        "plan": plan,
        "extension_dominio": extension_dominio,
        "ciclo_facturacion": ciclo_facturacion,
        is_servicio: is_servicio,
        "q2": q2,
        "num_ciclos": num_ciclos
    });
    let url = "../login/index.php/api/sess/servicio/format/json/";
    request_enid("POST", data_send, url, response_set_link);

};
let response_set_link = (data) => redirect("../login");
