<?=n_row_12()?>		
	<div class="contenedor_whatsapp_servicios">
		<?=$this->load->view("secciones/inputs_busqueda");?>
	</div>		
	<?=n_row_12()?>
		<?=icon("fa fa-chevron-left input-sm btn btn_indicador_izquierdo_whatsapp")?>
		<?=icon("fa fa-chevron-right btn input-sm btn_indicador_derecho_whatsapp")?>						
		<?=get_btn_nuevo_mensaje($id_usuario , "email");?>				
	<?=end_row()?>				
<?=end_row()?>
<?=n_row_12()?>			
	<div class='parche_email'>		
	</div>
<?=end_row()?>
