let $en_lista_deseos = $(".en_lista_deseos");
let $form_registro = $(".form_lead");
let $registro_nombre = $form_registro.find('.nombre_registro');
let $telefono_registro = $form_registro.find('.telefono_registro');
let $pw_registro = $form_registro.find(".pw_registro");
let $email_registro = $form_registro.find(".email_registro");


let $accion_continuar_registro = $(".accion_continuar_registro");

$(document).ready(function () {

    $form_registro.submit(registro_lead);
    $(".productos_en_carro_compra").addClass("d-none");
    $accion_continuar_registro.click(intento_registro_accion);

    $en_lista_deseos.click(function () {

        $(".en_lista_deseos_producto").val(1);
        $(".selectores").addClass("d-none").removeClass("d-flex");
    });

    $registro_nombre.keypress(function (e) {
        if (e.which == 13) {
            let len = $(this).val();
            if (len.length > 3) {

                $(".input_nombre").addClass("d-none");
                $(".input_telefono").removeClass("d-none");
                oculta_error_enid_input($(this).attr("id"));
            } else {

                error_enid_input($(this).attr("id"));
                escucha_submmit_selector(e, $form_registro);
            }
        }
    });

    $telefono_registro.keypress(function (e) {

        if (e.which == 13) {

            let telefono = $(this).val();
            var regexTelefono = /^[0-9]{10}$/;

            if (!regexTelefono.test(telefono)) {

                error_enid_input($(this).attr("id"));

            } else {

                escucha_submmit_selector(e, $form_registro);
                oculta_error_enid_input($(this).attr("id"));
            }
        }
    });

});


let agregar_deseos_sin_antecedente_promocional = function (id_servicio) {


    $(".cargando").removeClass("d-none");
    if (parseInt(id_servicio) > 0) {

        let data_send = { "id_servicio": id_servicio, "articulos": 1 };
        let url = "../q/index.php/api/usuario_deseo_compra/envio_pago/format/json/";
        request_enid("POST", data_send, url, muestra_form_promocional);

    }
}

let muestra_form_promocional = function (data) {

    $(".cargando").addClass("d-none");
    $(".contenedor_promocion").addClass("d-none");
    $(".navegacion_principal").addClass("d-none");
    $(".cerrar_modal").addClass("d-none");
    $("#lead_modal").modal("show");
    let $id_servicio = $(".id_servicio_registro").val();
    $(_text(".producto_", $id_servicio)).val(data);

}
let intento_registro_accion = function () {

    $registro_nombre.trigger(jQuery.Event("keypress", { which: 13 }));
    $telefono_registro.trigger(jQuery.Event("keypress", { which: 13 }));

}


let registro_lead = (e) => {


    let respuestas = [];
    respuestas.push(es_formato_nombre($registro_nombre));
    respuestas.push(es_formato_telefono($telefono_registro));

    let $tiene_formato = (!respuestas.includes(false));

    if ($tiene_formato) {

        $("#lead_modal").modal("hide");
        advierte('Procesando tu pedido', 1);
        let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
        let $producto_carro_compra = $("input[name='producto_carro_compra[]']").map(function () {
            return $(this).val();
        }).get();


        let $recompensas = $("input[name='recompensas[]']").map(function () {
            return $(this).val();
        }).get();




        let text_password = $.trim($pw_registro.val());
        let $secret = "" + CryptoJS.SHA1(text_password);

        let $data_send = {
            "password": $secret,
            "email": $email_registro.val(),
            "nombre": $registro_nombre.val(),
            "facebook": "",
            "telefono": $telefono_registro.val(),
            "id_servicio": $(".id_servicio_registro").val(),
            "ciclo_facturacion": 0,
            "usuario_referencia": 0,
            "talla": 0,
            "tipo_entrega": 2,
            "fecha_contra_entrega": $(".fecha_servicio").val(),
            "fecha_servicio": $(".fecha_servicio").val(),
            "es_cliente": 1,
            "es_carro_compras": 1,
            "producto_carro_compra": $producto_carro_compra,
            "recompensas": $recompensas,
            "cobro_secundario": 0,
            "es_prospecto": 0,
            "url_facebook_conversacion": "",
            "comentario_compra": "",
            "lead_ubicacion": 0,
            "lead_catalogo": 0,
            "numero_cliente": 0,
            "landing_secundario": 150,

        };


        request_enid("POST", $data_send, url, respuesta_registro_lead);

    }
    e.preventDefault();
};
let respuesta_registro_lead = (data) => {

    redirect(path_enid("procesar_ubicacion", data.id_orden_compra));

};
