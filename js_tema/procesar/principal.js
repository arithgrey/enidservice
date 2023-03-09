"use strict";

let form_miembro = '#form-miembro-enid-service';
let form_cotizacion = ".form_cotizacion_enid_service";

let input_nombre = '.nombre';
let input_email = '.email';
let input_facebook = '.facebook';
let input_id_servicio = '.id_servicio';
let descripcion_servicio = '.resumen_producto';
let id_ciclo_facturacion = '.id_ciclo_facturacion';
let usuario_referencia = '.q2';
let num_ciclos = '.num_ciclos';
let talla = '.talla';

let $form_miembro = $(form_miembro);
let $form_cotizacion = $(form_cotizacion);

let $id_servicio = $(input_id_servicio);
let $descripcion_servicio = $(descripcion_servicio);
let $id_ciclo_facturacion = $(id_ciclo_facturacion);
let $usuario_referencia = $(usuario_referencia);
let $num_ciclos = $(num_ciclos);
let $talla = $(talla);

let input_password = "#password_registro";
let fecha_servicio = ".fecha_servicio";
let fecha_contra_entrega = ".fecha_contra_entrega";

let $input_nombre_registro_envio = $form_miembro.find(input_nombre);
let $input_email_registro_envio = $form_miembro.find(input_email);
let $input_password_registro_envio = $form_miembro.find(input_password);
let $input_facebook_registro_envio = $form_miembro.find(input_facebook);
let $input_telefono_registro_envio = $form_miembro.find('.telefono');
let $input_es_prospecto_registro_envio = $form_miembro.find('.es_prospecto');
let $seccion_input_facebook = $form_miembro.find('.seccion_input_facebook');
let $url_facebook_conversacion = $form_miembro.find('.url_facebook_conversacion');
let $comentario_compra = $form_miembro.find('.comentario_compra');

let $check_indico_ubicacion = $form_miembro.find(".check_indico_ubicacion");
let $input_lead_ubicacion = $form_miembro.find('.lead_ubicacion');

let $check_indico_catalogo = $form_miembro.find(".check_vio_catalogo_web");
let $input_lead_catalogo = $form_miembro.find('.lead_catalogo');

let $input_adicionales = $form_miembro.find('.adicionales');
let $input_adicionales_cliente_frecuente = $form_miembro.find('.adicionales_cliente_frecuente');


let $adicionales_adimistrador = $form_miembro.find('.adicionales_adimistrador');
let $adicionales_adimistrador_numero_cliente = $form_miembro.find('.adicionales_adimistrador_numero_cliente');
let $input_numero_cliente = $form_miembro.find('.input_numero_cliente');

let $check_prospecto = $form_miembro.find('.check_prospecto');
let $check_numero_cliente = $form_miembro.find('.check_numero_cliente');

let $input_fecha_servicio = $(fecha_servicio);
let $input_fecha_contra_entrega = $(fecha_contra_entrega);

let $input_es_cliente = $('.es_cliente');
let $es_carro_compras = $(".es_carro_compras");
let $producto_carro_compra = $(".producto_carro_compra");

let primer_compra = '.primer_compra';
let $primer_compra = $(primer_compra);
let $form_busqueda_cliente = $(".form_busqueda_cliente");


$(document).ready(() => {
        
    $('footer').addClass('d-none');
    $(".barra_categorias_ab").removeClass("d-block").addClass("d-none");
    $form_busqueda_cliente.submit(busqueda_numero_cliente);

    $(".cupon_seccion_footer").removeClass("d-block").addClass("d-none");
    $(".seccion_menu_comunes").removeClass("d-block").addClass("d-none");
    
    oculta_acceder();
    set_option({ "vista": 1 });
    despliega([".base_compras", ".nav-sidebar", ".base_paginas_extra"]);
    $form_miembro.submit(registro);
    $form_cotizacion.submit(registro_cotizacion);
    $(".btn_procesar_pedido_cliente").click(procesar_pedido_usuario_activo);
    $(".link_acceso").click(set_link);
    $(".continuar_pedido").click(continuar_compra);

    $('.agregar_commentario').click(function () {
        $('.text_comentarios').removeClass('d-none');
    });

    $input_nombre_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });
    $input_email_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });
    $input_password_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });
    $input_telefono_registro_envio.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form_miembro);
    });

    $check_prospecto.click(modifica_estado_prospecto);
    $check_numero_cliente.click(modifica_estado_cliente_por_numero);

    $check_indico_ubicacion.click(modifica_lead_ubicacion);
    $check_indico_catalogo.click(modifica_lead_catalogo);

    $input_numero_cliente.change(busqueda_cliente);
    
    $(".busqueda_cliente_frecuente").click(function(){        
        $("#modal_busqueda_cliente_frecuente").modal("show");        
    });


});

