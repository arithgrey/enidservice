	<div class="contenedor_nombre">
 		<div class="panel">
 			<?=n_row_12()?>
 				<h2 class="texto_ventas_titulo">
 					DA A CONOCER TU PRODUCTO Ó SERVICIO
 				</h2>
 			<?=end_row()?>
 			<hr>
		    <form class="form_nombre_producto" id='form_nombre_producto'>                  

		    	
		    	<div class="col-lg-3 seccion_menu_tipo_servicio" >
		    		<?=n_row_12()?>
		    			<span style="font-size: 1.3em;font-weight: bold;" class="a_enid_blue">
		    				¿Qué deseas anunciar?	
		    			</span>
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

				<div class="col-lg-3 seccion_menu_tipo_servicio" >					
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
				<div class="col-lg-3 contenedor_ciclo_facturacion seccion_menu_tipo_servicio" style="display: none;">
					
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


				<div class="col-lg-3 contenedor_precio seccion_menu_tipo_servicio">					  
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
				</div>		    
		      	<div class='seccion_menu_tipo_servicio'>
		        <button class="btn input-sm btn_siguiente_registrar_servicio ">
		          Siguiente
		        </button>
		        </div>
		      
		    </form>
	    </div>
  	</div>


		  <div class="contenedor_categorias" >
		  	<?=n_row_12()?>
  	        		<div style="font-weight: bold;font-size: 1.5em;">
  	        			GRUPO AL CUAL PERTENECE TU PRODUCTO 
  	        		</div>
  	       	<?=end_row();?>
  	       	<hr>
  	        <div class='contenedor_nivel_tabla'>  	        	
  	        	<?=n_row_12()?>	
              		<div class="primer_nivel_seccion">          
              		</div>
              	<?=end_row();?>
              	    
            </div>
            <div class='contenedor_nivel_tabla'>
            	<?=n_row_12()?>
  	        		<div class='place_text_nivel'>
  	        			
  	        		</div>
  	        	<?=end_row();?>
  	        	<?=n_row_12()?>
                  <div class="segundo_nivel_seccion">          
                  </div>
                <?=end_row();?>    
            </div>
            <div class='contenedor_nivel_tabla'>
            	<?=n_row_12()?>
  	        		<div class='place_text_nivel'>
  	        			
  	        		</div>
  	        	<?=end_row();?>
  	        	<?=n_row_12()?>
                  <div class="tercer_nivel_seccion">          
                  </div>
                <?=end_row();?>
            </div>
            <div class='contenedor_nivel_tabla'>
            	<?=n_row_12()?>
  	        		<div class='place_text_nivel'>
  	        			
  	        		</div>
  	        	<?=end_row();?>
  	        	<?=n_row_12()?>
                  <div class="cuarto_nivel_seccion">          
                  </div>
                <?=end_row();?>
            </div>
            <div class='contenedor_nivel_tabla'>
            	<?=n_row_12()?>
  	        		<div class='place_text_nivel'>
  	        			
  	        		</div>
  	        	<?=end_row();?>
  	        	<?=n_row_12()?>
                  <div class="quinto_nivel_seccion">          
                  </div>
                <?=end_row();?>
            </div>
            <div class='contenedor_nivel_tabla'>
            	<?=n_row_12()?>
  	        		<div class='place_text_nivel'>
  	        			
  	        		</div>
  	        	<?=end_row();?>
            	<?=n_row_12()?>
                  <div class="sexto_nivel_seccion">          
                  </div>
                <?=end_row();?>
            </div>          
		  </div>


