$(document).ready(function () {

    $('.cantidad_articulos_deseados').change(modifica_cantidad_articulos_deseados);
    $('.texto_deseleccionar').click(deseleccionar);

});
let modifica_cantidad_articulos_deseados = function () {

    let $cantidad = $(this).val();
    let $id = $(this).attr("identificador");

    if ($cantidad > 0) {

        let url = "../q/index.php/api/usuario_deseo/cantidad/format/json/";
        let data_send = {"id": $id, "cantidad": $cantidad};
        request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");
    }


}

let cancela_productos = id => {

    let url = "../q/index.php/api/usuario_deseo/status/format/json/";
    let data_send = {"id": id, "status": 2};
    request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");

};

let cancela_productos_deseados = id => {

    let url = "../q/index.php/api/usuario_deseo_compra/id/format/json/";
    let data_send = {"id": id, "status": 2};
    request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");

};

let deseleccionar = () => {



    let $seleccion_producto_carro_compra = $(".seleccion_producto_carro_compra");
    $seleccion_producto_carro_compra.each(function(){

        if ($(this).is(":checked")) {

            $(this).prop('checked',false);

            $(".texto_deseleccionar").text("Seleccionar todos los artículos");


        }else{

            $(this).prop('checked',true);
            $(".texto_deseleccionar").text("Deseleccionar todos los artículos");

        }

    });

}

let response_carga_productos = (data) => redirect("");

