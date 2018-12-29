var editar_respuesta = 0; 
var faq = 0; 
$(document).ready(function(){	
	$("footer").ready(function() {
		recorrepage("#info_articulo");		
	});
	if($(".in_session").val() == 1 ) {
		$('#summernote').summernote();  			
		$(".form_respuesta").submit(registra_respuesta);	
	}	
	$(".btn_edicion_respuesta").click(pre_editar_respuesta);
	$(".btn_img_avanzado").click(carga_form_imagenes_faq);
	$(".btn_registro_respuesta").click(pre_registro_respuesta);
	$("footer").ready(carga_categocias_extras);

});
/**/
function registra_respuesta(e){


	var respuesta 	=  $(".note-editable").html();
	var data_send	= $(".form_respuesta").serialize()+"&"+$.param({"respuesta" : respuesta , "editar_respuesta" :  get_option("editar_respuesta") , "id_faq" : get_option("faq") });	
	var url 		=  "../q/index.php/api/faqs/respuesta/format/json/";
	request_enid( "POST",  data_send, url, response_registro_respuesta, ".place_refitro_respuesta" );
	e.preventDefault();
}
/**/
function response_registro_respuesta(data){

	show_response_ok_enid(".place_refitro_respuesta" , "Respuesta registrada!");										
	document.getElementById("form_respuesta").reset(); 				
	var new_url = "../faq/?faq="+data;				
	redirect(new_url);
}
/**/
function pre_editar_respuesta(e){
	/**/
	document.getElementById("form_respuesta").reset(); 	
	set_option("faq", get_parameter_enid($(this) , "id"));
	set_option("editar_respuesta", 1);
	carga_info_faq();
	carga_form_imagenes_faq();
	$(".btn_img_avanzado").show();
}
/**/
function pre_registro_respuesta(){
	document.getElementById("form_respuesta").reset(); 	
	set_option("editar_respuesta", 0);
	$(".btn_img_avanzado").hide();	
}
/**/
function carga_info_faq(){

	var data_send= {"id_faq" : get_option("faq")};	
	var url =  "../q/index.php/api/faqs/respuesta/format/json/";
	request_enid( "GET",  data_send, url, response_carga_info_faq);
}	
/**/
function response_carga_info_faq(data){
	/*form_respuesta*/
	var id_categoria =  data[0].id_categoria;
	var status       =  data[0].status;
	var titulo       =  data[0].titulo;
	var respuesta    =  data[0].respuesta;
				
	selecciona_select(".form_respuesta .categoria", id_categoria);
	selecciona_select(".form_respuesta .tipo_respuesta", status);
	valorHTML(".titulo" , titulo);
	$(".note-editable").html(respuesta);		
}	
/**/
function carga_form_imagenes_faq(){

	/**/
	var url_img_faq = "../imgs/index.php/enid/img_faq/"+get_option("faq");
	llenaelementoHTML(".place_img_actual_faq", "<img src='"+url_img_faq+"' style='width:100%;'>");
    var url =  "../imgs/index.php/api/img_controller/form_faq/format/json/";    
   	request_enid( "GET",  data_send, url, response_carga_form_imagenes, ".place_load_img_faq");
}
/**/
function response_carga_form_imagenes(data){

	llenaelementoHTML(".place_load_img_faq" , data);    
    carga_imgs_faq();
}
/**/

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
    var url =  "../q/index.php/api/archivo/imgs";  
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
        
        new_url = "../faq/?faq="+get_option("faq");				
		redirect(new_url);


    }).fail(function(){        
        show_error_enid(".place_load_img_faq" , "Error al registrar imagenes " ); 
        
    });
    $.removeData(formData);
}
/**/
function carga_categocias_extras(){
	var url =  "../q/index.php/api/faqs/categorias_extras/format/json/";
	var data_send = {}; 
	request_enid( "GET",  data_send, url, 1 , ".place_categorias_extras" , 0 , ".place_categorias_extras");
}