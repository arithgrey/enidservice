<?=n_row_12()?>
	<div class="contenedor_principal_enid">    	               
        
        <div class='col-lg-9'>
           <div class="info_articulo" id='info_articulo'>
           </div>
            <?=$this->load->view("secciones_2/paginas_web")?>
        </div>            
        <div class="col-lg-3">                        
	       <?=$this->load->view("../../../view_tema/izquierdo")?>
	    </div>
        
    </div>
<?=end_row()?>                        
<input type="hidden" value="<?=$email?>" class='email_s'>

