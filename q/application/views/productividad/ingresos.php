<form class="form-horizontal">
	<fieldset>	
	<legend class='white blue_background strong' style='padding:10px;'>
		Enid Service
	</legend>
	
	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="sitios_web">	  	
	  	Sitios web
	  </label>  
	  <div class="col-md-1">
	  	<input required id="sitios_web" name="accesos_sw" 
	  	value='<?=$metas["info_metas"][0]["accesos_sw"]?>'
	  	 class="form-control input-md" 
	  	  readonly="readonly"
	  	  >	    
	  </div>

	  <label class="col-md-3 control-label" for="sitios_web">	  	
	  	<span class='blue_enid'>
	  		Presentados
	  	</span>
	  	<i class="fa fa-gift white" aria-hidden="true">
	  	</i>
	  </label>  
	  <div class="col-md-1">
	  	<input required 
	  	id="sitios_web" 
	  	name="presentaciones_sw"
	  	class="form-control input-md" 
	  	value='<?=get_num_actual($metas['info_presentaciones'][0]["presentacion_sw"])?>'
	  	 readonly="readonly"
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
	  	<input 
	  	  	required id="sitios_web" 
	  	  	name="ventas_sw"
	  	  	class="form-control input-md" 
	  		 readonly="readonly"
	  		value='<?=get_num_actual($metas['info_proyecto'][0]["sw_creados"])?>'
	  	 >	    
	  </div>
	</div>


	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="tienda_en_linea">Tienda en linea</label>  
	  <div class="col-md-1">
	  <input required id="tienda_en_linea" name="accesos_tl"
	  class="form-control input-md" 
	  value='<?=$metas["info_metas"][0]["accesos_tl"]?>'
	   readonly="readonly"

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
	    value='<?=get_num_actual($metas['info_presentaciones'][0]["presentacion_tl"])?>'
	   readonly="readonly"
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
	  		  readonly="readonly"
	  		 value='<?=get_num_actual($metas['info_proyecto'][0]["tl_creados"])?>'
	   >
	    
	  </div>



	</div>

	<!-- number input-->
	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="crm">
	  	CRM
	  </label>  
	  <div class="col-md-1">
	  <input required id="crm" 
	  name="accesos_crm"  class="form-control input-md" 
	   readonly="readonly"
	  value='<?=get_num_actual($metas["info_metas"][0]["accesos_crm"]);?>'
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
	   value='<?=get_num_actual($metas['info_presentaciones'][0]["presentacion_crm"])?>'
	   readonly="readonly"
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
		   readonly="readonly"
		  value='<?=get_num_actual($metas['info_proyecto'][0]["crm_creados"])?>'
	   >	   
	  </div>


	</div>

	<!-- number input-->
	<div class="form-group">
	  <label class="col-md-3 control-label white blue_enid_background" for="adwords">
	  	Adwords
	  </label>  
	  <div class="col-md-1">
	  	<input required 
	  	id="adwords" 
	  	name="accesos_adwords"
	  	class="form-control input-md" 
	  	value='<?=$metas["info_metas"][0]["accesos_adwords"];?>'
	  	 readonly="readonly"
	  	 >	    
	  </div>


	  <label class="col-md-3 control-label" for="adwords">
	  	<span class='blue_enid'>Presentados
	  	</span>
	  	<i class="fa fa-gift white" aria-hidden="true"></i>
	  </label>  
	  <div class="col-md-1">
	  	<input 
	  	value='<?=get_num_actual($metas['info_presentaciones'][0]["presentacion_adwords"])?>'
	  	required id="adwords" name="presentaciones_adwords"  class="form-control input-md" 
	  	 readonly="readonly"

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
	  	 readonly="readonly"
	  	value='<?=get_num_actual($metas['info_proyecto'][0]["adwords_creados"])?>'
	  	 >	    
	  </div>
	</div>

	   <label class="col-md-3 control-label white blue_enid_background" for="adwords">
	  	<span>
	  		Artículos
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  


	  <div class="col-md-1">
	  	<input required id="adwords" name="blogs"  
	  	class="form-control input-md" 
	  	 readonly="readonly"
	  	value='<?=$metas["info_metas"][0]["blogs_creados"]?>'
	  	 >	    
	  </div>





	   <label class="col-md-3 control-label" for="adwords">
	  	<span class='blue_enid'>
	  		Creados
	  	</span>
	  	<i class="white fa fa-gift" aria-hidden="true">
	  	</i>
	  </label>  

	  
	  <div class="col-md-1">
	  	<input required id="adwords" name="blogs"  
	  	class="form-control input-md" 
	  	 readonly="readonly"
	  	value='<?=get_num_actual($metas["info_blogs"][0]["num_blogs"])?>'
	  	 >	    
	  </div>


	</fieldset>
	
</form>
