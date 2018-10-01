$(document).ready(function(){	
	$(".item_preferencias").click(agrega_interes);
	var slider = $('#slider');
    var slidesWrapper = $('.slides');
    var slides = $('.slides li');
    var activeSlide = $('.slides.active');

    var timer = function() {
        setInterval(changeSlide, 7500);
    }

    function changeSlide() {
        var a = slidesWrapper.find('.active');
        
        var b = a.next('li');
        
        if( b.length === 0 ) {
            console.log();
            a.removeClass('active');
            slides.first().addClass('active');
        } else {
            a.removeClass('active');
            b.addClass('active');
        }
        //
    }

    timer();

    $('.slide-nav-down').click(function(e) {
        clearInterval(changeSlide);
        changeSlide();
    
    });

    $('.slide-nav-down').on('mousedown', function() {
        $(this).css({'opacity': 1});
    });

    $('.slide-nav-down').on('mouseup', function() {
        $(this).css({'opacity': 0.5});
    });
});
/**/
function agrega_interes(e){
	
    var id_clasificacion = get_parameter_enid($(this) , "id");
    set_option("id_clasificacion" , id_clasificacion);
	var url = "../q/index.php/api/usuario_clasificacion/interes/format/json/";
	var data_send = {id_clasificacion : id_clasificacion};
    request_enid( "PUT",  data_send, url, response_agrega_interes, ".place_resumen_servicio");
}
/**/
function response_agrega_interes(data){
    var preferencia =".preferencia_"+get_option("id_clasificacion");
    if (data.tipo ==  1) {          
        $(preferencia).addClass("selected_clasificacion");  
    }else{
        $(preferencia).removeClass("selected_clasificacion");   
    }
}