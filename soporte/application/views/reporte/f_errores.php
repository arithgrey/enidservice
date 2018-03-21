<style type="text/css">

.seccion-califica p {
  text-align: center;
}

.seccion-califica label {
  font-size: 50px;
}

input[type="radio"] {
  display: none;
}

label {
  color: #D7EDF5;
}

.clasificacion {
  direction: rtl;
  unicode-bidi: bidi-override;
}
.input-start:hover , .s-estrella:hover{
	cursor: pointer;
}
label:hover,
label:hover ~ label {
  color: #10A9FC;
}

input[type="radio"]:checked ~ label {
  color: #10A9FC;
}

.calificaciones-ocultas{
	display: none;
}
.text-mejora{
	color: #078AEA;
	font-weight: bold;
	font-size: 1.3em;
}

</style>
<div class='seccion_form_errores'>
	<div class='col-lg-6 col-md-6  col-sm-8 col-lg-offset-3  col-md-offset-3 col-sm-offset-2'>				
		<form class='form-error' id='form-error' action='<?=base_url("index.php/api/reportes/reporteincidencia/format/json/")?>'>
			<div class='enid-service-start' id='enid-service-start'>
				<?=titulo_enid("Calíficanos")?>					
				<?=n_row_12()?>
					<center>					
						<div id="contenidor-ranking" >
							 <seccion id='seccion-califica' class='seccion-califica'>
								<p class="clasificacion">
								    <input id="radio1" name="estrellas" value="5" class='input-start' type="radio">    
								    <label title='Danos 5 estrellas ' class='s-estrella'  style='font-size:3em;' for="radio1">★</label>    
								    
								    <input id="radio2" name="estrellas" value="4"  class='input-start'  type="radio">    
								    <label title='Danos 4 estrellas ' class='s-estrella' style='font-size:3em;'  for="radio2">★</label>    

								    <input id="radio3" name="estrellas" value="3" class='input-start'  type="radio">    
								    <label title='Danos 3 estrellas ' class='s-estrella'  style='font-size:3em;'  for="radio3">★</label>    
								    
								    <input  id="radio4" name="estrellas" value="2" class='input-start'   type="radio">    
								    <label title='Danos 2 estrellas ' class='s-estrella'  style='font-size:3em;'  for="radio4">★</label>    

								    <input id="radio5" name="estrellas" value="1"  class='input-start'  type="radio">    
								    <label title='Danos 1 estrellas ' class='s-estrella'  style='font-size:3em;' for="radio5">★</label>
							  	</p>
							</seccion>
						</div>
						<div class='place_val_estrellas' id='place_val_estrellas'>
						</div>
					</center>
				<?=n_row_12()?>
			</div>
			<div class="form-group">            				

					<div class='calificaciones-ocultas'>
						<div class='col-lg-6'>						
							<?=create_select($tipos_incidencias , "tipo_incidencia", "incidencia form-control input-sm" ,  "incidencia" , "tipo_incidencia" , "idtipo_incidencia" )?>
						</div>
						<div class='col-lg-6'>												
							<?=create_select($calificaciones , "afectacion", "afectacion form-control input-sm" ,  "afectacion" , "nombre" , "idcalificacion" )?>
						</div>					
	                	<input class="form-control input-sm" value="<?=base_url()?>" name="pagina_error" id="pagina_error" type="hidden" placeholder="enidservice.com">                	
                	</div>
	            <center>
		            <span class='text-mejora'>
		               	¿Que mejorarías de Time Wallet?
					</span>
				</center>
                <div class='place_reporte_incidencia'>
                </div>
				<textarea name='descripcion' id='descripcion_incidencia' class='descripcion form-control'  rows="2" >
				</textarea>				
				<input type='hidden' name='tipo_template' value='<?=$param["tipo"]?>'>					 
             </div>
             <center>             	
             	<?=btn_registrar_cambios_enid("btn_registar" , "btn_registar")?>             	
             </center>
		</form>
	</div>
</div>

