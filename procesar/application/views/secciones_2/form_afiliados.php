<?php

  $info_ext =  $info_solicitud_extra;
  $plan = $info_ext["plan"];
  $num_ciclos = $info_ext["num_ciclos"];
  $ciclo_facturacion = $info_ext["ciclo_facturacion"];

?>
<?=n_row_12()?>

<?php if($in_session == 0){?>
<div class="row">
  <h2 class="black">
     <a class="blue_enid" href="../login">
      INGRESA 
     </a> O CREA UNA CUENTA PARA RECIBIR ASISTENCIA Y COMPRAR AL MOMENTO
  </h2>
</div> 
<?php }?>
<div class="row">
<form 
  class="form-miembro-enid-service" 
  id="form-miembro-enid-service">
    <input type="hidden" name="usuario_referencia" value="<?=$q2?>" class='q2'>
    <input type="hidden" name="plan" class="plan"  value="<?=$plan;?>">
    <input type="hidden" name="num_ciclos" class="num_ciclos"  value="<?=$num_ciclos;?>">
    <input type="hidden" name="ciclo_facturacion" class="ciclo_facturacion"  
    value="<?=$ciclo_facturacion;?>">
  
    <?php if($in_session == 0){?>
    <div class="row">
      <div class=" col-lg-6">        
          <span style="text-transform: uppercase;">
              Nombre 
              <span style="color: red;">
                *
              </span>
          </span>  
          <div>
          <input 
            id="" 
            name="nombre" 
            placeholder="Nombre" 
            class=" input-sm  nombre"
            type="text"
            value="" 
            required            
            >  
          </div>          
        </div>

        <div class=" col-lg-6">        
            <span style="text-transform: uppercase;">
                Correo Electrónico
                <span style="color: red;">
                  *
                </span>
            </span>  
            <div>
            <input 
              id="" 
              name="email" 
              placeholder="email" 
              class=" input-sm email"
              type="email"
              value=""
              onkeypress="minusculas(this);" 
              required            
              >  
            </div>
            <div class="place_correo_incorrecto">        
            </div>
        </div>
      </div>
      <div class="">
        <span style="text-transform: uppercase;">
            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            Escribe una contraseña
        </span> 
        <input 
            id="password"                         
            class=" input-sm password"
            type="password"
            value="" 
            required>              
          <div class="place_password_afiliado">            
          </div>
      </div>
      

      <div class="">
        <span style="text-transform: uppercase;">
            <i class="fa fa-phone" aria-hidden="true"></i>
            Teléfono 
            <span style="color: red;">
                *
            </span>
        </span> 
        <input 
            id="telefono"                         
            class="telefono input-sm form-control"            
            type="tel" 
            name="telefono"             
            required>  

          <div class="place_telefono">            
          </div>
      </div>

        <div class="">
            <button class="btn input-sm">
              Crear una cuenta
            </button>
        </div>
        <div>
          <a href="../login" class="blue_enid_background white" style="padding: 5px;color: white!important">
            ¿Ya tienes una cuenta? Entra aquí ya »
          </a>
        </div>
      </div>
    </div>
  
    <div class="place_config_usuario">      
    </div>
    <?php }?>
      
     
</form>

<?=n_row_12()?>
  <div class="place_registro_afiliado">
  </div>
<?=end_row()?>

</div>