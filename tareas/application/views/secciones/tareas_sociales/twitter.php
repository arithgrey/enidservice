<?=n_row_12()?>				
	<div class="contenedor_twitter_servicios">
		<?=$this->load->view("secciones/inputs_busqueda");?>
	</div>
	<?=n_row_12()?>
		<?=icon("fa fa-chevron-left btn btn_indicador_izquierdo_twitter input-sm ")?>
		<?=icon("fa fa-chevron-right btn btn_indicador_derecho_twitter input-sm")?>
		<?=get_btn_nuevo_mensaje($id_usuario , "twitter");?>				
	<?=end_row()?>					
<?=end_row()?>
<?=place("parche_twitter")?>
