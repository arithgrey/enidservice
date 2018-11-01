<?php $url = "../imgs/index.php/enid/imagen_servicio/".$id_servicio; ?>
<div class="col-lg-6 col-lg-offset-3">
	<?=n_row_12()?>
		<div>
			<center>
				<?=heading_enid("¿CÓMO PREFIERES TU ENTREGA?" , 2 , ["class" => "titulo_preferencia strong" ] )?>			
			</center>		
		</div>
	<?=end_row()?>

	<?=n_row_12()?>
		<div class="col-lg-6 col-lg-offset-3">
			<center>
				<?=img(["src" => $url])?>
			</center>		
		</div>
	<?=end_row()?>
	


</div>
<?=n_row_12()?>
	<div class="box">
    <div class="container">
     	<div class="row">
			 			 
				
				<div class="contenedor_opcion col-lg-4 col-md-4 col-sm-4 col-xs-12 cursor_pointer" 
				onclick="carga_opcion_entrega(1, <?=$id_servicio?>);">
					<div class="box-part text-center">                       
                        <?=icon('fa fa-truck fa-3x')?>                        
						<?=div(heading_enid("POR MENSAJERÍA",3) ,  ["class"=>"title"])?>
						<?=div(span("QUE LLEGUE A TU CASA U OFICINA") , ["class" => "text"])?>
					 </div>
				</div>	 
				
				<div class="contenedor_opcion col-lg-4 col-md-4 col-sm-4 col-xs-12 cursor_pointer" onclick="carga_opcion_entrega(2 , <?=$id_servicio?>);">               
					<div class="box-part text-center">                       
                        <?=icon('fa fa-map-marker fa-3x')?>  
						<?=div(heading_enid("VISÍTANOS",3) ,  ["class"=>"title"])?>
						<?=div(span("VEN POR TUS ARTÍCULOS") , ["class" => "text"])?>
					 </div>
				</div>	 
				<div class="contenedor_opcion col-lg-4 col-md-4 col-sm-4 col-xs-12 cursor_pointer" onclick="carga_opcion_entrega(3, <?=$id_servicio?>);">               
					<div class="box-part text-center">                       
                        <?=icon('fa fa-space-shuttle fa-3x')?>  
						<?=div(heading_enid("ENCONTRÉMONOS",3) ,  ["class"=>"title"])?>
						<?=div(span("ACORDEMOS UN PUNTO MEDIO") , ["class" => "text"])?>
					 </div>
				</div>	 
				


				
				
		
		</div>		
    </div>
	</div>
	<?=end_row()?>

   <?=input_hidden(["class" => "plan" , "value"=>  $plan])?>
   <?=input_hidden(["class" => "extension_dominio" , "value"=>  $extension_dominio])?>
   <?=input_hidden(["class" => "ciclo_facturacion" , "value"=>  $ciclo_facturacion])?>
   <?=input_hidden(["class" => "is_servicio" , "value"=>  $is_servicio])?>
   <?=input_hidden(["class" => "q2" , "value"=>  $q2])?>
   <?=input_hidden(["class" => "num_ciclos" , "value"=>  $num_ciclos])?>
        
