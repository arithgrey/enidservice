
	<?=n_row_12()?>				
			<div class="contenedor_twitter_servicios">
				<?=$this->load->view("secciones/inputs_busqueda");?>
			</div>
			<?=n_row_12()?>
				<i style="background:black!important;"
				class="fa fa-chevron-left btn btn_indicador_izquierdo_twitter input-sm " title="mover a la izquierda" ></i>
				<i style="background:black!important;"
				class="fa fa-chevron-right btn btn_indicador_derecho_twitter input-sm" title="mover a la derecha"></i>
				<?=get_btn_nuevo_mensaje($id_usuario , "twitter");?>				
			<?=end_row()?>					
	<?=end_row()?>
	<?=n_row_12()?>		
		<div class='parche_twitter'>		
		</div>			
	<?=end_row()?>