<?=n_row_12()?>
	<h2 class="texto_ventas_titulo">
		TUS ARTÍCULOS EN VENTA
	</h2>
<?=end_row()?>
<hr>
<?=n_row_12()?>
	<div class="contenedor_busqueda">
		<div>
			<label class="col-md-4">		  	
				<div class="row">
			  	BUSCAR ENTRE TUS ARTÍCULOS
			  	</div>	
			</label>  
			<div class="col-md-4">
					<select class="form-control" name="orden"
					id="orden">
                        <?php $a=1; foreach($list_orden as $row):?>
                            <option value="<?=$a?>">
                                <?=$row?>
                            </option>
                        <?php $a ++ ;endforeach;?>
                    </select>
			</div>
		  <div class="col-md-4">
		  	<div class="row">
			  	<input 
			  	id="textinput" 
			  	name="textinput" 
			  	placeholder="Nombre de tu producto o servicio" 
			  	class="form-control input-sm q_emp" 
			  	onkeyup="onkeyup_colfield_check(event);"
			  	type="text">	  
		  	</div>
		  </div>
		</div>
	</div>
<?=end_row()?>
<?=n_row_12()?>
		<div class="place_servicios">
		</div>	
<?=end_row()?>