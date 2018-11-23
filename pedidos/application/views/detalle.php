<br>
<div class="col-lg-10 col-lg-offset-1">
	<div class="col-lg-8">	
		<div class="encabezado_numero_orden">
			<?=div(heading_enid("# ORDEN ".$orden, 2,["class" => "strong"])	, ["class" => "numero_orden"])?>
		</div>
		<?=div(icon("fa fa-pencil") ,  
		[
			"class"	=> "text-right editar_estado",
			"id"	=> $orden
		])?>

		<?=div(crea_estado_venta($status_ventas , $recibo) , 1)?>

		
		<div class="selector_estados_ventas top_20 bottom_20">
			<?=div(strong("STATUS DE LA COMPRA"))?>
			<?=create_select(
				$status_ventas , 
				"status_venta" , 
				"status_venta form-control " , 
				"status_venta" ,
				"text_vendedor" , 
				"id_estatus_enid_service" , 
				1, 
				1 ,
				0 ,  
				"-"
			)?>
			<?=place("place_tipificaciones")?>
			<div class="form_cantidad_post_venta top_20">
				<?=div(strong("SALDO CUBIERTO") ,1)?>
				<div class="row">
					<?=div(input(
							[
								"class" 	=>	"form-control saldo_cubierto_pos_venta",
								"id"		=> 	"saldo_cubierto_pos_venta",
								"type"		=>	"number",
								"step"		=>	"any",
								"required" 	=> 	"true",
								"name"		=> 	"saldo_cubierto",
								"value"		=> 	$recibo[0]["saldo_cubierto"]

					]), 
					["class"=> "col-lg-10"])?>
										
					<?=div("MXN" , ["class" =>"mxn col-lg-2"])?>

				</div>				
			</div>
			<?=place("mensaje_saldo_cubierto_post_venta")?>

			<form class="form_cantidad top_20">
				<?=div(strong("SALDO CUBIERTO") ,1)?>
				

				<div class="row">
					<?=div(input(
							[
								"class" 	=>	"form-control saldo_cubierto",
								"id"		=> 	"saldo_cubierto",
								"type"		=>	"number",
								"step"		=>	"any",
								"required" 	=> 	"true",
								"name"		=> 	"saldo_cubierto",
								"value"		=> 	$recibo[0]["saldo_cubierto"]

					]), 
					["class"=> "col-lg-10"])?>
					
					<?=input_hidden(
						[
							"name"	=>	"recibo",
							"class"	=>	"recibo",
							"value" => 	$orden
						])?>
					<?=div("MXN" , ["class" =>"mxn col-lg-2"])?>

				</div>
				<?=place("mensaje_saldo_cubierto")?>
				
			</form>
		</div>		
		

		<?=div("REGISTRO ". $recibo[0]["fecha_registro"]	, ["class" => "fecha_registro"] , 1)?>
		<?=div(crea_fecha_entrega($recibo))?>		
		<?=crea_seccion_productos($recibo)?>		

		
		<br>
		<br>
		<?=n_row_12()?>
			<?=create_seccion_tipificaciones($tipificaciones)?>
		<?=end_row()?>
		
	</div>
	<div class="col-lg-4">
			

		<?=div(icon("fa fa fa-pencil") , ["class" => "editar_tipo_entrega text-right"])?>
		<?=create_seccion_tipo_entrega($recibo , $tipos_entregas)?>

		<?=div(create_select(
			$tipos_entregas , 
			"tipo_entrega" , 
			"tipo_entrega form-control" , 
			"tipo_entrega" , 
			"nombre" , 
			"id" , 
			0 , 
			1 ,
			0 , 
			"-"
		),
		["class" => "form_edicion_tipo_entrega"]
	)?>

		<br>
		<?=create_seccion_usuario($usuario)?>

		<?=create_seccion_domicilio($domicilio)?>
		<?=create_seccion_recordatorios($recibo)?>
		<br>
		<?=create_fecha_contra_entrega($recibo , $domicilio)?>
		<br>
		<?=n_row_12()?>
		<div class="padding_10 resumen_pago">
			<?=create_seccion_saldos($recibo)?>
		</div>
		<?=end_row()?>

		<br>

	</div>
</div>

<?=input_hidden(
	[
		"class" => "status_venta_registro" , 
		"name" 	=> "status_venta",
		"value"	=> $recibo[0]["status"],
		"id"	=> "status_venta_registro"
])?>
<?=input_hidden(
	[
		"class" => "saldo_actual_cubierto" , 
		"name" 	=> "saldo_cubierto",
		"value"	=> $recibo[0]["saldo_cubierto"]
	])?>
<?=input_hidden(
	[
		"class" => "tipo_entrega_def" , 
		"name" 	=> "tipo_entrega",
		"value"	=> $recibo[0]["tipo_entrega"]
])?>
