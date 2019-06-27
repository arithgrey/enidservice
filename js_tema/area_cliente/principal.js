window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.onpopstate = function (event) {

    if (event) {

        valida_retorno();
    }
}

let id_tarea = 0;
let persona = 0;
let telefono = 0;
let id_proyecto = 0;
let id_usuario = 0;
let id_ticket = 0;
let flag_mostrar_solo_pendientes = 0;
let id_proyecto_persona_forma_pago = "";
let menu_actual = "clientes";
let id_servicio = 0;
let id_persona = 0;

$(document).ready(() => {

    set_option("vista",1);
    set_option("estado_compra", 6);
    set_option("interno", 1);
    retorno();

    $(".btn_mis_ventas").click(() => {
        set_option("estado_compra", 1);
        set_option("modalidad_ventas", 1);
        compras_usuario();
    });
    $(".btn_cobranza").click(() => {
        set_option("estado_compra", 6);
        set_option("modalidad_ventas", 0);
        compras_usuario();
    });
    $(".num_alcance").click(alcance_producto);
    $("#mis_ventas").click(() => {
        $("#mis_compras").tab("show");
        $("#mis_ventas").tab("show");
    });
    $("#mis_compras").click(() => {
        $("#mis_ventas").tab("show");
        $("#mis_compras").tab("show");
    });

});
let retorno =  () =>  {

    switch (get_parameter(".action")) {
        case "ventas":

            set_option("modalidad_ventas", 1);
            set_option("estado_compra", 1);
            compras_usuario();

            break;
        case "compras":

            set_option("modalidad_ventas", 0);
            if (get_parameter(".ticket") > 0) {
                /*Cargo la información del ticket*/
                inf_ticket();
            } else {
                compras_usuario();
            }

            break;

        default:
            set_option("modalidad_ventas", 0);
            compras_usuario();
            break;
    }
}
let alcance_producto =  function (e) {
    let tipo = get_parameter_enid($(this), "id");
    let url = "../q/index.php/api/servicio/alcance_producto/format/json/";
    let data_send = {tipo: tipo};
    request_enid("GET", data_send, url, function (data) {
        redirect("../producto/?producto=" + data);
    });
}
let notifica_tipo_compra =  (tipo, recibo) => {

    let url = "../q/index.php/api/intento_compra/index/format/json/";
    let data_send = {tipo: tipo, recibo: recibo};
    request_enid("POST", data_send, url);

};
let valida_retorno =  () => {

    let vista = get_option("vista");
    if (vista < 1 ){
        switch (get_parameter(".action")) {

            case "ventas":

                $("#mis_compras").tab("show");
                $("#mis_ventas").tab("show");

                set_option("modalidad_ventas", 1);
                set_option("estado_compra", 1);
                compras_usuario();
                break;

            case "compras":

                $("#mis_ventas").tab("show");
                $("#mis_compras").tab("show");
                set_option("modalidad_ventas", 0);
                compras_usuario();

                break;

            default:
                set_option("modalidad_ventas", 0);
                compras_usuario();
                break;
        }


    }else{


        switch (vista) {

            case 2:

                $("#mis_compras").tab("show");
                $("#mis_ventas").tab("show");

                inf_ticket();


                break;

            case 3:


                break;

            default:

                break;
        }

    }
}