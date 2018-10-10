	<?=n_row_12()?>				
		<div class="contenedor_fb_servicios">				
			<?=$this->load->view("secciones/inputs_busqueda");?>
		</div>
		<?=n_row_12()?>
			<?=icon("fa fa-chevron-left btn input-sm btn_indicador_izquierdo_fb")?>
			<?=icon("fa fa-chevron-right btn input-sm btn_indicador_derecho_fb")?>
			<?=get_btn_nuevo_mensaje($id_usuario , "fb");?>				
		<?=end_row()?>				
	<?=end_row()?>
	<?=place("parche_fb")?>
		

