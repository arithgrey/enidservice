let cambio_seguimiento_evento = function(e){

    let $id_accion_seguimiento  = get_parameter_enid($(this), "id");
    $(".id_users_accion_seguimiento").val($id_accion_seguimiento);
    $modal_cambio_estado_evento.modal("show");
}
let notificar_evento_realizado =  function(){
    
    let $id = $(".id_users_accion_seguimiento").val();
    let data_send = $.param({"id":$id});
    let url = "../q/index.php/api/users_accion_seguimiento/evento/format/json/";
    $(".envio_comentario_evento").removeClass("d-none");
    request_enid("PUT", data_send, url, response_notificar_evento_realizado);

}
let notificar_evento_realizado_comentario = function(){
    
    let $id = $(".id_users_accion_seguimiento").val();
    let data_send = $.param({"id":$id});
    let url = "../q/index.php/api/users_accion_seguimiento/evento/format/json/";
    $(".envio_comentario_evento").removeClass("d-none");
    request_enid("PUT", data_send, url, response_notificar_evento_realizado_comentario);

}
let response_notificar_evento_realizado = function(data){
    $modal_cambio_estado_evento.modal("hide");
    acciones_seguimiento();

}

let response_notificar_evento_realizado_comentario = function(data){
    $modal_cambio_estado_evento.modal("hide");
    acciones_seguimiento();
    $boton_accion_seguimiento.click();
}