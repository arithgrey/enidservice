		<?=n_row_12()?>    						
			
				<div class="col-lg-4">
					<span>
						<i class="fa fa-search">
						</i>
						Ticket
					</span>  
				</div>
				<div class="col-lg-4">
					<input name="q" class="input-sm q" type="text">
				</div>
				<div class="col-lg-4">
					<div>
				        <?=create_select(
				            $departamentos , 
				            "depto" , 
				            "form-control input-sm depto" , 
				            "depto" , 
				            "nombre" , 
				            "id_departamento" );?>
				      	<input 
					        type="hidden" 
					        name="departamento" 
					        value="<?=$num_departamento?>"
					        id='num_departamento'
					        class='num_departamento'
					        style='display: none;'>
				   	</div>
		        </div>	        		
		<?=end_row()?>    

	
		<?=n_row_12()?>    			
			<div class='place_proyectos'>
			</div>			
		<?=end_row()?>    
		<?=n_row_12()?>    			
			<div class='place_tickets'>
			</div>
		<?=end_row()?>    