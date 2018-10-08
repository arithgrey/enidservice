<?php 
	$ayer =  0;
	$hoy =0;
	$style_btn = "background:#FF410E;";
	$style_btn1 = "background:rgb(11, 136, 243);";
	foreach ($info_mail as $row){	

		$ayer =  $row["ayer"];	
		$hoy =  $row["hoy"];	

		
		if ($ayer< $hoy){
			$style_btn = "background:rgb(11, 136, 243);";
			
		}
	}
?>
<div class='pull-right'>
	<?=guardar("Base registrada")?>
	<?=guardar("Ayer".$ayer , ["style"	=>	$style_btn1 ])?>
	<?=guardar("Hoy".$hoy , ["style"	=>	$style_btn ])?>
</div>		
			

