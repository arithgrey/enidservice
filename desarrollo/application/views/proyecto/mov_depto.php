<div class='row'>
	<div class='col-lg-12'>
		<div style='background:#007BE3!important;'>                    
		    <h3 class='white'>
		       <i class="fa fa-money" aria-hidden="true">
	            </i>
		        Mover ticket a 
		    </h3>
		</div>           
	</div>
	<div class='col-lg-12'>                    						    
		<div class="panel">		            			                
		    <div class="panel-body">		       
		    	

		    	<div class="col-lg-6  col-lg-offset-3">
		    		<form class="form_mover_ticket_depto">
				    	
				    	<label>
				    		Mover tikect a 
				    	</label>

				    	<?=create_select(
				    		$departamentos , 
				    		"depto" , 
				    		"form-control input-sm" , 
				    		"depto" , 
				    		"nombre" , 
				    		"id_departamento" );?>

				    	<button class="btn input-sm">
				    		Mover
				    	</button>	

			    	</form>
		    	</div>
		    </div>
		</div>		
	</div>
</div>
