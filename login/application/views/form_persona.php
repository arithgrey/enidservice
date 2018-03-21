<?=n_row_12()?>
  <div>
            <div class="text-right">
                <a  class="btn_acceder_cuenta_enid a_enid_blue" 
                    id="btn_acceder_cuenta_enid"
                   
                     style="color: white!important">
                    Acceder ahora!
                </a>
            </div>
  </div>
<?=end_row()?>
<div class="col-lg-4 col-lg-offset-4">
<?=n_row_12()?>
  <table border="1">
  <tr>
    <td>
      <table width="100%">
        <tr>
            <td>
              <i class="fa fa-2x fa-user-circle"></i>
            </td>
            <td style="padding: 5px;">
              <strong>
                Paso 1:              
              </strong>
              Crea tu cuenta personal
            </td>
        </tr>
      </table>    
    </td>
    <td>
        <table width="100%">
          <tr>
              <td>
                <i class="fa fa-2x fa-shopping-cart"></i>
              </td>
              <td style="padding: 5px;">
                <strong>
                  Paso 2:              
                </strong>
                Compra o vende tus artículos o servicios
              </td>
          </tr>
        </table>
    </td>
    <td>
      <table width="100%">
          <tr>
              <td>
                <i class="fa fa-2x fa-fighter-jet"></i>
              </td>
              <td style="padding: 5px;">
                <strong>
                  Paso 3:
                </strong>          
                <br>
                Disfruta la experiencia 
              </td>
          </tr>
        </table>

      
    </td>
  </tr>
</table>

<div>
  <h3 style="font-weight: bold;font-size: 3em;">      
    COMPRA Y VENDE DESDES ENID SERVICE
  </h3>
</div>
<?=end_row()?>  
<?=n_row_12()?>
  <div >
    <form class="form-miembro-enid-service" id='form-miembro-enid-service'>
          <div>
            <div class="col-lg-12">        
                <label style='font-size:1.5em;'>
                  Email
                </label>  
                <div>
                <input 
                  id="" 
                  name="email" 
                  placeholder="Email" 
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
                <label style='font-size:1.5em;'>
                  Nombre  
                </label>  
                <div>
                <input 
                  id="" 
                  name="nombre" 
                  placeholder="Nombre" 
                  class="form-control input-sm  nombre"
                  type="text"
                  value="" 
                  required>  
                  <span class="place_nombre_info">              
                  </span>
                </div>
            </div>
            <div class="col-lg-12">
              <label style='font-size:1.5em;'>
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
            <div class="col-lg-12">
               <button class="btn input-sm" style="background: #07B99F!important;">
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
<?=end_row()?>  
</div>