<?=construye_header_modal("modal_llamada_efectuada"  , "Marcar llamada hecha")?>

	<form class='form_llamada_confirmada'>
		<button class='btn'>
			<i class="fa fa-check" aria-hidden="true">
			</i>
			Confirmar llamada hecha! 
		</button>
	</form>
	<div class='place_llamada_hecha'> 
	</div>

<?=construye_footer_modal();?>



<?=construye_header_modal("modal_correo_enviado"  , "Marcar correo enviado")?>

	<form class='form_correo_enviado'>
		<button class='btn'>
			<i class="fa fa-check" aria-hidden="true">
			</i>
			Marcar como email enviado!
		</button>
	</form>
	<div class='place_correo_envio'> 
	</div>

<?=construye_footer_modal();?>
