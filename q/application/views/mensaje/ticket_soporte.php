<?php
      $usuario        =  $usuario[0];       
      $nombre_usuario =  
      $usuario["nombre"] ." " . $usuario["apellido_paterno"] . $usuario["apellido_materno"] ." -  " .
      $usuario["email"];    
      $asunto_email         = "Nuevo ticket abierto [".$extra["ticket"]."]";
      $lista_prioridades    =["" , "Alta" , "Media" , "Baja"];
      $lista                =  "";
      $asunto               = "";
      $mensaje              = "";
      $prioridad            = "";
      $nombre_departamento  = "";  

      foreach ($ticket as $row) {

          $asunto     =  $row["asunto"]; 
          $mensaje    =  $row["mensaje"];     
          $prioridad  = $row["prioridad"];
          $nombre_departamento =  $row["nombre_departamento"];           
      }

?>      
<?=label("Nuevo ticket abierto" . $extra["ticket"])?>
<?=div("Cliente que solicita " . $nombre_usuario)?> 
<div>
  <?=strong("Prioridad:")?>
  <?=$lista_prioridades[$prioridad]?>
</div>
<div>          
  <?=strong("Departamento a quien está dirigido:")?>          
  <?=$nombre_departamento?>
</div>
<div>
  <?=strong(" Asunto:")?>
  <?=$asunto?>          
</div>
<div>          
    <?=strong("Reseña:")?>          
    <?=$mensaje?>
</div>                