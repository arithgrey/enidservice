<?php 
	$heading_1	=  heading_enid("¿REALMENTE DESEAS CANCELAR LA COMPRA? DE:" ,	3 , [] , 1);
	$div 		=  div(strtoupper($recibo["resumen"]) , ["class"=>"blue_enid"]);
	$tmp 		= 	$heading_1. $div;
?>
<?=div($tmp , ['class' => 'jumbotron',  "style"=>"padding: 10px;" ])?>
<?=guardar("CANCELAR ÓRDEN DE COMPRA" , 
	[
	"class"			=>		"cancelar_orden_compra" 
	,"id"			=>		$recibo['id_recibo'] 
	,"modalidad"		=>	$modalidad 
	] , 1)?>
