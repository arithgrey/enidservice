	<?=n_row_12()?>	         
		<p class="white strong" style="font-size: 3em;line-height: .8;background: black;padding: 5px;">			Productividad
	  	</p>        		
	<?=end_row()?>
	<br>
	<?=n_row_12()?>	
		<div style="background: white;padding: 5px;">
	        <ul class="nav nav-tabs">
	            <li class="active">
		            <a href="#tab_logros" data-toggle="tab" style="font-size: .8em;">
						Logros
		            </a>
	           </li>
	           <li>
		            <a href="#tab_audiencia" data-toggle="tab" style="font-size: .8em;">
						Blogs
		            </a>
	           </li>
	           <!--
	           <li class="trafico_usuario">
		            <a  href="#tab_trafico_web" data-toggle="tab" style="font-size: .8em;">
		                Tráfico
		            </a>
	           </li>                  	
	       -->
	        </ul>                
	                
	        <div class="tab-content">            
				<div class="tab-pane fade in active" id="tab_logros" >                        	
					<?=n_row_12()?>	   								
						<form class='form_productividad_web'>
							<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						</form>
					<?=end_row()?>								
					<?=n_row_12()?>	                 
						<div class="place_productividad_usr">
						</div>
					<?=end_row()?>							
				</div>
				<div class="tab-pane fade" id="tab_trafico_web">                        	
					<?=n_row_12()?>	   
						<form class='form_busqueda_trafico'>
						<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						</form>
						<?=end_row()?>
					<?=n_row_12()?>	    
						<div class='place_trafico_web'>
						</div>      	              
					<?=end_row()?>							
				</div>
				<div class="tab-pane fade" id="tab_audiencia">                        	
					<?=n_row_12()?>	   											
						<form class='form_busqueda_blog'>
							<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						</form>											   
					<?=end_row()?>
					<?=n_row_12()?>	    
						<div class='place_repo_faq'>
						</div>      	              
					<?=end_row()?>
				</div>
			</div>
		</div>                        
		
    <?=end_row()?>        



