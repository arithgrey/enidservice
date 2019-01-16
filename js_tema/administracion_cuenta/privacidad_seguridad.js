"use strict";
var get_conceptos = function () {

    var url = "../q/index.php/api/funcionalidad/usuario/format/json/";
    var data_send = {};
    request_enid("GET", data_send, url, response_conceptos)
}
var response_conceptos = function (data) {
    llenaelementoHTML(".contenedor_conceptos_privacidad", data);
    $(".concepto_privacidad").click(update_conceptos_privacidad);

}
var update_conceptos_privacidad = function (e) {

    var concepto = get_parameter_enid($(this), "id");
    var termino_asociado = get_attr(this, "termino_asociado");
    var data_send = {"concepto": concepto, "termino_asociado": termino_asociado};
    var url = "../q/index.php/api/privacidad_usuario/index/format/json/";
    request_enid("PUT", data_send, url, get_conceptos, ".place_registro_conceptos", function () {
        show_response_ok_enid(".place_registro_conceptos", "Terminos de privacidad actualizados!")
    });
}
