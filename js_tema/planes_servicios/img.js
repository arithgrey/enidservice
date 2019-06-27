"use strict";
let carga_form_img = () => {
    set_option("s",3);
    showonehideone( ".contenedor_agregar_imagenes" , ".contenedor_global_servicio");    
    despliega([".titulo_articulos_venta" , ".guardar_img_enid"], 0);
	let url        = "../q/index.php/api/img/form_img_servicio_producto/format/json/";
	let data_send  = $.param({"id_servicio" : get_option("servicio")});		    
    request_enid("GET", data_send , url , response_cargar_form , ".place_img_producto" );					
}
let response_cargar_form = data => {

    
    render_enid(".place_img_producto" , data);
    despliega([".guardar_img_enid" , "#guardar_img"]);
    $(".imagen_img").change(upload_imgs_enid_pre);
    recorre("#guardar_img");
}
let upload_imgs_enid_pre = function(){

    
    let i = 0, len = this.files.length , img, reader, file;        
    file = this.files[i];    
    reader = new FileReader();
    reader.onloadend = function(e){
        showonehideone(".guardar_img_enid" , ".imagen_img");
        let im =e.target.result;
        mostrar_img_upload(im , 'place_load_img');

        recorre(".guardar_img_enid");                
        $("#form_img_enid").submit(registra_img_servicio);            
    };
    reader.readAsDataURL(file);
}
let registra_img_servicio = e =>{
    e.preventDefault();
    let formData        = new FormData();
    let q               = get_parameter(".q_imagen");
    let q2              = get_parameter(".q2_imagen");
    let dinamic_img     = get_parameter(".dinamic_img");


    formData.append("imagen", $('input[type=file]')[0].files[0] );
    formData.append("q", q);
    formData.append("servicio", q2);
    formData.append("dinamic_img", dinamic_img);

    let url         = "../q/index.php/api/archivo/imgs";
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

                sload(".place_load_img");
            }

    }).done(response_load_image).fail(function(){

        carga_informacion_servicio(1);
    });

    $.removeData(formData);

}
let response_load_image =  data =>{

    switch(array_key_exists("status_imagen_servicio", data)) {
        case 1:
            seccess_enid(".place_load_img" , "SE AGREGÓ LA IMAGEN!" );
            carga_informacion_servicio(1);
            set_option("seccion_a_recorrer", ".contenedor_global_servicio");
            recorre(".carga_informacion_servicio");

            break;
        case 2:

            render_enid(".place_load_img" , "AGREGA UNA IMAGEN MÁS PEQUEÑA" );
            carga_form_img();
            break;

        case 3:

            alert(3);
            break;

        default:

            break;
    }
};
