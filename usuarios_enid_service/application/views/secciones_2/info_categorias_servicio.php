<?=n_row_12()?>                    
	<div class="col-lg-7">
			
		<form class="form-horizontal form_categoria" id="form_categoria">
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">¿ES SERVICIO?</label>
		  <div class="col-md-8">
		    <select id="servicio" name="servicio" class="form-control servicio">
		      <option value="0">NO</option>
		      <option value="1">SI</option>
		    </select>
		  </div>
		</div>

		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">
		  		CATEGORÍA
		  </label>  
		  <div class="col-md-8">
		  <input 
			  id="textinput" 
			  name="clasificacion" 
			  placeholder="CATEGORÍA" 
			  class="form-control input-md clasificacion" 
			  required="" type="text">	
		  </div>
		</div>
		<div class="form-group">
			<div class="col-lg-4">				
			</div>
			<div class="col-lg-8">				
		    	<button  class="a_enid_blue add_categoria">
		    		SIGUIENTE
				</button>
			</div>	
			<center>
				<div class="msj_existencia"></div>	  
			</center>
		</div>		
		</form>
		<?=n_row_12()?>
			<table>
				<?=get_td("<div class='primer_nivel'></div>")?>
				<?=get_td("<div class='segundo_nivel'></div>")?>
				<?=get_td("<div class='tercer_nivel'></div>")?>
				<?=get_td("<div class='cuarto_nivel'></div>")?>
				<?=get_td("<div class='quinto_nivel'></div>")?>				
			</table>
		<?=end_row()?>
	</div>
	<div class="col-lg-5">
		<h3 class="font-weight: bold;font-size: 3em;">
			CATEGORÍAS 	EN PRODUCTOS Y SERVICIOS
		</h3>
	</div>
<?=end_row()?>
