<?php if (count($lista_productos)>0): ?>
	<?=n_row_12()?>
		<div style="margin-top: 30px;">
			<center>
				<h3 
					style="font-size: 2em;" 
					class="black" >							
					TAMBIÉN PODRÍA INTERESARTE
				</h3>
			</center>
		</div>
	<?=end_row()?>
<?php endif; ?>

<div style="margin-top: 20px;"></div>
<?=n_row_12()?>

	<table style="width: 100%">
		<tr>		
			<?php

				$list ="";  
				$flag =0;    
			 	foreach($lista_productos as $row){		                  
			 		echo "<td style='width:250px!important;'>";
					echo $row;
					$flag ++;
					echo "</td>";
					
				}?>
			
		</tr>
	</table>
<?end_row()?>