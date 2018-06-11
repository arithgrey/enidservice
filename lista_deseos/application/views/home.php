<?=n_row_12()?>
    <div class="contenedor_principal_enid">
        
        <div class="col-lg-2">
            <?=$this->load->view("secciones/menu");?>
        </div>  
        <div class="col-lg-7">            
           
            	            		
                        <?php n_row_12()?>
                        
                        	<?php
                        	   $a =0;
                        	   foreach ($productos_deseados as $row):
                        	   
                        	   $id_servicio =$row["id_servicio"];
                        	   $url = "../producto/?producto=".$id_servicio;
                        	   $src_img = "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
                        	                   	   
                        	?>
                        		
                            <div class='col-lg-3'>
                            	<div class='row'>
                                	<a href="<?=$url?>">
                                		<img src="<?=$src_img?>" class='img_servicio'>
                            		</a>
                            	</div> 
                            </div>
                        		
                        	<?php endforeach; ?>
                        <?php end_row()?>

            	
        </div>
        <div class="col-lg-3">
            <?php n_row_12()?>                
                    <h3 class='titulo_lista_deseos'>
                        TU LISTA DE DESEOS
                    </h3>
                    <div>
                        <a  href="../search/?q2=0&q=" 
                            style="color: white!important;"
                            class="a_enid_black">
                            EXPLORAR MÁS ARTÍCULOS
                        </a>
                    </div>                
            <?php end_row()?>
        </div>
    </div>
<?=end_row()?>