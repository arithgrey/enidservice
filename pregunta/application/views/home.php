<main>  	
	<?=n_row_12()?>
		<div class="col-lg-8 col-lg-offset-2">
			<?=$formulario_valoracion?>		
		</div>
		
	<?=end_row()?>	
	<?=n_row_12()?>

		<div class="col-lg-6 col-lg-offset-3">
			<a  href="../area_cliente?action=preguntas" 
				class="registro_pregunta" style="font-size: 1.5em; color: rgb(12, 64, 117); font-weight: bold; text-decoration-line: underline;display: none;">
					Se envió tu pregunta al vendedor! a la brevedad, este se pondrá en contacto contigo, puedes consultar tus preguntas y respuestas aquí 
			
			</a>
		</div>
	<?=end_row()?>
	<?=n_row_12()?>
		<div class="contenedor_registro" style="display: none;">
			<div class="col-lg-6 col-lg-offset-3">
				<div style="margin-top: 40px;">
					<strong>

						Accede a tu cuenta o registra tu usuario en Enid Service para hacer preguntas 
						al vendedor
					</strong>
				</div>
				<div style="margin-top: 15px;">
					<table>
						<tr>
							<td>
							<a href="../login"  class="a_enid_blue" 
								style="color: white!important">
								ACCEDER A MI CUENTA
							</a>			
							</td>
							<td>
								<a href="../login"  class="a_enid_black"
									style="color: white!important">
									REGISTRAR UNA CUENTA
								</a>
							</td>
						</tr>
					</table>
					
					
				</div>
			</div>
		</div>
	<?=end_row()?>
</main>
<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<input type="hidden" class="envio_pregunta" type="hidden" value="<?=$in_session?>">
<script type="text/javascript" src="<?=base_url()?>/application/js/principal.js"></script>