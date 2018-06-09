<?php            
    $en_servicios = [];
    $en_productos = [];
    /*INFO SERVICIO */
    $id_servicio = "";
    $nombre_servicio = "";
    $status = "";    
    $url_vide_youtube = "";
    $url_video_facebook =  "";
    $url_productos_publico = "";
    $metakeyword =  "";
    $metakeyword_usuario =  "";
    $flag_nuevo =  0;
    $flag_envio_gratis =  0;
    $flag_servicio =0;
    $existencia =0;
    $color ="";
    $precio = 0;
    $id_ciclo_facturacion = 0;
    $entregas_en_casa = 0;
    $telefono_visible = 0;
    $venta_mayoreo = 0;
    foreach ($servicio  as $row){
        
        $id_servicio =   $row["id_servicio"];
        $nombre_servicio =   $row["nombre_servicio"];
        $param["nombre_servicio"] =  $nombre_servicio;
        
        $status =   $row["status"];                
        $url_vide_youtube= $row["url_vide_youtube"];
        $url_video_facebook= $row["url_video_facebook"];
        $metakeyword =  $row["metakeyword"];
        $metakeyword_usuario =  $row["metakeyword_usuario"];
        $flag_nuevo =  $row["flag_nuevo"];
        $flag_envio_gratis = $row["flag_envio_gratis"];
        $flag_servicio = $row["flag_servicio"];
        $existencia =  $row["existencia"];
        $color = $row["color"];
        $precio =  $row["precio"];
        $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
        $entregas_en_casa =  $row["entregas_en_casa"];
        $telefono_visible = $row["telefono_visible"];
        $venta_mayoreo =  $row["venta_mayoreo"];
    }    
    $url_web_servicio = $url_request."producto/?producto=".$id_servicio;    
    $url_productos_publico ="../producto/?producto=".$id_servicio."&q2=".$id_usuario;            
    /*INFO costoS SERVICIO */        
    $costo_envio_vendedor =  
    ($flag_servicio == 0 )?floatval($costo_envio["costo_envio_vendedor"]):0;    

    $comision = porcentaje(floatval($precio),$porcentaje_comision);

    $utilidad =  floatval($precio) - $costo_envio_vendedor;
    $utilidad =  $utilidad - $comision;
    
    $param["precio"] =  $precio;
    $ganancias_afiliados =  0; 
    $ganancias_vendedores = 0; 

    /***/
    $text_meses ="No aplica";
    $text_num_mensualidades =  "No aplica";

    
    $param["imgs"] =  $imgs;        
    $costo_envio_cliente= ($flag_servicio == 0 )?$costo_envio["costo_envio_cliente"]:0;        
    $en_productos["info_colores"] =create_colores_disponibles($color);
    $en_productos["flag_nuevo"]=  $flag_nuevo;
    $en_productos["existencia"]=  $existencia;
     
    $en_servicios["ciclos_disponibles"]= $ciclos;
    $en_servicios["id_ciclo_facturacion"] =  $id_ciclo_facturacion;
    
    $text_clasificacion ="";
    foreach($clasificaciones as $row){
        $id_clasificacion = $row["id_clasificacion"];
        $nombre_clasificacion = $row["nombre_clasificacion"];
        $text_clasificacion .=  $nombre_clasificacion." /";
    } 
    /**/
    $text_tipo_promocion =  valida_tipo_promocion($servicio);
    /**/
    $data["servicio"] = $servicio;
    $data["tipo_promocion"] = $text_tipo_promocion;
    $data["url_productos_publico"] =  $url_productos_publico;    
    $data["precio"] = $precio;
    $data["utilidad"] =  $utilidad;
    $data["comision"] = $comision;

    $msj_compra_en_casa = ($flag_servicio==1)?"OFRECES SERVICIO EN TU NEGOCIO?":
                        "¿CLIENTES 
                            <span class='indicacion_tambien'>TAMBIÉN</span>
                        PUEDEN RECOGER 
                        SUS COMPRAS EN TU NEGOCIO? ";

    $no_atencion_en_casa =  ($flag_servicio==1)?"NO":"NO, SOLO HAGO ENVÍOS";


    $msj_ver_telefono =  ($flag_servicio==1)?
    "¿PERSONAS PUEDEN VER TU NÚMERO TELEFÓNICO PARA SOLICITARTE MÁS 
    INFORMES?":
    "¿PERSONAS PUEDEN SOLICITARTE MÁS 
    INFORMES POR TELÉFONO?";
    


    
