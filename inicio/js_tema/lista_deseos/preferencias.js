"use strict";
$(document).ready(function(){
	$(".item_preferencias").click(agrega_interes);
	let slider = $('#slider');
    let slidesWrapper = $('.slides');
    let slides = $('.slides li');
    let activeSlide = $('.slides.active');

    let timer = function() {
        setInterval(changeSlide, 7500);
    };

    function changeSlide() {
        let a = slidesWrapper.find('.active');
        
        let b = a.next('li');
        
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

let agrega_interes = function(e){
	
    let id_clasificacion = get_parameter_enid($(this) , "id");
    set_option("id_clasificacion" , id_clasificacion);
	let url = "../q/index.php/api/usuario_clasificacion/interes/format/json/";
	let data_send = {id_clasificacion : id_clasificacion};
    request_enid( "PUT",  data_send, url, response_agrega_interes, ".place_resumen_servicio");
}

let response_agrega_interes = function(data){
    let preferencia =".preferencia_"+get_option("id_clasificacion");
    if (data.tipo ==  1) {          
        $(preferencia).addClass("selected_clasificacion");  
    }else{
        $(preferencia).removeClass("selected_clasificacion");   
    }
}