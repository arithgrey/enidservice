"use strict";
let $edicion_recompensa = $(".edicion_recompensa");
let $modal_resumen_recompensa = $("#modal_resumen_recompensa");
let $modal_recompensa = $("#modal_recompensa");
let $agregar_promocion = $(".agregar_promocion");
let $servicio_dominante_recompensa =  $(".servicio_dominante_recompensa");
let $bottom_carro_compra_recompensa = $(".bottom_carro_compra_recompensa");
set_option("page", 1);
$(document).ready(() => {

    $edicion_recompensa.click(editar_recompensa);
    $agregar_promocion.click(nueva_promocion);
    $bottom_carro_compra_recompensa.click(carro_compra_recompensa);


    
});

let nueva_promocion = function () {
    
    $modal_recompensa.modal('show');    
   
    set_option("s", 1);
    let global = (get_parameter_enid($(this), "id" || get_option("global")) > 0) ? 1 : 0;
    set_option("global", global);    
    

    let url = "../q/index.php/api/servicio/empresa/format/json/";    
    let data_send = {
        "q": "",
        "id_clasificacion": get_option("id_clasificacion"),
        "page": get_option("page"),
        "order": 2,
        "global": global
    };

    request_enid("GET", data_send, url, response_servicios);

    
}
let response_servicios = data => {
    
    render_enid(".place_nueva_recompensa", data);
    $(".producto_en_recompensa").click(anexar_servicio_recompensa);
          
    $(".pagination > li > a, .pagination > li > span").click(function (e) {
            let page_html = $(this);
            let num_paginacion = $(page_html).attr("data-ci-pagination-page");
            if (validar_si_numero(num_paginacion) == true) {
                set_option("page", num_paginacion);
            } else {
                num_paginacion = $(this).text();
                set_option("page", num_paginacion);
            }
            nueva_promocion();
            e.preventDefault();
    });

}

let anexar_servicio_recompensa = function(e){

    let $producto_en_recompensa = parseInt(e.target.id);
    if ($producto_en_recompensa > 0) {

        let url = "../q/index.php/api/recompensa/index/format/json/";
        
        let data_send = {"servicio": $servicio_dominante_recompensa.val(), "servicio_conjunto": $producto_en_recompensa};

        request_enid("POST", data_send, url, function(){
            redirect("");
        });

    }

}
let editar_recompensa = function(e){


    let $id = parseInt(e.target.id);
    if ($id > 0) {

        $modal_resumen_recompensa.modal('show');    
        let $data_send = $.param({id: $id});
        let url = "../q/index.php/api/recompensa/id/format/json/";                
        request_enid("GET", $data_send, url, response_recompensa);


    }

}
let response_recompensa = function(data){


    render_enid(".resumen_recompensa", data);
    verifica_formato_default_inputs(0);
    let $form_descuento = $(".form_descuento");
    $form_descuento.submit(recompensa_descuento);

    $(".descuento").keyup(function (e) {
        
        escucha_submmit_selector(e, $form_descuento,1);
    });
    
    
}
let recompensa_descuento = function(e){

    let url = "../q/index.php/api/recompensa/descuento/format/json/";
    let id = get_parameter_enid($(this), "id");

    let data_send = $(".form_descuento").serialize();
    request_enid("PUT", data_send, url, response_recompensa_descuento);
    bloquea_form(".form_descuento");
    e.preventDefault();
}
let response_recompensa_descuento = function(data){


    redirect("");
}

let carro_compra_recompensa  = function(){

    let $id = $(this).attr('id');
    let $antecedente_compra = $(this).attr('antecedente_compra');

    if (parseInt($id) > 0) {

        $("#modal-error-message").modal("show");            
            
        let $selector_carga_modal = $('.cargando_modal');
        $selector_carga_modal.removeClass('d-none');
        $(".text-order-name-error").text("Procesando ...");    
        $(this).addClass("d-none");
        let url = "../q/index.php/api/recompensa/deseo_compra/index/format/json/";
        let data_send = {"id": $id, "antecedente_compra" : $antecedente_compra};
        request_enid("POST", data_send, url, response_deseo_compra_recompensa);
        
        
    }
}

let response_deseo_compra_recompensa = function(data){
    $("#modal-error-message").modal("hide");            
    redirect("../lista_deseos");

}