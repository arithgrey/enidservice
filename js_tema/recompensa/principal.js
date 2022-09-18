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
    $("footer").ready(carga_productos_sugeridos);

    
});


let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let data_send = {
        "id_servicio": 0,
        "sugerido": 2
    };
    request_enid("GET", data_send, url, response_carga_productos);
};


let response_carga_productos = data => {


    if (data["sugerencias"] == undefined) {
        $(".text_sugerencias").removeClass("d-none");
        render_enid(".place_tambien_podria_interezar", data);
        $('.agregar_deseos_sin_antecedente').click(agregar_deseos_sin_antecedente_gbl);
        $('.quitar_deseo_sin_antecedente').click(quitar_deseo_sin_antecedente_gbl);            
    }
};

let nueva_promocion = function (q = "") {
    
    $modal_recompensa.modal('show');    
   
    set_option("s", 1);
    let global = (get_parameter_enid($(this), "id" || get_option("global")) > 0) ? 1 : 0;    
    set_option("global", global);    
    
    let url = "../q/index.php/api/servicio/empresa/format/json/";    
    let data_send = {
        "q": q,
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

    $(".descuento").keyup(calcula_total_final);
    $(".editar_costo_servicio").click(function(){
        $(".texto_editar_costo_servicio").addClass("d-none");
        $(".form_costo").removeClass("d-none");
        
    });

    let $form_costo = $(".form_costo");
    $form_costo.submit(costo_servicio);
    $(".input_costo").keyup(function (e) {        

        escucha_submmit_selector(e, $form_costo,1);

    });

    /**/
    $(".editar_costo_servicio_conjunto").click(function(){
        $(".texto_editar_costo_servicio_conjunto").addClass("d-none");
        $(".form_costo_conjunto").removeClass("d-none");
        
    });

    let $form_costo_conjunto = $(".form_costo_conjunto");
    $form_costo_conjunto.submit(costo_servicio_conjunto);
    $(".input_costo_conjunto").keyup(function (e) {        

        escucha_submmit_selector(e, $form_costo_conjunto,1);
        
    });
    
    $(".notifica_cancelacion_recompensa").click(baja_recompensa);
    
}
let baja_recompensa = function(e){

    let $id = e.target.id;
    debugger;

    if (parseInt($id) > 0) {

        show_confirm("¿DESEAS DAR DE BAJA LA PROMOCIÓN?", "", "CONTINUAR", function () {
            
            let url = "../q/index.php/api/recompensa/baja/format/json/";    
            let data_send = $.param({"id": $id});
            request_enid("PUT", data_send, url, function(){
                redirect("");
            });
            
        });
    }
    
    e.preventDefault();
}


let recompensa_descuento = function(e){

    let $descuento = $(".descuento").val();

    if ($descuento > 0) {

        let url = "../q/index.php/api/recompensa/descuento/format/json/";
        let id = get_parameter_enid($(this), "id");

        let data_send = $(".form_descuento").serialize();
        request_enid("PUT", data_send, url, response_recompensa_descuento);
        bloquea_form(".form_descuento");

    }
    
    e.preventDefault();
}
let costo_servicio = function(e){

    let $costo = $(".costo").val();    
    if (es_float($costo) && $costo > 0) {

        let url = "../q/index.php/api/servicio/costo_compra/format/json/";
        let data_send = $(".form_costo").serialize();
        request_enid("PUT", data_send, url, function (data) {
            redirect("");
        });
    } 

    e.preventDefault();

}

let costo_servicio_conjunto = function(e){

    let $costo = $(".costo_conjunto").val();    
    if (es_float($costo) && $costo > 0) {

        let url = "../q/index.php/api/servicio/costo_compra/format/json/";
        let data_send = $(".form_costo_conjunto").serialize();
        request_enid("PUT", data_send, url, function (data) {
            redirect("");
        });
    } 

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
let calcula_total_final = function() {
    
    let $descuento_por_aplicar = $(this).val();
    let $total_sin_descuento = $(".total_sin_descuento").val();
    let $precio_final_con_descuento = $(".precio_final_con_descuento_input");
    let $nuevo_descuento  =  ($total_sin_descuento - $descuento_por_aplicar );  
    $precio_final_con_descuento.text(_text_($nuevo_descuento,"MXN"));

    /*Se calcula utilidad global*/
    let $total_utilidad = $(".total_utilidad").val();
    let $total_utilidad_descuento = ($total_utilidad - $descuento_por_aplicar);
    $(".utilidad_descuento").text(_text($total_utilidad_descuento,".00MXN"));
    

    /*Se calcula utilidad menos comision*/      
    let  $pago_por_venta = $(".pago_por_venta").val();
    let $total_utilidad_descuento_comision  = ($total_utilidad_descuento - $pago_por_venta);    
    $(".utilidad_descuento_comision").text(_text($total_utilidad_descuento_comision,".00MXN"));


    /*Se calcula utilidad menos entrega*/          
    let  $pago_por_entrega = 100;
    let $total_utilidad_descuento_comision_entrega  = ($total_utilidad_descuento - $pago_por_venta - $pago_por_entrega);    
    $(".utilidad_descuento_comision_entrega").text(_text($total_utilidad_descuento_comision_entrega,".00MXN"));

}

let onkeyup_colfield_check = (e) => {
    
    let enterKey = 13;
    if (e.which == enterKey) {
        
        set_option("page", 1);
        nueva_promocion(e.target.value);
    }
};
