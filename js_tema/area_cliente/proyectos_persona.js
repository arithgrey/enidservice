"use strict";
let get_lugar_por_stus_compra = () => {

    let nuevo_place = "";
    if (get_option("modalidad_ventas") == 0) {

        switch (parseFloat(get_option("estado_compra"))) {
            case 10:
                nuevo_place = ".place_resumen_servicio";
                break;
            case 6:
                nuevo_place = ".place_servicios_contratados";
                break;
            case 1:
                nuevo_place = ".place_servicios_contratados_y_pagados";
                break;
            default:
                nuevo_place = ".place_servicios_contratados";
                break;
        }
    } else {
        nuevo_place = ".place_ventas_usuario";
    }
    return nuevo_place;
};
let compras_usuario = () => {


    recorre();
    let modalidad = get_option("modalidad_ventas");
    let url = "../q/index.php/api/recibo/proyecto_persona_info/format/json/";
    let data_send = {"status": get_option("estado_compra"), "modalidad": modalidad};
    request_enid("GET", data_send, url, r_compras_usuario);

};
let r_compras_usuario = function (data) {

    let place = get_lugar_por_stus_compra();
    render_enid(place, data);
    $(".solicitar_desarrollo").click(function (e) {

        set_option("id_proyecto", get_parameter_enid($(this), "id"));
        tikets_usuario_servicio();

    });
    $(".form_q_servicios").submit();
    $(".resumen_pagos_pendientes").click(inf_ticket);
    $(".btn_direccion_envio").click(inf_envio);
    $(".ver_mas_compras_o_ventas").click(compras_ventas_concluidas);
};
let inf_envio = function (e) {

    set_option("recibo", get_parameter_enid($(this), "id"));
    inf_envio_complete();
};
let compras_ventas_concluidas = () => {

    let url = "../q/index.php/api/recibo/compras_efectivas/format/json/";
    let data_send = {"modalidad": get_option("modalidad_ventas"), "page": get_option("page")};
    request_enid("GET", data_send, url, r_compras_ventas_concluidas);
};
let r_compras_ventas_concluidas = (data) => {


    let place = get_lugar_por_stus_compra();
    render_enid(place, data);
    $(".resumen_pagos_pendientes").click(inf_ticket);
    $(".pagination > li > a, .pagination > li > span").css("color", "white");
    $(".pagination > li > a, .pagination > li > span").click(function (e) {
        set_option("page", $(this).text());
        compras_ventas_concluidas();
        e.preventDefault();
    });
    recorre(place);

};