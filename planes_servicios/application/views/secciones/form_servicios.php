		<?=n_row_12()?>
			<div class="contenedor_agregar_servicio_form">
		 		
		 			<?=n_row_12()?>
		 				<h2 class="texto_ventas_titulo">
		 					DA A CONOCER TU PRODUCTO Ó SERVICIO
		 				</h2>
		 			<?=end_row()?>
		 			<hr>
				    <form class="form_nombre_producto" id='form_nombre_producto'>                  
				    	<div class="col-lg-3 seccion_menu_tipo_servicio">
				    		<div class="row">
					    		<?=n_row_12()?>
					    			<div class="text_deseas_anunciar">
					    				¿QUÉ DESEAS ANUNCIAR?
					    			</div>
					    		<?=end_row()?>
					    		<div style="margin-top: 20px;"></div>
					    		<?=n_row_12()?>
						    		<table style="width:100%">
										<tbody>							
											<tr>
												<td>
													<a class="tipo_promocion tipo_producto" 
														id="0" style="color: blue;">
														UN PRODUCTO
													</a>
												</td>
												<td>
													<a class="tipo_promocion tipo_servicio" id="1">
														UN SERVICIO
													</a>
												</td>
											</tr>
										</tbody>
									</table>
								<?=end_row()?>					
							</div>
						</div>

						<div class="col-lg-3 seccion_menu_tipo_servicio" >	
							<div class="row">
						        <h4 class="media-heading black text_modalidad" title="¿Qué vendes?">
						        	<i class="fa fa-shopping-bag"></i>
								    Artículo
								</h4>  
						        <input 
						        	id="nombre_producto" 
						            name="nombre" 
						            placeholder="" 
						            class="input  nuevo_producto_nombre input-sm" 
						            type="text" 
						             onkeyup="transforma_mayusculas(this)"
						            required> 
					        </div>				
						</div>
						<div class="col-lg-3 contenedor_ciclo_facturacion seccion_menu_tipo_servicio" style="display: none;">
							<div class="row">
							
					         <h4 class="media-heading black">
							  Ciclo facturación
							</h4>       
				        	  <?=create_select($ciclo_facturacion ,
				        	   "ciclo" , 
				        	   "form-control ciclo_facturacion ci_facturacion" , 
				        	   "ciclo" , 
				        	   "ciclo", 
				        	   "id_ciclo_facturacion" )?>
				        	</div>
						</div>


						<div class="col-lg-3 contenedor_precio seccion_menu_tipo_servicio">			
							<div class="row">
						        <h4 class="media-heading black" 
						        	title="¿Cual es el precio de tu artículo/Servicio?">
								  <i class="fa fa-money">
								  </i>
								  Precio
								</h4>            				
					            <input 
					            id="costo" 
					            class="form-control input-sm costo precio" 
					            name="costo" required="" step="any" type="number"> 
					            <span class="extra_precio">
				 					<?=$error_registro?>
				 				</span>

							</div>		    
				      	<div class='seccion_menu_tipo_servicio row'>
					        <button class=" btn_siguiente_registrar_servicio ">
					          SIGUIENTE
					        </button>
				        </div>
				      
				    </form>		    
		  	</div>
		  	
		<?=end_row();?>
		<br><br><br><br><br>
		<?=n_row_12()?>
			<?php if($es_movil ==  0):?>
				<?php $this->load->view("secciones/categorias_web");?>
			<?php else:?>
				<?php $this->load->view("secciones/categorias_movil");?>
			<?php endif;?>
		<?=end_row();?>
