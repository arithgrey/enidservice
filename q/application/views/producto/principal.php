<?php 
	
	echo "<div> Resultados: " .count($info_productos) ."</div>";




	$z =0;
	foreach ($info_productos["info_productos"] as $row) {
		$keyword =  $row["keyword"];
		$num_keywords =  $row["num_keywords"];


		?>	

			<?php if($z == 0){?>
			
			<div class="row" style="background: #f6f6f6;">
		    	    <ul>
		                <li>
		                	<span class="strong" style="font-size: .8em;">
		                		<table >
		                			<tr>
		                				<td>
					                		<span 
					                			class="white" 
					                			style="padding: 10px;background: #123886;">
					                			Solicitudes
					                		</span> 		                	
				                		</td>
				                		
				                		<td>
				                		<span 
				                		class="white" 
				                		style="background: #0093ff;padding: 10px;" >
				                			Producto
				                		</span>
				                		</td>
			                		</tr>
		                		</table>
		                	</span>		                	
		                </li>		                
		            </ul>
				</div>				
			<?php }?>

				<div class="row" style="background: #f6f6f6;">
		    	    <ul>
		                <li>
		                	<span class="strong" style="font-size: .8em;">
		                		<table >
		                			<tr>
		                				<td>
					                		<span class="blue_enid_background white" 
					                				style="padding: 10px;">
					                			<?=$num_keywords?> 
					                		</span> 		                	
				                		</td>
				                		<td>
				                		 | 
				                		</td>
				                		<td>
				                		<span 
				                		class="white" 
				                		style="background: #0093ff;padding: 10px;" >
				                			<?=$keyword?> 
				                		</span>
				                		</td>
			                		</tr>
		                		</table>
		                	</span>		                	
		                </li>		                
		            </ul>
				</div>
		
		<?php
		$z ++;

	}
?>

<style type="text/css">
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
.nav-stacked > li + li {
    margin-top: 0px;
}

</style>