function carga_form_imagenes_usuario(){    

    url =  "../imgs/index.php/api/img_controller/form_img_user/format/json/";
    $.ajax({
        url : url , 
        type : "GET" ,
        data : {},
        beforeSend: function(){                        
            show_load_enid(".place_form_img" , "Cargando ... " , 1 ); 
        }
    }).done(function(data){        
        
        llenaelementoHTML(".place_form_img" ,  data);
        $(".imagen_img").change(upload_imgs_enid_pre);
        
    }).fail(function(){
        show_error_enid(".place_form_img" , "Error al cargar la sección de imagenes para el esceario" ); 
    });

}/**/
function upload_imgs_enid_pre(){    

    var i = 0, len = this.files.length , img, reader, file;        
    file = this.files[i];    
    reader = new FileReader();
    reader.onloadend = function(e){

        $(".contenedor_img_usuario").hide();
        $(".guardar_img_enid").show();
        mostrar_img_upload(e.target.result , 'place_load_img');                    
        $("#form_img_enid").submit(registra_img_usr);            
    };
    reader.readAsDataURL(file);
}
/**/
function registra_img_usr(e){
   
    e.preventDefault();
    var formData = new FormData(document.getElementById("form_img_enid"));    
    url = "../imgs/index.php/api/archivo/imgs";

    $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false , 
            beforeSend : function(){
               //show_load_enid(".place_img_registrada", "Cargando ... " , 2);                 
               //$(".guardar_img_enid").hide();
            }
    }).done(function(data){

        /**/

        show_response_ok_enid(".place_load_img" , "Imagen cargada con éxito" );                 
        redirect("");


    }).fail(function(){
        show_error_enid(".place_load_img" , "Falla al actualizar al cargar la imagen" );   
    });
    $.removeData(formData);
}        
/**/     
