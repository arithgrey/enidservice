
	<?=n_row_12()?>		
		<div class="contenedor_whatsapp_servicios">
			<?=$this->load->view("secciones/inputs_busqueda");?>
		</div>		
		<?=n_row_12()?>
			<i style="background:black!important;"
				class="fa fa-chevron-left input-sm btn btn_indicador_izquierdo_whatsapp" 
				title="mover a la izquierda">					
			get_titulo_modalidad
			<i 	
				title="mover a la derecha"
				style="background:black!important;"
				class="fa fa-chevron-right btn input-sm btn_indicador_derecho_whatsapp" >					
			get_titulo_modalidad
			<?=get_btn_nuevo_mensaje($id_usuario , "email");?>				
		<?=end_row()?>				
	<?=end_row()?>
	<?=n_row_12()?>			
		<div class='parche_email'>		
		</div>
	<?=end_row()?>
