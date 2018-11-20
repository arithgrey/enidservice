<div>
	<CENTER>
	<?=heading_enid("UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN" , 1, ["class" => "funny_error_message"])?>
	</CENTER>
	
	<?=div(
		img(["src" 	=> "../img_tema/gif/funny_error.gif"]) , 
		["class"	=>	""
	])?>

	<?=div(anchor_enid("ENCUENTRA TU ORDEN AQUÍ", 
		[
			"href" 	=>	"../pedidos" , 
			"class" => 	"busqueda_mensaje"
		]) ,
		["class" => 	"busqueda_mensaje_text"]
	)?>
	
</div>