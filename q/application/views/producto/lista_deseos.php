<?php n_row_12()?>
    <div class='col-lg-10 col-lg-offset-1'>
    	<center>
        	<h3 class='titulo_lista_deseos'>
        		TU LISTA DE DESEOS
        	</h3>
    	</center>
    	<div class="a_enid_black">
    		<a href="../search/?q2=0&q=" style="color: white!important;">
    			ARTICULOS AGREGADOS A LA LISTA DE DESEOS DEL 
                <?=$extra["fecha_inicio"]?> - <?=$extra["fecha_termino"]?> 
    		</a>
    	</div>
    </div>
<?php end_row()?>

    <?php n_row_12()?>
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
                    			<div class='row'>
                        			<a href="<?=$url?>">
                        				<img src="<?=$src_img?>" 
                        				class='img_servicio'>                    			
                    				</a>
                    			</div> 
                                <div class="row num_deseo_producto" 
                                    title="Personas que agregaron a la lista de deseos este producto">
                                    <center>
                                        <?=$num_deseo?>
                                    </center>
                                </div>
                    		</div>
                		
                	<?php endforeach; ?>
                <?php end_row()?>

    	</div>
    <?php end_row()?>
