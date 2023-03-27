let $en_lista_deseos = $(".en_lista_deseos");

$(document).ready(function () {

    $(".productos_en_carro_compra").addClass("d-none");

    $en_lista_deseos.click(function () {

        localStorage.setItem('descuento_provicional', 150);
        $(".en_lista_deseos_producto").val(1);
        $(".selectores").addClass("d-none").removeClass("d-flex");
    });
});

let respuesta_add_valoracion = data => {

    redirect("../lista_deseos");
};
