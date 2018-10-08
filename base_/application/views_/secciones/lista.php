<?php 
	$list =  "";
	$style = "";
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
<?=div("Email encontrados".count($info_mail) , ['class' => 'text-left' , 1])?>
<table class="table_enid_service" border="1">			
	<?=$list?>			
</table>
