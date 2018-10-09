<?=n_row_12()?>
<div class="contenedor_principal_enid">        
    <div class="col-lg-2">
        <?=$this->load->view("secciones/menu");?>
    </div>  
    <div class="col-lg-7">                    
    <?php
        $a =0;
        foreach ($productos_deseados as $row):

        $id_servicio    =   $row["id_servicio"];
        $url            =   "../producto/?producto=".$id_servicio;
        $src_img        = "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
        $config         = [

            'src'   => $src_img ,
            'style' => 'width:100%!important;height:250px!important;'
        ];

        $img        =  img($config);                    
        $img_link   =  anchor_enid($img , ["src" =>  $url] );
        $div        =  div($img_link , ['class'     => 'col-lg-4'] ); 
        
    ?>
    <?=$div?>                        
    <?php endforeach; ?>            
    </div>
    <div class="col-lg-3">            
        <?=heading_enid("TU LISTA DE DESEOS" , 3,
        ["class"=>'titulo_lista_deseos'] , 1 )?>
        
        <?=anchor_enid("EXPLORAR MÁS ARTÍCULOS",     
            ["href" => "../search/?q2=0&q="] , 
            1
        )?>
    </div>
</div>
<?=end_row()?>