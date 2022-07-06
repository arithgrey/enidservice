"use strict";
$(document).ready(() => {
    $(".order").change(filtro);

});

let filtro = () => {

    let url_actual = window.location;
    let new_url = url_actual + "&order=" + get_parameter("#order option:selected");
    redirect(new_url);
};
