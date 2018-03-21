var editar_respuesta = 0; 
var faq = 0; 
$(document).ready(function(){
	/**/
	$("footer").ready(function() {
		recorrepage("#info_articulo");		
	});
	if($(".in_session").val() == 1 ) {

		$('#summernote').summernote();  			
		$(".form_respuesta").submit(registra_respuesta);	
	}	
	$(".btn_edicion_respuesta").click(pre_editar_respuesta);
	$(".btn_img_avanzado").click(carga_form_imagenes_faq);
	/**/
	$(".btn_registro_respuesta").click(pre_registro_respuesta);
	/**/
	$("footer").ready(carga_categocias_extras);

});
/**/
function registra_respuesta(e){


	respuesta =  $(".note-editable").html();
	data_send= $(".form_respuesta").serialize()+"&"+$.param({"respuesta" : respuesta , "editar_respuesta" :  get_editar_respuesta() , "id_faq" : get_faq() });	
	

	url =  "../base/index.php/api/faqs/respuesta/format/json/";

		$.ajax({ 
			url : url , 
			data: data_send, 
			method: "POST",	

				beforeSend: function(xhr){					
					show_load_enid(".place_refitro_respuesta" , "Cargando ... " , 1 );
				}
			}).done(function(data){							

				
				show_response_ok_enid(".place_refitro_respuesta" , "Respuesta registrada!");										
				document.getElementById("form_respuesta").reset(); 				
				new_url = "../faq/?faq="+data;				
				redirect(new_url);

		}).fail(function(){			
			show_error_enid(".place_refitro_respuesta", "Error al registrar" ); 
		});

	e.preventDefault();
}
/**/
function  set_editar_respuesta(new_editar_respuesta) {
	editar_respuesta = new_editar_respuesta;
}
/**/
function get_editar_respuesta(){
	return  editar_respuesta;
}
/**/
function set_faq(new_faq){
	faq =  new_faq;
}
/**/
function get_faq(){
	return faq;
}
/**/
function pre_editar_respuesta(e){
	/**/
	document.getElementById("form_respuesta").reset(); 	
	set_faq(e.target.id);
	set_editar_respuesta(1);
	carga_info_faq();
	carga_form_imagenes_faq();
	$(".btn_img_avanzado").show();
}
/**/
function pre_registro_respuesta(){
	
	document.getElementById("form_respuesta").reset(); 	
	set_editar_respuesta(0);
	$(".btn_img_avanzado").hide();	
}
/**/
function carga_info_faq(){

	data_send= {"id_faq" : get_faq()};	

	url =  "../base/index.php/api/faqs/respuesta/format/json/";

		$.ajax({ 
			url : url , 
			data: data_send, 
			method: "GET",	
				beforeSend: function(xhr){}
			}).done(function(data){							

				
				/*form_respuesta*/
				id_categoria =  data[0].id_categoria;
				status       =  data[0].status        
				titulo       =  data[0].titulo;
				respuesta    =  data[0].respuesta     	
				
				selecciona_select(".form_respuesta .categoria", id_categoria);
				selecciona_select(".form_respuesta .tipo_respuesta", status);
				valorHTML(".titulo" , titulo);
				$(".note-editable").html(respuesta);		
							
		}).fail(function(){			
			show_error_enid(".place_refitro_respuesta", "Error al registrar" ); 
		});

}		
/**/
function carga_form_imagenes_faq(){

	/**/
	url_img_faq = "../imgs/index.php/enid/img_faq/"+get_faq();
	llenaelementoHTML(".place_img_actual_faq", "<img src='"+url_img_faq+"' style='width:100%;'>");
	/**/
    url =  "../imgs/index.php/api/img_controller/form_faq/format/json/";    
    $.ajax({
        url : url , 
        type : "GET" ,
        data :  {"id_faq" :  get_faq() },
        beforeSend: function(){                        
            show_load_enid(".place_load_img_faq" , "Cargando ... " , 1 ); 
        }
    }).done(function(data){        
    	
        llenaelementoHTML(".place_load_img_faq" , data);    
        
        carga_imgs_faq();
    }).fail(function(){
        show_error_enid(".place_load_img_faq" , "Error al cargar la sección de imagenes para el faq" ); 
    });

}


function carga_imgs_faq(){
    $("#guardar_img_faq").hide();
    $(".imagen_img_faq").change(upload_imgs_enid_faq);
}
/**/
function upload_imgs_enid_faq(){        
    var i = 0, len = this.files.length , img, reader, file;        
    file = this.files[i];
    reader = new FileReader();
    reader.onloadend = function(e){
        mostrar_img_upload(e.target.result , 'lista_imagenes_faq');            
        $("#guardar_img_faq").show();
        $("#form_img_enid_faq").submit(registra_img_faq);            
    };
    reader.readAsDataURL(file);
}
function registra_img_faq(e){


    e.preventDefault();
    var formData = new FormData(document.getElementById("form_img_enid_faq"));    
    url =  "../imgs/index.php/api/archivo/imgs";
    
    $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                show_load_enid(".place_load_img_faq" , "Cargando ... " , 2); 
                $(".guardar_img_enid").hide();
            } 
    }).done(function(data){        
        /**/
               
        $(".place_load_img_faq").html(data);
        muestra_alert_segundos(".place_load_img_faq");         
        $("#lista_imagenes_faq").html("");  
        
        new_url = "../faq/?faq="+get_faq();				
		redirect(new_url);


    }).fail(function(){        
        show_error_enid(".place_load_img_faq" , "Error al registrar imagenes " ); 
        
    });
    $.removeData(formData);
}
/**/
function carga_categocias_extras(){

	
	url =  "../base/index.php/api/faqs/categorias_extras/format/json/";
	data_send = {}; 

		$.ajax({ 
			url : url , 
			data: data_send, 
			method: "GET",	

				beforeSend: function(xhr){					
					//show_load_enid(".place_categorias_extras" , "Cargando ... " , 1 );
				}
			}).done(function(data){							

				
						
				llenaelementoHTML(".place_categorias_extras" , data);										
				

		}).fail(function(){			
			show_error_enid(".place_categorias_extras", "Error al registrar" ); 
		});

	e.preventDefault();
}
/**/