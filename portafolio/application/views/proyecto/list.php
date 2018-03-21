<?php   
  $l = "<h3 
        class='pull-left strong blue_enid_background white'
        style='padding:5px;'> 
        Pedidos del día 
        ". count($proyectos)."
        </h3>";
  echo $l;
  
  $x =1;
  foreach($proyectos as $row){
     $detalles=  $row["detalles"];
     $monto_a_pagar=  $row["monto_a_pagar"];
     $saldo_cubierto=  $row["saldo_cubierto"];    
     $id_recibo =  $row["id_proyecto_persona_forma_pago"];  
     $href  ="../forma_pago/?recibo=".$id_recibo;
    ?>
        <div class="row">  
          <div class="col-md-8 col-lg-offset-2">
              <div>
                <div>                     
                    <div>
                      <span>
                        <?=$x?> .- <?=$detalles?>
                      </span>                        
                    </div>                    
                    <a class="btn input-sm" style="font-size: .8em;" >
                      <?=$monto_a_pagar?>MXN
                      <br>
                      Saldo pendiente
                    </a>
                    <a class="btn input-sm"  style="font-size: .8em;">
                      <?=$saldo_cubierto?>MXN
                      <br>
                      Saldo cubierto
                    </a>                  
                    <a 
                      class="btn input-sm"  
                      href="<?=$href?>" 
                      target="_blank"
                      style="font-size: .8em;background: #004593 !important;">
                      Detalles de compra
                    </a>
                  <hr>
                </div>              
              </div>        
          </div>
      </div>
  <?php   
    $x ++;
  }
?>