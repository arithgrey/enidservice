<div class='row'>
	<div class='col-lg-12'>
		
		<div style='background:#007BE3!important;'>                    
		    <h3 class='white'>		       	
		        Agregar servicio
		    </h3>
		</div>           
		<a href="#tab_abrir_ticket" 
			data-toggle="tab" 
			class="strong  black"
			>
            <i class="fa fa-chevron-circle-left">            
            </i>
            Regresar a servicios
        </a>
        
	</div>
	<div class='col-lg-12'>                    						    
		<div class="panel">		            			                
		    <div class="panel-body">		       
		    	<?=n_row_12()?>
		    		<form class='form_q_servicios'>
				    	<div class="col-lg-4">
					    	<label>
					    		Servicio 
					    	</label>
							<?=create_select($servicios , 
							"servicio" , 
							"form-control select_tipo_negocio_servicio input-sm", 
							"selectbasic" , 
							"nombre_servicio" , 
							"id_servicio")?>   
						</div>
					</form>		    							
				<?=end_row()?>

				<?=n_row_12()?>
					<div class="col-lg-12">
						<div class='place_form_proyectos'>					
						</div>	
					</div>
				<?=end_row()?>

		    </div>
		</div>		
	</div>
</div>
