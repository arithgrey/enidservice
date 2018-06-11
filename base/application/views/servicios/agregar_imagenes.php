<?=n_row_12()?>    
    <div class="contenedor_agregar_imagenes" style="display: none;">
        <?=n_row_12()?>
            <div class="cancelar_img">
                <?=anchor_enid("<i class='fa fa-chevron-left'></i>CANCELAR" , 
                array( 
                    'class' =>  'btn_enid_blue cancelar_carga_imagen' , 
                    'style' => "color:white!important"
                ))?>
            </div>    
        <?=end_row()?> 

		<div class='text-center'>                
            <div class="contenedor_imagenes_info">            
                    <?=n_row_12();?>
                        <p class='text_add_imgs'>      
                            AGREGAR IMAGENES A TU - 
                            <a  target="_blank"
                                href="<?=$url_productos_publico?>" 
                                class='a_enid_blue_sm' 
                                style='color:white!important;'>
                                <?=$tipo_promocion;?>
                            </a>
                        </p>
                    <?=end_row()?>        
                    <?=n_row_12();?>      
                        <div class="col-lg-4 col-lg-offset-4" 
                            style="margin-top: 10px;margin-bottom: 10px;">
                            <div class="place_img_producto">                            
                            </div>
                        </div>
                    <?=end_row()?> 

            </div>
        </div>
    </div>        
<?=end_row()?>

