
	<?=n_row_12()?>		
		<div class="contenedor_tumblr_servicios">
			<?=$this->load->view("secciones/inputs_busqueda");?>
		</div>		
		<?=n_row_12()?>
			<i style="background:black!important;"
				class="fa fa-chevron-left input-sm btn btn_indicador_izquierdo_tumblr" 
				title="mover a la izquierda">					
			</i>
			<i 	
				title="mover a la derecha"
				style="background:black!important;"
				class="fa fa-chevron-right btn input-sm btn_indicador_derecho_tumblr" >					
			</i>
			<?=get_btn_nuevo_mensaje($id_usuario , "tumblr");?>				
		<?=end_row()?>				
	<?=end_row()?>
	<?=n_row_12()?>			
		<div class='parche_tumblr'>		
		</div>
	<?=end_row()?>
