    <?=n_row_12()?>
      <div class="text-right">
          <a  class="btn_acceder_cuenta_enid a_enid_blue" 
              id="btn_acceder_cuenta_enid"
              style="color: white!important">                    
              ACCEDER AHORA
          </a>
      </div>
    <?=end_row()?>

<?=n_row_12()?>
  <div class="col-lg-4 col-lg-offset-4">
    <div class="col-lg-6 col-lg-offset-3">
      <img src="../img_tema/enid_service_logo.jpg" style="width: 100%">
    </div>
  </div>
<?=end_row()?>
<?=n_row_12()?>
<hr style="margin-top: 0px!important;margin-bottom: 0px!important;">
<?=end_row()?>

<div class="col-lg-4 col-lg-offset-4">
<?=n_row_12()?>
  <div class="row">
    <form class="form-miembro-enid-service" id='form-miembro-enid-service'>
          <div>
            <div class="col-lg-12">                      
                <div>
                <input 
                  id="" 
                  name="email" 
                  placeholder="CORREO ELECTRÓNICO" 
                  class="form-control input-sm email email"
                  type="email"
                  value="" 
                  required
                  onkeypress="minusculas(this);" >  
                </div>
                <div class="place_correo_incorrecto">        
                </div>
            </div>
            <div class="col-lg-12">        
                <div>
                <input 
                  id="" 
                  name="nombre" 
                  placeholder="TU NOMBRE" 
                  class="form-control input-sm  nombre nombre_persona"
                  type="text"
                  value="" 
                  required>  
                  <span class="place_nombre_info">              
                  </span>
                </div>
            </div>
            <div class="col-lg-12">
              
              <input 
                  id="password"             
                  placeholder="UNA CONTRASEÑA " 
                  class="form-control input-sm password"
                  type="password"
                  value="" 
                  required            
                  >  
                <div class="place_password_afiliado">            
                </div>
            </div>
            <div class="col-lg-12">
              <button 
                style="background: #0003E1!important;width: 100%;padding: 10px;color: white;">
                Registrar
              </button>
            </div>
          </div>
        
    </form>
    <?=n_row_12()?>    
      <div class="place_registro_miembro">
      </div>
    <?=end_row()?>  
  </div>
  <div>
  <h3 style="font-size: 1.7em;font-weight: bold;">      
    COMPRA Y VENDE DESDES ENID SERVICE
  </h3>
</div>
<?=end_row()?>  
</div>