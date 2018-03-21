<div>
    
			
			<h3 class="blue_enid_background white">
				Agregar término
			</h3>

			<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_default_1" data-toggle="tab">
								AGREGAR NUEVO
							</a>
						</li>
						<li>
							<a href="#tab_default_2" data-toggle="tab">
								ELEGIR DE LA LISTA
							</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_default_1">
							
							<form class="form_termino_servicio">								
								<div>
									<span class="strong">
										Término
									</span>
								</div>
								<div>								    								   <input type="text" name="termino" class='input-sm'>					
								</div>
								<button class="btn input-sm">
									Agregar 
								</button>
							</form>
						</div>
						<div class="tab-pane" id="tab_default_2">

							<br>
							<form class='form_busqueda_termino'>
							    <label for="inputsm">
							    	Búsqueda
								</label>
							    <input class="form-control input-sm"  name ="q" id="inputsm" type="text">
							</form>							
							<div style="overflow: auto;">
								<div class="lista_terminos_actuales">
									<?=get_lista_terminos($terminos_servicio)?>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>

		
		
	
</div>

<br>
<br>