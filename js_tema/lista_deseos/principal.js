"use strict";
let id_tarea = 0;
let flageditable = 0;
let persona = 0;
let tipo_negocio = 0;
let telefono = 0;
let id_proyecto = 0;
let id_usuario = 0;
let id_ticket = 0;
let flag_mostrar_solo_pendientes = 0;
let id_proyecto_persona_forma_pago = "";
let menu_actual = "clientes";
let id_servicio = 0;
let id_proyecto_persona_forma_pago = 0;
let id_persona = 0;

$(document).ready(() => {

    set_option("action", $(".action").val());
    set_option("estado_compra", 6);
    set_option("interno", 1);
    retorno();


    $(".btn_mis_ventas").click(function () {
        set_option("estado_compra", 1);
        set_option("modalidad_ventas", 1);
        compras_usuario();
    });

    $(".btn_cobranza").click(function () {

        set_option("estado_compra", 6);
        set_option("modalidad_ventas", 0);
        compras_usuario();
    });
    $(".btn_buzon").click(function () {

        //carga_num_preguntas();
        carga_buzon();
    });

    $(".preguntas").click(function (e) {

        if (get_parameter_enid($(this), "id") == 0) {
            $(".btn_preguntas_compras").addClass("a_enid_blue");
            $(".btn_preguntas_compras").removeClass("a_enid_black");
            $(".btn_preguntas_ventas").addClass("a_enid_black");
        } else {

            $(".btn_preguntas_ventas").addClass("a_enid_blue");
            $(".btn_preguntas_ventas").removeClass("a_enid_black");
            $(".btn_preguntas_compras").addClass("a_enid_black");

        }


        set_option("modalidad_ventas", get_parameter_enid($(this), "id"));
        $(".contenedor_opciones_buzon").show();
        carga_buzon();
    });

    $(".num_alcance").click(alcance_producto);



});

let retorno = () => {

    let action = get_option("action");
    switch (action) {
        case "ventas":
            set_option("modalidad_ventas", 1);
            compras_usuario();
            break;
        case "compras":
            set_option("modalidad_ventas", 0);
            compras_usuario();
            break;
        default:
            set_option("modalidad_ventas", 0);
            compras_usuario();
            break;
    }
}

let alcance_producto =  function(e) {

    let tipo = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/servicio/alcance_producto/format/json/";
    let data_send = {tipo: tipo};
    $.ajax({
        url: url,
        type: "GET",
        data: data_send,
        beforeSend: function () {
        }
    }).done(function (data) {
        redirect("../producto/?producto=" + data);
    }).fail(function () {
        show_error_enid(".place_buzon", "Error ... ");
    });
}
