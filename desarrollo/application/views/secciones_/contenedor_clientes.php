							<div class="panel-heading">
				                <ul class="nav nav-tabs">
				                    <li class="active li_menu">
				                     <a style="font-size: .9em!important;" 
										href="#tab1default" 
				                        data-toggle="tab">
				                      <i class="fa fa-credit-card-alt">
				                      </i>
				                        Clientes
				                     </a>
				                 	</li>
				                </ul>
			                </div>
			                <div class="panel-body">
			                    <div class="tab-content">
			                        <div class="tab-pane fade in active" id="tab1default">
			                        	<div class='row'>
				                        	<form class='form_busqueda_clientes'  id='form_busqueda_clientes'>					
												<?=$this->load->view("secciones/inputs_busqueda")?>
											</form>				
											<br>
											<?=n_row_12()?>	
												<div class='place_info_clientes'>
												</div>		
											<?=end_row()?>										           
										</div>
			                        </div>
			                    </div>
			                </div>			       