<form class="form-miembro-enid-service" id='form-miembro-enid-service'>
    <?=n_row_12()?>    
      <div class="col-lg-3">        
          <label class="black">
            Email
          </label>  
          <div>
          <input 
            id="" 
            name="email" 
            placeholder="Email" 
            class="form-control input-sm email"
            type="email"
            value="" 
            required
            onkeypress="minusculas(this);"            
            >  
          </div>
          <div class="place_correo_incorrecto">        
          </div>
      </div>
      <div class="col-lg-3">        
          <label class="black">
            Nombre  
          </label>  
          <div>
          <input 
            id="" 
            name="nombre" 
            placeholder="Nombre" 
            class="form-control input-sm  nombre nombre_persona"
            type="text"
            value="" 
            required>  
            <span class="place_nombre_info">              
            </span>
          </div>
          
      </div>
      <div class="col-lg-3">        
          <label class="black">
            Teléfono
          </label>  
          <div>
          <input 
            id="" 
            name="telefono" 
            placeholder="Telefono" 
            class="form-control input-sm telefono telefono_info_contacto"
            type="tel"
            value="" 
            required            
            >  
          </div>
          <div class="place_num_tel">        
          </div>
      </div>

      <div class="col-lg-3">
        <label class="black">
            Una contraseña
        </label> 
        <input 
            id="password"             
            placeholder="Password" 
            class="form-control input-sm password"
            type="password"
            value="" 
            required            
            >  
          <div class="place_password_afiliado">            
          </div>
      </div>
      <div class="col-lg-3">
         <button class="btn input-sm" style="background: #07B99F!important;">
          Registrar
        </button>
      </div>
    <?=end_row()?>  
    <?=n_row_12()?>    
      <div class="place_config_usuario">      
      </div>
    <?=end_row()?>  
      
     
</form>

<?=n_row_12()?>    
  <div class="place_registro_afiliado">
  </div>
<?=end_row()?>  