?>

<?=$this->load->view("servicios/agregar_imagenes" , $data);?>

<div class="contenedor_global_servicio">        
    <?=$this->load->view("servicios/general" , $data);?>        
    <div>
        <?=$this->load->view("servicios/menu_tabs" , $data);?>                   
        <div class="tab-content" style="margin-top: 10px;">
            <div 
                class="tab-pane <?=valida_active_pane($num , 1)?>" 
                id="tab_imagenes">
                <?=n_row_12()?>                    
                    <?=$this->load->view("servicios/imagenes_servicios" , $data)?>
                <?=end_row()?>                    
                <?=n_row_12()?>                     
                    <hr class="hr_producto">                       
                    <?=$this->load->view("servicios/videos" , $data)?>
                <?=end_row()?> 
            </div>
            <div 
                class="tab-pane <?=valida_active_pane($num , 2);?>" 
                id="tab_info_producto" >                
                            
                <?=$this->load->view("servicios/descripcion" , $data)?>        
                <?php if($flag_servicio ==  0): ?>
                    <div style="margin-top: 20px;"></div>                      
                    <?=n_row_12()?>
                        <?php $this->load->view("servicios/colores", $en_productos); ?>
                    <?=end_row()?>
                <?php endif; ?>

            </div>
            <div class="tab-pane <?=valida_active_pane($num , 3);?>" id="tab_terminos_de_busqueda">
                <?=n_row_12()?>    
                    <div class="contenedor_inf_servicios">
                    


                    
                        
                        <div class="titulo_seccion_producto titulo_producto_servicio">
                            ¿PALABRAS CLAVE DE BÚSQUEDA?
                        </div>
                        <div class="info_meta_tags">
                            <?=create_meta_tags(
                                $metakeyword_usuario , $id_servicio);?>
                        </div> 
                        <table style="width: 100%;">
                            <tr>
                                <?=get_td(add_element("AGREGAR" , "span"))?>
                            <td>                        
                                <form class="form_tag" id="form_tag">
                                    <?=add_input(array( "type"   =>  "hidden" ,
                                                "name"  => "id_servicio" ,
                                                "value" => $id_servicio))?>             
                                    <?=add_input(array(  
                                                "type"          =>"text" ,
                                                "name"          =>"metakeyword_usuario" ,
                                                "required"      =>"",
                                                "placeholder"   =>
                                                "Palabra como buscan tu producto",
                                                "class"         =>"input-md metakeyword_usuario"))?>
                                            
                                </form>                                
                            </td>   
                                        
                            </tr>
                        </table>  
                        <div class="contenedor_sugerencias_tags"></div>                                              
                    </div>
                <?=end_row()?>
            
               
            </div>
            <div 
                class="tab-pane <?=valida_active_pane($num , 4);?>" 
                id="tab_info_precios">
                <br>
                <div class='contenedor_inf_servicios'>        
                    
                    <?=n_row_12();?> 

                        <div class='col-lg-6'>
                            <div class="row">                                
                                <div class='col-lg-5'>
                                    <div class="row">
                                        <div class="titulo_producto_servicio">
                                            <?=$msj_compra_en_casa;?>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-lg-7 info_recoge_en_casa'>
                                    <div class="row">                                        
                                        <br>
                                        <?=n_row_12();?>    
                                            
                                                <a  id='1'
                                                    class='button_enid_eleccion 
                                                    entregas_en_casa_si
                                                    entregas_en_casa 
                                                    <?=valida_activo_entregas_en_casa(1 , $entregas_en_casa)?>'>
                                                    SI
                                                </a>
                                                <a  style="margin-left: 10px;"
                                                    id='0'
                                                    class='button_enid_eleccion 
                                                    entregas_en_casa_no
                                                    entregas_en_casa
                                                    <?=valida_activo_entregas_en_casa(
                                                        0 , $entregas_en_casa)?>'>
                                                    <?=$no_atencion_en_casa;?>
                                                </a>
                                            
                                        <?=end_row()?>
                                        
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <hr class="hr_producto">

                        <div class='col-lg-6 contenedor_infor_telefonos'>
                            <div class="row">
                                    <div class='col-lg-5'>
                                        <div class="row">
                                            <div class="titulo_producto_servicio">
                                                <?=$msj_ver_telefono;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-lg-7 info_telefonos_visibles'>
                                        <div class="row">
                                            <br>
                                            <?=n_row_12();?>    
                                                <?=anchor_enid(
                                                    "SI",
                                                    array('id'    => 1 ,
                                                        'class' => '
                                                        button_enid_eleccion telefono_visible
                                                        '.valida_activo_vista_telefono(1 , 
                                                            $telefono_visible).' '
                                                ))?>
                                                

                                                <?=anchor_enid("NO, OCULTAR MI TELÉFONO",
                                                array(
                                                    'id'    => 0 ,
                                                    'class' => '
                                                        button_enid_eleccion 
                                                        no_tel telefono_visible
                                                        '.valida_activo_vista_telefono(0 , 
                                                            $telefono_visible).' '

                                                        ))?>    

                                                    
                                                
                                            <?=end_row()?>
                                            <?=br()?>
                                            <?=n_row_12()?>
                                                
                                                <?=text_agregar_telefono($has_phone, 
                                                    $telefono_visible)?>
                                            <?=end_row()?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <hr class="hr_producto">
                    <?=end_row();?>                    
                </div>

                <?php if ($flag_servicio == 0): ?>                    
                    
                    <div class="contenedor_inf_servicios contenedor_inf_servicios_novedad">
                        <?=n_row_12()?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php $this->load->view("servicios/seccion_nuevo" , 
                                        $en_productos);?>
                                </div>
                                <div class="col-lg-6">
                                    <?php 
                                    $this->load->view("servicios/seccion_disponibles", 
                                        $en_productos);?>
                                </div>
                            </div>
                        <?=end_row()?>
                    </div>
                    <br>



                <?php else: ?>
                    <?=n_row_12()?>
                        <?php 
                        $this->load->view("servicios/seccion_servicios" , $en_servicios); ?>
                    <?=end_row()?>
                <?php endif; ?>
                <?php if ($id_ciclo_facturacion != 9): ?>                    
                    <?=$this->load->view("servicios/precios" , $data);?>
                <?php endif; ?>




                <?php if($flag_servicio == 0 ):?>
                    <hr class="hr_producto">
                    <div class="contenedor_inf_servicios" >                        
                            <div class="row">
                                <div class="col-lg-8">                                
                                    <div class="row">   
                                            <div class="col-lg-4">
                                                <div class="titulo_producto_servicio">
                                                    ¿TAMBIÉN VENDES ESTE PRODUCTO A 
                                                    PRECIOS DE MAYOREO?
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <br>
                                                <?=n_row_12()?>
                                                    <a 
                                                        id='1'
                                                        class='button_enid_eleccion venta_mayoreo 
                                                        <?=valida_activo_ventas_mayoreo(1 , 
                                                            $venta_mayoreo)?>'>
                                                        SI
                                                    </a>
                                                    <a  style="margin-left: 10px;"
                                                        id='0'
                                                        class='button_enid_eleccion venta_mayoreo
                                                        <?=valida_activo_ventas_mayoreo(0 , 
                                                            $venta_mayoreo)?>'>
                                                        NO
                                                    </a>
                                                <?=end_row()?>
                                            </div>
                                    </div>                                    
                                </div>
                                <div class="col-lg-4">                                
                                </div>
                            </div>       
                    </div>
                <?php  endif;?>
            </div>
        
    </div>

   