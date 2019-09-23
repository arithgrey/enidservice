"use strict";
$(document).ready(() => {

    $(".monto_a_ingresar").keyup(valida_monto_ingreso);
});

let valida_monto_ingreso = () => $(".monto_a_ingresar").val(quitar_espacios_numericos(this.value));
