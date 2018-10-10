<?=n_row_12()?>					
	<div class="contenedor_linkedin_servicios">
		<?=$this->load->view("secciones/inputs_busqueda");?>
	</div>		
	<?=n_row_12()?>
		<?=icon("fa fa-chevron-left btn input-sm btn_indicador_izquierdo_linkedin")?>
		<?=icon("fa fa-chevron-right btn input-sm btn_indicador_derecho_linkedin")?>
		<?=get_btn_nuevo_mensaje($id_usuario , "linkedin");?>			
	<?=end_row()?>		
<?=end_row()?>
<?=place("parche_linkedin")?>
