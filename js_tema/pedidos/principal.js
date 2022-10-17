"use strict";
let $form_tag_arquetipo = $('.form_tag_arquetipo');
let $tag_arquetipo = $('.baja_tag_arquetipo');
let $usuario_tipo_negocio = $('.usuario_tipo_negocio');
let $editar_usuario_tipo_negocio = $('.editar_usuario_tipo_negocio');
let $form_usuario_tipo_negocio = $('.form_usuario_tipo_negocio');
let $form_cantidad_post_venta = $('.form_cantidad_post_venta');
let $form_cantidad = $(".form_cantidad");
let $saldo_actual_cubierto = $('.saldo_actual_cubierto');
let $saldo_cubierto_pos_venta = $('.saldo_cubierto_pos_venta');
let $status_venta = $('.status_venta');
let $modal_estado_venta = $('#modal_estado_venta');
let $modal_envio_reparto = $("#modal_envio_reparto");
let $editar_estado_compra = $('.editar_estado_compra');
let $selector_estados_ventas = $('.selector_estados_ventas');
let $status_venta_registro = $('.status_venta_registro');
let $saldo_cubierto = parseInt($saldo_actual_cubierto.val());
let $modal_opciones_compra = $('#modal_opciones_compra');
let $menu_recibo = $('.menu_recibo');
let $repartidor = $('.repartidor');
let $registro_articulo_interes = $('.registro_articulo_interes');
let $id_usuario_referencia = $('.id_usuario_referencia');
let $telefono_contacto_recibo = $('.telefono_contacto_recibo');
let $edicion_cantidad = $('.edicion_cantidad');
let $id_status = $(".id_status");
let $botton_enviar_reparto = $(".botton_enviar_reparto");
let $botton_enviar_despues = $(".botton_enviar_despues");

let $seccion_cantidad = $('.seccion_cantidad');
let $seccion_edicion_cantidad = $('.seccion_edicion_cantidad');
let $botton_actualizar = $('.botton_actualizar');


