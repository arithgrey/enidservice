"use strict";
$(document).ready(() => {

    $('.agregar_deseos_sin_antecedente').click(agregar_deseo_sorteo);
});

let agregar_deseo_sorteo = function () {

    let $id_servicio = $(this).attr('id');
    let $numero_boleto = $(this).attr('numero_boleto');
    $numero_boleto = parseInt($numero_boleto);
    
    if ($numero_boleto > 0 ) {
        let $clase_boleto_append = _text('numero_boleto_apartado_',$numero_boleto);
        
        if(!$(this).hasClass("apartado")){
            

            $(this).addClass("bg_black white apartado");
            if (parseInt($id_servicio) > 0) {
                
                $(".enviar_orden").removeClass('d-none');
                $(".simular_compra").addClass('d-none');
                
                let $boleto_append = d(_text_('Ticket número',$numero_boleto),'borde_end mt-2 p-2 mb-2', $clase_boleto_append);
                
                
                $(".tickets_apartados").append($boleto_append);
                
                


                let data_send = { "id_servicio": $id_servicio, "articulos": 1 , "numero_boleto": $numero_boleto};
    
                if (parseInt(get_option("in_session")) > 0) {
    
                    let url = "../q/index.php/api/usuario_deseo/lista_deseos/format/json/";
                    request_enid("PUT", data_send, url, adicionales);
    
                } else {
    
                    let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
                    request_enid("POST", data_send, url, adicionales);
                }
            }

        }else{

            $(this).removeClass("bg_black white apartado");
            
            $(_text("#",$clase_boleto_append)).remove();
            
            let data_send = { "id_servicio": $id_servicio, "numero_boleto": $numero_boleto};

            if (parseInt(get_option("in_session")) > 0) {

                let url = "../q/index.php/api/usuario_deseo/lista_deseos_boleto/format/json/";
                request_enid("DELETE", data_send, url, adicionales);

            } else {

                let url = "../q/index.php/api/usuario_deseo_compra/index/format/json/";
                request_enid("DELETE", data_send, url, adicionales);
            }

        }    

    }


}
let adicionales = function () {
    metricas_perfil();
    cerrar_modal();

}
