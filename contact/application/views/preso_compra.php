<br><br>
<div class="col-lg-10 col-lg-offset-1">
	<center>
		<?=heading_enid("Recibe nuestra ubicación" , 2 ,[ "class" => "strong" ])?>
		<?=div("¿Donde quieres recibir la información?" ,["class" => "text_selector"])?>
	</center>
	
</div>
<div class="col-lg-10 col-lg-offset-1">	
	<div class="contenedor_eleccion">
		<?=div(icon("fa fa-envelope-o")." CORREO" 	, 	["class" => "easy_select_enid cursor_pointer selector" , 
			"id" => 1 ])?>
		<?=div(icon("fa fa-whatsapp")." WHATSAPP" 	,	["class" => "easy_select_enid cursor_pointer selector"
			, 	
			"id" => 2])?>
	</div>		
</div>
<div class="contenedor_eleccion_correo_electronico">
	<div class="col-lg-6 col-lg-offset-3">	
		<div class="contendor_in_correo top_20">
			<form class="form-horizontal form_correo">			
				<div class="form-group">				  	
						<?=label(" NOMBRE "   , ["class" =>	"col-lg-4 control-label"])?>  
						<div class="col-lg-8">
						  	<?=input([
						  			"id"  			=>	"nombre" ,
						  			"name" 			=>	"nombre" ,
						  			"type"			=>	"text" ,
						  			"placeholder"	=>	"Tu nombre ",
						  			"class"			=>	"form-control input-md nombre"
						  		])?>				  							  
					  	</div>
						<?=label(icon("fa fa-envelope-o") ." CORREO "   , ["class" =>	"col-lg-4 control-label"])?>  
					  	<div class="col-lg-8">
						  	<?=input([
						  			"id"  			=>	"correo" ,
						  			"name" 			=>	"email" ,
						  			"type"			=>	"email" ,
						  			"placeholder"	=>	"@",
						  			"class"			=>	"form-control input-md correo_electronico"
						  		])?>				  		
					  	<?=span("INGRESA TU EMAIL  PARA RECIBIR NUESTRA UBICACIÓN")?>
					  </div>
					  <br>
					  <?=guardar("RECIBIR  UBICACIÓN" ,["class" =>"top_20"])?>
				</div>
				
			</form>
		</div>
	</div>
</div>
<div class="contenedor_eleccion_whatsapp">
	<div class="col-lg-6 col-lg-offset-3">	
		<div class="contendor_in_correo top_20">
			<form class="form-horizontal form_whatsapp">			
				<div class="form-group">				  	
					<?=label(" NOMBRE "   , ["class" =>	"col-lg-4 control-label"])?>  
						<div class="col-lg-8">
						  	<?=input([
						  			"id"  			=>	"nombre" ,
						  			"name" 			=>	"nombre" ,
						  			"type"			=>	"text" ,
						  			"placeholder"	=>	"Tu nombre ",
						  			"class"			=>	"form-control input-md nombre_whatsapp"
						  		])?>				  							  
					  	</div>
					<?=label(icon(".fa fa-whatsapp")." WHATSAPP" , ["class" =>	"col-lg-4 control-label"])?>  
					  <div class="col-lg-8">
					  	<?=input([
					  			"id"  			=>	"whatsapp" ,
					  			"name" 			=>	"whatsapp" ,
					  			"type"			=>	"tel" ,					  			
					  			"class"			=>	"form-control input-md tel "
					  		])?>				  		
					  	<?=span("INGRESA TU WHATSAPP PARA RECIBIR NUESTRA UBICACIÓN")?>
					  </div>
					  <?=guardar("RECIBIR  UBICACIÓN" ,["class" =>"top_20"])?>
				</div>				
			</form>
		</div>
	</div>
</div>