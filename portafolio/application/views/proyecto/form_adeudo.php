<br>	
<?php
	
	
		$list  = "";
		$extra_estilos ="style='font-size:.8em;' ";		
		$extra_estilos_header ="style='font-size:.8em;background:black;color:white;' ";		
		$z =1;
		foreach ($info_historial_anticipos as $row){

			$fecha_registro  =  $row["fecha_registro"];		
			$id_anticipo =  $row["id_anticipo"];				
			$anticipo =  $row["anticipo"];
			$usuario_validacion =  $row["usuario_validacion"];
			$email =  $row["email"];
			$fecha_vencimiento =  $row["fecha_vencimiento"];
			$list .="<tr>";

				$list .=  get_td($z , $extra_estilos );
				$list .=  get_td($fecha_registro , $extra_estilos );
				$list .=  get_td($fecha_vencimiento , $extra_estilos );
				$list .=  get_td($anticipo."MXN" , $extra_estilos);
				$list .=  get_td($usuario_validacion , $extra_estilos);
				$list .=  get_td($email , $extra_estilos);
				

			$list .="</tr>";
			
			$z++;
		}
	/**/		



	$info_adeudo = $info_adeudo[0];
	$id_proyecto_persona =  $info_adeudo["id_proyecto_persona"];	
	$id_forma_pago =  $info_adeudo["id_forma_pago"];
	$saldo_cubierto =  $info_adeudo["saldo_cubierto"];
	$saldo_cubierto_texto =  $info_adeudo["saldo_cubierto_texto"];
	$fecha_registro =  $info_adeudo["fecha_registro"];
	$RFC =  $info_adeudo["RFC"];
	$domicilio_fiscal =  $info_adeudo["domicilio_fiscal"];
	$status =  $info_adeudo["status"];
	$razon_social =  $info_adeudo["razon_social"];
	$fecha_vencimiento =  $info_adeudo["fecha_vencimiento"];
	$id_usuario_validacion =  $info_adeudo["id_usuario_validacion"];
	$monto_a_pagar =  $info_adeudo["monto_a_pagar"];
	$id_proyecto_persona_forma_pago =  $info_adeudo["id_proyecto_persona_forma_pago"];
	$deuda = $monto_a_pagar - $saldo_cubierto;


?>


<?=n_row_12()?>
	<center>
		<div class="col-lg-11" style="background: black!important;padding: 10px;">
			<div>	
				<div>
					<form class='form_liquidacion_adeudo'>				
						<div class='col-lg-3'>
							<div>
								<label class='lb_titulo'>
									Monto total
								</label>
							</div>
							<div>
								<span class='white'>
									<?=$monto_a_pagar;?>MXN
								</span>
							</div>
						</div>

						<div class='col-lg-3'>
							<div>
								<label class='lb_titulo'>
									Saldo cubierto	
								</label>
							</div>
							<div>
								<span class='white'>
									<?=$saldo_cubierto;?>MXN
								</span>
							</div>
						</div>

						<div class='col-lg-3'>
							<div>
								<label class='lb_titulo'>
									Saldo pendiente
								</label>
							</div>			
							<div>
								<span class='white'>
									<?=$deuda?>MXN
								</span>
							</div>			
						</div>	
						<input  
							type="hidden" 
							name="id_proyecto_persona_forma_pago" 
							value='<?=$id_proyecto_persona_forma_pago?>'>


						<input 
						type="hidden" 
						name="saldo_cubierto"
						value='<?=$saldo_cubierto;?>'>	

						<div class='col-lg-3'>
							<div>
								<label class='lb_titulo'>
									Monto a liquidar
								</label>
							</div>			
							<div>
									<input 
									value="<?=$deuda?>"
									name="monto_liquidado"  
									step="any"
									type="number"
									class='form-control input-sm'>								
									<span class="white">
										MXN
									</span>
							</div>			
						</div>	

						<div class='col-lg-3'>
							<div>
								<span class='white'>
									<button 
										class="btn input-sm black" 									
										style="background: white!important;color: black!important;">
										Registrar pago	
									</button>
								</span>
							</div>			
						</div>	


					</form>
				</div>
			</div>
		</div>
	</center>
	<div class="pllace_registro_adeudo">
	</div>
<?=end_row()?>







<br>
<?=n_row_12()?>
	<div class="col-lg-8 col-lg-offset-2">
		<?=$this->load->view("../../../view_tema/header_table");?>
			<tr>
				<?=get_td("#",$extra_estilos_header)?>
				<?=get_td("Fecha anticipo",$extra_estilos_header)?>
				<?=get_td("Fecha Vencimiento",$extra_estilos_header)?>
				<?=get_td("Monto",$extra_estilos_header)?>					
				<?=get_td("Persona que valida",$extra_estilos_header)?>	
				<?=get_td("Usuario",$extra_estilos_header)?>	
			</tr>
			<?=$list;?>
		<?=$this->load->view("../../../view_tema/footer_table");?>
	</div>
<?=end_row()?>


<style type="text/css">
	.lb_titulo{
		color: white!important;
	}
</style>