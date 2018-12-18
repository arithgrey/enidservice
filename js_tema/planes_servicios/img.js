function carga_form_img(){	
    /**/    
    showonehideone( ".contenedor_agregar_imagenes" , ".contenedor_global_servicio");    
    display_elements([".titulo_articulos_venta" , ".guardar_img_enid"], 0);
	var url        = "../q/index.php/api/img/form_img_servicio_producto/format/json/";
	var data_send  = $.param({"id_servicio" : get_option("servicio")});		    
    request_enid("GET", data_send , url , response_cargar_form , ".place_img_producto" );					
}
/**/
function response_cargar_form(data){   

    
    llenaelementoHTML(".place_img_producto" , data);
    display_elements([".guardar_img_enid" , "#guardar_img"]);
    $(".imagen_img").change(upload_imgs_enid_pre);
    recorrepage("#guardar_img");
}
/**/
function upload_imgs_enid_pre(){    

    
    var i = 0, len = this.files.length , img, reader, file;        
    file = this.files[i];    
    reader = new FileReader();
    reader.onloadend = function(e){
        showonehideone(".guardar_img_enid" , ".imagen_img");
        var im =e.target.result;
        //redimensionar(im,1000,1000);
        mostrar_img_upload(im , 'place_load_img');

        recorrepage(".guardar_img_enid");                
        $("#form_img_enid").submit(registra_img_servicio);            
    };
    reader.readAsDataURL(file);
}
/**/
function registra_img_servicio(e){
    e.preventDefault();
    //debugger;




    var formData        = new FormData();
    var q               = get_parameter(".q_imagen");
    var q2              = get_parameter(".q2_imagen");
    var dinamic_img     = get_parameter(".dinamic_img");


    formData.append("imagen", $('input[type=file]')[0].files[0] );
    formData.append("q", q);
    formData.append("servicio", q2);
    formData.append("dinamic_img", dinamic_img);





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

    //$.removeData(formData);

}
/*function redimensionar(im,maxWidth,maxHeight){
    var i=new Image();
    i.onload=function(){
        var w=this.width,
            h=this.height,
            scale=Math.min(maxWidth/w,maxHeight/h),
            canvas=document.createElement('canvas'),
            ctx=canvas.getContext('2d');
        canvas.width=w*scale;
        canvas.height=h*scale;
        ctx.drawImage(i,0,0,w*scale,h*scale);
        $('redimensionada').innerHTML='<img src="'+canvas.toDataURL()+'">';
        $('base64Redimensionada').innerHTML=canvas.toDataURL();

    }
    i.src=im;
}
*/
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
function preview(campo) {
    // campo = document.getElementById('upload').value;
    alert("Antes: "+campo);

    ruta = 'file:///'+ campo;
    ruta = escape(ruta);
    ruta = ruta.replace(/%5C/g, "/");
    ruta = ruta.replace(/%3A/g, ":");
    alert("Despues: "+ruta);
    imagen.src = ruta;
    imagen.style.display = 'block';
    imagen.style.width = "200px";
    imagen.style.height = "150px";
}