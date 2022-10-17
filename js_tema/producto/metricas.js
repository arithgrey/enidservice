"use strict";

$(document).ready(() => {

    $(".form_busqueda_accesos_pagina").submit(carga_accesos_pagina);

});

let carga_accesos_pagina = function (e) {


    if (get_parameter(".form_busqueda_accesos_pagina #datetimepicker4").length > 5 && get_parameter(".form_busqueda_accesos_pagina #datetimepicker5").length > 5) {

        let url = "../q/index.php/api/acceso/busqueda_fecha/format/json/";
        let data_send = $(".form_busqueda_accesos_pagina").serialize();
        request_enid("GET", data_send, url, 1, ".place_keywords", 0, ".place_keywords");

    } else {

        focus_input([".form_busqueda_productos_solicitados #datetimepicker4", ".form_busqueda_productos_solicitados #datetimepicker5"]);

    }
    e.preventDefault();
}
