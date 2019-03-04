<?php
$l = [
	"- Revisa la <strong> ortografía de la palabra.</strong>",
	"- Utiliza palabras <strong>más simples o menos palabras.</strong>",
	"- Navega por categorías"
];
?>
<div class="container">
	<div class="row">
		<div class="thumbnail">
			<?= div(div(heading_enid("No hay productos que coincidan con tu búsqueda.", 3) . ul($l)), ["class" => "caption"]) ?>
		</div>
	</div>
</div>