let busqueda_cliente =  function(){
    
    let $usuario_cliente_frecuente= $input_numero_cliente.val();
    if (parseInt($usuario_cliente_frecuente) > 0) {        

        let url = "../q/index.php/api/usuario/q/format/json/";
        let data_send = {"id_usuario": $usuario_cliente_frecuente};
        request_enid("GET", data_send, url, response_cliente_frecuente);     

    }
}

let response_cliente_frecuente =  function(data){

    $input_nombre_registro_envio.val("");
    $input_telefono_registro_envio.val(""); 

    data = data[0];    
    $input_nombre_registro_envio.val(data.name);
    $input_telefono_registro_envio.val(data.tel_contacto);

}
let modifica_estado_cliente_por_numero = (e) => {

    
    let $val = $input_es_prospecto_registro_envio.val();    
    let $adicionales = parseInt($input_adicionales_cliente_frecuente.val());
    if ($adicionales > 0) {
        $adicionales_adimistrador_numero_cliente.removeClass('d-none');
    }
    
    if ($val > 0) {
        
        $input_es_prospecto_registro_envio.val(0);
        $adicionales_adimistrador_numero_cliente.addClass('d-none');        
        $(".label_registro_facebook").removeClass('d-none');

    } else {
        
        $input_es_prospecto_registro_envio.val(1);
        $adicionales_adimistrador_numero_cliente.removeClass('d-none');
        $(".label_registro_facebook").addClass('d-none');
               
    }    

}

let modifica_estado_prospecto = (e) => {

    let $val = $input_es_prospecto_registro_envio.val();
    let $adicionales = parseInt($input_adicionales.val());
    if ($adicionales > 0) {
        $adicionales_adimistrador.removeClass('d-none');
    }

    if ($val > 0) {

        $input_telefono_registro_envio.prop('required', true);
        $input_facebook_registro_envio.prop('required', false);
        $input_es_prospecto_registro_envio.val(0);
        $seccion_input_facebook.addClass('d-none');

        $adicionales_adimistrador.addClass('d-none');
    } else {


        $input_facebook_registro_envio.prop('required', true);
        $input_telefono_registro_envio.prop('required', false);
        $input_es_prospecto_registro_envio.val(1);
        $seccion_input_facebook.removeClass('d-none');
    }

}

let modifica_lead_ubicacion = (e) => {

    let $val = $input_lead_ubicacion.val();
    if ($val > 0) {

        $input_lead_ubicacion.val(0);

    } else {

        $input_lead_ubicacion.val(1);
    }

}

let modifica_lead_catalogo = (e) => {

    let $val = $input_lead_catalogo.val();
    if ($val > 0) {

        $input_lead_catalogo.val(0);

    } else {

        $input_lead_catalogo.val(1);
    }

}

