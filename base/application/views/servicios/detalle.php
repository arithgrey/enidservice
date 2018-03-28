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
    }    
    $url_web_servicio = $url_request."producto/?producto=".$id_servicio;    
    $url_productos_publico ="../producto/?producto=".$id_servicio."&q2=".$id_usuario;        
    $costo  = "";    
    $id_ciclo_facturacion = "";
    $ciclo = "";
    $flag_meses = "";
    $num_meses = "";    
    $precio_publico = 0;    

    /*INFO costoS SERVICIO */
    foreach ($precios_servicio  as $row){
                
        $costo  =  $row["costo"];    
        $id_ciclo_facturacion =  $row["id_ciclo_facturacion"];
        $ciclo =  $row["ciclo"];
        $flag_meses =  $row["flag_meses"];
        $num_meses =  $row["num_meses"];
        $precio_publico =  $row["precio_publico"];
        
    }

    $precio_venta =  $precio_publico["precio"];            
    $costo_envio_vendedor =  ($flag_servicio == 0 )?floatval($costo_envio["costo_envio_vendedor"]):0;    
    $comision = porcentaje(floatval($precio_venta),9);

    $utilidad =  floatval($precio_venta) - $costo_envio_vendedor;
    $utilidad =  $utilidad - $comision;
    
    $param["precio"] =  $precio_venta;
    $ganancias_afiliados =  0; 
    $ganancias_vendedores = 0; 

    /***/
    $text_meses ="No aplica";
    $text_num_mensualidades =  "No aplica";

    if($flag_meses > 0){
        $text_meses ="Si"; 
        $text_num_mensualidades =  $num_meses;
    }
    $param["imgs"] =  $imgs;    
    
    $costo_envio_cliente= ($flag_servicio == 0 )?$costo_envio["costo_envio_cliente"]:0;    
    
    $en_productos["info_colores"] =create_colores_disponibles($color);
    $en_productos["flag_nuevo"]=  $flag_nuevo;
    $en_productos["existencia"]=  $existencia;
     
    $en_servicios["ciclos_disponibles"]= $ciclo_facturarion_servicio;
    
    $text_clasificacion ="";
    foreach($clasificaciones as $row){
        $id_clasificacion = $row["id_clasificacion"];
        $nombre_clasificacion = $row["nombre_clasificacion"];
        $text_clasificacion .=  $nombre_clasificacion." /";
    } 
    /**/
    $data["servicio"] = $servicio;
    $data["url_productos_publico"] =  $url_productos_publico;
    $data["costo"]  =  $costo;
    $data["precio_venta"] = $precio_venta;
    $data["utilidad"] =  $utilidad;
    $data["comision"] = $comision;
?>

<?=$this->load->view("servicios/agregar_imagenes" , $data);?>

