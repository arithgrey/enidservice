<?php
$l = [
    "- Revisa la <strong> ortografía de la palabra.</strong>",
    "- Utiliza palabras <strong>más simples o menos palabras.</strong>",
    "- Navega por categorías"
];
?>
<div class="container">
    <?= d(d(h("No hay productos que coincidan con tu búsqueda.", 3) . ul($l)), "caption" ) ?>
</div>
