<?php
	$b = 0;
	$imagenes =  ""; 
	foreach ($imgs as $row) {
		$imagenes .= create_icon_img($row , $b , $b );
		$imagenes .=  "<hr>";
		$b  ++;
	}
?>

<?=$imagenes?>