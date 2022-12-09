"use strict";
let $form_busqueda = $(".form_busqueda_pedidos");
let $form_franja_horaria = $(".form_franja_horaria");
let $form_alcaldias = $(".form_alcaldias");

let $ids = $(".ids");
let $usurios = $(".usuarios");
let $reparto = $(".reparto");
let $es_busqueda_reparto = $form_busqueda.find('.es_busqueda_reparto');
let $form_pago_comisiones = $('.form_pago_comisiones');
let $modal_pago_comision = $('#modal_pago_comision');
let $modal_pago_comisiones = $('#modal_pago_comisiones');
let $modal_envio_catalogo = $('#modal_envio_catalogo');
let $modal_envio_promocion = $('#modal_envio_promocion');



let $usuario_pago = $('.usuario_pago');
let $fecha_inicio = $form_pago_comisiones.find('.fecha_inicio');
let $fecha_termino = $form_pago_comisiones.find('.fecha_termino');
let $input_busqueda = $form_busqueda.find('.input_busqueda');
let $tipo_orden = $form_busqueda.find('.tipo_orden');
let $nombre_usuario_venta = $('.nombre_usuario_venta');
let $marcar_cuentas_pagas = $('.marcar_cuentas_pagas');

let $busqueda_metricas = $(".busqueda_metricas");

let $busqueda_ventas_en_proceso = $(".ventas_en_proceso");
let $busqueda_ventas_en_proceso_clientes = $(".ventas_en_proceso_clientes");
let $busqueda_ventas_efectivas = $(".ventas_efectivas");

let $busqueda_catalogos_pendientes = $(".busqueda_catalogos_pendientes");
let $busqueda_promociones_disponibles = $(".busqueda_promociones_disponibles");

let $sintesis = $('.sintesis');
let $marcar_pagos = $('.marcar_pagos');
let $ids_pagos = $('.ids_pagos');

let $ventas_en_carros = $(".en_carros_de_compras");
let $ventas_en_carros_vendedores = $(".en_carros_de_compras_vendedores");



let $fecha_venta_efectiva = $(".fecha_venta_efectiva");

$(document).ready(() => {

    $('footer').ready(function () {
        valida_busqueda_inicial();
    });

    $form_busqueda.submit(busqueda_pedidos);
    $form_pago_comisiones.submit(registro_pago);
    $('.usuario_venta_pago').click(busqueda_pago_pendiente);
    $input_busqueda.keyup(elimina_guienes);
    $nombre_usuario_venta.click(filtro_ordenes_vendedor);
    $marcar_pagos.click(marcar_pagos);
    $marcar_cuentas_pagas.click(marcar_cuentas_pagas);
    $busqueda_catalogos_pendientes.click(busqueda_leads_catalogo);
    $busqueda_promociones_disponibles.click(busqueda_lead_promociones_disponibles);
    $busqueda_ventas_en_proceso.click(busqueda_ventas_proceso);
    $busqueda_ventas_en_proceso_clientes.click(busqueda_ventas_proceso_clientes);
    $busqueda_ventas_efectivas.click(busqueda_ventas_efectivas);
    $ventas_en_carros.click(busqueda_ventas_en_carros);
    $ventas_en_carros_vendedores.click(busqueda_ventas_en_carros_vendedores);

    $form_franja_horaria.submit(busqueda_metricas_franja_horaria);
    $form_alcaldias.submit(busqueda_metricas_alcaldias);


    $busqueda_ventas_en_proceso.click();
    $busqueda_ventas_en_proceso_clientes.click();
    $form_alcaldias.submit();

});


let busqueda_ventas_en_carros = function () {

    let data_send = $.param({});
    let url = "../q/index.php/api/usuario_deseo_compra/agregados/format/json/";
    request_enid("GET", data_send, url, response_personas_registradas_carrito);

}


let busqueda_ventas_en_carros_vendedores = function () {

    let data_send = $.param({});

    let path = "../q/index.php/api/usuario_deseo/agregados/format/json/";
    request_enid("GET", data_send, path, response_personas_carrito_vendedores);

}


let response_personas_registradas_carrito = function (data) {

    render_enid(".place_en_carros_de_compras", data);
    $(".cancela_deseo_compra_carro_ip").click(cancela_productos_deseados_carro_compras);
};
let response_personas_carrito_vendedores = function (data) {

    render_enid(".place_en_carros_de_compras_vendedores", data);
    
};

let cancela_productos_deseados_carro_compras = function(e) {

    let $id = e.target.id;
    if (parseInt($id) > 0) {
        let url = "../q/index.php/api/usuario_deseo_compra/ip/format/json/";
        let data_send = { "ip": $id, "status": 2 };
        request_enid("PUT", data_send, url, function(){
            let data_send = $.param({});
            let url = "../q/index.php/api/usuario_deseo_compra/agregados/format/json/";
            request_enid("GET", data_send, url, response_personas_registradas_carrito);
        
        });
    }

};

