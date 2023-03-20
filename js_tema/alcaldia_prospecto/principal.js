let $busqueda_alcaldias_prospectos= $(".busqueda_alcaldias_prospectos");
let $form_busqueda_alcaldias_prospectos = $(".form_alcaldias_prospectos");
$(document).ready(() => {

    $busqueda_alcaldias_prospectos.click(function(){
        $form_busqueda_alcaldias_prospectos.submit();    
    });
    $form_busqueda_alcaldias_prospectos.submit(busqueda_alcaldias_prospectos);
});
let busqueda_alcaldias_prospectos = function(e){

    
    let url = "../q/index.php/api/alcaldia_prospecto/penetracion_tiempo/format/json/";
    let data_send = $form_busqueda_alcaldias_prospectos.serialize();
    request_enid("GET", data_send, url, alcaldias_prospectos);
    e.preventDefault();

}
let alcaldias_prospectos =  function(data){
    
    render_enid('.place_alcaldias_prospectos', data);
}