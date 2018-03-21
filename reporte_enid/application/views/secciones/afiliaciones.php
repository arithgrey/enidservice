		
			<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_reporte_afiliados" data-toggle="tab" style="font-size: .8em;">
								Reporte
							</a>
						</li>
						<li>
							<a href="#tab_reporte_lista_afiliados" data-toggle="tab" style="font-size: .8em;">
								Afiliados productividad
							</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_reporte_afiliados">						
							<br>
							<?=n_row_12()?>
							<div class='row'>
								<form class='form_busqueda_afiliacion'>         
									<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
								</form>
							</div>
							<?=end_row()?>
							<br>
							<?=n_row_12()?>                
								<div class='place_repo_afiliacion'>                      
								</div>                    
							<?=end_row()?> 
						</div>
						<div class="tab-pane" id="tab_reporte_lista_afiliados">
							<?=n_row_12()?>
							<div class='row'>
								<form class='form_busqueda_afiliacion_productividad'>         
									<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
								</form>
							</div>
							<?=end_row()?>
							<br>
							<?=n_row_12()?>                
								<div class='place_repo_afiliacion_productividad'>                      
								</div>                    
							<?=end_row()?>


						</div>
						
					</div>
				</div>
			</div>

		
