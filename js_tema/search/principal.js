"use strict";
$(document).ready(function () {
    $(".order").change(filtro);
});

var filtro = function () {

    var url_actual = window.location;
    var order = get_parameter("#order option:selected");
    var new_url = url_actual + "&order=" + order;
    redirect(new_url);
}