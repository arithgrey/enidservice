function carga_form_img(){	
    /**/    
    showonehideone( ".contenedor_agregar_imagenes" , ".contenedor_global_servicio");
    display_elements([".titulo_articulos_venta"], 0);
	var url        = "../q/index.php/api/img/form_img_servicio_producto/format/json/";
	var data_send  = $.param({"id_servicio" : get_option("servicio")});		    
    request_enid("GET", data_send , url , response_cargar_form , ".place_img_producto" );					
}
/**/
function response_cargar_form(data){

    llenaelementoHTML(".place_img_producto" , data);
    $(".imagen_img").change(upload_imgs_enid_pre);
    recorrepage("#guardar_img");
}
/**/
function upload_imgs_enid_pre(){    

    
    var i       = 0, len = this.files.length , img, reader, file;        
    var file    = this.files[i];    
    var reader  = new FileReader();
    reader.onloadend = function(e){
        showonehideone(".guardar_img_enid" , ".imagen_img");
        mostrar_img_upload(e.target.result , 'place_load_img');    
        recorrepage(".guardar_img_enid");                
        $("#form_img_enid").submit(registra_img_servicio);            
    };
    reader.readAsDataURL(file);
}
/**/
function registra_img_servicio(e){

    e.preventDefault();
    var formData    = new FormData(document.getElementById("form_img_enid"));        
    var url         = "../q/index.php/api/archivo/imgs";
    $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false , 
            beforeSend : function(){
                $(".guardar_img_enid").hide();
                recorrepage(".carga_informacion_servicio");
                show_load_enid(".place_load_img");
            }

    }).done(response_load_image).fail(function(){
        show_error_enid(".place_load_img" , "Falla al actualizar al cargar la imagen" );   
        carga_informacion_servicio(1);
    });
    $.removeData(formData);
}        
/**/     
var response_load_image = function(data){

    if(array_key_exists("session_exp", data)){        
        /*Session exp*/
        redirect("");
    }
    if (data.status_imagen_servicio != true) {


        llenaelementoHTML(".info_form" , "Intenta cargar otra imagen!" );                         
        recorrepage(".info_form");
        carga_form_img();

    }else{
        
        show_response_ok_enid(".place_load_img" , "Imagen cargada con éxito" );                         
        carga_informacion_servicio(1);        
        set_option("seccion_a_recorrer", ".contenedor_global_servicio");
        recorrepage(".carga_informacion_servicio");    
    }

    
}
