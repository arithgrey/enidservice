<?php 
	$heading_1	=  	heading_enid("¿REALMENTE DESEAS CANCELAR LA COMPRA? DE:" ,	3 );
	$div 		=  	div(strtoupper($recibo["resumen"]) );
	$tmp 		= 	div($heading_1 . $div , ["class" => "padding_20"]);
?>
<?=div($tmp , ['class' => 'jumbotron' ])?>
<?=guardar("CANCELAR ÓRDEN DE COMPRA" , 
	[
		"class"				=>		"cancelar_orden_compra" ,
		"id"				=>		$recibo['id_recibo'] ,
		"modalidad"			=>		$modalidad 
	], 
	1,
	1)?>
