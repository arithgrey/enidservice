"use strict";
let $anexar_foto_link = $(".anexar_foto_link");
$(document).ready(() => {

    $("footer").removeClass("blue_enid3");
    $anexar_foto_link.click(expon_formulario_fotos);

    $(".click_facebook_clientes").click(function () {
        log_operaciones_externas(18);
    });
    $(".click_amazon_clientes").click(function () {
        log_operaciones_externas(19);
    });
    $(".click_instagram_clientes").click(function () {
        log_operaciones_externas(20);
    });

});

let expon_formulario_fotos = function () {

    let data_send = {};
    let url = "../q/index.php/api/img/formulario_imagen_cliente/format/json/";
    request_enid("GET", data_send, url, response_formulario_fotos, ".place_form_img");

}
let response_formulario_fotos = function (data){

    render_enid(".formulario_fotos_clientes", data);
    $(".anexar_foto_link").addClass("d-none");
    $(".imagen_img").change(previsualizacion);
}

let previsualizacion = function () {

    let i = 0, len = this.files.length, img, reader, file;
    file = this.files[i];
    reader = new FileReader();
    reader.onloadend = function (e) {
        showonehideone(".guardar_img_enid", ".imagen_img");
        mostrar_img_upload(e.target.result, 'place_load_img');
        $("#form_img_enid").submit(registro_imagen_cliente);
    };
    reader.readAsDataURL(file);

};

let registro_imagen_cliente = e => {

    e.preventDefault();
    let formData = new FormData(document.getElementById("form_img_enid"));
    let url = "../q/index.php/api/archivo/imgs";
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {

        }
    }).done((data) => {

        redirect("");

    });
    $.removeData(formData);
};
