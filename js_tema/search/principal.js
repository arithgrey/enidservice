"use strict";
$(document).ready(function () {
    $(".order").change(filtro);
});

let filtro = () => {

    let url_actual = window.location;
    let order = get_parameter("#order option:selected");
    let new_url = url_actual + "&order=" + order;
    redirect(new_url);
}