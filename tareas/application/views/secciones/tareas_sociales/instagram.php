<?=n_row_12()?>		
	<div class="contenedor_instagram_servicios">
		<?=$this->load->view("secciones/inputs_busqueda");?>
	</div>		
	<?=n_row_12()?>
		<?=icon("fa fa-chevron-left input-sm btn btn_indicador_izquierdo_instagram")?>
		<?=icon("fa fa-chevron-right btn input-sm btn_indicador_derecho_instagram")?>		
		<?=get_btn_nuevo_mensaje($id_usuario , "instagram");?>				
	<?=end_row()?>				
<?=end_row()?>
<?=place("parche_instagram")?>
	