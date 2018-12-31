<?php            
    $en_servicios = [];
    $en_productos = [];
    $id_servicio                =   "";
    $nombre_servicio            =   "";
    $status                     =   "";    
    $url_vide_youtube           =   "";
    $url_video_facebook         =   "";
    $url_productos_publico      =   "";
    $metakeyword                =   "";
    $metakeyword_usuario        =   "";
    $flag_nuevo                 =   0;
    $flag_envio_gratis          =   0;
    $flag_servicio              =   0;
    $existencia                 =   0;
    $color                      =   "";
    $precio                     =   0;
    $id_ciclo_facturacion       =   0;
    $entregas_en_casa           =   0;
    $telefono_visible           =   0;
    $venta_mayoreo              =   0;
    $url_ml                     =   "";
    $link_dropshipping          =   "";
    foreach ($servicio  as $row){
        
        $id_servicio                =   $row["id_servicio"];
        $nombre_servicio            =   $row["nombre_servicio"];
        $param["nombre_servicio"]   =   $nombre_servicio;
        $status                     =   $row["status"];                
        $url_vide_youtube           =   $row["url_vide_youtube"];
        $url_video_facebook         =   $row["url_video_facebook"];
        $metakeyword                =   $row["metakeyword"];
        $metakeyword_usuario        =   $row["metakeyword_usuario"];
        $flag_nuevo                 =   $row["flag_nuevo"];
        $flag_envio_gratis          =   $row["flag_envio_gratis"];
        $flag_servicio              =   $row["flag_servicio"];
        $existencia                 =   $row["existencia"];
        $color                      =   $row["color"];
        $precio                     =   $row["precio"];
        $id_ciclo_facturacion       =   $row["id_ciclo_facturacion"];
        $entregas_en_casa           =   $row["entregas_en_casa"];
        $telefono_visible           =   $row["telefono_visible"];
        $venta_mayoreo              =   $row["venta_mayoreo"];
        $tiempo_promedio_entrega    =   $row["tiempo_promedio_entrega"];
        $url_ml                     =   $row["url_ml"];
        $link_dropshipping          =   $row["link_dropshipping"];
    }

    $url_web_servicio = $url_request."producto/?producto=".$id_servicio;    
    $url_productos_publico  = "../producto/?producto=".$id_servicio."&q2=".$id_usuario;            
    /*INFO costoS SERVICIO */        
    $costo_envio_vendedor   =  
    ($flag_servicio == 0 )?floatval($costo_envio["costo_envio_vendedor"]):0;    

    $comision = 0;
    $utilidad = 0;
    if ($flag_servicio ==  0) {
        
        $comision  =   porcentaje(floatval($precio),$porcentaje_comision);
        $comision_num  =   porcentaje(floatval($precio),$porcentaje_comision,2,2);
        $utilidad  =   floatval($precio) - $costo_envio_vendedor;        
        $utilidad  =   $utilidad - $comision_num;

    }
    
    $param["precio"]        =  $precio;
    $ganancias_afiliados    =  0; 
    $ganancias_vendedores   = 0; 

    /***/
    $text_meses ="No aplica";
    $text_num_mensualidades =  "No aplica";

    $costo_envio_cliente                = 
    ($flag_servicio == 0 )?$costo_envio["costo_envio_cliente"]:0;        
    $info_colores                       =  create_colores_disponibles($color);
    $en_productos["flag_nuevo"]         =  $flag_nuevo;
    $en_productos["existencia"]         =  $existencia;
     
    $en_servicios["ciclos_disponibles"]= $ciclos;
    $en_servicios["id_ciclo_facturacion"] =  $id_ciclo_facturacion;
    
    $text_clasificacion ="";
    foreach($clasificaciones as $row){
        $id_clasificacion = $row["id_clasificacion"];
        $nombre_clasificacion = $row["nombre_clasificacion"];
        $text_clasificacion .=  $nombre_clasificacion." /";
    }     
    $data["tipo_promocion"]=  $tipo_promocion =  valida_tipo_promocion($servicio);    
    $data["servicio"] = $servicio;
    $data["url_productos_publico"] =  $url_productos_publico;    
    $data["precio"] = $precio;
    $data["utilidad"] =  $utilidad;
    $data["comision"] = $comision;
    $data["url_ml"]   = $url_ml;


    $titulo_compra_en_casa = ($flag_servicio==1)?
    "OFRECES SERVICIO EN TU NEGOCIO?":"¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO?";

    $no_atencion_en_casa =  ($flag_servicio==1)?"NO":"NO, SOLO HAGO ENVÍOS";


    $msj_ver_telefono =  ($flag_servicio==1)?
    "¿PERSONAS PUEDEN VER TU NÚMERO TELEFÓNICO PARA SOLICITARTE MÁS 
    INFORMES?":"¿PERSONAS PUEDEN SOLICITARTE MÁS INFORMES POR TELÉFONO?";
    
    $data["flag_servicio"]      =  get_campo($servicio , "flag_servicio");         
    $text_notificacion_imagenes =  valida_text_imagenes($tipo_promocion, $num_imagenes);

    $notificacion_imagenes  
    = 
    heading_enid( $text_notificacion_imagenes, 2 ,["class"    =>  "titulo_seccion_producto"]);

    $extra_extrega_casa_si  =   valida_activo_entregas_en_casa(1 , $entregas_en_casa);  
    $extra_extrega_casa_no  =   valida_activo_entregas_en_casa(0 , $entregas_en_casa); 
    $activo_visita_telefono =   valida_activo_vista_telefono(1 , $telefono_visible);  
    $baja_visita_telefono   =   valida_activo_vista_telefono(0 , $telefono_visible);  
    $data["activo_ventas_mayoreo"]  =   valida_activo_ventas_mayoreo(1 , $venta_mayoreo);
    $data["baja_ventas_mayoreo"]    =  valida_activo_ventas_mayoreo(0 , $venta_mayoreo); 

    $extra_1                    =  valida_active_pane($num , 1);  
    $extra_2                    =  valida_active_pane($num , 2);  
    $extra_3                    =  valida_active_pane($num , 3);  
    $extra_4                    =  valida_active_pane($num , 4);  
    $num_articulos              =  valida_text_numero_articulos($existencia);     
    $llamada_accion_youtube     =  
    "¿TIENES ALGÚN VIDEO SOBRE TU ".$tipo_promocion."?";
    $text_llamada_accion_youtube =  icon('fa fa-youtube-play') ." VIDEO DE YOUTUBE ";
    $valor_youtube               =  get_campo($servicio , "url_vide_youtube");
    $val_youtube                 =  icon('fa fa-pencil text_url_youtube').$valor_youtube;
    $nuevo_nombre_servicio       =  get_campo($servicio ,"nombre_servicio");

    $text_titulo_seccion_producto=  
    "INFORMACIÓN SOBRE TU ".$nuevo_nombre_servicio.
    icon('fa fa-pencil text_desc_servicio icon-pencil');
    $nueva_descripcion          = get_campo($servicio , 'descripcion');
    $nombre_servicio_heading    = icon('fa fa-pencil text_nombre_servicio')." ". 
    $tipo_promocion ." ".$nuevo_nombre_servicio;


    $nuevo_titulo_seleccion_producto =  div(
        $text_titulo_seccion_producto , 
        ["class"=>"titulo_seccion_producto titulo_producto_servicio"],
        1);

    $info_nueva_descripcion      =  
    div($nueva_descripcion , ["class" => "text_desc_servicio contenedor_descripcion"],1);
    /**inputs**/
    /*NOMBRE*/
    $i_nombre = input_hidden([        
        "name"  =>  "q" , 
        "value" =>  "nombre_servicio"]
        ,1);

    $ie_nombre=  input([
        "type"    =>  "text" ,
        "name"    =>  "q2" ,
        "class"   =>  "nuevo_producto_nombre",
        "onkeyup" =>  "transforma_mayusculas(this)",
        "value"   =>  get_campo($servicio,'nombre_servicio') ,
        "required"=> true ],
        1);
    

    $i_cantidad =  input([
                        "type"      =>"number" ,
                        "name"      =>"existencia" ,
                        "class"     =>"existencia" ,
                        "required"  =>"" ,
                        "value"     => $existencia,
                    ],
                    1);
    /*DESCRIPCION*/
    $i_descripcion = 
    input(["type"  =>  "hidden" ,  "name"  =>  "q" , "value" =>"descripcion"] , 1); 
    $isummer_descripcion =  div("-".$nueva_descripcion, ["id"   =>  "summernote"], 1);

    /*youtube*/
    $i_youtube  =  input([
        "type"      =>  "url" ,
        "name"      =>  "q2" ,
        "class"     =>  'url_youtube' ,
        "value"     =>  $valor_youtube,
        "required"  =>  true 
        ] , 1);

    $ih_youtube  = input([  
                    "type"    =>    "hidden",
                    "name"   =>    "q" ,
                    "value"  =>    "url_vide_youtube"
                ],1);


    $icantidad       =  icon('fa fa-pencil text_cantidad');
    $metatags_format =  create_meta_tags($metakeyword_usuario , $id_servicio);


    $i_tags =  input([
        "type" => "hidden" , 
        "name"  => "id_servicio" , 
        "value" => $id_servicio]);

    $i_tag_usuario =  input([  
        "type"          =>"text" ,
        "name"          =>"metakeyword_usuario" ,
        "required"      =>"",
        "placeholder"   =>
        "Palabra como buscan tu producto",
        "class"         =>
        "input-md metakeyword_usuario"]);

    /*BUTTONS*/
    $btn_confirm_entrega_casa =  
        anchor_enid(
        "SI" , 
        ["id"   =>      '1', 
        "class" =>     
        'button_enid_eleccion entregas_en_casa_si 
        entregas_en_casa '.$extra_extrega_casa_si 
        ], 
        1);

    $btn_confirm_no_entrega_casa = 
        anchor_enid( 
            $no_atencion_en_casa , 
            ["id"       =>  '0',
            "class"     =>  'button_enid_eleccion 
            entregas_en_casa_no entregas_en_casa '.$extra_extrega_casa_no
            ] 
            , 
            1);    


    $accion_agregar_telefono    = 
    div(text_agregar_telefono($has_phone, $telefono_visible),["class" =>"accion_agregar_telefono"],1);     
    $btn_telefono_visible =  
        anchor_enid(
            "SI",
            [   'id'       => 1 , 
                'class'     => 'button_enid_eleccion 
                telefono_visible '.$activo_visita_telefono
            ] ,
            1);

    $btn_telefono_no_visible =  
        anchor_enid("NO, OCULTAR MI TELÉFONO",
            [
                'id'    => 0 ,
                'class' => 'button_enid_eleccion  no_tel telefono_visible 
                '.$baja_visita_telefono
            ],
            1);

    $place_youtube =  div("" , ["class" => "place_url_youtube"] , 1);

