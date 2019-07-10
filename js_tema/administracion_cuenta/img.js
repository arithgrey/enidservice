"use strict";
let carga_form_imagenes_usuario = () => {

    recorre(".contenedor_principal_enid");
    despliega([".imagen_usuario_completa", ".menu_info_usuario", ".contenedor_lateral", ".registro_telefono_usuario_lada_negocio", ".editar_imagen_perfil"], 0);
    let data_send = {};
    let url = "../q/index.php/api/img/form_img_user/format/json/";
    request_enid("GET", data_send, url, response_carga_form_imagenes, ".place_form_img");
}

let response_carga_form_imagenes = data => {

    render_enid(".place_form_img", data);
    $(".imagen_img").change(upload_imgs_enid_pre);

}
let upload_imgs_enid_pre =  function() {


    let i = 0, len = this.files.length, img, reader, file;
    file = this.files[i];
    reader = new FileReader();
    reader.onloadend = function (e) {

        showonehideone(".guardar_img_enid" , ".imagen_img");
        mostrar_img_upload(e.target.result, 'place_load_img');
        $("#form_img_enid").submit(registra_img_usr);
    };
    reader.readAsDataURL(file);

}

let registra_img_usr = e => {

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
    }).done(function (data) {

        redirect("");

    });
    $.removeData(formData);
}