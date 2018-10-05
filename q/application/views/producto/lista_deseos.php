<?=n_row_12()?>
    <div class='col-lg-10 col-lg-offset-1'>
    	<?=heading_enid("TU LISTA DE DESEOS" , 3, [ "class"=>'titulo_lista_deseos'])?>            	       
        <?=div(anchor_enid("ARTICULOS AGREGADOS A LA LISTA DE DESEOS DEL " . 
            $extra["fecha_inicio"] ."-" . $extra["fecha_termino"],
            ["href" =>  "../search/?q2=0&q="]
        ), 
        ["class"=>"a_enid_black"]
        )?>    	
    </div>
<?=end_row()?>

<?=n_row_12()?>
    <div class='col-lg-10 col-lg-offset-1'>
    	<?php n_row_12()?>
        <?php
        $a =0;
            foreach ($productos_deseados as $row):
                	   
                $num_deseo =$row["num_deseo"];
                $id_servicio =$row["id_servicio"];
                $url = "../producto/?producto=".$id_servicio;
                $src_img = "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
        ?>
                	
                		
        <div class='col-lg-3'>
            <?=anchor_enid(icon(["src"=> $src_img , "class"=>'img_servicio']) ,["href"=> $url])?>
            <?=div($num_deseo , 
                    [
                    "class" =>  "num_deseo_producto" 
                    "title" =>  "Personas que agregaron a la lista de deseos este producto"
            ])?>                
        </div>
                		
        <?php endforeach; ?>
        <?php end_row()?>
    </div>
<?=end_row()?>
