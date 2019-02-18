<?php 
	
	echo div("Resultados:" .count($info_productos));

	$z =0;
	foreach ($info_productos["info_productos"] as $row) {
		$keyword 		=  $row["keyword"];
		$num_keywords 	=  $row["num_keywords"];
	?>	
		<?php if($z == 0){?>
		       
		    <table>
		     	<tr>
		      		<?=get_td(div("Solicitudes" , 
		      				[
		      					"class"	=>	"white padding_10" ,
		      					"style"	=>	"background: #123886;"
		      				]))?>				                					


				    <?=get_td("Producto" , 
				    [
				    	"class"=>"white padding_10" , 
				    	"style"=>"background: #0093ff;"
				    ] )?>
			    </tr>
		    </table>		               
		            
		        
			<?php }?>

				
		    <table>
		     <tr>
		      <?=get_td(span($num_keywords , 
		      	["class"=>"blue_enid_background white padding_10"]))?>
		                		
		      	<?=get_td(span($keyword ,  
		                			[
		                				"class"=>"white padding_10", 
		                				"style"=>"background: #0093ff;"]
		            ))?>
			    </tr>
		    </table>		                			            
				
		
		<?php
		$z ++;

	}
?>