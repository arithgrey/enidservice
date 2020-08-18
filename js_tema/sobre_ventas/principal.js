"use strict";
let $link_nuba = $('.link_nuba');
let $definicion_nuba_seller = $('.definicion_nuba_seller');
$(document).ready(function () {

    $link_nuba.click(muestra_definicion_nuba);

});
let muestra_definicion_nuba = function () {

    $definicion_nuba_seller.removeClass('d-none');
    recorre('.definicion_nuba_seller');
}