							<div class="panel-heading">
			                        <ul class="nav nav-tabs">
			                            <li class="active">
			                            	<a 
			                            	style="font-size: .9em!important;"
			                            	href="#tab1default_en_agenda" data-toggle="tab">
			                            		<i class="icon-mobile contact">
                								</i>								
                								Seguimiento 
                								<span class='place_num_agendados'>
                        						</span>
			                            	</a>
			                        	</li>
			                            <li class='btn_correos_por_enviar'>
			                            	<a 
			                            	style="font-size: .9em!important;"
			                            	href="#tab2default_en_agenda" 
			                            		data-toggle="tab">		                            
			                            		<i class="fa fa-envelope-o" >
			                            		</i>
			                            		Correos por enviar
			                            		<span class='place_numero_agendados_email'>    
			                            		</span>
			                            	</a>
			                        	</li>			                            
			                        </ul>
			                </div>
			                <div class="panel-body">
			                    <div class="tab-content">
			                        <div class="tab-pane fade in active" id="tab1default_en_agenda">

			                        	<div class='row'>				                        	
			                        			<form 
												style='display:none;'
												class='form_busqueda_agendados' 
												id='form_busqueda_agendados'>			        
												<input name="id_usuario" type='hidden'  value='<?=$id_usuario;?>'>              
													<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>				
												</form>                      			                        				                	
												<?=n_row_12()?>
													<div class='place_info_agendados'>
													</div>				    
												<?=end_row()?>		            
										</div>

			                        </div>
			                        <div class="tab-pane fade" id="tab2default_en_agenda">			                        				                        	
										<div class='place_info_correos_agendados'>
										</div>
			                        </div>			                        
			                    </div>
			                </div>			      