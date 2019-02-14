<?=heading_enid("SERVICIOS POSTULADOS" ,3)?>
<?php   
    $l          =   "";
    $url_imagen =   "";
    foreach($servicios as $row){
  
        $nombre_servicio    =   $row["nombre_servicio"];
        $fecha_registro     =   $row["fecha_registro"];
        $id_servicio        =   $row["id_servicio"];
        $url_imagen         =   "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
        $precio             =   $row["precio"];
        $vista              =   $row["vista"];
        $id_error           =   "imagen_".$id_servicio;
    ?>
      <a href="../producto/?producto=<?=$id_servicio?>" class='contenedor_resumen_servicio'>
        <div  
          class="popup-box chat-popup" id="qnimate" 
            style="margin-top: 4px;">
              <div class="popup-head">
                <div class="popup-head-left pull-left">                  
                  <?=img([    
                      "src"     =>  $url_imagen ,
                      "style"   =>  'width: 44px!important;height: 44px;',
                      "id"      =>  $id_error,
                      'onerror' =>  "reloload_img('".$id_error."','".$url_imagen."');"
                  ])?>
                  <?=span($nombre_servicio . "|".  $precio ."MXN")?>
                  <?=div($fecha_registro ."|".  "alcance" . $vista)?>                  
                </div>                
            </div>
          </div> 
      </a>
  <?php } ?>

<?=$l;?>

