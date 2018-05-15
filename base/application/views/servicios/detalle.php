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
    <div class="page-header">      
      <?=$this->load->view("servicios/general" , $data);?>    
    </div>        
    <div>
    <?=$this->load->view("servicios/menu_tabs" , $data);?>            
       <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane <?=valida_active_pane($num , 1)?>" 
                id="tab_imagenes">
                    <?=n_row_12()?>                    
                        <?=$this->load->view("servicios/imagenes_servicios" , $data)?>
                    <?=end_row()?>                    
                    <?=n_row_12()?>                                            
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
                    <div class="well">
                    <table style="width: 100%" id="seccion_metakeywords_servicio"> 
                        <div class="titulo_seccion_producto">
                            ¿Clientes por qué palabras encuentran lo que vendes?
                        </div>
                        <div style="height: 50px;overflow: auto;">
                            <?=create_meta_tags($metakeyword_usuario , $id_servicio);?>
                        </div>                    
                        <table>
                            <tr>
                                <td>
                                    <span class="strong" style="font-size: .9em">
                                                Agregar
                                    </span>
                                </td>
                                <td>
                                    <div style="width: 300px;margin-left: 5px;">                    
                                        <form class="form_tag" id="form_tag">
                                            <input 
                                                    type="hidden" 
                                                    name="id_servicio" 
                                            value="<?=$id_servicio?>">
                                            <input 
                                                    type="text" 
                                                    name="metakeyword_usuario" 
                                                    required 
                                                    placeholder="Palabra como buscan tu producto" 
                                                    class="input-sm" style="height: 30px;">
                                        </form>
                                    </div>
                                </td>
                                        
                            </tr>
                        </table>                        
                        
                    </table>
                    </div>

                <?=end_row()?>
            
                <?=n_row_12()?>
                    <div class="well">
                        <div class="titulo_seccion_producto">
                            ¿A qué grupo pertenece?
                        </div>                    
                        <div style="font-size: .9em;">
                            <i  class="fa fa-pencil editar_categorias_servicio" 
                                id='<?=$id_servicio?>'>
                            </i>
                            <?=$text_clasificacion?>
                        </div>
                        <?=n_row_12()?>
                            <div class="contenedor_categorias " style="display: none;">    
                                <div class="panel">      
                                    <div style="overflow-x: auto;">
                                    <table width="100%;" class="categorias_edicion">
                                        <tr>
                                        <td>
                                            <div class="primer_nivel_seccion">          
                                            </div>    
                                        </td>
                                        <td>
                                            <div class="segundo_nivel_seccion">          
                                            </div>    
                                        </td>
                                        <td>
                                            <div class="tercer_nivel_seccion">          
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cuarto_nivel_seccion">          
                                            </div>
                                        </td>
                                        <td>
                                            <div class="quinto_nivel_seccion">          
                                            </div>
                                        </td>
                                        <td>
                                            <div class="sexto_nivel_seccion">          
                                            </div>
                                        </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                            </div>  
                            <div class="contenedor_cat"></div>  
                        <?=end_row()?>   
                    </div>
                <?=end_row()?>
            </div>
            <div 
                class="tab-pane <?=valida_active_pane($num , 4);?>" 
                id="tab_info_precios">
                <div class="well">        
                    <?=n_row_12();?> 
                    <div class='col-lg-6'>
                                <div class='col-lg-5'>
                                    <div class="row">
                                        <strong>
                                            <?=$msj_compra_en_casa;?>
                                        </strong>
                                    </div>
                                </div>
                                <div class='col-lg-7'>
                                    <a 
                                        id='1'
                                        class='button_enid_eleccion entregas_en_casa 
                                        <?=valida_activo_entregas_en_casa(1 , $entregas_en_casa)?>'>
                                        SI
                                    </a>
                                    <a  style="margin-left: 10px;"
                                        id='0'
                                        class='button_enid_eleccion entregas_en_casa
                                        <?=valida_activo_entregas_en_casa(0 , $entregas_en_casa)?>'>
                                        <?=$no_atencion_en_casa;?>
                                    </a>
                                </div>
                        
                    </div>
                    <div class='col-lg-6'>
                                <div class='col-lg-5'>
                                    <div class="row">
                                        <strong>
                                            <?=$msj_ver_telefono;?>
                                        </strong>
                                    </div>
                                </div>
                                <div class='col-lg-7'>
                                    <a 
                                        id='1'
                                        class='button_enid_eleccion telefono_visible 
                                        <?=valida_activo_vista_telefono(1 , 
                                            $telefono_visible)?>'>
                                        SI
                                    </a>
                                    <a  style="margin-left: 10px;"
                                        id='0'
                                        class='button_enid_eleccion telefono_visible
                                        <?=valida_activo_vista_telefono(0 , 
                                            $telefono_visible)?>'>
                                        NO, OCULTAR MI TELÉFONO
                                    </a>
                                </div>
                    </div>
                    <?=end_row();?>
                    
                </div>
                <?php if ($flag_servicio == 0): ?>                    
                    
                    <div class="well">
                        <?=n_row_12()?>
                            
                                <div class="col-lg-6">
                                    <?php $this->load->view("servicios/seccion_nuevo" , $en_productos);?>
                                </div>
                                <div class="col-lg-6">
                                    <?php $this->load->view("servicios/seccion_disponibles", $en_productos);?>
                                </div>
                            
                        <?=end_row()?>
                    </div>




                <?php else: ?>
                    <?=n_row_12()?>
                        <?php $this->load->view("servicios/seccion_servicios" , $en_servicios); ?>
                    <?=end_row()?>
                <?php endif; ?>
                <?php if ($id_ciclo_facturacion != 9): ?>                    
                    <?=$this->load->view("servicios/precios" , $data);?>
                <?php endif; ?>




                <?php if($flag_servicio == 0 ):?>

                    <div class="well">
                        <?=n_row_12()?>                        
                            <div class="col-lg-8">                                
                                <div>   
                                        <div class="col-lg-4">
                                            <strong>
                                                ¿TAMBIÉN VENDES ESTE PRODUCTO A 
                                                PRECIOS DE MAYOREO?
                                            </strong>
                                        </div>
                                        <div class="col-lg-8">
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
                                        </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-4">
                            
                            </div>
                        <?=end_row()?>
                    </div>

                <?php  endif;?>
            </div>
        
    </div>

   