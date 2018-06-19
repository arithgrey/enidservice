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
    /**/
    $categorias_destacadas_orden =  sub_categorias_destacadas($categorias_destacadas);  
?>

<?php if ( strlen(trim($q)) ==  0):?>
    <?=n_row_12()?>
        <div class="contenedor_img_principal" >                
        </div>        
    <?=end_row()?>    
<?php endif;?>
   
<?=n_row_12();?>            
            <div class='contenedor_anuncios_home'>
                <div class='contenedor_anunciate'>
                    <div>
                        <a  href="../login?action=nuevo" 
                            class='anuncia_articulos'
                            style="color: white!important">
                            ANUNCIA TUS ARTÍCULOS AQUÍ!
                            <i class="fa fa-chevron-circle-right"></i>
                        </a>

                        <?php if($es_movil ==  0):?>
                            <?php 
                            foreach(crea_menu_principal_web($categorias_destacadas) as $row): ?>

                                <a  href="?q=&q2=<?=$row['primer_nivel']?>" 
                                    class='categorias_mas_vistas'
                                    style='color: white!important'
                                    >
                                    <?=mayus($row["nombre_clasificacion"])?>                                        
                                </a>
                            <?php endforeach; ?>      
                        <?php endif;?>               
                    </div>
                </div>              
            </div>
            
            
<?=end_row();?>                        

<?=n_row_12()?>
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
                        <div class="col-md-3">
                                
                                <select 
                                class="form-control order" 
                                name="order"
                                id="order">
                                    <?php $a=0; foreach($filtros as $row):?>                                        
                                        <?php if ($a ==  $order):?>
                                            <option value="<?=$a?>" selected>
                                                <?=$row?>
                                            </option>
                                        <?php else: ?>
                                            <option value="<?=$a?>">
                                                <?=$row?>
                                            </option>
                                        <?php endif;?>
                                        
                                    <?php $a ++ ;endforeach;?>
                                </select>
                        </div>
                        <div class="col-md-9">
                            <div class="pull-right">
                                <?=$paginacion?>
                            </div>
                        </div>                    
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
    <br>
    <?=n_row_12()?>         
        <div class="col-lg-2">            
        </div>  
        <div class="col-lg-10">
            <p class='titulo_categorias'>
                CATEGORIAS DESTACAGAS
            </p>
            <div class="row">
                <?=crea_sub_menu_categorias_destacadas($categorias_destacadas_orden)?>
            </div>
        </div>
    <?=end_row()?>
<?=end_row()?>

