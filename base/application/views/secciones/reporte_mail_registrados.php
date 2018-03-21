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
	<button class='btn' style='background:rgb(11, 136, 243);'>
		Base registrada
	</button>
	<button class='btn' style='<?=$style_btn1;?>'>
		Ayer  	<?=$ayer;?>
	</button>
	<button class='btn' style='<?=$style_btn ?>' >
		Hoy  <?=$hoy;?>
	</button>			
</div>		
			

