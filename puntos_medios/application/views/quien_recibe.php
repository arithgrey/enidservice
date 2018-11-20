<?php if($in_session ==  0):?>
	<div class="col-lg-10 col-lg-offset-1">
		<center>
			<?=heading_enid("¿Quién recibe?" , 2 ,[ "class" => "strong" ])?>
		</center>	
	</div>

	<div class="contenedor_eleccion_correo_electronico">
		<div class="col-lg-6 col-lg-offset-3">	
			<div class="contendor_in_correo top_20">
				<form class="form-horizontal form_punto_encuentro">			
					<div class="form-group">				  	
							<?=label(" NOMBRE "   , ["class" =>	"col-lg-4 control-label"])?>  
							<div class="col-lg-8">
							  	<?=input([
							  			"id"  			=>	"nombre" ,
							  			"name" 			=>	"nombre" ,
							  			"type"			=>	"text" ,
							  			"placeholder"	=>	"Persona que recibe",
							  			"class"			=>	"form-control input-md nombre",
							  			"required" 		=>  true
							  		])?>				  							  
						  	</div>
							<?=label(icon("fa fa-envelope-o") ." CORREO "   , ["class" =>	"col-lg-4 control-label"])?>  
						  	<div class="col-lg-8">
							  	<?=input([
							  			"id"  			=>	"correo" ,
							  			"name" 			=>	"email" ,
							  			"type"			=>	"email" ,
							  			"placeholder"	=>	"@",
							  			"class"			=>	"form-control input-md correo",
							  			"required" 		=>  true
							  		])?>				  							  	
						  </div>
						  <?=label(icon("fa fa-mobile") ." TELÉFONO "   , ["class" =>	"col-lg-4 control-label"])?>  
						  	<div class="col-lg-8">
							  	<?=input([
							  			"id"  			=>	"tel" ,
							  			"name" 			=>	"telefono" ,
							  			"type"			=>	"tel" ,						  			
							  			"class"			=>	"form-control input-md  telefono",
							  			"required" 		=>  true
							  		])?>				  							  	

						  	</div>
						  	<br>
						  	<br>
						  	<center>
						  		<?=heading_enid("¿En qué horario te gustaría recibir tu pedido?",
						  		4,
						  		["class" =>"strong"])?>
						  	</center>					  	
							<?=label(icon("fa fa-calendar-o") ." FECHA ",["class" =>"col-lg-4 control-label"])?>  
							  	<div class="col-lg-8">
								  	<?=input(
							        [
							            "data-date-format"  =>  "yyyy-mm-dd",
							            "name"              =>  'fecha_entrega',
							            "class"             =>  "form-control input-sm " ,
							            "type"				=>  'date',
							            "value"             =>  date("Y-m-d"),
							            "min"				=>  date("Y-m-d"),
							            "max"				=> add_date(date("Y-m-d") , 4)
							    	])?>        
						    	</div>
							  
							<?=label( icon("fa fa-clock-o") ." HORA DE ENCUENTRO", 
							  		["class" =>	"col-lg-4 control-label"]
							)?>  
							<div class="col-lg-8">
								<?=lista_horarios()?>							  	    
							</div>
						    


						  <?=input_hidden(["name" => "punto_encuentro" , "class"  =>"punto_encuentro_form" ])?>

						  <?=input_hidden(["name" => "num_ciclos" 	   , "class"  =>"num_ciclos" , "value" => $num_ciclos])?>

						
						<br>
						  	<?=guardar("CONTINUAR" ,["class" =>"top_20"])?>
						  	<?php if($in_session == 0):?>
						  		<div class="contenedor_ya_tienes_cuenta">
							  		<br>
							  		<?=heading_enid("YA TIENES UN USUARIO REGISTRADO",2,
							  		["class" => "display_none text_usuario_registrado"])?>
							  		<?=heading_enid("¿Ya tienes una cuenta? ",3 , 
							  		["class" => " text_usuario_registrado_pregunta"])?>
							  		<?php
							  		 $extra = 
									    [
									      "plan"              => $servicio, 
									      "num_ciclos"        => $num_ciclos,							      
									      "class"             => "link_acceso cursor_pointer"      
									    ];  
									    
									    echo div("ACCEDE AHORA!", $extra , 1);								    
									?>
								</div>
								<?=place("place_notificacion_punto_encuentro_registro")?>
							<?php endif;?>
					</div>
					
				</form>
			</div>
		</div>
	</div>
<?php else:?>
<div >
	<div class="col-lg-6 col-lg-offset-3">	

		<form class="form_punto_encuentro_horario">
		 	<?=heading_enid("¿En qué horario te gustaría recibir tu pedido?",
				4, 
			["class" =>"strong titulo_horario_entra"])?>				
			
			<br>  	
			<?=label(icon("fa fa-calendar-o") ." FECHA ",["class" =>"col-lg-4 control-label"])?>  
			<div class="col-lg-8">
				<?=input([
					"data-date-format"  =>  "yyyy-mm-dd",
					"name"              =>  'fecha_entrega',
					"class"             =>  "form-control input-sm " ,
					"type"				=>  'date',
					"value"             =>  date("Y-m-d"),
					"min"				=>  date("Y-m-d"),
					"max"				=> add_date(date("Y-m-d") , 4)
				])?>        
			</div>
			<?=label( icon("fa fa-clock-o") ." HORA DE ENCUENTRO", 
				["class" =>	"col-lg-4 control-label"]
									)?>  
			<div class="col-lg-8">
				<?=lista_horarios()?>							  	    
			</div>
			
			<?=input_hidden([
				"name" 		=> 	"punto_encuentro" , 
				"class"  	=>	"punto_encuentro_form" ])?>
			<?=input_hidden([
				"name" 		=> 	"servicio", 
				"class"  	=>	"servicio" , 
				"value" 	=> 	$servicio ])?>

			<?=input_hidden([
				"name" 	=> 	"num_ciclos" 	   , 
				"class" =>  "num_ciclos" , 
				"value" => 	$num_ciclos]
			)?>
			<br>
			<?=guardar("CONTINUAR" ,["class" =>"top_20"])?>
			<?=place("place_notificacion_punto_encuentro")?>
		</form>	 	
	</div>
</div>
<?php endif;?>