let response_personas_carrito = function (data) {

    render_enid(".place_en_carros", data);

};

let busqueda_ventas_proceso = function () {

    let data_send = $form_franja_horaria.serialize();
    let url = "../q/index.php/api/lead/ventas_proceso/format/json/";
    request_enid("GET", data_send, url, response_busqueda_ventas_proceso);

}

let response_busqueda_ventas_proceso = function (data) {

    render_enid(".place_ventas_en_proceso", data);
    $(".place_ventas_proceso").text($(".place_ventas_en_proceso .total_ventas_pendientes").val());
    ver_notificaciones_ordenes_compra();
};

let busqueda_ventas_efectivas = function () {


    let fecha_inicio = $fecha_venta_efectiva.val();
    let fecha_termino = $fecha_venta_efectiva.val();
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $.param({
            "fecha_inicio": fecha_inicio,
            "fecha_termino": fecha_termino,
            "tipo_orden": 5,
            "tipo_entrega": 0,
            "recibo": "",
            "v": 1,
            "cliente": "",
            "status_venta": 15,
            "perfil": 0
        });
        let url = "../q/index.php/api/recibo/pedidos/format/json/";
        request_enid("GET", data_send, url, response_busqueda_ventas_efectivas);

    }



}

let response_busqueda_ventas_efectivas = function (data) {

    render_enid(".place_ventas_efectivas", data);

};
let busqueda_ventas_proceso_clientes = function () {


    let data_send = {};
    let url = "../q/index.php/api/lead/ventas_proceso_clientes/format/json/";
    request_enid("GET", data_send, url, response_busqueda_ventas_proceso_clientes);

}

let response_busqueda_ventas_proceso_clientes = function (data) {

    render_enid(".place_ventas_en_proceso_clientes", data);
    $(".place_ventas_proceso_cliente").text($(".place_ventas_en_proceso_clientes .total_ventas_pendientes").val());
    ver_notificaciones_ordenes_compra();

};


let busqueda_lead_promociones_disponibles = function () {


    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_busqueda.serialize();
        let url = "../q/index.php/api/recibo/leads_promociones/format/json/";
        request_enid("GET", data_send, url, response_lead_promociones);

    }

}
let busqueda_metricas_franja_horaria = function (e) {

    let fecha_inicio = get_parameter(".form_franja_horaria #datetimepicker4");
    let fecha_termino = get_parameter(".form_franja_horaria #datetimepicker5");

    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_franja_horaria.serialize();
        let url = "../q/index.php/api/lead/franja_horaria/format/json/";
        request_enid("GET", data_send, url, response_lead_franja_horaria);

    }

    e.preventDefault();
}

let busqueda_metricas_alcaldias = function (e) {


    let fecha_inicio = get_parameter(".form_alcaldias #datetimepicker4");
    let fecha_termino = get_parameter(".form_alcaldias #datetimepicker5");

    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_alcaldias.serialize();
        let url = "../q/index.php/api/ubicacion/penetracion_tiempo/format/json/";
        request_enid("GET", data_send, url, response_metricas_alcaldias);

    }

    e.preventDefault();
}

let response_lead_franja_horaria = function (data) {

    render_enid(".place_lead_franja_horaria", data);

};
let response_metricas_alcaldias = function (data) {

    render_enid(".place_alcaldias", data);
    $(".place_penetracion_leads").text(_text_("Leads", $(".penetracion_leads").val()));
    $(".place_penetracion_leads_ventas").text(_text_("Ventas", $(".penetracion_leads_ventas").val()));
};

let response_lead_promociones = function (data) {

    render_enid(".place_leads_promocion", data);
    $(".notificacion_envio_promocion").click(notificacion_envio_promocion);

};

let notificacion_envio_promocion = function () {

    let $id_orden_compra = get_parameter_enid($(this), "id");
    $modal_envio_promocion.modal("show");

    /*Búsqueda lead*/
    busqueda_lead_recibo($id_orden_compra, 1);

    $(".marcar_envio_promocion").click(function () {

        let data_send = $.param({ "orden_compra": $id_orden_compra });
        let url = "../q/index.php/api/recibo/envio_lead_promocion/format/json/";
        $modal_envio_promocion.modal("hide");
        request_enid("PUT", data_send, url, busqueda_lead_promociones_disponibles);

    });
};

let busqueda_leads_catalogo = function () {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_busqueda.serialize();
        let url = "../q/index.php/api/recibo/leads_catalogo/format/json/";
        request_enid("GET", data_send, url, response_lead_catalogo);

    }

};
let response_lead_catalogo = function (data) {

    render_enid(".place_leads_catalogo", data);
    $(".notificacion_envio_catalogo").click(notificacion_envio_catalogo_web);

};

