<?=n_row_12()?>
	<div class='contenedor_principal_enid'>
		<div class="col-lg-4 col-lg-offset-4">
			<h3 style="font-size: 2em;margin-top: 70px;">      
	           SOLICITA SALDO A UN AMIGO
	        </h3>
	        <div class="desc_solicitud">
	        	Ingresa el monto y correo que solicitas a tu amigo para contar con saldo en tu cuenta.
	        </div>
				
				<form class='solicitar_saldo_amigo_form'>
					<?=n_row_12()?>
						<table style="width: 100%;margin-top: 15px;">
							<tr>
								<td style="width: 90%;">
									<input 
										placeholder="Ejemplo 200" 
										type="number" 
										name="monto" 
										class="form-control input-sm input monto_a_ingresar"
										required="">								
								</td>
								<td style="width: 10%;margin-bottom: 10px!important;">
									<spa style='' class='strong'>
										MXN
									</span>
								</td>
							</tr>
							<tr>
								<td 
									colspan="2" style="color: black;text-decoration: underline;
									font-size: 2em;">
										¿MONTO?
								</td>
							</tr>
							<tr>
								<td>
									<input 
									type="email" 
									name="email_amigo" 
									class="form-control input-sm input email_solicitud"
									placeholder="Ejemplo jmedrano@enidservice.com" 
									required>
								</td>
								<td>
									<span style='' class='strong'>
										Email
									</span>
								</td>
							</tr>
							
						</table>
						<span>						
						</span>
						<div >
							<center>
								<button class="a_enid_blue btn_solicitud_saldo" type="submit">
									SOLICITAR SALDO
								</button>
							</center>
						</div>
					<?=end_row()?>
				</form>		
				<?=n_row_12()?>
					<div class="place_solicitud_amigo">
					</div>
				<?=end_row()?>
		</div>
	</div>
<?=end_row()?>


