<?php
  $info_ext           =  $info_solicitud_extra;
  $plan               = $info_ext["plan"];
  $num_ciclos         = $info_ext["num_ciclos"];
  $ciclo_facturacion  = $info_ext["ciclo_facturacion"];
  $ingresar =  anchor_enid( 'INGRESA', array(                            
                            'href'  => '../login'
                          )); 
$talla                = 
(array_key_exists("talla", $info_solicitud_extra))?$info_solicitud_extra["talla"]:0;  

?>  
<?=n_row_12()?>

<?php if($in_session == 0){?>

  <?=
  div(
  heading_enid($ingresar.' O CREA UNA CUENTA PARA RECIBIR ASISTENCIA Y COMPRAR AL MOMENTO', 
    3 , 
    ["class" => "strong"] , 
    1
  )
  ,
  ["class" => "row"]
  )
  ?>
<?php }?>
<div class="row">
<form class="form-miembro-enid-service"  id="form-miembro-enid-service">
  
     <?=input_hidden([
      "name"    =>  "descripcion",        
      "value"   =>  ""
    ])?>
     <?=input_hidden([
      "name"   =>  "usuario_referencia", 
      "value" => $q2 ,  
      "class" =>'q2'
    ])?>
    <?=input_hidden([
      "name"   =>  "plan" ,              
      "class" => "plan", 
      "value" =>  $plan 
    ])?>
    <?=input_hidden([
      "name"    =>  "num_ciclos" ,        
      "class"   => "num_ciclos" , 
      "value"   => $num_ciclos 
    ])?>
    <?=input_hidden([
      "name"    =>  "ciclo_facturacion" , 
      "class"   =>  "ciclo_facturacion" , 
      "value"   => $ciclo_facturacion 
    ])?>
    <?=input_hidden([
      "name"    =>  "talla" ,
      "class"   =>  "talla"   ,
      "value"    => $talla 
    ])?>

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

    <?=div(anchor_enid("TU USUARIO YA SE ENCUENTRA REGISTRADO" ,
      [
        'class' =>    "white",
        "href"  =>    "../login"
      ]) , 
      [        
        'class' =>    "usuario_existente black_enid_background padding_1 white top_20 enid_hide"
      ] , 
      1)?>

      <?=div(anchor_enid(
        '¿Ya tienes una cuenta? Entra aquí ya »', 
        ["href"  =>    "../login"]) 
      )?>
      
      </div>
    </div>

    <?=place("place_config_usuario")?>
    <?php }?>      
</form>
<?=place("place_registro_afiliado")?>
</div>