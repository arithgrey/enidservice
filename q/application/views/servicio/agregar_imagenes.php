<div class="contenedor_agregar_imagenes">    
    <?=anchor_enid(
            icon('fa fa fa-times'),
            [
                'class' =>  'btn_enid_blue cancelar_carga_imagen cancelar_img pull-right' , 
                'style' => "color:white!important"
            ]
            ,1
    );?>        
    <div class="col-lg-4 col-lg-offset-4">            
        <?=heading_enid("AGREGAR IMAGENES", 3 ,  
            ["class"     =>  "titulo_agregar_imagenes"]  , 
        1)?>                                   
        <?=place("place_img_producto")?>
    </div>    
</div>