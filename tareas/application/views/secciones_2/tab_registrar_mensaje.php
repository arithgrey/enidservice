<div>	

    
		<?=n_row_12()?>
          <div class="row">            
              <p class="white strong" 
                style="
                line-height: .8;
                background: black;padding: 5px;">                                        
                + Agregar promoción en 
	            <span class="place_mensaje_mensaje_social">                	
	            </span>
              </p>            
              
          </div>
        <?=end_row()?>
        
		<form class='mensaje_red_social' id='mensaje_red_social'
			  action="../base/index.php/api/mensaje/red_social/format/json/">
			<?=n_row_12()?>
				<div class="contenedor_modal_mensaje row">						
					
					<div class="col-lg-8 contenedor_clasificacion">						
						<div class="row">
							<div class="form-group">
							  <span class="col-lg-3" style="font-size: .9em;color: white!important;">
							  	¿<span class="text_info_modalidad">Producto</span>?
							  </span>  
							  <div class="col-lg-9">
							  <input 
							  		id="Producto" 
							  		name="nombre_producto" 
							  		placeholder="Artículo ó servicio" 
							  		class="form-control input-sm nombre_producto" 
							  		type="text"
							  		autocomplete="off">						    
							  </div>
							</div>					
						</div>

						
					</div>
					<div class="col-lg-4">
						<div class="contenedor_opciones">
							<div class="place_busqueda_nombre_servicio">							
							</div>		
						</div>
					</div>
				</div>		
			<?=end_row()?>										
				<input name='id_mensaje' class='form-control id_mensaje'  type='hidden' value="0">
				<span class="white" >
					Promoción
				</span>
				<div class="summernote">
					-
				</div>	
				<div>
					<span class="place_notificacion_mensaje">
					</span>
				</div>
				<button class='btn' style="background: black!important;">
					Registrar
				</button>	

			<?=n_row_12()?>															
				<div class='place_mensaje_red_social'>
				</div>
			<?=end_row()?>
		</form>

</div>	
	
	


       
  


	<style type="text/css">
		.contenedor_opciones{
			height: 20px;
			overflow-y: auto;
		}
	</style>