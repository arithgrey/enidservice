function carga_form_img(){	
    /**/
    
    showonehideone( ".contenedor_agregar_imagenes" , ".contenedor_global_servicio");
	url = "../imgs/index.php/api/img_controller/form_img_servicio_producto/format/json/";
	data_send = $.param({"servicio" : get_option("servicio")});		
				
	$.ajax({		
			url : url,
			type : "GET", 		
			data : data_send,  			
			beforeSend:function(){
				show_load_enid(".place_img_producto" , "Cargando ... ", 1 );	
			}
		}).done(function(data){
			/**/
			llenaelementoHTML(".place_img_producto" , data);											
			 $(".imagen_img").change(upload_imgs_enid_pre);

		}).fail(function(){
			show_error_enid(".place_img_producto" , "Error ... ");
		});			
}
/**/
function upload_imgs_enid_pre(){    

    var i = 0, len = this.files.length , img, reader, file;        
    file = this.files[i];    
    reader = new FileReader();
    reader.onloadend = function(e){

        $(".imagen_img").hide();
        $(".guardar_img_enid").show();
        mostrar_img_upload(e.target.result , 'place_load_img');                    
        $("#form_img_enid").submit(registra_img_servicio);            
    };
    reader.readAsDataURL(file);
}
/**/
function registra_img_servicio(e){
   
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
            beforeSend : function(){}

    }).done(function(data){
        
        show_response_ok_enid(".place_load_img" , "Imagen cargada con éxito" );                         
        carga_informacion_servicio(1);        
        /**/
    }).fail(function(){
        show_error_enid(".place_load_img" , "Falla al actualizar al cargar la imagen" );   
        carga_informacion_servicio(1);
    });
    $.removeData(formData);
}        
/**/     