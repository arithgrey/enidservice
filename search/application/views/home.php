<?php if ( strlen(trim($q)) ==  0):?>
    <?=n_row_12()?>
        <div class="contenedor_img_principal" >                
        </div>        
    <?=end_row()?>    
<?php endif;?>
   
<?=n_row_12();?>        
    
            <div class='contenedor_anuncios_home'>
                <div class='contenedor_anunciate'>
                    <a  href="../login?action=nuevo" 
                        class='anuncia_articulos'>
                        ANUNCIA TUS ARTÍCULOS AQUÍ!
                        <i class="fa fa-chevron-circle-right"></i>
                    </a> 
                </div>
                
            </div>                  
    
<?=end_row();?>                       
<?php    

    $num_servicios_encontrados =  $servicios["num_servicios"];
    $servicios = $servicios["servicios"];        
    if($es_movil == 0){        

        $primer_nivel =  $bloque_busqueda["primer_nivel"];
        $segundo_nivel =  $bloque_busqueda["segundo_nivel"];
        $tercer_nivel =  $bloque_busqueda["tercer_nivel"];
        $cuarto_nivel =  $bloque_busqueda["cuarto_nivel"];
        $quinto_nivel =  $bloque_busqueda["quinto_nivel"];

        $bloque_primer_nivel =  crea_seccion_de_busqueda_extra($primer_nivel, $busqueda); 
        $bloque_segundo_nivel =  crea_seccion_de_busqueda_extra($segundo_nivel, $busqueda); 
        $bloque_tercer_nivel =  crea_seccion_de_busqueda_extra($tercer_nivel, $busqueda); 
        $bloque_cuarto_nivel =  crea_seccion_de_busqueda_extra($cuarto_nivel, $busqueda); 
        $bloque_quinto_nivel =  crea_seccion_de_busqueda_extra($quinto_nivel, $busqueda); 
    }
?>
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css'>
<main>
    <div style="margin-top: 30px;">                            
            <div class="col-lg-2">      
                <?=n_row_12()?>
                    <div class='informacion_busqueda_productos_encontrados'>
                        <i class="fa fa-search strong">                    
                        </i>
                        <?=$busqueda?>(<?=$num_servicios?> PRODUCTOS)
                    </div>
                <?=end_row()?>
                       
                <?php if($es_movil ==  0):?>                    
                <div 
                    style="border: solid black .7px;padding: 3px;background: #000205;color: white;">
                    <span class="strong" style="font-size: .85em;" >
                        FILTRA TU BÚSQUEDA
                    </span>
                </div>  
                <?php endif;?>
                <div class='contenedor_menu_productos_sugeridos'>
                    <?php
                        if ($es_movil == 0){                            

                            if ($bloque_primer_nivel["num_categorias"] > 0) {
                                echo $bloque_primer_nivel["html"];
                            }
                            /**/
                            if($bloque_segundo_nivel["num_categorias"] > 0){
                                echo "<hr>";
                                echo $bloque_segundo_nivel["html"];
                            }
                            /**/
                            if($bloque_tercer_nivel["num_categorias"] > 0){
                                echo "<hr>";
                                echo $bloque_tercer_nivel["html"];
                            }
                            /**/
                            if($bloque_cuarto_nivel["num_categorias"] > 0){
                                echo "<hr>";
                                echo $bloque_cuarto_nivel["html"];
                            }
                            /**/
                            if($bloque_quinto_nivel["num_categorias"] > 0){
                                echo "<hr>";
                                echo $bloque_quinto_nivel["html"];
                            }

                        }

                    ?>

                </div>
            </div>
            <div class="col-lg-10">
                <?=n_row_12()?>
                    <?=$paginacion?>
                <?=end_row()?>
                
                <?php
                   $list ="";  
                   $flag =0;    
                   $extra = "";
                   $b=0;
                    foreach($lista_productos as $row){                        
                        if ($b > 0) {
                            $extra = "style='margin-top:30px;'";          
                        } 
                        echo "<div class='col-lg-3' ".$extra." >";  
                        echo "<div class='row'>";
                            echo "<center>";
                                echo $row;
                            echo "</center>";  
                        echo "</div>";  
                        echo "</div>";  
                        $flag ++;
                        if ($flag == 4) {
                            $flag =0;
                            echo "<hr>";
                            $b ++;
                        }
                    }
                    
                ?>
                <?php if( count($lista_productos) > 8):?>
                    <?=n_row_12();?>
                        <?=$paginacion;?>
                    <?=end_row();?>
                <?php endif;?>
                
        </div>
    </div>    
</main>

<style>

.contenedor_anuncios_home{
    width: 50%;margin:0 auto;    
} 
.anuncia_articulos,.btn_formas_pago{
    font-size: 1em; color: black;
}
.informacion_busqueda_productos_encontrados{
    font-size: 1em;    
}
.contenedor_menu_productos_sugeridos{
    border: solid black .7px;padding: 3px;
}

@media only screen and (max-width: 768px) {
    /* For mobile phones: */
    .contenedor_anuncios_home{
        width: 100%;margin:0 auto;
    }
    .contenedor_anunciate{
        background: #0231fc;
        color:white;
        padding:5px;        
    }
    .contenedor_anunciate a{
        color:white!important;
    }
    .contenedor_formas_pago{
        display:none;
    }
    .contenedor_menu_productos_sugeridos{
        display: none;
    }
    .informacion_busqueda_productos_encontrados{        
        font-weight: bold;
        font-size: 1.2em;
    }
    
}

}
</style>