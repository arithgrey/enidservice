window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.onpopstate = function (event) {

    if (event) {

        valida_retorno();
    }
};

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

        set_option({
            "estado_compra":  1,
            "modalidad_ventas": 1
        });
        compras_usuario();
    });
    $(".btn_cobranza").click(() => {


        set_option({
            "estado_compra": 6,
            "modalidad_ventas": 0,
        });
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

            set_option({
                "modalidad_ventas": 1,
                "estado_compra": 1,
            });

            compras_usuario();

            break;
        case "compras":

            set_option("modalidad_ventas", 0);
            let fn =  (get_parameter(".ticket") > 0) ? inf_ticket() : compras_usuario();
            break;

        default:
            set_option("modalidad_ventas", 0);
            compras_usuario();
            break;
    }
};
let alcance_producto =  function (e) {

    let url = "../q/index.php/api/servicio/alcance_producto/format/json/";
    let data_send = {tipo: get_parameter_enid($(this), "id")};
    request_enid("GET", data_send, url, function (data) {
        redirect("../producto/?producto=" + data);
    });
};
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

                show_tabs(["#mis_compras", "#mis_ventas"]);

                set_option({
                    "modalidad_ventas": 1,
                    "estado_compra": 1,
                });

                compras_usuario();
                break;

            case "compras":

                show_tabs(["#mis_compras", "#mis_ventas"]);
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

                show_tabs(["#mis_compras", "#mis_ventas"]);
                inf_ticket();

                break;

            default:

                break;
        }

    }
};