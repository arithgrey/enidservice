<?php if ( strlen(trim($q)) ==  0):?>
    <section id="hero" class=" "
     style="background-image: url(../img_tema/portafolio/llamada_gratis_2.png);">
        <div class="container ">
        <div class="row">

            <div class="col-md-4">            
                <div style="background: #1b03ff!important;opacity: .8">                
                <ul class="contacts ">                
                        
                <li class='text_enid_contact' style="margin-top: 5px!important;"> 
                    <label style='padding:10px;'>
                        <span style='font-size:1em;' class="white">
                            <a href="../login?action=nuevo" style="color: white !important">
                             ANUNCIA TUS ARTÍCULOS Y SERVICIOS AQUÍ!
                            </a>
                        </span>                    
                    </label>        
                </li>                        
                </div>
                </ul><br><br><br><br><br><br><br>
            </div>    
    </div>
    </div>
    </section>
<?php endif; ?>

<?php    
    $num_servicios_encontrados =  $servicios["num_servicios"];
    $servicios = $servicios["servicios"];        
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
?>
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css'>
<main>
    <div class="col-lg-12" style="padding: 50px;">
        <br>    
        <?=n_row_12()?>
                <i class="fa fa-search">                    
                </i>
                Tu búsqueda de
                <strong>
                <?=$busqueda?>
                </strong> (<?=$num_servicios?> Productos)
        <?=end_row()?>
        <br>
        <div class="row">
            <div class="col-lg-2">      
                <div 
                    style="border: solid black .7px;padding: 3px;background: #000205;color: white;">
                    <span class="strong" style="font-size: .85em;" >
                        FILTRA TU BÚSQUEDA
                    </span>
                </div>  
                <div style="border: solid black .7px;padding: 3px;">
                    <?php
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


                    ?>

                </div>
            </div>
            <div class="col-lg-10">
                <center>
                    <?=$paginacion?>
                </center>
                
                <?php
                   $list ="";  
                   $flag =0;    
                    foreach($lista_productos as $row){
                        
                        echo "<div class='col-lg-3' style='margin-top:30px;' >";  
                        echo $row;
                        echo "</div>";  
                        $flag ++;
                        if ($flag == 4) {
                            $flag =0;
                            echo "<hr>";
                        }
                    }
                    if(count($lista_productos) > 8){
                        echo "<center>" . $paginacion ."</center>";
                    }
                ?>
                
            </div>
        </div>
    </div>
    <br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</main>

