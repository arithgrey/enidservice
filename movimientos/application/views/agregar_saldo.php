<?=n_row_12()?>
	<div class='contenedor_principal_enid'>
		<div class="col-lg-4 col-lg-offset-4">
			<?=heading_enid("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR " , 3)?>

			<a href="?q=transfer&action=7">
				<div class="option_ingresar_saldo tipo_pago">					
					<?=div("UN PAGO EN EFECTIVO EN OXXO "  ,
					[
						"class"	=>	"tipo_pago" ,
						"style"	=>	"text-decoration: underline;color: black" 
					] , 
					1 );?>					
					
					<?=div(
						"Depositas 
						saldo a tu cuenta de Enid service desde  cualquier sucursal de oxxo " ,
						["class"=>"tipo_pago_descripcion"] , 
					1)?>
				</div>
			</a>
			
			<a href="?q=transfer&action=9">
				<div class="option_ingresar_saldo">				
					<?=div("SOLICITA SALDO A UN AMIGO" ,
					[	
						"style"	=>	"text-decoration:underline;",
						"class"	=>"tipo_pago"
					] , 
					1)?>
					<?=div(
						"Pide a un amigo que te transfira saldo desde su cuenta" ,
						[
						"style"	=>	
						"text-decoration: underline;",
						"class"	=>"tipo_pago_descripcion" 
						] 
					, 
					1)?>					
				</div>
			</a>
		</div>
	</div>
<?=end_row()?>