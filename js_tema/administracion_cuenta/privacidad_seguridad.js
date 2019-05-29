"use strict";
let get_conceptos = function () {

    let url = "../q/index.php/api/funcionalidad/usuario/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, response_conceptos)
}
let response_conceptos = function (data) {

    render_enid(".contenedor_conceptos_privacidad", data);
    $(".concepto_privacidad").click(update_conceptos_privacidad);

}
let update_conceptos_privacidad = function (e) {

    let concepto = get_parameter_enid($(this), "id");
    let termino_asociado = get_attr(this, "termino_asociado");
    let data_send = {"concepto": concepto, "termino_asociado": termino_asociado};
    let url = "../q/index.php/api/privacidad_usuario/index/format/json/";
    request_enid("PUT", data_send, url, get_conceptos, ".place_registro_conceptos", function () {
        show_response_ok_enid(".place_registro_conceptos", "Terminos de privacidad actualizados!")
    });
}
