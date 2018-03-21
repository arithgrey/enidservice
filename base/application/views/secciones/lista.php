<?php 
	$list =  "";
	$style = "style='font-size:.8em;'";
	$z =1;
	foreach($info_mail as $row){

		$email =  $row["email"];
		
		$list .="<tr>";
			$list .= get_td($z ,$style);
			$list .= get_td($email ,$style);
		$list .="</tr>";
		$z ++;
	}
?>
<div class='text-left'>
	<label >
		Email encontrados <?=count($info_mail);?>
	</label>
</div>
<br>
<div style='height:240px; overflow-x:auto;'>
	<table class="table_enid_service" border="1">			
		<?=$list?>
	</table>
</div>