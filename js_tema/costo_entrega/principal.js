"use strict";

let $ubicacion_delegacion = $('.ubicacion_delegacion');

let $adicionales_seccion = $(".adicionales_seccion");
$(document).ready(() => {

        
        $ubicacion_delegacion.change(busqueda_colonia_ubicacion);
        $form_ubicacion.submit(registro_ubicacion);
      

});
let busqueda_colonia_ubicacion = () => {

    let id_delegacion = $ubicacion_delegacion.val();
    if(parseInt(id_delegacion ) > 0 ){
        
        let $nombre = $(".ubicacion_delegacion option:selected").text();    
        $(".text_delegacion").val($nombre);
        let url = "../q/index.php/api/colonia/delegacion_cotizador/format/json/";
        let data_send = {"delegacion": $nombre , 'auto' : 1 };
        request_enid("GET", data_send, url, response_colonias);
    }
    
};
let response_colonias = (data) => {

    $(".place_colonia").removeClass("d-none");
    render_enid(".place_colonia", data);
    $(".sin_colonia").click(function(){
        selecciona_select(".colonia_ubicacion", 0);        
        $(".place_colonia").addClass("d-none");        
    });
    
};

