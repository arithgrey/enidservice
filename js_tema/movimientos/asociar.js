"use strict";
$(document).ready(() => {

    $(".numero_tarjeta").keyup(() => {
        set_parameter(".numero_tarjeta", quitar_espacios_numericos(get_parameter(".numero_tarjeta")))
    });

});