$(document).ready(() => {

    
    $editar_estado_compra.click(function () {

        selecciona_select('.status_venta_select', parseInt($status_venta_registro.val()));
        $modal_estado_venta.modal("show");
        despliega([".selector_estados_ventas", 1]);
        oculta_opciones_recibo();
    });
    $menu_recibo.click(opciones_recibo);

    despliega([".form_cantidad", ".form_cantidad_post_venta"], 0);
    $(".form_fecha_entrega").submit(editar_horario_entrega);
    $(".form_fecha_recordatorio").submit(crea_recordatorio);
    $(".editar_estado").click(cambio_estado);
    $(".editar_tipo_entrega").click(pre_tipo_entrega);

    $status_venta.change(modifica_estado);

    $(".form_cantidad").submit(registra_saldo_cubierto);
    $(".configurara_informacion_cliente").click(muestra_form_usuario);
    $(".form_set_usuario").submit(registro_usuario);


    $(".agenda_compra").click(agenda_compra);
    $saldo_cubierto_pos_venta.keyup((e) => {
        let code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            modifica_status(get_valor_selected(".status_venta"));
        }
    });
    $(".form_edicion_tipo_entrega").change(cambio_tipo_entrega);
    $(".form_notas").submit(registrar_nota);
    retorno();

    $form_tag_arquetipo.submit(registro_arquetipo);
    $tag_arquetipo.click(baja_tag_arquetipo);
    $usuario_tipo_negocio.change(usuario_tipo_negocio);
    $editar_usuario_tipo_negocio.click(editar_usuario_tipo_negocio);
    $repartidor.click(cambio_reparto);
    $edicion_cantidad.click(habilita_edicion);
    $botton_actualizar.click(actualizar_cantidad);    
    valida_envio_reparto();

});
let valida_envio_reparto = () => {

    let status = parseInt($id_status.val());    
    let saldo_cubierto =  parseInt($saldo_actual_cubierto.val());
    
    if(status == 16 && saldo_cubierto < 1){
        
        $modal_envio_reparto.modal("show");
        $botton_enviar_despues.click(function(){
            $modal_envio_reparto.modal("hide");
        });
        
        $botton_enviar_reparto.click(confirma_envio_reparto);

    }

};
let confirma_envio_reparto =  () =>{

    advierte('Procesando ...', 1);

    let data_send = $.param({
        "orden_compra": get_parameter(".recibo"),                
    });
    let url = "../q/index.php/api/lead/envio_reparto/format/json/";    
    request_enid("PUT", data_send, url, response_notificacion_envio_reparto);

}
let response_notificacion_envio_reparto = data => {
    
    redirect('');
};
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

    if (data === true) {
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
let cambio_estado = function () {

    let recibo = get_parameter_enid($(this), "id");
    $selector_estados_ventas.show();
    let status_venta_actual = get_parameter(".status_venta_registro");
    selecciona_valor_select(".selector_estados_ventas .status_venta", status_venta_actual);
    let status_venta_registro = parseInt(get_parameter(".status_venta_registro"));
    $(".status_venta_registro option[value='" + status_venta_registro + "']").attr("disabled", "disabled");

};
let modifica_estado = function () {

    $('.place_tipificaciones').addClass('mt-5 mb-5');
    if ($saldo_cubierto < 1) {

        guarda_nuevo_estado();

    } else {

        let text = "ESTE PEDIDO YA FUÉ NOTIFICADO COMO PAGADO, ¿AÚN ASÍ DESEAS MODIFICAR SU ESTADO?";
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

                    $modal_estado_venta.modal('hide');
                }
            }
        });
    }
};
let guarda_nuevo_estado = () => {

    let status_venta = parseInt(get_valor_selected(".selector_estados_ventas .status_venta"));
    let status_venta_registro = parseInt(get_parameter(".status_venta_registro"));
    if (status_venta !== status_venta_registro) {
        $form_cantidad.hide();
        $(".place_tipificaciones").empty();
        switch (status_venta) {
            case 0:
                break;
            case 1:
                $form_cantidad_post_venta.show();
                break;
            case 6:
                /*Cuando no ha registrado algún pago*/
                verifica_pago_previo(6);
                break;
            case 10:
                $modal_estado_venta.modal("hide");
                pre_cancelacion();
                break;
            case 15:
                $form_cantidad_post_venta.show();
                break;
            default:
                modifica_status(status_venta);
                break;
        }
    }
};
let modifica_status = (status_venta, es_proceso_compra_sin_filtro = 0) => {

    if (es_proceso_compra_sin_filtro === 0) {

        let saldo_pos_venta = parseInt($saldo_cubierto_pos_venta.val());

        if (($saldo_cubierto > 0 || saldo_pos_venta > 0)) {

            registra_data_nuevo_estado(status_venta);

        } else {

            $form_cantidad_post_venta.show();
        }

    } else {
        set_option("es_proceso_compra", 1);
        registra_data_nuevo_estado(status_venta);
    }
};
let registra_saldo_cubierto = e => {

    if (valida_num_form(".saldo_cubierto", ".mensaje_saldo_cubierto") === 1) {

        let data_send = $form_cantidad.serialize();
        $(".mensaje_saldo_cubierto").empty();
        let url = "../q/index.php/api/recibo/saldo_cubierto/format/json/";
        bloquea_form(".form_cantidad");
        request_enid("PUT", data_send, url, response_saldo_cubierto)
    }
    e.preventDefault();
};
let response_saldo_cubierto = data => {


    if (data === true) {

        let status_venta = parseInt(get_valor_selected(".status_venta"));

        if (status_venta === 6 || status_venta === 9) {
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
    let recibo = get_parameter(".recibo");
    let data_send = $.param({
        "id_servicio": id_servicio,
        "stock": stock,
        "compra": 1,
        'recibo': recibo,
        'id_usuario_referencia': $id_usuario_referencia.val()
    });
    let url = "../q/index.php/api/servicio/stock/format/json/";
    $modal_estado_venta.modal('hide');
    request_enid("PUT", data_send, url, response_articulos_stock);

};
let response_articulos_stock = data => {

    let url = "../pedidos/?recibo=" + get_parameter(".recibo");
    redirect(url);
};
let response_cancelacion = data => {

    $('.tipificacion').prop('disabled', 'disabled');
    redirect('');
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

    modal(data);
    $(".tipificacion").change(registra_motivo_cancelacion);
};
let registra_motivo_cancelacion = () => {

    let status_venta = get_valor_selected(".status_venta");
    let tipificacion = get_valor_selected(".tipificacion");
    let data_send = $.param({
        "orden_compra": get_parameter(".recibo"),
        "status": status_venta,
        "tipificacion": tipificacion,
        "cancelacion": 1
    });
    let url = "../q/index.php/api/recibo/status/format/json/";
    bloquea_form(".selector_estados_ventas");
    request_enid("PUT", data_send, url, response_cancelacion);
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

    let saldo_cubierto = $saldo_actual_cubierto.val();

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

    $modal_estado_venta.modal("hide");

};
let procesa_cambio_estado = () => {

    set_option("es_proceso_compra", 1);
    modifica_status(6, 1);

};
let registra_data_nuevo_estado = status_venta => {

    bloquea_form(".selector_estados_ventas");
    let data_send = $.param({
        "orden_compra": get_parameter(".recibo"),
        "status": status_venta,
        "saldo_cubierto": get_parameter(".saldo_cubierto_pos_venta"),
        "es_proceso_compra": get_option("es_proceso_compra"),
        'tipo_entrega': get_parameter('.tipo_entrega_def')
    });
    set_option("es_proceso_compra", 0);
    let url = "../q/index.php/api/recibo/status/format/json/";
    request_enid("PUT", data_send, url, response_status_venta)
};
let response_status_venta = data => {

    desbloqueda_form(".selector_estados_ventas");
    let status = parseInt(get_valor_selected('.status_venta'));
    if (data === true) {


        switch (parseInt(status)) {
            case 6:
                $status_venta.prop('disabled', 'disabled');
                redirect('');
                break;

            default:

                show_confirm("¿QUIERES DESCONTAR LOS ARTICULOS DEL STOCK?", "", 0, descontar_articulos_stock, next_status);
                break;
        }


    } else {

        advierte(data);
    }

};

let confirma_cambio_horario = (tipo_entrega, ubicacion, id_recibo, status, saldo_cubierto_envio, monto_a_pagar, se_cancela, fecha_entrega) => {


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
        let url = _text("../pedidos/?recibo=", id_recibo, "&fecha_entrega=1&ubicacion=", ubicacion, "&tipo_entrega=", tipo_entrega);
        redirect(url);
    });


};
let confirma_lugar_horario_entrega = () => {

    let text = "¿DESEAS CAMBIAR EL HORARIO Y PUNTO DE ENCUENTRO?";
    show_confirm(text, '', "SI", function () {
        $('.form_puntos_medios_avanzado').submit();
    });

};
let confirma_cambio_domicilio = ($path) => {

    let text = "¿DESEAS CAMBIAR EL DOMICILIO DE ENTREGA?";
    show_confirm(text, '', "SI", function () {
        redirect($path);
    });

};

