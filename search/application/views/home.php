<?php if ( strlen(trim($q)) ==  0):?>
    <?=n_row_12()?>
        <div class="contenedor_img_principal" >                
        </div>        
    <?=end_row()?>    
<?php endif;?>
<?=n_row_12()?>    
    <div style="border-bottom:solid 1px;padding: 4px;">
        <?=n_row_12()?>
            <div style="width: 50%;margin:0 auto;">
                <div class="col-lg-4">                                    
                    <a  
                        href="../login?action=nuevo" 
                        style="font-size: 1em; color: black;"
                        >
                        ANUNCIA TUS ARTÍCULOS  AQUÍ!
                        <i class="fa fa-chevron-circle-right"></i>
                    </a> 
                </div>
                <div class="col-lg-4">                                    
                    <a  
                        href="../forma_pago/?info=" 
                        style="font-size: 1em; color: black;">
                        FORMAS DE PAGO
                        <i class="fa fa-chevron-circle-right">                        
                        </i>
                    </a> 
                </div>  
                <div class="col-lg-4">                                          
                </div>  
            </div>        
        <?=end_row()?>         
    </div>        
<?=end_row()?>                       
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
    <div style="width: 95%;margin-top: 20px;">                            
            <div class="col-lg-2">      
                <?=n_row_12()?>
                    <div style="font-size: 1.5em;text-align: center;margin-bottom: 5px;">
                        <i class="fa fa-search strong">                    
                        </i><?=$busqueda?>(<?=$num_servicios?> PRODUCTOS)
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
                <div style="border: solid black .7px;padding: 3px;">
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
                        echo $row;
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

