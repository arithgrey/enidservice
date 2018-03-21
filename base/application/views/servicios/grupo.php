<ul class="nav nav-tabs">
  <li class="active">
  		<a href="#home" data-toggle="tab" aria-expanded="true">Grupos</a>
	</li>
  <li class="">
  		<a class="nuevo_grupo_servicios" >
  			+ Nuevo grupo de servicios
  		</a>
	</li>
  
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="home">
    
    <br>    
    <?=n_row_12()?>
			
		<div class="row">
			<div class="col-lg-4">
				<?=create_select($info_grupos , 
				"grupo" , 
				"form-control grupo" , 
				"grupo" , 
				"grupo" ,
				"id_grupo" 
				);?>
			</div>	
		</div>
		
	<?=end_row()?>	
	<div class="place_info_grupos">		
	</div>
  </div>
  <div class="tab-pane fade" id="profile">
    okok
  </div>
  
</div>