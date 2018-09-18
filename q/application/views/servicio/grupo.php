<ul class="nav nav-tabs">
  	<li class="active">
  		<?=anchor_enid("Grupos" ,  ["href"=>"#home", "data-toggle"=>"tab"] )?>
  	</li>
  	<li>
  		<?=anchor_enid("+ Nuevo grupo de servicios" ,  ['class'=> 'nuevo_grupo_servicios'] )?>  
	</li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="home">    
    <?=create_select($info_grupos , 
		"grupo" , 
		"form-control grupo" , 
		"grupo" , 
		"grupo" ,
		"id_grupo" 
		);?>	
	<?=place('place_info_grupos')?>	
  </div>
  <div class="tab-pane fade" id="profile">
    
  </div>  
</div>