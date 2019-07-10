set_option("flag_carga", 0);
let carga_opcion_entrega = (id, id_servicio, orden_pedido) => {


    if (get_option("flag_carga") == 0) {

        set_option("id_servicio", id_servicio);
        set_option("tipo", id);
        set_option("orden_pedido", orden_pedido);
        let data_send = $.param({"tipo": id, "id_servicio": id_servicio});
        let url = "../q/index.php/api/intento_tipo_entrega/index/format/json/";
        request_enid("POST", data_send, url, response_opcion_entrega);
    }
};

let response_opcion_entrega = (data) => {
    set_option("flag_carga", 1);
    switch (get_option("tipo")) {
        case 1:

            $(".form_pre_puntos_medios").submit();
            break;

        case 2:

            $(".form_pre_pedido").submit();
            break;

        case 3:
            if (get_option("in_session") == 0) {

                $(".form_pre_pedido_contact").submit();
            } else {
                agrega_lista_deseos();
            }
            break;

        default:
    }
};
let agrega_lista_deseos = () => {


    let data_send = {
        servicio: get_parameter(".form_pre_pedido_contact  .servicio")
    };
    let url = "../q/index.php/api/usuario_deseo/servicio/format/json/";
    request_enid("POST", data_send, url, response_lista_deseos)
}
let response_lista_deseos = data => {

    submit_enid(".form_pre_pedido_contact");

}