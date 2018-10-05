
	<?=n_row_12()?>		
		<div class="contenedor_email_servicios">
			<?=$this->load->view("secciones/inputs_busqueda");?>
		</div>		
		<?=n_row_12()?>
			<?=icon("fa fa-chevron-left input-sm btn btn_indicador_izquierdo_email black")?>
			<?=icon("fa fa-chevron-right btn input-sm btn_indicador_derecho_email black")?>			
			<?=get_btn_nuevo_mensaje($id_usuario , "email");?>				
		<?=end_row()?>				
	<?=end_row()?>
	<?=place("parche_email")?>
	