let confirma_envio_lista_negra = (id_usuario) => {


    let text_confirmacion = '¿Realmente deseas mandar a lista negra a esta persona?';
    show_confirm(text_confirmacion, '', "SI", function () {
        let url = "../q/index.php/api/motivo_lista_negra/index/format/json/";
        let data_send = {'v': 1, 'id_usuario': id_usuario, 'tipo': 0};
        request_enid("GET", data_send, url, response_motivos_lista_negra);
    });

};
let confirma_desbloqueo_lista_negra = (id_usuario) => {

    let text_confirmacion = '¿Realmente deseas desbloquear a este usuario de la lista negra?';
    show_confirm(text_confirmacion, '', "SI", function () {
        let url = "../q/index.php/api/lista_negra/desbloqueo/format/json/";
        let $recibo = $('.recibo').val();
        let data_send = {'v': 1, 'id_usuario': id_usuario, 'recibo': $recibo};
        request_enid("PUT", data_send, url, response_desbloqueo);
    });

};
let response_desbloqueo = (data) => {

    redirect('');
};
let confirma_intento_recuperacion = (id_usuario, recibo, dias) => {


    let data_send = {"v": 1, tipo: 11, 'id_usuario': id_usuario, 'recibo': recibo, 'dias': dias};
    let url = "../q/index.php/api/tipificacion/recuperacion/format/json/";
    request_enid("GET", data_send, url, response_form_intento_recuperacion)

};
let response_form_intento_recuperacion = function (data) {

    modal(data);
    $('.form_tipificacion_recuperacion').submit(registro_intento_recuperacion);
    let $select = '.form_tipificacion_recuperacion .tipificacion';
    $($select).change(function () {
        $($select).removeClass('sin_seleccion');
    });
    oculta_opciones_recibo();

};
let registro_intento_recuperacion = (e) => {

    let $form = $('.form_tipificacion_recuperacion');
    let data_send = $form.serialize();
    let $select = '.form_tipificacion_recuperacion .tipificacion';
    let tipificacion = get_valor_selected($select);
    if (parseInt(tipificacion) > 0) {
        bloquea_form('.form_tipificacion_recuperacion');
        $($select).removeClass('sin_seleccion');
        let url = "../q/index.php/api/tipificacion_recibo/index/format/json/";
        request_enid("POST", data_send, url, response_intento_recuperacion)

    } else {

        $($select).addClass('sin_seleccion');
    }

    e.preventDefault()

}
let response_intento_recuperacion = (data) => {
    cerrar_modal();
    show_confirm("¿HAY ALGO MÁS QUÉ HACER CON ESTE PEDIDO?", "", 'si', function () {
        opciones_recibo();
    });

};
let confirma_intento_reventa = (id_usuario, id_orden_compra) => {


    oculta_opciones_recibo();
    let url = "../q/index.php/api/tipo_tag_arquetipo/reventa/format/json/";
    let data_send = {'v': 1, 'id_usuario': id_usuario, 'id_orden_compra': id_orden_compra};
    request_enid("GET", data_send, url, response_reventa);

};

