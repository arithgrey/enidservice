"use strict";

$(document).ready(() => {
    $(".order").change(filtro);
    $("footer").ready(carga_promociones_sugerencias);
    
});

let filtro = () => {

    let url_actual = window.location;
    let new_url = url_actual + "&order=" + get_parameter("#order option:selected");
    redirect(new_url);
};


let carga_promociones_sugerencias = () => {

    let url = "../q/index.php/api/recompensa/sugeridos/format/json/";
    let data_send = {};
    request_enid("GET", data_send, url, function(data){
        render_enid(".promociones_sugeridas", data);
    
        
        $(".bottom_carro_compra_recompensa").click(carro_compra_recompensa);

        
    });
};

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