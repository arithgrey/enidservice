	<?=n_row_12()?>				
			<div class="contenedor_fb_servicios">				
				<?=$this->load->view("secciones/inputs_busqueda");?>
			</div>
			<?=n_row_12()?>
				<i 
				style="background:black!important;"
				class="fa fa-chevron-left btn input-sm btn_indicador_izquierdo_fb"  
				title="mover a la izquierda">
				
				<i 
				title="mover a la derecha"
				style="background:black!important;"
				class="fa fa-chevron-right btn input-sm btn_indicador_derecho_fb" >
				
				<?=get_btn_nuevo_mensaje($id_usuario , "fb");?>				
			<?=end_row()?>				
	<?=end_row()?>
	<?=n_row_12()?>						
		<div class='parche_fb'>	
		</div>			
	<?=end_row()?>

