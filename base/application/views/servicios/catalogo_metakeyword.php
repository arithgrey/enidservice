<div class="item-content-block">
    <div class="block-title">
    	<strong>
    		ÚLTIMAS EMPLEADAS 
    	</strong>	
    </div>
</div
<br>
<?php  foreach ($catalogo as $row): ?>			
	<?=anchor_enid( $row,  array('class' => 'tag_catalogo' , 'id' => $row , 
	"style" => "color:white!important;"))?>	
<?php  endforeach;?>
