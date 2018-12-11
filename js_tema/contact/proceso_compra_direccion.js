$(document).ready(function () {

    $(".selector_proceso").click(procesar_apartado);
});

var procesar_apartado = function (e) {

    var id 		=  get_parameter_enid($(this) , "id");

    if (parseInt(id) ==  2){
        $(".form_view_location").submit();
    }else{
        /*Agrego a la lista de deseos*/

    }
}