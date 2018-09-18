<?=div("ÚLTIMAS EMPLEADAS " , ["class"=>"item-content-block"])?>
<?php  foreach ($catalogo as $row): ?>			
	<?=anchor_enid( $row,  
		['class' => 'tag_catalogo' , 'id' => $row , "style" => "color:white!important;"])?>	
<?php  endforeach;?>
