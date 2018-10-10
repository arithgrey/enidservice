	<?=heading("Productividad")?>
	<?=n_row_12()?>	
		<div style="background: white;padding: 5px;">
	        <ul class="nav nav-tabs">
	            <li class="active">
	            	<?=anchor_enid("Logros" , 
	            	[
	            		"href"			=>	"#tab_logros",
	            		"data-toggle"	=>	"tab"
	            	])?>		            
	           </li>
	           <li>
	           		<?=anchor_enid("Blogs", 
	           		[
	           			"href"			=>	"#tab_audiencia" ,
	           			"data-toggle"	=>	"tab"
	           		])?>		            
	           </li>
	        </ul>     
	        <div class="tab-content">            
				<div class="tab-pane fade in active" id="tab_logros" >                        	
					<?=n_row_12()?>	   								
						<form class='form_productividad_web'>
							<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						</form>
					<?=end_row()?>								
					<?=place("place_productividad_usr")?>					
				</div>
				<div class="tab-pane fade" id="tab_trafico_web">                        	
					<?=n_row_12()?>	   
						<form class='form_busqueda_trafico'>
						<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						</form>
					<?=end_row()?>
					<?=place("place_trafico_web")?>
				</div>
				<div class="tab-pane fade" id="tab_audiencia">                        	
					<?=n_row_12()?>	   											
						<form class='form_busqueda_blog'>
							<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						</form>											   
					<?=end_row()?>
					<?=place("place_repo_faq")?>
				</div>
			</div>
		</div>                        		
    <?=end_row()?>        