let response_reventa = (data) => {

    modal(data);
    verifica_formato_default_inputs();
    $(".input_enid_format :input").focus(next_label_input_focus);
    $('.form_reventa').submit(registra_intento_reventa);

    $('.accion_reventa').change(function () {
        let text = this.value;
        if (text.length > 5) {

            $('.hay_interes').removeClass('d-none');
            $('.interes_articulo').click(function () {

                $('.registro_articulo').removeClass('d-none');
                $('.interes').val(1);

            });

            $('.no_aplica').click(function () {
                $('.form_reventa').addClass('d-none');
                registro_reventa();
            });

        } else {

            $('.registro_articulo').addClass('d-none');
        }
    });


};

let registro_reventa = function () {


    $('.cargando_modal').removeClass('d-none');
    let data_send = $('.form_reventa').serialize() + '&' + $.param({'intento_reventa': 1});
    bloquea_form('.form_tag_arquetipo');
    let url = "../q/index.php/api/tag_arquetipo/index/format/json/";
    bloquea_form('.form_reventa');
    request_enid("POST", data_send, url, response_tag_arquetipo);
}
let registra_intento_reventa = function (e) {

    registro_reventa();
    e.preventDefault();

};
let response_motivos_lista_negra = (data) => {
    modal(data);
    $(".input_enid_format :input").focus(next_label_input_focus);
    $(".input_enid_format :input").change(next_label_input_focus);
    $('.form_lista_negra').submit(agregar_lista_negra);
    $('.motivo').change(evalua_registro_motivo_lista_negra);
    oculta_opciones_recibo();
};
let evalua_registro_motivo_lista_negra = function () {

    let $motivo = parseInt(get_valor_selected('.motivo'));

    if (Number.isInteger($motivo)) {
        $('.agregar_botton_lista_negra').removeClass('d-none');
    } else {
        $('.agregar_botton_lista_negra').addClass('d-none');
    }

    if ($motivo === 0) {

        $('.input_agregar_motivo').removeClass('d-none');
        $('.motivo_lista_negra').attr('required', true);

    } else {

        $('.input_agregar_motivo').addClass('d-none');
        $('.motivo_lista_negra').attr('required', false);

    }

};
let agregar_lista_negra = (e) => {

    
    let $motivo = parseInt(get_valor_selected('.motivo'));
    if ($motivo >= 0) {

        let $telefono = $telefono_contacto_recibo.val();
        let $orden_compra = $('.recibo').val();
        let data_send = $('.form_lista_negra').serialize() + "&" + $.param({
            'orden_compra': $orden_compra,
            'telefono': $telefono
        });
        let url = "../q/index.php/api/lista_negra/index/format/json/";
        $('.cargando_modal').removeClass('d-none');
        $('.motivo').prop('disabled', 'disabled');
        request_enid("POST", data_send, url, function (data) {
            //debugger;
            redirect('');
        });
    }
    e.preventDefault();
}


