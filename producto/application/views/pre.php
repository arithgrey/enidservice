<?php 
	$url 			  = "../imgs/index.php/enid/imagen_servicio/".$id_servicio; 
	$class_contenedor = 
	($orden_pedido ==  1) ? 
	"contenedor_opcion col-lg-4 col-md-4 col-sm-4 col-xs-12 cursor_pointer":
	"contenedor_opcion col-lg-6 col-md-6 col-sm-6 col-xs-12 cursor_pointer";
?>
<div class="col-lg-6 col-lg-offset-3">
	<?=n_row_12()?>
		<div>
			<center>
				<?=heading_enid("¿CÓMO PREFIERES TU ENTREGA?" , 2 , ["class" => "titulo_preferencia strong" ] )?>			
			</center>		
		</div>
	<?=end_row()?>
</div>
<?=n_row_12()?>
	<div class="box">
    <div class="container">
     	<div class="row">
     		<div class="col-lg-8 col-lg-offset-2">
				<div class="<?=$class_contenedor?>" 
				onclick="carga_opcion_entrega(2, <?=$id_servicio?> , <?=$orden_pedido?>);">
					<div class="box-part text-center">                       
                        <?=icon('fa fa-truck fa-3x')?>                        
						<?=div(heading_enid("POR MENSAJERÍA",3) ,  ["class"=>"title"])?>
						<?=div(span("QUE LLEGUE A TU CASA U OFICINA") , ["class" => "text"])?>
					 </div>
				</div>	 
				<?php if($orden_pedido == 1):?>
					<div class="<?=$class_contenedor?>" onclick="carga_opcion_entrega(3 , <?=$id_servicio?> , <?=$orden_pedido?>);">               
						<div class="box-part text-center">                       
	                        <?=icon('fa fa-map-marker fa-3x')?>  
							<?=div(heading_enid("VISÍTANOS",3) ,  ["class"=>"title"])?>
							<?=div(span("VEN POR TUS ARTÍCULOS") , ["class" => "text"])?>
						 </div>
					</div>	 
				<?php endif;?>
				<div class="<?=$class_contenedor?>" onclick="carga_opcion_entrega(1, <?=$id_servicio?> , <?=$orden_pedido?>);">
					<div class="box-part text-center">                       
                        <?=icon('fa fa-space-shuttle fa-3x')?>  
						<?=div(heading_enid("ENCONTRÉMONOS",3) ,  ["class"=>"title"])?>
						<?=div(span("ACORDEMOS UN PUNTO MEDIO") , ["class" => "text"])?>
					 </div>
				</div>	 						
			</div>
		</div>		
    </div>
	</div>
	<?=end_row()?>

<?php if($orden_pedido ==  1):?>
	<form class="form_pre_pedido" action="../procesar/?w=1" method="POST">
	   <?=input_hidden(["class" => "plan" , "name" => "plan", "value"=>  $plan])?>
	   <?=input_hidden(["class" => "extension_dominio" ,"name" => "extension_dominio"  , "value"=>  $extension_dominio])?>
	   <?=input_hidden(["class" => "ciclo_facturacion" , "name" => "ciclo_facturacion" ,  "value"=>  $ciclo_facturacion])?>
	   <?=input_hidden(["class" => "is_servicio" ,"name" => "is_servicio" , "value"=>  $is_servicio])?>
	   <?=input_hidden(["class" => "q2" , "name" => "q2" ,  "value"=>  $q2])?>
	   <?=input_hidden(["class" => "num_ciclos" ,"name" => "num_ciclos" , "value"=>  $num_ciclos])?>
    </form>	   
   	<form class="form_pre_pedido_contact" action="../contact/?w=1" method="POST">
	   <?=input_hidden(["class" => "servicio" , "name" => "servicio", "value"=>  $plan])?>	   
	   <?=input_hidden(["class" => "num_ciclos" ,"name" => "num_ciclos" , "value"=>  $num_ciclos])?>
    </form>	
    <form class="form_pre_puntos_medios" action="../puntos_medios/?producto=<?=$plan?>" method="POST">
	   <?=input_hidden([
	   	"class" => "servicio" , 
	   	"name"  => "servicio", 
	   	"value" => $plan
	   ])?>	   
	   <?=input_hidden([
	   	"class" => "num_ciclos" ,
	   	"name" 	=> "num_ciclos" , 
	   	"value"=>  $num_ciclos
	   ])?>
    </form>	
   	
	<?=n_row_12()?>
		<div class="col-lg-6 col-lg-offset-3">
			<center>
				<?=img(["src" => $url])?>
			</center>		
		</div>
	<?=end_row()?>
<?php else:?>	
	
<?php endif;?>