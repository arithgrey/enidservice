<?php
  $info_ext           =  $info_solicitud_extra;
  $plan               = $info_ext["plan"];
  $num_ciclos         = $info_ext["num_ciclos"];
  $ciclo_facturacion  = $info_ext["ciclo_facturacion"];
  $ingresar =  anchor_enid( 'INGRESA', array(                            
                            'href'  => '../login',
                            'style' => 'color:#BEF8FF!important;font-weight: bold'
                          )); 
$talla                = 
(array_key_exists("talla", $info_solicitud_extra))?$info_solicitud_extra["talla"]:0;  

?>  
<?=n_row_12()?>

<?php if($in_session == 0){?>
<?=heading_enid(
  $ingresar.' O CREA UNA CUENTA PARA RECIBIR ASISTENCIA Y COMPRAR AL MOMENTO', 2)?>
<?php }?>
<div class="row">
<form 
  class="form-miembro-enid-service" 
  id="form-miembro-enid-service">
    <input type="hidden" name="descripcion" value="">
    <input type="hidden" name="usuario_referencia" value="<?=$q2?>" class='q2'>
    <input type="hidden" name="plan" class="plan"  value="<?=$plan;?>">
    <input type="hidden" name="num_ciclos" class="num_ciclos"  value="<?=$num_ciclos;?>">
    <input type="hidden" name="ciclo_facturacion" class="ciclo_facturacion"  
    value="<?=$ciclo_facturacion;?>">
    <input type="hidden" name="talla" class="talla" value="<?=$talla;?>">

    
    <?php if($in_session == 0){?>
    <div class="row">
      <div class=" col-lg-6">        
          <?=div("Nombre *")?>
          <?=div(input([
            "name"          =>  "nombre" ,
            "placeholder"   =>  "Nombre" ,
            "class"         =>  " input-sm  nombre",
            "type"          =>  "text",            
            "required"      =>  "true"
          ]))?>        
      </div>
      <div class=" col-lg-6">        
        <?=div("Correo Electrónico  *")?>
        <?=div(input([
            "name"          =>  "email" ,
            "placeholder"   =>  "email" ,
            "class"         =>  " input-sm  email",
            "type"          =>  "email",            
            "required"      =>  "true",
            "onkeypress"    =>  "minusculas(this);" 
          ]))?>        
        <?=place('place_correo_incorrecto')?>
      </div>
    </div>

    <?=div(icon('fa fa-unlock-alt')."Escribe una contraseña")?>      
    <?=input([
      "id"          =>"password",                         
      "class"       =>" input-sm password",
      "type"        =>"password",      
      "required"    => "true"
    ])?>
    <?=place("place_password_afiliado")?>
      
    <?=div(icon('fa fa-phone') ."Teléfono *" )?>
    <?=input([
        "id"          =>  "telefono",
        "class"       =>  "telefono form-control",
        "type"        =>  "tel" ,
        "name"        =>  "telefono" ,
        "required"    =>  "true"
    ])?>
    <?=place("place_telefono")?>        
    <?=guardar("CREA UNA CUENTA", [] , 1)?>            
    <?=div(anchor_enid('¿Ya tienes una cuenta? Entra aquí ya »', 
    ["href"  =>    "../login"]) )?>
      
      </div>
    </div>
    <?=place("place_config_usuario")?>
    <?php }?>      
</form>
<?=place("place_registro_afiliado")?>
</div>