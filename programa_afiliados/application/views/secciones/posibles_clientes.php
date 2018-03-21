<?=n_row_12()?>
	<p class="white strong" style="font-size: 3em;line-height: .8;background: black;padding: 5px;">
		Sus referidos
	</p>
<?=end_row()?>
<?=n_row_12()?> 	
    	<br>
    	<div class="row">
	    	<center>
		    	<span class="strong">
		    		Su URL único para referir clientes
		    	</span>
	    	</center>	    	
	    	<div class="col-lg-6 col-lg-offset-3">
	    		<input 
	    		style="background: white;"
		    	type="form-control" 
		    	value="<?='http://'.$_SERVER['HTTP_HOST']?>/inicio/nosotros/?q=<?=$id_usuario;?>" 
		    	readonly="">
			</div>
		</div>
		<div style="margin-top: 10px;"></div>
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3">
				<center>
					<div class="col-lg-3 contenedor_metricas">
						Visitas Referidos
						<div class="row">
							<span class="num_visitas">								
							</span>
						</div>
					</div>
					<div class=" col-lg-3 contenedor_metricas">
						Miembros recomendados
						<div class="row">
							<span class="num_contactos">								
							</span>
						</div>
					</div>
					<div class=" col-lg-3 contenedor_metricas">
						Ventas por su recomendación
						<div class="row">
							<span class="num_ventas_por_recomendacion">								
							</span>
						</div>
					</div>					
					<div class=" col-lg-3 contenedor_metricas">
						Balance de comisiones
						<div class="row">
							<span class="num_efectivo">								
							</span>
						</div>
					</div>
				</center>
			</div>
		</div>
    <?=end_row()?> 

	<?=n_row_12()?>
		<span 
			href="#tab_form_persona" 
	  		data-toggle="tab"        			
	        class='strong btn agregar_posible_cliente_btn btn_referidos input-s'
	        style="background: blue!important;">            
			<i class="fa fa-plus">				
			</i>
			Agregar nuevo
		</span>
	<?=end_row()?>
<?=n_row_12()?>
	<form class='form_busqueda_posibles_clientes'  id='form_busqueda_posibles_clientes'>
		<?=$this->load->view("secciones/inputs_busqueda")?>
	</form>
<?=end_row()?>
<?=n_row_12()?>							
	<div class='place_info_posibles_clientes'>
	</div>								
<?=end_row()?>	
<style type="text/css">
	.contenedor_metricas{
		background: #0015fe;
		color: white;
		font-size: .9em;		
	}
	.num_estadísticas{
		font-size: 2em;
	}
	.num_estadisticas{
		font-weight: bold;
		font-size: 1.2em;
	}
	.num_visitas,
	.num_contactos,
	.num_efectivo,.num_ventas_por_recomendacion{

		font-weight: bold;
		font-size: 1.5em;
	}
</style>