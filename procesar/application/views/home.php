<?=n_row_12()?>
	<div class="contenedor_principal_enid">    	               
        <?php if($is_mobile == 0):?>
	        <div class="col-lg-3">                        
	            <?=$this->load->view("../../../view_tema/izquierdo")?>
	        </div>
    	<?php endif;?>
        <div class='col-lg-9'>
           <div class="info_articulo" id='info_articulo'>
           </div>
            <?=$this->load->view("secciones_2/paginas_web")?>
        </div>    
        <?php if($is_mobile == 1):?>
        	<div class="col-lg-3">                        
	            <?=$this->load->view("../../../view_tema/izquierdo")?>
	        </div>
        <?php endif;?>
    </div>
<?=end_row()?>                        
<input type="hidden" value="<?=$email?>" class='email_s'>

