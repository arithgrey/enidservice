<br>
<?=div(img(
	[
		"src"=>"https://media.giphy.com/media/VTXzh4qtahZS/giphy.gif" ,
		"style" => "border-radius:100%;"
	]) ,  
	[
		"class" => "col-lg-4 col-lg-offset-4",
		"style" => "background:#011220;padding:20px;"

	],
	1)?>

<center>
	<div class="col-lg-4 col-lg-offset-4">
		<?=heading_enid("UPS AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA" , 
		2,
		["class" => "strong"])?>
		<?=anchor_enid("Explorar ahora!", 
			[
				"href"	=> "../",				
				"style" => 
				"color: #040174;text-decoration: none;font-size: 1.5em;text-decoration: underline;"
		])?>
	</div>
</center>
