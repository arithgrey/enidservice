<?php   
  $array_list =  [
    "- Revisa la <strong> ortografía de la palabra.</strong>",
    "- Utiliza palabras <strong>más simples o menos palabras.</strong>",
    "- Navega por categorías"
  ];  
?>
<div class="container">
	<div class="row">		
    <div class="thumbnail">                
      <div class="caption">
          <?=div(heading_enid("No hay productos que coincidan con tu búsqueda." , 3) .ul($array_list))?>
      </div>
    </div>
	</div>
</div>
