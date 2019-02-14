<div class="col-lg-12 ">
	<form class="form_busqueda_pedidos row" method="post">
        <div class="col-lg-3">
            <?=strong("CLIENTE")?>
            <?=input([
                "name"          => "cliente" ,
                "class"         =>  "form-control",
                "placeholder"   =>  "Nombre, correo, telefono ..."
            ])?>

        </div>
		<div class="col-lg-2">
			<?=strong("#Recibo")?>
			<?=input([
				"name"=> "recibo" , 
				"class"=>"form-control"
			])?>

			<?=input_hidden([
				"name"	=> "v" , 
				'value'	=>	1
				
			])?>		
		</div>
		


		<div class="col-lg-3">
			<?=strong("TIPO ENTREGA")?>
			
			
			<?=create_select($tipos_entregas , 
			"tipo_entrega" , 
			"tipo_entrega form-control" , 
			"tipo_entrega" , 
			"nombre" , 
			"id",
			0,
			1,
			0,
			"-" )?>
		</div>
		

		<div class="col-lg-3">
			<?=strong("STATUS")?>
			<?=create_select(
				$status_ventas , 
				"status_venta" , 
				"status_venta  form-control" , 
				"status_venta" , 
				"text_vendedor" , 
				"id_estatus_enid_service",
				0,
				1,
				0,
				"-"
			)?>
		</div>
		<div class="col-lg-3">
			<?=strong("ORDENAR")?>
			<select name="tipo_orden" class="form-control">
				<option value="1">
					FECHA REGISTRO
				</option>
                <option value="5">
                    FECHA CONTRA ENTREGA
                </option>
				<option value="2">
					FECHA ENTREGA
				</option>
				<option value="3">
					FECHA CANCELACION
				</option>
				<option value="4">
					FECHA PAGO
				</option>

            </select>
		</div>
		<div class="col-lg-6">
            <div class="row">
			    <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
            </div>
		</div>
	</form>	
	<form class="form_search" action="" method="GET">
		<?=input_hidden(["name" => "recibo" , "value"=>"" , "class" =>"numero_recibo"])?>
	</form>
	
</div>
<div class="col-lg-12 ">
	<?=place("place_pedidos")?>
</div>