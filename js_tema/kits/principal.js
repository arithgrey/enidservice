let $icono_agregar_kit = $(".icono_agregar_kit");
let $modal_servicios_kit = $("#modal_servicios_kit");
let $modal_kit = $("#modal_kit");
let $boton_nuevo_kit = $(".boton_nuevo_kit");
let $form_kit = $(".form_kit");
set_option("page", 1);
set_option("id_kit", 0);
$(document).ready(() => {

    $icono_agregar_kit.click(function(e){
        set_option("id_kit", e.target.id);
        busqueda_servicios();

    });
    $boton_nuevo_kit.click(modal_kit);
    $form_kit.submit(registro_kit);
});

let modal_kit = function(){
    $modal_kit.modal("show");
}

let registro_kit = function (e) {

    let data_send = $form_kit.serialize();
    let url = "../q/index.php/api/kit/index/format/json/";
    bloquea_form('.form_kit');

    request_enid("POST", data_send, url, response_form_kit);
    e.preventDefault();
};

let response_form_kit = function(data){
    
    redirect("");
}
let busqueda_servicios = function (q = "") {


    $modal_servicios_kit.modal('show');    
   
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

    request_enid("GET", data_send, url, response_servicios_kits);


}
let onkeyup_colfield_check = (e) => {
    let enterKey = 13;
    if (e.which == enterKey) {
        set_option("page", 1);
        busqueda_servicios();
    }
};
let response_servicios_kits = data => {
    
    render_enid(".place_nuevo_servicio_kit", data);
    
    $(".producto_en_recompensa").click(anexar_servicio_kit);
          
    $(".pagination > li > a, .pagination > li > span").click(function (e) {
            let page_html = $(this);
            let num_paginacion = $(page_html).attr("data-ci-pagination-page");
            if (validar_si_numero(num_paginacion) == true) {
                set_option("page", num_paginacion);
            } else {
                num_paginacion = $(this).text();
                set_option("page", num_paginacion);
            }
            busqueda_servicios();
            e.preventDefault();
    });
    

}

let anexar_servicio_kit = function(e){

    let $id_servicio = parseInt(e.target.id);
    let $id_kit = parseInt(get_option("id_kit"));
    
    if ($id_servicio > 0 && $id_kit > 0) {
        
        let url = "../q/index.php/api/servicio_kit/index/format/json/";        
        let data_send = {"id_kit": $id_kit, "id_servicio": $id_servicio};

        request_enid("POST", data_send, url, function(){
            redirect("");
        });

    }

}
