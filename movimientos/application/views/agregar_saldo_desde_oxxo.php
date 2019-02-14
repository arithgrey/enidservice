<?php 
	$heading_enid_1	= 
	heading_enid(
		"AÑADE SALDO A TU CUENTA DE ENID SERVICE AL 
		REALIZAR DEPÓSITO DESDE CUALQUIER SUCURSAL OXXO", 
		3 );
	
	
	$input_0=  input([
		"type"	=>	"number" ,
		"name"	=>	"q" ,
		"class"		=>	"form-control input-sm input monto_a_ingresar",
		"required" 	=>	true]); 
	$input_1	=  input_hidden(["name"	=>  "q2" ,          "value"=>   $id_usuario ]);
	$input_2	=  input_hidden(["name"	=>  "concepto" ,    "value"=>   "1"]);
	$input_3	=  input_hidden(["name"	=>  "q3" ,          "value"=>   $id_usuario]);
	
?>
<?=n_row_12()?>
	<div class='contenedor_principal_enid'>
		<div class="col-lg-4 col-lg-offset-4">
			<?=$heading_enid_1?>
			<form method="GET" action="../orden_pago_oxxo">
				<?=$input_0?>
				<?=$input_1?>		
				<?=$input_3?>		
				<table>
					<tr>
						<?=get_td($input_2)?>
						<?=get_td(heading_enid("MXN" , 2 ))?>						
					</tr>
					<tr>
						<?=get_td("¿MONTO QUÉ DESEAS INGRESAR A TU SALDO ENID SERVICE?" ,
							[
								"colspan"	=>	"2" ,
								"class"		=> 	"underline"
							]
					)?>						
					</tr>
				</table>
				<?=guardar("Generar órden")?>
			</form>				
		</div>
	</div>
<?=end_row()?>