<div class="contenedor_global_servicio">
    <?=n_row_12()?>
    <?php if($flag_servicio == 0){
        $this->load->view("servicios/seccion_disponibles", $en_productos);echo "<hr>";} ?>
    <?=end_row()?>
    <?=$this->load->view("servicios/general" , $data);?>    
    <div>
    <?=$this->load->view("servicios/menu_tabs" , $data);?>            
       <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane <?=valida_active_pane($num , 1)?>" id="tab_imagenes">            
                <?=n_row_12()?>                    
                    <?=$this->load->view("servicios/imagenes_servicios" , $data)?>
                <?=end_row()?>
                <hr>
                <?=n_row_12()?>                    
                    <?=$this->load->view("servicios/videos" , $data)?>
                <?=end_row()?>
            </div>
            <div class="tab-pane <?=valida_active_pane($num , 2);?>" id="tab_info_producto" >                
                <?=$this->load->view("servicios/descripcion" , $data)?>
                <div style="margin-top: 20px;"></div>  
                <?=n_row_12()?>
                    <?php if($flag_servicio == 1){$this->load->view("servicios/seccion_servicios" , 
                    $en_servicios);} ?>
                <?=end_row()?>
                <?=n_row_12()?>
                    <?php if($flag_servicio == 0){
                        $this->load->view("servicios/seccion_nuevo" , $en_productos);}?>
                <?=end_row()?>
                <?=n_row_12()?>
                    <?php
                    if($flag_servicio == 0){
                        $this->load->view("servicios/seccion_disponibles", $en_productos);} ?>
                <?=end_row()?>
                <?=n_row_12()?>
                <?php if($flag_servicio == 0){ $this->load->view("servicios/colores", $en_productos);} ?>
                <?=end_row()?>

            </div>
            <div class="tab-pane <?=valida_active_pane($num , 3);?>" id="tab_terminos_de_busqueda">
                <?=n_row_12()?>    
                    <table style="width: 100%" id="seccion_metakeywords_servicio"> 
                        <div class="strong black">
                            ¿Cuales son las palabras clave de búsqueda?
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
                <?=end_row()?>
                <hr>
                <?=n_row_12()?>
                        <div class="strong black">
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
                <?=end_row()?>
            </div>
            <div  class="tab-pane <?=valida_active_pane($num , 4);?>" id="tab_info_precios">
                <?=$this->load->view("servicios/precios" , $data);?>
            </div>
        
    </div>

    <style>
            .text-danger strong {

                color: #001ec3;
            }
            .receipt-main {
                
                padding: 40px 30px !important;
                position: relative;
                box-shadow: 0 1px 21px #acacac;                
            }            
            .receipt-footer h1{            
                font-weight: 400 !important;
                margin: 0 !important;
            }
            
            
            .receipt-right h5 {
                font-size: 16px;
                font-weight: bold;
                margin: 0 0 7px 0;
            }
            .receipt-right p {
                font-size: 12px;
                margin: 0px;
            }
            .receipt-right p i {
                text-align: center;
                width: 18px;
            }
            .receipt-main td {
                padding: 9px 20px !important;
            }
            .receipt-main th {
                padding: 13px 20px !important;
            }
            .receipt-main td {
                font-size: 13px;
                font-weight: initial !important;
            }

                 
            #container {
                background-color: #dcdcdc;
            }
            .terminos_btn:hover{
                cursor: pointer;
            }
            .text_ciclo_facturacion:hover{
                cursor: pointer;
            }
    </style>






    <style>
    .tag_servicio:hover{    
        padding: 10px;
        background: blue;
        cursor: pointer;   
    }  
    .tag_servicio{
        background:black;margin-left: 1px;font-size:.8em;padding: 5px;color: white;
    }
    .gallery {  
      margin: 0 auto;
      padding: 5px;
      background: #fff;
      box-shadow: 0 1px 2px rgba(0,0,0,.3);
    }
    .gallery > div {
      position: relative;
      float: left;
      padding: 5px;
    }
    .gallery > div > img {
      display: block;
      width: 200px;
      transition: .1s transform;
      transform: translateZ(0); /* hack */
    }
    .gallery > div:hover {
      z-index: 1;
    }
    .gallery > div:hover > img {
      transform: scale(1.7,1.7);
      transition: .3s transform;
    }

    </style>

    <style>

    .nav-tabs>li>a {
      padding: 0;
      border: none;
      background: none;
    }
    .nav-tabs>li.active {
      cursor: default;
      background: #fff;
      color: #434951;
      border: 1px solid #ddd;
      border-top: 5px solid blue;
      border-bottom-color: transparent;
    }
    .nav-tabs>li {      
      border: 1px solid #fff;
      border-top: 3px solid transparent;        
      min-width: 80px;                              
    }    
    .text_agregar_color:hover{
        cursor: pointer;
    }
    .text_info_envio:hover{
        cursor: pointer;
    }
    .contenedor_imagenes_info{
        border:solid 1px;
    }
    </style>
</div>

<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

