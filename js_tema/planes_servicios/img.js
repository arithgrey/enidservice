"use strict";

let carga_form_img = () => {
    set_option("s", 3);
    showonehideone(".contenedor_agregar_imagenes", ".contenedor_global_servicio");
    $('.titulo_articulos_venta .guardar_img_enid').addClass('d-none');
    let url = "../q/index.php/api/img/form_img_servicio_producto/format/json/";
    let data_send = $.param({"id_servicio": get_option("servicio")});
    request_enid("GET", data_send, url, response_cargar_form, ".place_img_producto");
};
let response_cargar_form = data => {

    render_enid(".place_img_producto", data);
    despliega([".guardar_img_enid", "#guardar_img"]);
    let $imagen_img = $(".imagen_img");
    if ($imagen_img.length) {
        $imagen_img.change(ver_carga);
    }

    recorre("#guardar_img");
};
let ver_carga = function () {

    let i = 0, reader, file;
    file = this.files[i];
    reader = new FileReader();
    reader.onloadend = function (e) {
        showonehideone(".btn_guardar_imagen", ".imagen_img");
        let im = e.target.result;
        mostrar_img_upload(im, 'place_load_img');
        recorre(".guardar_img_enid");
        $("#form_img_enid").submit(agrega_imagenes);
    };
    reader.readAsDataURL(file);
};
let agrega_imagenes = function (e) {
    //registra_img_servicio
    e.preventDefault();
    let file = $('input[type=file]')[0].files;
    registra_img_servicio(file);
    setTimeout(function () {
        response_load_image("true");
        carga_informacion_servicio(1);
        cerrar_modal();
    }, 4000);


};
let registra_img_servicio = file => {

    advierte('Procesando tus imágenes', 1);
    $(".guardar_img_enid").hide();
    let $q = get_parameter(".q_imagen");
    let $servicio = get_parameter(".q2_imagen");
    let $imgs = get_parameter(".dinamic_img");
    for (let x in file) {

        let formData = new FormData();
        formData.append("imagen", file[x]);
        formData.append("q", $q);
        formData.append("servicio", $servicio);
        formData.append("dinamic_img", $imgs);

        $.ajax({
            url: "../q/index.php/api/archivo/imgs",
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

    }
    //
    // response_load_image("true");
    // carga_informacion_servicio(1);
};

let response_load_image = data => {

    switch (array_key_exists("status_imagen_servicio", data)) {
        case 1:
            seccess_enid(".place_load_img", "SE AGREGÓ LA IMAGEN!");
            carga_informacion_servicio(1);
            set_option("seccion_a_recorrer", ".contenedor_global_servicio");
            recorre(".carga_informacion_servicio");

            break;
        case 2:

            render_enid(".place_load_img", "AGREGA UNA IMAGEN MÁS PEQUEÑA");
            carga_form_img();
            break;

        case 3:

            break;

        default:

            break;
    }
};
