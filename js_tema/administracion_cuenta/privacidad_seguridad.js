"use strict";
let get_conceptos = () => {

    let url = "../q/index.php/api/funcionalidad/usuario/format/json/";
    request_enid("GET", {}, url, r_conceptos)
}
let r_conceptos = data => {

    render_enid(".contenedor_conceptos_privacidad", data);
    $(".concepto_privacidad").click(u_conceptos_privacidad);

}
let u_conceptos_privacidad = e => {

    let concepto = get_parameter_enid($(this), "id");
    let termino_asociado = get_attr(this, "termino_asociado");
    let data_send = {"concepto": concepto, "termino_asociado": termino_asociado};
    let url = "../q/index.php/api/privacidad_usuario/index/format/json/";
    request_enid("PUT", data_send, url, get_conceptos, ".place_registro_conceptos", function () {
        seccess_enid(".place_registro_conceptos", "Terminos de privacidad actualizados!")
    });
}
