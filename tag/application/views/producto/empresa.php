<link rel='stylesheet prefetch' href='<?=base_url("application/css/css_tienda.css")?>'>

<main>
    <xmp>
        <?=print_r($servicios);?>
    </xmp>
    <div class="col-lg-12" style="padding: 50px;">
        <br>    
        
        <br>
        <div class="row">
            <div class="col-lg-2">      
                <div style="border: solid black .7px;padding: 3px;">                    
                    <span class="strong" style="font-size: .85em;" >
                        FILTRA TU BÚSQUEDA
                    </span>
                </div>  
                <div style="border: solid black .7px;padding: 3px;">
                   

                </div>
            </div>
            <div class="col-lg-10">
            <?php
               $list ="";  
               $flag =0;    
                  foreach ($servicios as $row) {
                    
                    $nombre_servicio =  $row["nombre_servicio"];      
                    $id_servicio  =  $row["id_servicio"];        
                    $precio =  $row["precio"];        
                    $flag_envio_gratis =  $row["flag_envio_gratis"];
                    $text_extra =  is_servicio($row);        
                    $precio_publico =  $row["precio_publico"];        
                    $url_img  = $url_request."imgs/index.php/enid/imagen_servicio/".$id_servicio;
                    $url_img_error  = $url_request."img_tema/portafolio/producto.png";
                    $metakeyword =  $row["metakeyword"];

                    /**/        
                    $extra_url =  "";
                    if ($in_session == 1){

                        $extra_url =  "&q2=".$id_usuario;    
                        
                    }

                    $url_info_producto =  "../producto/?producto=".$id_servicio.$extra_url;
                    $url_venta ="http://enidservice.com/inicio/producto/?producto=".$id_servicio.$extra_url;        
                    $social = create_social_buttons($url_venta , $nombre_servicio);
                        
                    $extra_flag_1 ="";
                    $extra_flag_2 ="";
                    $extra ="";
                    $flag =0;
                    if($flag == 4){            
                        $extra_flag_1 ="<div class='row'>";
                        $extra_flag_2 ="</div><hr>";
                        $flag =0;
                    }
                    $flag ++;

            ?>


                    
                     <div class="col-md-3">
                        <div class="card">
                            <a href="<?=$url_info_producto?>">
                                <img src="<?=$url_img?>" 
                                alt="<?=$metakeyword?>" 
                                onerror="this.src='<?=$url_img_error?>'" 
                                class="card-img-top"
                                style="width: 100%;"> 
                            </a>
                            <div class="card-block">            
                                <h3 class="black" style="font-size: .8em;">
                                    <?=$nombre_servicio?>
                                </h3> 
                                <div class="card-text" style="font-style:.7em!important;">
                                    <?=$social?>
                                </div> 
                                <div class="row">
                                    <a  href="<?=$url_info_producto?>" 
                                        class="btn btn-primary" 
                                        style="background: #00137d !important">
                                        <?=$precio_publico?>MXN    
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>                
                  <?php 
                }
                
            ?>
            </div>
        </div>
    </div>
    <br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</main>
