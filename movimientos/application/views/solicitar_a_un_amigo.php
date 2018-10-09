<?=n_row_12()?>
	<div class='contenedor_principal_enid'>
		<div class="col-lg-4 col-lg-offset-4">
			<?=anchor_enid("SOLICITA SALDO A UN AMIGO" ,3)?>
			<?=div(
				"Ingresa el monto y correo que solicitas a tu amigo para contar con saldo en tu cuenta." ,
				["class"=>"desc_solicitud"]
			)?>
			
	        
			<form class='solicitar_saldo_amigo_form'>
				<?=n_row_12()?>
					<table style="width: 100%;margin-top: 15px;">
						<tr>
							<?=get_td([
									"placeholder"	=>	"Ejemplo 200" ,
									"type"			=>	"number" ,
									"name"			=>	"monto" ,
									"class"			=>	"form-control input-sm input monto_a_ingresar",
									"required"		=>	true
								])?>
							<?=get_td("MXN" , ["class" => "strong top_10"])?>								
						</tr>
						<tr>
							<?=get_td("¿MONTO?" , 
								[
									"colspan"	=>	2, 
									"style"		=>	
									"color: black;text-decoration: underline;font-size: 2em;"]
								)?>							
						</tr>
						<tr>
							<?=get_td(input([

								"type"			=>	"email" ,
								"name"			=>	"email_amigo" ,
								"class"			=>	"form-control input-sm input email_solicitud",
								"placeholder"	=>	"Ejemplo jmedrano@enidservice.com" ,
								"required" 		=>	 true
							]))?>
							<?=get_td("Email" , ["class"=>'strong'])?>
						</tr>
							
						</table>
						<?=anchor_enid("SOLICITAR SALDO"  , ["class" => "btn_solicitud_saldo"] , 1,1)?>
					<?=end_row()?>
				</form>		
				<?=place("place_solicitud_amigo")?>				
		</div>
	</div>
<?=end_row()?>