let confirma_reparto = (id_recibo, punto_encuentro) => {

    let text = "¿DESEAS QUE EL REPARTIDOR SE DIRIJA HACER LA ENTREGA A:?";
    show_confirm(text, punto_encuentro, "SI", function () {
        enviar_repatidor(id_recibo);
    });
    setTimeout(function () {

        let $jsSelector = $('.jconfirm-content');
        if ($jsSelector.length) {
            $jsSelector.find('div').addClass('rounded-0 alert border-secondary alert-light black text-uppercase text-center border');
        }
    }, 1000);

};
let confirma_reparto_contra_entrega_domicilio = (id_recibo, id_domicilio) => {


    let text = "¿DESEAS QUE EL REPARTIDOR SE DIRIJA HACER LA ENTREGA A:?";
    show_confirm(text, id_domicilio, "SI", function () {
        enviar_repatidor(id_recibo, 2);
    });
    setTimeout(function () {

        let $jsSelector = $('.jconfirm-content');
        if ($jsSelector.length) {
            $jsSelector.find('div').addClass('rounded-0 alert border-secondary alert-light black text-uppercase text-center border');
        }
    }, 1000);

};

let enviar_repatidor = function (id_recibo, es_punto_encuentro = 1) {

    $('.jconfirm').addClass('d-none');
    advierte('Se está solicitando tu entrega al repartidor', 1)
    $('.text-order-name-error').addClass('h4 text-uppercase');
    let url = "../q/index.php/api/recibo/reparto/format/json/";
    let data_send = {'id': id_recibo, 'es_punto_encuentro': es_punto_encuentro};
    request_enid("PUT", data_send, url, response_reparto);
};
let response_reparto = function () {

    advierte('Tu solicitud fué enviada ya pronto estaremos en camino!');
    setTimeout(function () {
        redirect("");
    }, 2000);

};

let agregar_nota = () => {

    showonehideone(".form_notas", ".agregar_comentario");
    oculta_opciones_recibo();
    recorre(".form_notas");
};
let registrar_nota = e => {

    let url = "../q/index.php/api/orden_comentario/index/format/json/";
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


};
let response_tag_arquetipo = function (data) {
    redirect('');
};
let baja_tag_arquetipo = function () {

    set_option('tag_arquetipo', get_parameter_enid($(this), 'id'));
    show_confirm("¿QUIERES QUITAR ESTA DESCRIPCIÓN?", "", 0, baja_tag);
};
let baja_tag = function () {

    let tag_arquetipo = get_option('tag_arquetipo');
    if (parseInt(tag_arquetipo) > 0) {

        let data_send = $.param({'id': tag_arquetipo});
        let url = "../q/index.php/api/tag_arquetipo/index/format/json/";
        request_enid("DELETE", data_send, url, response_tag_arquetipo);
    }
};
let usuario_tipo_negocio = function () {

    let tipo_negocio = get_valor_selected('.usuario_tipo_negocio');
    if (parseInt(tipo_negocio) > 0) {
        let data_send = $form_usuario_tipo_negocio.serialize();
        let url = "../q/index.php/api/usuario_tipo_negocio/index/format/json/";
        request_enid("POST", data_send, url, response_tag_arquetipo);
    }
};
let editar_usuario_tipo_negocio = function () {

    $form_usuario_tipo_negocio.removeClass('d-none');
};
let opciones_recibo = () => {
    $form_cantidad_post_venta.hide();
    $modal_opciones_compra.modal('show');
};
let oculta_opciones_recibo = () => {
    $modal_opciones_compra.modal('hide');
};
let cambio_reparto = function (e) {

    modal('Buscando ...', 1);
    let $id_recibo = get_parameter_enid($(this), 'id');
    let $id_usuario = get_parameter_enid($(this), 'usuario');
    let data_send = $.param({'id_recibo': $id_recibo, 'usuario': $id_usuario, 'v': 1, 'id_perfil': 21});
    let url = "../q/index.php/api/usuario/perfiles/format/json/";
    request_enid("GET", data_send, url, response_cambio_reparto);

};
let response_cambio_reparto = function (data) {

    modal(data);
    $('.form_cambio_reparto').submit(nuevo_repartidor);

};

