		<?=n_row_12()?>    						
			<div class="col-lg-8 col-lg-2-offset">
					 <label class="col-md-2 control-label" >
					  <i class="fa fa-search">
					  </i>
						  	Ticket
				</label>  
				<div class="col-lg-4">
					<input name="q" class="input-sm q" type="text">
				</div>
				<div class="col-lg-4">
					<div class="contenedor_deptos">
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
	        </div>			
		<?=end_row()?>    
		<?=n_row_12()?>    
			<div class='place_proyectos'>
			</div>
			<div class='place_tickets'>
			</div>
		<?=end_row()?>    
	