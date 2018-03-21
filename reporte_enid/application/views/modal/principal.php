<?=construye_header_modal('miembros', "Miembros de la cuenta" );?>                           	
	<div class="place_miembros">		
	</div>
<?=construye_footer_modal()?>  

<?=construye_header_modal('info-resumen', "+ Info  del prospecto" );?>                           	
	
	<div class='info-resumen-prospecto'>
	</div>
<?=construye_footer_modal()?>  



<?=construye_header_modal('visitas_dia', "+ Info " );?>                           	
    <div style='overflow-x:hidden; height: 300px;'>
		<div class="place_visitas">		
		</div>
	</div>
	
<?=construye_footer_modal()?>  

<?=construye_header_modal('evalua_bug', "Califica inicidencia" );?>                           	
	<center>
		<div class='place_info_calificacion_incidencia'>
		</div>
	</center>
	<form  id='form-calificacion-incidencia' action="../q/index.php/api/enid/bug/format/json">
    	
    	<?=create_select_estados_incidencia("status_incidencia" , "status_incidencia")?>

    	<?=btn_registrar_cambios_enid("btn-actualiza-incidecia" , "btn-actualiza-incidecia")?>
    </form>
<?=construye_footer_modal()?>  



<?=construye_header_modal('mas_info', "+ Info " );?>                           	
	<div style='overflow-x:hidden; height: 300px;'>
		<div class='place_mas_info'>
		</div>
	</div>
<?=construye_footer_modal()?>  























<?=construye_header_modal('fijar_metas_equipo', "Metas del equipo");?>                           	
<form class="form-horizontal" id='form_metas'>
	<fieldset>	
	<legend class='blue_enid red_enid_background strong' style='padding:10px;'>
		Enid Service
	</legend>
	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="sitios_web">	  	
	  	Sitios web
	  </label>  
	  <div class="col-md-1">
	  	<input required id="sitios_web" name="accesos_sw" 

	  	 class="form-control input-md" 
	  	 type="number"
	  	  >	    
	  </div>

	  <label class="col-md-3 control-label" for="sitios_web">	  	
	  	<span class='blue_enid'>
	  		Presentados
	  	</span>
	  	<i class="fa fa-gift white" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  	<input required id="sitios_web" name="presentaciones_sw"
	  	  class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>

	  <label class="col-md-3 control-label" for="sitios_web">	  	
	  	<span class='blue_enid'>
	  		Ventas
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  
	  <div class="col-md-1">
	  	<input required id="sitios_web" name="ventas_sw"
	  	  class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>
	</div>


	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="tienda_en_linea">Tienda en linea</label>  
	  <div class="col-md-1">
	  <input required id="tienda_en_linea" name="accesos_tl"
	    class="form-control input-md" 
	  type="number"
	   >
	    
	  </div>

	  <label class="col-md-3 control-label" for="tienda_en_linea">
	  	
	  	<span class='blue_enid'>Presentados
	  	</span>
	  	<i class="fa fa-gift white" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  <input required id="tienda_en_linea" name="presentaciones_tl"
	    class="form-control input-md" 
	  type="number"
	   >
	    
	  </div>


	  <label class="col-md-3 control-label" for="tienda_en_linea">
	  	<span class='blue_enid'>
	  		Ventas
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  <input required id="tienda_en_linea" name="ventas_tl"
	    class="form-control input-md" 
	  type="number"
	   >
	    
	  </div>



	</div>

	<!-- number input-->
	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="crm">
	  	CRM
	  </label>  
	  <div class="col-md-1">
	  <input required id="crm" name="accesos_crm"  class="form-control input-md" 
	  type="number"
	   >	   
	  </div>

	  <label class="col-md-3 control-label" for="crm">
	  	
	  	<span class='blue_enid'>Presentados
	  	</span>
	  	<i class="fa fa-gift white" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  <input required id="crm" name="presentaciones_crm"
	   class="form-control input-md" 
	  type="number"
	   >	   
	  </div>

	  <label class="col-md-3 control-label" for="crm">
	  	
	  	<span class='blue_enid'>
	  		Ventas
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  <input required id="crm" name="ventas_crm"
		  class="form-control input-md" 
		  type="number"
	   >	   
	  </div>


	</div>

	<!-- number input-->
	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="adwords">
	  	Adwords
	  </label>  
	  <div class="col-md-1">
	  	<input required id="adwords" name="accesos_adwords"  class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>


	  <label class="col-md-3 control-label" for="adwords">
	  	<span class='blue_enid'>Presentados
	  	</span>
	  	<i class="fa fa-gift white" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  	<input required id="adwords" name="presentaciones_adwords"  class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>


	  <label class="col-md-3 control-label" for="adwords">
	  	<span class='blue_enid'>
	  		Ventas
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  	<input required id="adwords" name="ventas_adwords"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>
	</div>

	   <label class="col-md-3 control-label white blue_enid_background" for="adwords">
	  	<span>
	  		blogs creados
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  



	  <div class="col-md-1">
	  	<input required id="adwords" name="blogs"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>






	  <label class="col-md-3 control-label white blue_linkeding_background" for="adwords">
	  	<span>
	  		Usuarios en Linkeding
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  
	  

	  
	  <div class="col-md-1">
	  	<input required id="adwords" name="linkedin"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>




	  <label class="col-md-3 control-label white blue_linkeding_background" for="adwords">
	  	<span>
	  		Usuarios en Facebook
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  
	  
	  
	  <div class="col-md-1">
	  	<input required id="adwords" name="facebook"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>




	  <label class="col-md-3 control-label white blue_linkeding_background" for="adwords">
	  	<span>
	  		Usuarios en Twitter
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  
	  
	  
	  <div class="col-md-1">
	  	<input required id="adwords" name="twitter"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>

	  <label class="col-md-3 control-label white blue_linkeding_background" for="adwords">
	  	<span>
	  		Usuarios en Instagram
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  
	  	 
	  <div class="col-md-1">
	  	<input required id="adwords" name="instagram"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>


	  <label class="col-md-3 control-label white blue_linkeding_background" for="adwords">
	  	<span>
	  		Usuarios en Pinterest
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  
	  	 
	  <div class="col-md-1">
	  	<input required id="adwords" name="pinterest"  
	  	class="form-control input-md" 
	  	type="number"
	  	 >	    
	  </div>











	</fieldset>
	<div class='pull-right'>
		<button class='btn '>
			Registrar Metas
		</button>
	</div>
</form>
<div class='place_registro_metas'>
</div>
<br>
<hr>
<br>

<?=construye_footer_modal()?>  






<?=construye_header_modal('fijar_metas_equipo_perfil', "Fijar perfiles del día" );?>                           	
	


	<?=n_row_12()?>	
		<div class='place_tipo_negocio_actuales'>
		</div>
	<?=end_row()?>
	<br>
	<?=n_row_12()?>	
		<div class='col-lg-6 col-lg-offset-3'>
			<form class="form-horizontal" id='form_busqueda_tipo_negocio'>	
			<div class="form-group">			  
			  <div class="col-md-12">
			    <div class="input-group">
			      <span class="input-group-addon">
			      	Tipo de negocio
			      </span>
			      <input id="prependedtext" name="q" class="form-control" placeholder="Negocio" type="text">
			    </div>			    
			  </div>
			</div>
			</form>
		</div>	
	<?=end_row()?>
	<br>
	<?=n_row_12()?>
		<div class='col-lg-6 col-lg-offset-3'>
			<div class='place_perfiles_disponibles'>
			</div>
		</div>
	<?=end_row()?>

<?=construye_footer_modal()?>  