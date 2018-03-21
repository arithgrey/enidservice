<div style="margin-top: 10px;"></div>
<?=n_row_12()?>
<div class="col-lg-12">
    <div class="strong black">                                                    
        <?=valida_text_imagenes(valida_valor_variable($servicio , "flag_servicio") , $imgs);?>
    </div>                        
</div>
<?=end_row()?>
<?=n_row_12()?>
<div class="gallery cf" style="overflow-x: scroll;  overflow-x: hidden;">    
<table>
    <tr>
    <?php
        /**/
            $num_imgs =0; 
            foreach($imgs as $row) {
                $id_imagen =  $row["id_imagen"];
                $url_imagen = "../imgs/index.php/enid/imagen/".$id_imagen;
                $num_imgs ++;
            ?>
            <div>            
                <div style="border-style: solid;position:absolute;z-index: 2000;color: white;" >
                    <i  
                    class="fa fa-times fa-2x foto_producto" 
                    id="<?=$id_imagen?>">                
                    </i>
                </div>            
                <img 
                class="img-responsive" 
                src="<?=$url_imagen?>"
                style="position: relative;"/>
            </div>
    <?php } ?>


    <?php if ($num_imgs < 5){
        $url_imagen_pre_view ="../img_tema/tienda_en_linea/agregar_imagen.png";
        ?>              
        <?php for ($num_imgs=$num_imgs; $num_imgs <5; $num_imgs++) { ?>                
            <div>            
                <div 
                    class="agregar_img_servicio" 
                    style="border-style: solid;position:absolute;z-index: 2000;margin-left: 10px;padding: 3px;margin-top: 3px;" 
                    >
                    <i  class="fa fa-camera agregar_img_servicio" >                
                    </i>
                </div>
                    
                <img 
                    class="img-responsive" 
                    src="<?=$url_imagen_pre_view?>"
                    style="position: relative;"/>
            </div>
        <?php }?>
    <?php } ?>
    </tr>
</table>
</div>
<?=end_row()?>
