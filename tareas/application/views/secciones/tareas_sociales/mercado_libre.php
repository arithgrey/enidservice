<?=n_row_12()?>		
	<div class="contenedor_ml_servicios">
		<?=$this->load->view("secciones/inputs_busqueda");?>
	</div>
	<?=n_row_12()?>
		<?=icon("fa fa-chevron-left btn  btn_indicador_izquierdo_ml input-sm")?>
		<?=icon("fa fa-chevron-right btn btn_indicador_derecho_ml input-sm")?>			
		<?=get_btn_nuevo_mensaje($id_usuario , "mercado_libre");?>
	<?=end_row()?>				
<?=end_row()?>
<?=place("parche_mercado_libre")?>
	