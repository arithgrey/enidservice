"use strict";
$(document).ready(() => {

    $(".codigo_postal").keyup(auto_completa_direccion);
    $(".numero_exterior").keyup(() => quita_espacios(".numero_exterior"));
    $(".numero_interior").keyup(() => quita_espacios(".numero_interior"));
    $(".form_direccion_envio").submit(registra_nueva_direccion);
});