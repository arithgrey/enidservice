<div class="col-lg-12 ">
	<form class="form_busqueda_pedidos" method="post">
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
		


		<div class="col-lg-2">
			<?=strong("TIPO ENTREGA")?>
			<?=create_select($tipos_entregas , 
			"tipo_entrega" , 
			"tipo_entrega form-control" , 
			"tipo_entrega" , 
			"nombre" , 
			"id" )?>
		</div>

		<div class="col-lg-8">
			<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
		</div>
	</form>	
	<form class="form_search" action="" method="GET">
		<?=input_hidden(["name" => "recibo" , "value"=>"" , "class" =>"numero_recibo"])?>
	</form>
	
</div>
<div class="col-lg-12 ">
	<?=place("place_pedidos")?>
</div>