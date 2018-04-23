<?php 
	
	$extra_estilos2 = "style='color:white!important; font-size:.8em!important; ' ";	
	$extra_estilos3 = "";
	$extra_estilos4 = "";
	$estilos_header_tabla = "style='background: #03153B !important;font-size:.8em!important;color:white:!important;' ";	

	$extra_estilos = "style='color:#007BE3!important; font-size:.8em!important; ' ";
	$extra_estilos_tabla_mes = "style='font-size:.8em!important;background: #0030ff;color: white;' ";

?>
<?php
	
	$l =  "";
	$clientes = 0;
	$envios_a_validar = 0;		
	$meta = 15;
	$prospectos  = 0; 

	foreach($comparativa as $row){
		
		$clientes =  $row["clientes"];
		$prospectos =  $row["prospectos"];
		$envios_a_validar = $row["envios_a_validar"];		
		$prospectos =  $row["prospectos"];
	}
	$restantes  =  $meta - $clientes;


	if ($restantes > 8 ){
		$extra_estilos3 = "style='background:red;
				color:white!important; font-size:.8em!important; ' ";
	}else{

		$extra_estilos3 = "style='background:blue;
				color:white!important; font-size:.8em!important; ' ";
	}



	if ($envios_a_validar < 60 ){
		$extra_estilos4 = "style='background:red;
				color:white!important; font-size:.8em!important; ' ";
	}else{

		$extra_estilos4 = "style='background:blue;
				color:white!important; font-size:.8em!important; ' ";
	}


?>



<span class='blue_enid_background white' 
	style='padding:5px;font-size: .8em;'>
	Resumen día
</span>
<div style='overflow:auto;'>
	<table class="table-striped table-bordered text-center" width="100%">
		
	        <tr class="white">
	        	<?=get_td("Clientes" ,  $estilos_header_tabla );?>		        
	        	<?=get_td("Contactos efectivos" ,  $estilos_header_tabla );?>		        	        
	        	<?=get_td("Meta" ,  $estilos_header_tabla );?>		        
	        	<?=get_td("Restantes" ,  $estilos_header_tabla );?>		                	
	        </tr>
	        <tr>
	        	<?=get_td($clientes ,  $extra_estilos );?>		        
	        	<?=get_td($prospectos ,  $extra_estilos);?>		        	        	
	        	<?=get_td($meta ,  $extra_estilos );?>		        
	        	<?=get_td($restantes,  $extra_estilos3 );?>		                	
	        </tr>
		
	</table>	
</div>

<br>
<br>
<span 
	class='blue_enid_background white' 
	style='padding:5px;font-size: .8em;'>
	Resumen Mensual
</span>

<div style='overflow:auto;'>
	<table class="table-striped table-bordered text-center" width="100%">		
	        <tr>
	        	<?=get_td("Fecha" ,  $extra_estilos_tabla_mes );?>		        
	        	<?=get_td("Día" ,  $extra_estilos_tabla_mes );?>		        	        	
	        	<?=get_td("Ventas" ,  $extra_estilos_tabla_mes );?>						        	
				<?=get_td("Contactos" ,  $extra_estilos_tabla_mes );?>						   
	        </tr>	                                          
			<?=get_resumen_venta_usuario($labor_venta)?>		
	</table>
</div>
