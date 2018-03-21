var  flag_calificacion = 0; 
$(document).on("ready", function(){        
    //$(".seccion_errores").show();               
    carga_form_errores( 1  , ".place_error_disponibles");   
    
});
/**/
function get_calificacion(){
    return flag_calificacion;
}
/**/
function set_calificacion(new_flag_calificacion){
    flag_calificacion = new_flag_calificacion;
}
/**/
function carga_form_errores( tipo , place ){
    
    $(".place_error_disponibles").empty();
    $(".place_seccion_propuestas").empty();        
    url =  now + "index.php/api/reportes/erroresform/format/json/";    
    $.ajax({
        url : url , 
        type :  "GET",  
        data:  { "tipo" :  tipo },                
        beforeSend: function(){
            show_load_enid( place  , "Cargando ... " , 1 );
        } 



    }).done(function(data){
        
        llenaelementoHTML( place , data );            
        $(".input-start").click(asigna_calificacion);
        $(".form-error").submit(registra_incidencia);

    }).fail(function(){
        show_error_enid(place  , "Error en la carga reporte al administrador " );
    });
}
/**/
function registra_incidencia(e){
    
    valida_calificacion();
    if (get_calificacion() > 0 ){        
        flag_form =  valida_text_form("#descripcion_incidencia" , ".place_reporte_incidencia" , 5  , "Descripcion  de la incidencia " ); 
        if (flag_form ==  1  ){        
            $(".place_reporte_incidencia").empty();            

            url =  $(".form-error").attr("action");            
            data_send =  $(".form-error").serialize()+ "&" + $.param({"num_calificacion" : get_calificacion() });
            console.log(data_send);
            $.ajax({
                url: url ,
                type: "POST",          
                data: data_send,
                beforeSend: function(){
                show_load_enid(".place_registro" , "Registrando tu solicitud ... " , 1);        
                }

            }).done(function(data){    
                
                show_response_ok_enid(".place_registro" , "Gracias por ayudarnos a mejorar Time Wallet!");    
                document.getElementById("form-error").reset();
                set_calificacion(0);
                setTimeout(function() {
                    redirect("../principal");
                }, 1500);                        

            }).fail(function(){
                show_error_enid(".place_registro"  , "Error en la carga reporte al administrador " );       
            });    
        }
        
    }
    e.preventDefault();
}
/**/
function asigna_calificacion(e){  
    
    n_calificacion  =  e.target.value;         
    

    set_calificacion(n_calificacion);    
    $("#contenidor-ranking").removeClass("animated infinite bounce");
}
/**/
function valida_calificacion(){
    /**/    
    if (get_calificacion() == 0 ){
        $("#contenidor-ranking").addClass("animated infinite bounce");
        recorrepage("#enid-service-start");         
        llenaelementoHTML(".place_val_estrellas" , "<span class='msj-calificanos'> <strong> Ayudanos a mejorar nuestros servicios, califícanos.!</strong> </span>");
        return get_calificacion();
    }else{

        $("#contenidor-ranking").removeClass("animated infinite bounce");
        $(".place_val_estrellas").empty();
        return get_calificacion();   
    }
}
