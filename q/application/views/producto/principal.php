<?php 
	
	echo "<div> Resultados: " .count($info_productos) ."</div>";

	$z =0;
	foreach ($info_productos["info_productos"] as $row) {
		$keyword =  $row["keyword"];
		$num_keywords =  $row["num_keywords"];


		?>	

			<?php if($z == 0){?>
			
			<div class="row">
		    	<ul>
		            <li>		                
		                <table>
		                	<tr>
		                		<?=get_td(
		                			div("Solicitudes" , 
		                				[
		                					"class"	=>	"white padding_10" ,
		                					"style"	=>	"background: #123886;"
		                				]))?>				                						                	
				                <?=get_td("Producto" , 
				                ["class"=>"white padding_10" , "style"=>"background: #0093ff;"] )?>
			                </tr>
		                </table>		               
		            </li>		                
		        </ul>
			</div>				
			<?php }?>

				<div class="row" style="background: #f6f6f6;">
		    	    <ul>
		                <li>		                
		                <table >
		                	<tr>
		                		<?=get_td(span($num_keywords , 
		                			["class"=>"blue_enid_background white padding_10"]))?>
		                		<?=get_td("|")?>
		                		<?=get_td(span($keyword ,  
		                			[
		                				"class"=>"white padding_10", 
		                				"style"=>"background: #0093ff;"]
		                		))?>
			                </tr>
		                </table>		                	
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