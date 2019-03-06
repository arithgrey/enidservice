"use strict";
let editar_respuesta = 0;
let faq = 0; 
$(document).ready(function(){	

	if($(".in_session").val() == 1 ) {
		$('#summernote').summernote();  			
		$(".form_respuesta").submit(registra_respuesta);	
	}	
	$(".btn_edicion_respuesta").click(pre_editar_respuesta);
	$(".btn_img_avanzado").click(carga_form_imagenes_faq);
	$(".btn_registro_respuesta").click(pre_registro_respuesta);
	$("footer").ready(carga_categocias_extras);

});

let registra_respuesta = function(e){


	let respuesta 	=  $(".note-editable").html();
	let data_send	= $(".form_respuesta").serialize()+"&"+$.param({"respuesta" : respuesta , "editar_respuesta" :  get_option("editar_respuesta") , "id_faq" : get_option("faq") });	
	let url 		=  "../q/index.php/api/faqs/respuesta/format/json/";
	request_enid( "POST",  data_send, url, response_registro_respuesta, ".place_refitro_respuesta" );
	e.preventDefault();
}

let response_registro_respuesta = function(data){
	debugger;
	show_response_ok_enid(".place_refitro_respuesta" , "Respuesta registrada!");
	document.getElementById("form_respuesta").reset(); 				
	let new_url = "../faq/?faq="+data;				
	redirect(new_url);
}

let pre_editar_respuesta = function(e){

	document.getElementById("form_respuesta").reset(); 	
	set_option("faq", get_parameter_enid($(this) , "id"));
	set_option("editar_respuesta", 1);
	carga_info_faq();
	carga_form_imagenes_faq();
	$(".btn_img_avanzado").show();
}

let pre_registro_respuesta = function(){
	document.getElementById("form_respuesta").reset(); 	
	set_option("editar_respuesta", 0);
	$(".btn_img_avanzado").hide();	
}

let carga_info_faq = function(){

	let data_send= {"id_faq" : get_option("faq")};	
	let url =  "../q/index.php/api/faqs/respuesta/format/json/";
	request_enid( "GET",  data_send, url, response_carga_info_faq);
}	

let response_carga_info_faq = function(data){

	let id_categoria =  data[0].id_categoria;
	let status       =  data[0].status;
	let titulo       =  data[0].titulo;
	let respuesta    =  data[0].respuesta;
				
	selecciona_select(".form_respuesta .categoria", id_categoria);
	selecciona_select(".form_respuesta .tipo_respuesta", status);
	valorHTML(".titulo" , titulo);
	$(".note-editable").html(respuesta);		
}	

let carga_form_imagenes_faq = function(){


	let url_img_faq = "../imgs/index.php/enid/img_faq/"+get_option("faq");
	llenaelementoHTML(".place_img_actual_faq", "<img src='"+url_img_faq+"' style='width:100%;'>");
    let url =  "../imgs/index.php/api/img_controller/form_faq/format/json/";    
   	request_enid( "GET",  data_send, url, response_carga_form_imagenes, ".place_load_img_faq");
}

let response_carga_form_imagenes = function(data){

	llenaelementoHTML(".place_load_img_faq" , data);    
    carga_imgs_faq();
}


let carga_imgs_faq = function(){
    $("#guardar_img_faq").hide();
    $(".imagen_img_faq").change(upload_imgs_enid_faq);
}

let upload_imgs_enid_faq = function(){
    let i = 0, len = this.files.length , img, reader, file;        
    file = this.files[i];
    reader = new FileReader();
    reader.onloadend = function(e){
        mostrar_img_upload(e.target.result , 'lista_imagenes_faq');            
        $("#guardar_img_faq").show();
        $("#form_img_enid_faq").submit(registra_img_faq);            
    };
    reader.readAsDataURL(file);
}
let registra_img_faq = function(e){


    e.preventDefault();
    let formData = new FormData(document.getElementById("form_img_enid_faq"));    
    let url =  "../q/index.php/api/archivo/imgs";  
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

               
        $(".place_load_img_faq").html(data);
        $("#lista_imagenes_faq").html("");  
        
        let new_url = "../faq/?faq="+get_option("faq");
		redirect(new_url);


    }).fail(function(){        
        show_error_enid(".place_load_img_faq" , "Error al registrar imagenes " ); 
        
    });
    $.removeData(formData);
}

let carga_categocias_extras = function(){
	let url =  "../q/index.php/api/faqs/categorias_extras/format/json/";
	let data_send = {}; 
	request_enid( "GET",  data_send, url, 1 , ".place_categorias_extras" , 0 , ".place_categorias_extras");
}