let notificacion_envio_catalogo_web = function () {

    let $id_orden_compra = get_parameter_enid($(this), "id");
    $modal_envio_catalogo.modal("show");

    /*Búsqueda lead*/
    busqueda_lead_recibo($id_orden_compra);

    $(".marcar_envio_catalogo").click(function () {

        let data_send = $.param({ "orden_compra": $id_orden_compra });
        let url = "../q/index.php/api/recibo/envio_lead_catalogo/format/json/";
        $modal_envio_catalogo.modal("hide");
        request_enid("PUT", data_send, url, busqueda_leads_catalogo);

    });
};

let busqueda_lead_recibo = function ($id_orden_compra, $es_promocion = 0) {

    let data_send = $.param({ "id_orden_compra": $id_orden_compra });
    let url = "../q/index.php/api/recibo/lead/format/json/";
    request_enid("GET", data_send, url, function (data) {

        let $path = data.usuario[0].url_lead;

        if ($es_promocion) {

            $(".link_cliente_potencial_promocion").attr("href", $path);

        } else {

            $(".link_cliente_potencial").attr("href", $path);
        }



    });

}

let busqueda_pedidos = function (e) {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_busqueda.serialize();
        let url = "../q/index.php/api/recibo/pedidos/format/json/";
        request_enid("GET", data_send, url, response_pedidos, ".place_pedidos");

    }
    e.preventDefault();
};
let response_pedidos = function (data) {

    render_enid(".place_pedidos", data);

    $('.usuario_venta').click(busqueda_usuario_selector);
    $('th').click(ordena_tabla);
    $(".desglose_orden").click(function () {
        let recibo = get_parameter_enid($(this), "id");
        $(".numero_recibo").val(recibo);
        $(".form_search").submit();
    });


};
let valida_busqueda_inicial = function () {

    if (parseInt($ids.val()) > 0 && $usurios.val().length > 0) {

        $form_busqueda.submit();

    } else if (parseInt($es_busqueda_reparto.val()) > 0) {

        selecciona_valor_select('.form_busqueda_pedidos .tipo_orden', 2);
        $form_busqueda.submit();
    }

};
let busqueda_usuario_selector = function (e) {


    let id = e.target.id;
    if (parseInt(id) > 0) {

        $(".comisionista option[value='" + id + "']").attr("selected", true);
        let data_send = $(this).serialize();
        let url = "../q/index.php/api/tag_arquetipo/interes/format/json/";
        request_enid("POST", data_send, url, response_tag_arquetipo);
        $form_busqueda.submit();

    }

};
let busqueda_pago_pendiente = function (e) {

    let id = e.target.id;
    $modal_pago_comision.modal("show");
    let total_comisiones = get_parameter_enid($(this), "total_comisiones");
    let nombre_comisionista = get_parameter_enid($(this), "nombre_comisionista");

    let fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    let fecha_termino = get_parameter_enid($(this), "fecha_termino");

    $usuario_pago.val(id);
    $fecha_inicio.val(fecha_inicio);
    $fecha_termino.val(fecha_termino);

    let text_comisionista = d(_text_(nombre_comisionista), 'text-uppercase text-center mt-3');
    let text_totales = d(_text_('Total', total_comisiones), 'h2 text-center');

    render_enid('.resumen_pago_comisionista', _text_(text_comisionista, text_totales));


}
let registro_pago = function (e) {

    let data_send = $(this).serialize();
    let url = '../q/index.php/api/recibo/pago_recibos_comisiones/format/json/';
    request_enid("PUT", data_send, url, response_pagos);
    e.preventDefault();
}
let response_pagos = function (data) {

    $modal_pago_comision.modal("hide");
    redirect('');
}
let elimina_guienes = function (e) {

    if (e.keyCode === 173) {
        let texto = this.value;
        texto = texto.replace(/-/g, '');
        this.value = texto;
    }
}
let paste_busqueda = function () {

    event.preventDefault();
    if (event.clipboardData) {
        let str = event.clipboardData.getData("text/plain");
        event.target.value = str.replace(/-/g, '');
    }
}
let filtro_ordenes_vendedor = function (e) {

    let $id = e.target.id;
    if (parseInt($id) > 0) {

        $('.linea_venta').addClass('d-none').removeClass('d-block');
        let linea = _text('.usuario_', $id);
        $(linea).removeClass('d-none');
        $sintesis.removeClass('selector');


        $('sintesis').removeClass('selector');
        let linea_selector = _text('.nombre_vendedor_sintesis_', $id);
        $(linea_selector).addClass('selector');

    }


}
let marcar_pagos = function () {

    $modal_pago_comisiones.modal("show");
}
let marcar_cuentas_pagas = function () {


    let data_send = $.param({ 'ids': $ids_pagos.val() });
    let url = '../q/index.php/api/recibo/pago_recibos_comisiones_ids/format/json/';
    request_enid("PUT", data_send, url, response_pagos);
    e.preventDefault();


}