let registro = (e) => {


    let respuestas = [];
    respuestas.push(es_formato_nombre($input_nombre_registro_envio));
    respuestas.push(es_formato_password($input_password_registro_envio));
    respuestas.push(es_formato_email($input_email_registro_envio));

    if (parseInt($input_es_prospecto_registro_envio.val()) < 1) {

        respuestas.push(es_formato_telefono($input_telefono_registro_envio));

    }

    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {

        advierte('Procesando tu pedido', 1);
        let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
        let $producto_carro_compra = $("input[name='producto_carro_compra[]']").map(function () {
            return $(this).val();
        }).get();

        let $recompensas = $("input[name='recompensas[]']").map(function () {
            return $(this).val();
        }).get();


        let text_password = $.trim($input_password_registro_envio.val());
        let $secret = "" + CryptoJS.SHA1(text_password);
        let $cobro_secundario = $(".cobro_secundario").val();

        let $data_send = {
            "password": $secret,
            "email": $input_email_registro_envio.val(),
            "nombre": $input_nombre_registro_envio.val(),
            "facebook": $input_facebook_registro_envio.val(),
            "telefono": $input_telefono_registro_envio.val(),
            "id_servicio": $id_servicio.val(),
            "ciclo_facturacion": $id_ciclo_facturacion.val(),
            "usuario_referencia": $usuario_referencia.val(),
            "talla": $talla.val(),
            "tipo_entrega": 2,
            "fecha_contra_entrega": $input_fecha_contra_entrega.val(),
            "fecha_servicio": $input_fecha_servicio.val(),
            "es_cliente": $input_es_cliente.val(),
            "es_carro_compras": $es_carro_compras.val(),
            "producto_carro_compra": $producto_carro_compra,
            "recompensas": $recompensas,
            "cobro_secundario": $cobro_secundario,
            "es_prospecto": $input_es_prospecto_registro_envio.val(),
            "url_facebook_conversacion": $url_facebook_conversacion.val(),
            "comentario_compra": $comentario_compra.val(),
            "lead_ubicacion": $input_lead_ubicacion.val(),
            "lead_catalogo": $input_lead_catalogo.val(),
            "numero_cliente":  $input_numero_cliente.val()

        };

        bloquea_form(form_miembro);
        request_enid("POST", $data_send, url, respuesta_registro, 0);

    }
    e.preventDefault();
};
let busqueda_numero_cliente = (e) => {
    
    
    let url = "../q/index.php/api/usuario/tel_contacto_email/format/json/";
    
    let $data_send = $form_busqueda_cliente.serialize();
    
    request_enid("GET", $data_send, url, lista_clientes_encontrados);
    e.preventDefault();

}
let lista_clientes_encontrados = (data) => {

    render_enid(".place_usuarios_coincidentes", data);
    $(".cliente_encontrado").click(click_usuario_coincidencia);
};
let click_usuario_coincidencia = function(e){
    
    let $id = e.target.id;
    
    if(parseInt($id)  > 0){
        
        $("#modal_busqueda_cliente_frecuente").modal("hide");        
        $(".input_numero_cliente").val($id);
        $(".check_numero_cliente").click();
        $input_numero_cliente.change();

    }


}
let registro_cotizacion = (e) => {

    let data_send = $form_cotizacion.serialize();
    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    bloquea_form(form_cotizacion);
    valida_load();
    request_enid("POST", data_send, url, respuesta_proceso_usuario_activo);
    e.preventDefault();
};

let respuesta_registro = (data) => {

    
    empty_elements(".place_registro_afiliado");
    if (data !== -1) {

        //$("#modal-error-message").modal("hide");
        desbloqueda_form(form_miembro);
        if (parseInt(data.usuario_existe) > 0) {

            $('.usuario_existente').removeClass('d-none');
            $primer_compra.addClass('d-none');
            recorre(".usuario_existente");

        } else {

            let $path = _text("../area_cliente/?action=compras&ticket=", data.id_orden_compra);
            redirect($path);
        }

    } else {

        redirect("../");
    }

};

let procesar_pedido_usuario_activo = () => {

    advierte('Procesando pedido', 1);
    let url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    let data_send = {
        "id_servicio": $id_servicio.val(),
        "num_ciclos": $num_ciclos.val(),
        "descripcion_servicio": $descripcion_servicio.val(),
        "ciclo_facturacion": $id_ciclo_facturacion.val(),
        "talla": $talla.val(),
        "tipo_entrega": 2,
        "id_carro_compras": get_parameter(".id_carro_compras"),
        "carro_compras": get_parameter(".carro_compras"),
    };

    $('.btn_procesar_pedido_cliente').prop('disabled', true);
    request_enid("POST", data_send, url, respuesta_registro);

};
let respuesta_proceso_usuario_activo = (data) => {

    redirect("../area_cliente");

};

let set_link = function () {

    let id = get_parameter_enid($(this), "id_servicio");
    let ciclo_facturacion = get_parameter_enid($(this), "ciclo_facturacion");
    let is_servicio = get_parameter_enid($(this), "is_servicio");
    let q2 = get_parameter_enid($(this), "q2");
    let num_ciclos = get_parameter_enid($(this), "num_ciclos");

    let data_send = $.param({
        "id_servicio": id,
        "ciclo_facturacion": ciclo_facturacion,
        is_servicio: is_servicio,
        "q2": q2,
        "num_ciclos": num_ciclos
    });
    let url = "../login/index.php/api/sess/servicio/format/json/";
    request_enid("POST", data_send, url, response_set_link);

};
let continuar_compra = function () {
    showonehideone(primer_compra, ".compra_resumen");
    set_option("vista", 2)
};
let response_set_link = (data) => redirect("../login");
