<main>
	<br>
	<?=n_row_12()?>	 
		<?=$this->load->view("menu");?>				
		<div class="col-lg-10">			
			<div class="tab-content">								
			    <div class="tab-pane active"  id="tab_mis_datos">
			    	 <?=$this->load->view("micuenta/cuenta");?>
			    </div>
			    <div class="tab-pane " id="tab_privacidad">
			       <?=$this->load->view("micuenta/privacidad");?>
			    </div>
			    <div class="tab-pane " id="tab_privacidad_seguridad">
			       <?=$this->load->view("micuenta/privacidad_seguridad");?>			       
			    </div>			    
			    <div class="tab-pane " id="tab_direccion">
			    	<?=$this->load->view("micuenta/direccion")?>
			    </div>
			</div>		    
		</div>         
	<?=end_row()?>	
</main>


<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>"></script>
<script type="text/javascript" src="<?=base_url('application/js/privacidad_seguridad.js')?>">
</script>
<script type="text/javascript" src="<?=base_url('application/js/sobre_el_negocio.js')?>">
</script>
<script type="text/javascript" src="<?=base_url('application/js/img.js')?>"></script>
<script type="text/javascript" src="<?=base_url('application/js/perfil_user.js')?>"></script>
<script type="text/javascript" src="../js_tema/js/direccion.js"></script>
<script type="text/javascript" src="<?= base_url('application/js/sha1.js')?>"></script>
