"use strict";
let $form_tag_arquetipo = $('.form_tag_arquetipo');
let $tag_arquetipo = $('.baja_tag_arquetipo');
$(document).ready(() => {

    despliega([".selector_estados_ventas", ".form_cantidad", ".form_cantidad_post_venta"], 0);

    $(".form_busqueda_pedidos").submit(busqueda_pedidos);
    $(".form_fecha_entrega").submit(editar_horario_entrega);
    $(".form_fecha_recordatorio").submit(crea_recordatorio);
    $(".editar_estado").click(cambio_estado);
    $(".editar_tipo_entrega").click(pre_tipo_entrega);
    $(".status_venta").change(modidica_estado);
    $(".form_cantidad").submit(registra_saldo_cubierto);
    $(".configurara_informacion_cliente").click(muestra_form_usuario);
    $(".form_set_usuario").submit(registro_usuario);
    $(".form_costos").submit(registro_costo_operativo);

    $(".agenda_compra").click(agenda_compra);
    $(".saldo_cubierto_pos_venta").keyup((e) => {
        let code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            modifica_status(get_valor_selected(".status_venta"));
        }
    });
    $(".form_edicion_tipo_entrega").change(cambio_tipo_entrega);
    $(".form_notas").submit(registrar_nota);
    retorno();
    $(".precio").focus(function () {
        $('.precio').next('label').addClass('focused_input');

    });

    $form_tag_arquetipo.submit(registro_arquetipo);
    $tag_arquetipo.click(baja_tag_arquetipo);
});
let editar_horario_entrega = function (e) {

    let data_send = $(".form_fecha_entrega").serialize();
    let url = "../q/index.php/api/recibo/fecha_entrega/format/json/";
    bloquea_form(".form_fecha_entrega");
    request_enid("PUT", data_send, url, response_horario_entrega, ".place_fecha_entrega");
    e.preventDefault();
};
let crea_recordatorio = function (e) {


    let descripcion = get_parameter(".descripcion_recordatorio").trim();
    if (descripcion.length > 5) {

        let data_send = $(".form_fecha_recordatorio").serialize();
        let url = "../q/index.php/api/recordatorio/index/format/json/";
        bloquea_form(".form_fecha_recordatorio");
        let hora_fecha = get_parameter(".form_fecha_recordatorio .fecha_cordatorio") + " " + get_valor_selected(".form_fecha_recordatorio .horario_entrega") + "00";
        let orden = get_parameter(".recibo");
        google_path("orden de compra " + orden, hora_fecha, descripcion);
        request_enid("POST", data_send, url, response_recordatorio, ".place_recordatorio");

    } else {

        format_error(".nota_recordatorio", "Ingresa un  recordatorio");
        $(".nota_recordatorio").show();

    }

    e.preventDefault();

};
let google_path = function (desc_google, hora_fecha, details) {

    let base = "https://calendar.google.com/calendar/r/eventedit";
    base += (desc_google.length > 5) ? "?text=Recodatorio Enid Service " + desc_google : "";
    if (hora_fecha.length > 5) {
        let format_google = "";
        let eliminar = ['-', ':'];
        for (let x in hora_fecha) {

            if (eliminar.includes(hora_fecha[x]) == false) {
                if (hora_fecha[x] != ' ') {

                    format_google += hora_fecha[x];

                } else {

                    format_google += "T";
                }

            }

        }


        if (details.length > 5) {
            base += "&details=" + details;
        }

        base += "&dates=" + format_google + "/" + format_google;
    }
    window.open(base, '_blank');
};
let response_recordatorio = function (data) {

    if (data == true) {
        $(".place_recordatorio").empty();
        let url = "../pedidos/?recibo=" + get_parameter(".recibo");
        redirect(url);
    } else {
        desbloqueda_form(".form_fecha_recordatorio");
    }
};
let response_horario_entrega = function (data) {

    $(".place_fecha_entrega").empty();
    let url = "../pedidos/?recibo=" + get_parameter(".recibo");
    desbloqueda_form(".form_fecha_entrega");
    redirect(url);

};
let busqueda_pedidos = function (e) {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $(".form_busqueda_pedidos").serialize();
        let url = "../q/index.php/api/recibo/pedidos/format/json/";
        request_enid("GET", data_send, url, response_pedidos, ".place_pedidos");

    }
    e.preventDefault();
};
let response_pedidos = function (data) {

    render_enid(".place_pedidos", data);
    $('th').click(ordena_tabla);
    $(".desglose_orden").click(function () {
        let recibo = get_parameter_enid($(this), "id");
        $(".numero_recibo").val(recibo);
        $(".form_search").submit();
    });

};
let cambio_estado = function () {

    let recibo = get_parameter_enid($(this), "id");
    $(".selector_estados_ventas").show();
    let status_venta_actual = get_parameter(".status_venta_registro");
    selecciona_valor_select(".selector_estados_ventas .status_venta", status_venta_actual);
    let status_venta_registro = parseInt(get_parameter(".status_venta_registro"));
    $(".status_venta_registro option[value='" + status_venta_registro + "']").attr("disabled", "disabled");

};
let modidica_estado = function () {

    $('.place_tipificaciones').addClass('mt-5 mb-5');
    if (get_parameter(".status_venta_registro") != 9) {

        guarda_nuevo_estado();

    } else {
        let text = "ESTE PEDIDO YA FUÉ NOTIFICADO COMO ENTREGADO, ¿AÚN ASÍ DESEAS MODIFICAR SU ESTADO?";
        $.confirm({
            title: text,
            content: '',
            type: 'green',
            buttons: {
                ok: {
                    text: "CONTINUAR Y MODIFICAR",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        guarda_nuevo_estado();
                    }
                },
                cancel: function () {
                    $(".selector_estados_ventas").hide();
                }
            }
        });
    }
};
let guarda_nuevo_estado = () => {

    let status_venta = parseInt(get_valor_selected(".selector_estados_ventas .status_venta"));
    let status_venta_registro = parseInt(get_parameter(".status_venta_registro"));

    if (status_venta != status_venta_registro) {
        $(".form_cantidad").hide();
        $(".place_tipificaciones").empty();
        switch (status_venta) {
            case 0:

                break;
            case 1:
                $(".form_cantidad").show();
                break;

            case 6:
                /*Cuando no ha registrado algún pago*/
                verifica_pago_previo(6);
                break;

            case 7:
                modifica_status(status_venta);
                break;
            case 9:
                modifica_status(status_venta);
                break;
            case 10:
                pre_cancelacion();
                break;
            case 11:
                modifica_status(status_venta);
                break;

            case 15:

                modifica_status(status_venta);
                break;

            default:
                break;
        }
    }
};
let modifica_status = (status_venta, es_proceso_compra_sin_filtro = 0) => {


    let saldo_cubierto = get_parameter(".saldo_actual_cubierto");

    if (es_proceso_compra_sin_filtro == 0) {

        if (saldo_cubierto > 0 || get_parameter(".saldo_cubierto_pos_venta") > 0) {

            registra_data_nuevo_estado(status_venta);
        } else {

            $(".form_cantidad_post_venta").show();
        }

    } else {
        set_option("es_proceso_compra", 1);
        registra_data_nuevo_estado(status_venta);
    }
};
let registra_saldo_cubierto = e => {

    if (valida_num_form(".saldo_cubierto", ".mensaje_saldo_cubierto") == 1) {

        let data_send = $(".form_cantidad").serialize();
        $(".mensaje_saldo_cubierto").empty();
        let url = "../q/index.php/api/recibo/saldo_cubierto/format/json/";
        bloquea_form(".form_cantidad");
        request_enid("PUT", data_send, url, response_saldo_cubierto)

    }
    e.preventDefault();
};
let response_saldo_cubierto = data => {

    debugger;
    if (data == true) {

        let status_venta = get_valor_selected(".status_venta");
        if (status_venta == 6 || status_venta == 9) {
            next_status();
        } else {
            show_confirm("¿QUIERES DESCONTAR LOS ARTICULOS DEL STOCK?", "", 0, descontar_articulos_stock, next_status);
        }


    } else {

        desbloqueda_form(".form_cantidad");
        $(".mensaje_saldo_cubierto").show();
        render_enid(".mensaje_saldo_cubierto", data);
    }
};
let next_status = () => {

    let url = "../pedidos/?recibo=" + get_parameter(".recibo");
    redirect(url);
};
let descontar_articulos_stock = () => {

    let id_servicio = get_parameter(".id_servicio");
    let stock = get_parameter(".articulos");
    let data_send = $.param({"id_servicio": id_servicio, "stock": stock, "compra": 1});
    let url = "../q/index.php/api/servicio/stock/format/json/";
    request_enid("PUT", data_send, url, response_articulos_stock);

};
let response_articulos_stock = data => {

    let url = "../pedidos/?recibo=" + get_parameter(".recibo");
    redirect(url);
};
let response_status_venta = data => {


    desbloqueda_form(".selector_estados_ventas");
    if (data == true) {

        show_confirm("¿QUIERES DESCONTAR LOS ARTICULOS DEL STOCK?", "", 0, descontar_articulos_stock, next_status);

    } else {

        render_enid(".mensaje_saldo_cubierto_post_venta", data);
    }

};
let pre_cancelacion = () => {

    let tipo = 0;
    switch (parseInt(get_parameter(".tipo_entrega_def"))) {

        case 0:
            tipo = 2;
            break;

        /*opciones en punto de encuentro*/
        case 1:
            tipo = 2;
            break;
        /*opciones en mensajeria por  enid*/
        case 2:
            tipo = 4;

            break;
        /*Visita en el negocio*/
        case 3:

            tipo = 6;
            break;
        /*opciones en mensajeria por  mercado libre*/
        case 4:
            tipo = 5;
            break;

        default:
            break;

    }

    let data_send = {"v": 1, tipo: tipo, "text": "MOTIVO DE CANCELACIÓN"};
    let url = "../q/index.php/api/tipificacion/index/format/json/";
    request_enid("GET", data_send, url, response_pre_cancelacion)

};
let response_pre_cancelacion = data => {

    render_enid(".place_tipificaciones", data);
    $('.place_tipificaciones').addClass('row mt-5 mb-5');
    $(".tipificacion").change(registra_motivo_cancelacion);
};
let registra_motivo_cancelacion = () => {

    let status_venta = get_valor_selected(".status_venta");
    let tipificacion = get_valor_selected(".tipificacion");
    let data_send = $.param({
        "recibo": get_parameter(".recibo"),
        "status": status_venta,
        "tipificacion": tipificacion,
        "cancelacion": 1
    });
    let url = "../q/index.php/api/recibo/status/format/json/";
    bloquea_form(".selector_estados_ventas");
    request_enid("PUT", data_send, url, response_status_venta);
};
let cambio_tipo_entrega = () => {

    let tipo_entrega = get_valor_selected(".form_edicion_tipo_entrega .tipo_entrega");
    let tipo_entrega_actual = get_parameter(".tipo_entrega_def");

    if (tipo_entrega > 0 && tipo_entrega != tipo_entrega_actual) {
        let text = "¿REALMENTE DESEAS MODIFICAR EL TIPO DE ENTREGA?";
        let mensaje = "ACTUAL: " + get_parameter(".text_tipo_entrega");
        $.confirm({
            title: text,
            content: mensaje,
            type: 'green',
            buttons: {
                ok: {
                    text: "CONTINUAR",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        set_tipo_entrega(tipo_entrega, tipo_entrega_actual);
                    }
                },
                cancel: function () {

                }
            }
        });

    }

};
let set_tipo_entrega = (tipo_entrega, tipo_entrega_actual) => {

    if (tipo_entrega != tipo_entrega_actual) {
        switch (tipo_entrega) {

            /*opciones en punto de encuentro*/
            case 1:

                break;
            /*opciones en mensajeria por  enid*/
            case 2:

                break;
            /*VISITA EN NEGOCIO*/
            case 3:

                break;
            /*opciones en mensajeria por  mercado libre*/
            case 4:

                break;

            default:

                break;

        }
        registra_tipo_entrega(tipo_entrega, get_parameter(".recibo"));
    }

};
let registra_tipo_entrega = (tipo_entrega, recibo) => {

    let text_tipo_entrega = get_parameter(".text_tipo_entrega");
    let data_send = {
        "tipo_entrega": tipo_entrega,
        recibo: recibo,
        text_tipo_entrega: text_tipo_entrega
    };
    let url = "../q/index.php/api/recibo/tipo_entrega/format/json/";
    request_enid("PUT", data_send, url, response_tipo_entrega);
};
let response_tipo_entrega = (data) => {

    let url = "../pedidos/?recibo=" + get_parameter(".recibo");
    redirect(url);
};
let pre_tipo_entrega = () => {
    $(".form_edicion_tipo_entrega").show();
    let tipo_entrega_actual = get_parameter(".tipo_entrega_def");
    selecciona_valor_select(".form_edicion_tipo_entrega .tipo_entrega", tipo_entrega_actual);
};
let verifica_pago_previo = id_status => {

    debugger;
    let saldo_cubierto = get_parameter(".saldo_actual_cubierto");
    if (saldo_cubierto > 0) {

        let text = "ESTA ORDEN  CUENTA CON UN SALDO REGISTRADO DE " + saldo_cubierto + "MXN ¿AUN ASÍ DESEAS NOTIFICAR SU FALTA DE PAGO?";
        let text_complemento = "EL SALDO DE LA ORDEN PASARÁ A 0 MXN AL REALIZAR ESTA ACCIÓN";
        let text_continuar = "DEJAR EN 0MXN";
        show_confirm(text, text_complemento, text_continuar, procesa_cambio_estado, oculta_opciones_estados);

    } else {

        modifica_status(id_status, 1);
    }

};
let oculta_opciones_estados = () => {

    despliega([".selector_estados_ventas", 0]);

};
let procesa_cambio_estado = () => {

    set_option("es_proceso_compra", 1);
    modifica_status(6, 1);

};
let registra_data_nuevo_estado = status_venta => {


    bloquea_form(".selector_estados_ventas");
    let data_send = $.param({
        "recibo": get_parameter(".recibo"),
        "status": status_venta,
        "saldo_cubierto": get_parameter(".saldo_cubierto_pos_venta"),
        "es_proceso_compra": get_option("es_proceso_compra")
    });
    set_option("es_proceso_compra", 0);
    let url = "../q/index.php/api/recibo/status/format/json/";
    request_enid("PUT", data_send, url, response_status_venta)
};
let confirma_cambio_horario = (id_recibo, status, saldo_cubierto_envio, monto_a_pagar, se_cancela, fecha_entrega) => {


    let text = "¿DESEAS EDITAR EL HORARIO DE ENTREGA DEL PEDIDO?";
    let text_confirmacion = "";
    switch (parseInt(status)) {
        case 9:
            text = "LA ORDEN YA FUÉ ENTREGADA!";
            text_confirmacion = "¿EDITAR HORARIO DE ENTREGA AÚN ASÍ?";

            break;
        case 10:
            text = "LA ORDEN FUÉ CANCELADA!";
            text_confirmacion = "¿EDITAR HORARIO DE ENTREGA AÚN ASÍ?";
            break;

        default:
            text = "¿DESEAS EDITAR EL HORARIO DE ENTREGA DEL PEDIDO?";
            text_confirmacion = "";
            break;
    }

    show_confirm(text, text_confirmacion, "SI", function () {
        let url = "../pedidos/?recibo=" + id_recibo + "&fecha_entrega=1";
        redirect(url);
    });


};
let agregar_nota = () => {

    showonehideone(".form_notas", ".agregar_comentario");
    recorre(".form_notas");
};
let registrar_nota = e => {

    debugger;
    let url = "../q/index.php/api/recibo_comentario/index/format/json/";
    let comentario = get_parameter(".comentarios");
    let texto = comentario.trim().length;
    if (texto > 10) {

        let data_send = $(".form_notas").serialize();
        request_enid("POST", data_send, url, response_registro_nota, ".place_nota");

    } else {

        format_error(".place_nota", "comentario muy corto");

    }

    e.preventDefault();
};
let response_registro_nota = data => {
    $(".place_nota").empty();
    redirect("");

};
let modifica_status_recordatorio = (id_recordatorio, status) => {
    if (id_recordatorio > 0) {

        let url = "../q/index.php/api/recordatorio/status/format/json/";
        let data_send = {id_recordatorio: id_recordatorio, status: status};
        request_enid("PUT", data_send, url);
    }
};
let registro_usuario = function (e) {

    debugger;
    let url = $(".form_set_usuario").attr("action");
    let data_send = $(".form_set_usuario").serialize();
    bloquea_form(".form_set_usuario");
    request_enid("PUT", data_send, url, response_usuario);
    e.preventDefault();
};