let nuevo_repartidor = function (e) {

    $('.cargando_modal').removeClass('d-none');
    let data_send = $(".form_cambio_reparto").serialize();
    let url = "../q/index.php/api/recibo/repartidor/format/json/";
    request_enid("PUT", data_send, url, response_nuevo_repartidor);
    bloquea_form(".form_cambio_reparto");
    e.preventDefault();
};

let response_nuevo_repartidor = function (data) {

    redirect('');
};

let valida_registro_articulo_interes = () => {


    let $se_registra_articulo_interes = $registro_articulo_interes.val();
    let $en_lista_negra = $es_lista_negra.val();

    let no_boletinado = ($en_lista_negra.length < 1 || parseInt($en_lista_negra) < 1);
    if (parseInt($se_registra_articulo_interes) < 1 && no_boletinado) {

        let $recibo = $('.recibo').val();
        let $id_usuario_compra = $('.id_usuario_compra').val();
        let data_send = $.param({'v': 1, 'recibo': $recibo, 'id_usuario': $id_usuario_compra});
        let url = "../q/index.php/api/tag_arquetipo/articulos_interes/format/json/";
        request_enid("GET", data_send, url, response_form_interes);

    }
};

let response_form_interes = function (data) {

    modal(data);
    $(".input_enid_format :input").focus(next_label_input_focus);
    $(".input_enid_format :input").change(next_label_input_focus);

    $('.agregar_nuevo_interes').click(function () {
        $('.opciones_nuevo_articulo').addClass('d-none');
        $('.form_articulo_interes').removeClass('d-none');
    });

    $('.form_articulo_interes').submit(registro_articulo_interes);
    $('.aun_no_se').click(registro_aun_sin_articulo_interes);

};
let registro_articulo_interes = function (e) {


    let data_send = $(this).serialize();
    let url = "../q/index.php/api/tag_arquetipo/interes/format/json/";
    request_enid("POST", data_send, url, response_tag_arquetipo);
    e.preventDefault();
};
let registro_aun_sin_articulo_interes = function () {

    let $recibo = $('.recibo').val();
    let data_send = $.param({'v': 1, 'id': $recibo});
    let url = "../q/index.php/api/recibo/registro_articulo_interes/format/json/";
    request_enid("PUT", data_send, url, response_tag_arquetipo);
};
let habilita_edicion = function () {

    let $id = $(this).attr("id");
    let $seccion_edicion_cantidad_ = $(_text(".seccion_edicion_cantidad_", $id));
    let $icono_edicion_cantidad_ = $(_text(".icono_edicion_cantidad_", $id));
    $(".id_producto_orden_compra").val($id);

    $seccion_edicion_cantidad_.removeClass('d-none');
    $icono_edicion_cantidad_.addClass("d-none");


};
let actualizar_cantidad = function () {


    let $id_producto_orden_compra = $(".id_producto_orden_compra").val();
    let $cantidad = $(_text('.cantidad_', $id_producto_orden_compra)).val();
    let data_send = $.param({'id': $id_producto_orden_compra, 'cantidad': $cantidad});
    let url = "../q/index.php/api/recibo/cantidad/format/json/";
    $seccion_edicion_cantidad.addClass('d-none');
    request_enid("PUT", data_send, url, response_tag_arquetipo);

};
