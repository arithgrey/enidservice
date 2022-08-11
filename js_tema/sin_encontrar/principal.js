"use strict";
$(document).ready(() => {
    
    carga_productos_sugeridos();
});

let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let q = get_parameter(".qservicio");
    let data_send = {"id_servicio": 541};
    request_enid("GET", data_send, url, response_carga_productos);
};
let response_carga_productos = data => {

    if (data["sugerencias"] == undefined) {
        $('.sugerencias_titulo').removeClass('d-none');
        $('.otros').removeClass('d-none');
        $(".text_interes").removeClass("hidden");
        render_enid(".place_tambien_podria_interezar", data);
        $('.agregar_deseos_sin_antecedente').click(agregar_deseos_sin_antecedente_gbl);
        $('.quitar_deseo_sin_antecedente').click(quitar_deseo_sin_antecedente_gbl);            
    }
};