let response_usuario = (data) => redirect("");

let muestra_form_usuario = () => {
    showonehideone("#contenedor_form_usuario", ".contenedor_cliente");

};
let confirma_eliminar_concepto = id => {

    show_confirm("¿Seguro deseas eliminar este concepto?", "", "Eliminar", function () {

        elimina_costo_operacion(id);
    });
};

let elimina_costo_operacion = id => {


    let data_send = $.param({"id": id});
    let url = "../q/index.php/api/costo_operacion/index/format/json/";
    request_enid("DELETE", data_send, url, function () {
        redirect("");
    });

};
let retorno = () => {
    let sender = get_parameter(".consulta");
    if (sender > 0) {
        let type = get_parameter(".type");


        switch (parseInt(type)) {
            case 13:

                selecciona_valor_select(".status_venta", 0);

                break;

            case 14:

                selecciona_valor_select(".status_venta", parseInt(type));

                break;

            default:

                break;
        }

        $(".form_busqueda_pedidos").submit();
    }

};
let agenda_compra = function () {

    let id = get_parameter_enid($(this), "id");
    if (id > 0) {

        let data_send = {id: id};
        let url = "../q/index.php/api/recibo/agenda/format/json/";
        request_enid("POST", data_send, url, r_agenda);
    }


};
let r_agenda = function (data) {

    if (data != false) {

        redirect("../");
    }
};

let registro_arquetipo = function (e) {

    e.preventDefault();

    let data_send = $(this).serialize();
    let str = $(this).find('input').val();
    let $selector_avertencia = $(this).find('input').next('label').next('div');
    if (str.length) {

        $selector_avertencia.addClass('d-none');
        bloquea_form('.form_tag_arquetipo');
        let url = "../q/index.php/api/tag_arquetipo/index/format/json/";
        request_enid("POST", data_send, url, response_tag_arquetipo);

    } else {

        $selector_avertencia.removeClass('d-none');
    }


}
let response_tag_arquetipo = function () {
    redirect('');
}
let baja_tag_arquetipo = function () {

    set_option('tag_arquetipo', get_parameter_enid($(this), 'id'));
    show_confirm("¿QUIERES QUITAR ESTA DESCRIPCIÓN?", "", 0, baja_tag);
}
let baja_tag = function () {

    let tag_arquetipo = get_option('tag_arquetipo');
    if (parseInt(tag_arquetipo) > 0) {

        let data_send = $.param({'id': tag_arquetipo});
        let url = "../q/index.php/api/tag_arquetipo/index/format/json/";
        request_enid("DELETE", data_send, url, response_tag_arquetipo);
    }
}