?>

<?=$this->load->view("servicio/agregar_imagenes" , $data);?>
<div class="contenedor_global_servicio">                
    <?=n_row_12()?>
        <?=heading_enid($nombre_servicio_heading, 4 ,[] , 1)?>    
        <?=form_open("",
            [ 'class' => 'form_servicio_nombre_info input_nombre_servicio_facturacion ']
            );?>  
            <?=$i_nombre?>          
            <?=div($ie_nombre ,['class'=> 'col-lg-9'])?>
            <?=div(guardar("GUARDAR",["class" => "info_guardar_nombre_servicio"],1)
             ,['class'=> 'col-lg-3'])?>
        <?=form_close()?>
    <?=end_row()?>
    <?=n_row_12()?>
        <?=$this->load->view("servicio/menu_tabs" , $data);?>                       
    <?=end_row()?>

    <div class="tab-content">                
        <!--IMAGENES +  YOUTUBE-->
        <div class="tab-pane <?=$extra_1?>" id="tab_imagenes">

            <?=valida_descartar_promocion($num_imagenes , $id_servicio)?>

            <?=$notificacion_imagenes;?>
            <?=div($images, ["class"   => "contenedor_imagen_muestra"],1 )?>
            
            <?=heading_enid($llamada_accion_youtube , 4 ,[] ,1)?>

            <?=div($text_llamada_accion_youtube , [] , 1)?>
            <?=div($val_youtube , ["class"    =>  "text_video_servicio"] , 1 )?>
            <?=form_open("",  
                [
                "class"=>
                "form_servicio_youtube input_url_youtube contenedor_info_youtube row"])?>
                <?=$ih_youtube?>
                <?=div($i_youtube.$place_youtube , ['class' => 'col-lg-9'])?>                
                <?=div(guardar("GUARDAR", ["class" =>"guardar_video_btn"] ,1) ,
                ['class' => 'col-lg-3'])?>
            <?=form_close()?>
        </div> 

        <!--DESCRIPCION DEL PRODUCTO-->
        <div class="tab-pane <?=$extra_2?>" id="tab_info_producto">

            <?=$nuevo_titulo_seleccion_producto;?>

            <?=place("place_tallas_disponibles")?>
            
            <?=$info_nueva_descripcion?>

            <?=form_open("",
            ["class"=>"form_servicio_desc input_desc_servicio_facturacion"])?>
                <?=$i_descripcion?>
                <?=$isummer_descripcion?>    
                <?=guardar("GUARDAR" ,["class" => "btn_guardar_desc "] , 1 )?>
            <?=form_close()?>          
            
            <?php if($flag_servicio ==  0): ?>                
                <div class="contenedor_inf_servicios">
                    <?=heading_enid("COLORES" , 4 , [] ,1)?>            
                    <?=div("+ AGREGAR COLORES", ["class" =>"text_agregar_color "],1);?>
                    <?=heading_enid("COLORES DISPONIBLES" , 4 )?>       
                    <?=div($info_colores ,[] ,1)?>
                    <div class="input_servicio_color" >
                        <?=div("" ,["id"    =>  "seccion_colores_info"], 1)?>
                        <?=div("" ,["class" =>  "place_colores_disponibles"] , 1)?>
                    </div>          
                </div>
            <?php endif; ?>
        </div>

    
        <div class="tab-pane <?=$extra_4?>" id="tab_info_precios">            

            <br>
            <?=n_row_12()?>
                <?=div(get_estado_publicacion($status , $id_servicio) , ["class" => "text-right"])?>
            <?=end_row()?>

            <?=get_rango_entrega(
                $id_perfil, 
                $tiempo_promedio_entrega, 
                [   "name"=>"tiempo_entrega" , 
                    "class"=> "tiempo_entrega form-control"
                ])?>
            <form action="../q/index.php/api/servicio/dropshiping/format/json/" class="form_dropshipping">
                <?=get_link_dropshipping($id_perfil , $id_servicio , $link_dropshipping)?>
            </form>

            <?=heading_enid($titulo_compra_en_casa,4);?>
            <table  class='seccion_compras_casa'>
                <tr>
                    <?=get_td($btn_confirm_entrega_casa )?>
                    <?=get_td($btn_confirm_no_entrega_casa)?>
                </tr>
            </table>    

            <?=heading_enid($msj_ver_telefono ,4 , [] , 1)?>            
            <table class="seccion_telefono_publico">
                <tr>
                    <?=get_td($btn_telefono_visible . $accion_agregar_telefono )?>
                    <?=get_td($btn_telefono_no_visible )?>
                </tr>
            </table>
        
    
        <?php if ($flag_servicio == 0): ?>                    
            <div class="contenedor_inf_servicios contenedor_inf_servicios_novedad">
                <div class="contenedor_es_nuevo">                    
                    <?=heading_enid("¿ES NUEVO?", 4 ,[] , 1)?>
                    <?=div(icon('fa fa-pencil text_nuevo').get_producto_usado($flag_nuevo))?>
                </div>                
                <table class="input_nuevo seccion_es_nuevo">
                    <tr>
                        <?=get_td(select_producto_usado($flag_nuevo),
                        ['class'=>'col-lg-9'])?>
                        <?=get_td(guardar("GUARDAR", 
                        ["class" => "btn_guardar_producto_nuevo es_nuevo col-lg-3"]))?>
                    </tr>
                </table>                        
                <div class="contenedor_articulos_disponibles">
                    <?=heading_enid('¿ARTÍCULOS DISPONIBLES?', 4 ,[]);?>
                    <?=div($icantidad.$num_articulos,["class" => "text_numero_existencia"])?>
                </div>  
                <table class="input_cantidad seccion_cantidad">
                    <tr>
                        <?=get_td($i_cantidad , ['col-lg-9'])?>        
                        <?=get_td(guardar("GUARDAR" , 
                            ["class"=> "es_disponible btn_guardar_cantidad_productos col-lg-3"]))?>
                    </tr>
                </table>                                    
            </div>
        <?php else: ?>
        <?php $this->load->view("servicios/seccion_servicios" , $en_servicios); ?>
        <?php endif; ?>        
        
        <?php if($flag_servicio == 0 || $id_ciclo_facturacion == 9): ?>

            <?=$this->load->view("servicio/precios" , $data);?>
        <?php endif; ?>


        </div>
        <!--BUSQUEDA AVANZADA-->
        <div class="tab-pane <?=$extra_3?>" id="tab_terminos_de_busqueda">
            <?=heading_enid("¿PALABRAS CLAVE DE BÚSQUEDA?" , 4 , [] , 1)?>
            <?=div($metatags_format , ["class"    =>  "info_meta_tags"] , 1)?>
            <table>
                <tr>
                    <?=get_td(div("AGREGAR"))?>
                    <td>     
                        <?=form_open("" , ["class"=>"form_tag", "id"=>"form_tag"])?>
                            <?=$i_tags?>             
                            <?=$i_tag_usuario?>             
                        <?=form_close()?>
                    </td>   
                </tr>
            </table>              
            <?=place("contenedor_sugerencias_tags")?>
        </div>

    </div>
</div>