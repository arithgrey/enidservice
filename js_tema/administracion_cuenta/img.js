function carga_form_imagenes_usuario(){
    recorrepage(".contenedor_principal_enid");
    display_elements(  [".imagen_usuario_completa" , ".menu_info_usuario" , ".contenedor_lateral" , ".registro_telefono_usuario_lada_negocio" , ".editar_imagen_perfil"] , 0  );
    var data_send   = {};
    var url         =  "../q/index.php/api/img/form_img_user/format/json/";
    request_enid( "GET",  data_send, url, response_carga_form_imagenes, ".place_form_img"); 
}
function response_carga_form_imagenes(data)
{
    llenaelementoHTML(".place_form_img" ,  data);
    $(".imagen_img").change(upload_imgs_enid_pre);
        
}
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
    var url = "../q/index.php/api/archivo/imgs";
    $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false , 
            beforeSend : function(){

            }
    }).done(function(data){    
        
        show_response_ok_enid(".place_load_img" , "Imagen cargada con éxito" );                 
        redirect("");

    }).fail(function(){
        show_error_enid(".place_load_img" , "Falla al actualizar al cargar la imagen" );   
    });
    $.removeData(formData);
}