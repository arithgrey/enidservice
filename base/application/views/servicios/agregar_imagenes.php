<?=n_row_12()?>    
    <div class="contenedor_agregar_imagenes" style="display: none;">
        <div class="contenedor_imagenes_info ">
            <center>
                <h3 style="font-weight: bold;font-size: 2em;">      
                    AGREGAR IMAGENES A TU - 
                    <a  target="_blank"
                        href="<?=$url_productos_publico?>" 
                        class='a_enid_blue_sm' 
                        style='color:white;'>
                        <?=strtoupper(entrega_data_campo($servicio , "nombre_servicio"))?>
                    </a>
                </h3>
            </center>
            <center>
                <div class="col-lg-4 col-lg-offset-4" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="place_img_producto">                            
                    </div>
                </div>
            </center>
        </div>
    </div>        
<?=end_row()?>