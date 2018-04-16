<main>  
	<div class="contenedor_header"></div>
    <div class='contenedor_principal_area_cliente' >
	    <?=$this->load->view("secciones/menu");?>
	    <div class='col-lg-10'>
	        <div class="tab-content">            
	            <div class="tab-pane <?=valida_active_tab('compras' , $action)?>"  
	            	id='tab_mis_pagos'>
	                <?=n_row_12()?>                
	                    <div class="place_servicios_contratados"></div>
	                <?=end_row()?>
	            </div>
	            <div 
	            	class="tab-pane <?=valida_active_tab('ventas' , $action)?>" 
	            	id='tab_mis_ventas'>                
	                <?=n_row_12()?> 
	                	<div class="col-lg-9">	                		
	                    	<div class="place_ventas_usuario"></div>
	                    </div>
	                    <div class="col-lg-3">	                		
					       	<h3 style="font-size: 1.5em;" class="black strong">					
								MIS VALORACIONES Y RESEÑAS RECIBIDAS
							</h3>
							<br>
							
							<center>
					    		<?=$valoraciones;?>
					    	</center>
					    	<br>
					    	<div>	
								<center>
									<a href="../recomendacion/?q=<?=$id_usuario?>" 
									   class="a_enid_blue text-center" 
									   style="color: white!important">
										VER COMENTARIOS
									</a>
								</center>						
							</div>

							<?=n_row_12()?>
			                	<?=$alcance?>
			                <?=end_row()?>
	                    </div>

	                <?=end_row()?>

	            </div>
	            <div class="tab-pane <?=valida_active_tab('preguntas' , $action)?>" id="tab_buzon">
	            	
					<div class="contenedor_opciones_buzon">
						<h3 style="font-weight: bold;font-size: 3em;">			
							BUZÓN
						</h3>
						<p style="font-size: 1.5em;">
							TUS PREGUNTAS
						</p>
						<hr>
						<?=n_row_12()?>
							<table>
								<tr>
									<td>
										<a 	class="a_enid_black preguntas btn_preguntas_compras" 
											id='0' style="color: white!important">
											HECHAS											
											<span class="notificacion_preguntas_sin_leer_cliente">
											</span>
										</a>
										<a class="a_enid_blue preguntas btn_preguntas_ventas" 
											id="1" 
											style="color: white!important">
											RECIBIDAS
											<span class="notificacion_preguntas_sin_leer_ventas">
											</span>
										</a>
									</td>
								</tr>
							</table>
						<?=end_row()?>
					</div>
					<?=n_row_12()?>
						<div class="place_buzon"></div>
					<?=end_row()?>
	            </div>
	            <div  class="tab-pane" id="tab_pagos">
	                <div  class="place_pagar_ahora">                
	                </div> 
	            </div>
	            <div  class="tab-pane" id="tab_renovar_servicio">                
	                <div  class="place_resumen_servicio">                
	                </div> 
	            </div>
	            
	        </div>
	    </div>   

	</div> 
	<input type="hidden" class="action" value="<?=$action?>" >
</main>       

<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/proyectos_persona.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/cobranza.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/notificaciones.js')?>">
</script>    
<script type="text/javascript" src="../js_tema/js/direccion.js">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/buzon.js')?>">
</script>    
<link rel="stylesheet" type="text/css" href="../css_tema/template/css_tienda_cliente.css">
<link rel="stylesheet" type="text/css" href="../css_tema/template/valoracion.css">
<link rel="stylesheet" type="text/css" href="../css_tema/template/area_cliente.css">
<style type="text/css">
	.notificacion_preguntas_no_leida{
		background: #023263;
		padding: 5px;
	}
	.num_alcance:hover{
		cursor: pointer;
		color: blue;
	}
</style>