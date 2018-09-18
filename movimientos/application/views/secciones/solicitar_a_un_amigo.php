<main>
	<div class="col-lg-4 col-lg-offset-4">
		<h3 style="font-size: 2em;margin-top: 70px;">                 
           SOLICITA SALDO A UN AMIGO
        </h3>
			
			<form method="GET" action="../orden_pago_oxxo">
				<?=n_row_12()?>
					<table style="width: 100%;margin-top: 15px;">
						<tr>
							<td style="width: 90%;">
								<input type="number" name="q" 
									class="form-control input-sm input monto_a_ingresar"
									required="">
								<input type="hidden" name="q2" value="<?=$id_usuario?>">
								<input type="hidden" name="concepto" value="1">
							</td>
							<td style="width: 10%;margin-bottom: 10px!important;">
								<spa style='font-size: 2.5em;' class='strong'>
									MXN
								</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="color: black;text-decoration: underline;" >
								¿MONTO?
							</td>
						</tr>
					</table>
					<span>						
					</span>
					<center>
						<div >		
							<input 
							type="submit"
							class="a_enid_blue" 
							style="margin-top: 20px;border-radius: 10px;"
							value="Generar órden">
						</div>
					</center>
				<?=end_row()?>
			</form>
		
		
	</div>
</main>
<style type="text/css">
	.option_ingresar_saldo{
		border-style: solid;
		border-width: .5px;
		margin-top: 10px;		
		
		padding: 10px;
		background: #0054ff;
		color: white!important;


	}	
</style>
<script type="text/javascript" src="<?=base_url('application/js/solicitud_oxxo.js')?>"></script>