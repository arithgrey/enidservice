<?php
  $a_pendientes = anchor_enid("PENDIENTES DE LIQUIDAR", ["href"=>"#home", "class"=>"strong btn_compras_solicitadas", "data-toggle"=>"tab"]);
  $a_en_camino  = anchor_enid("EN CAMINO A TU HOGAR",   ["href"=>"#compras_efectivas_y_enviadas" ,"role"=>"tab" ,"class"=>"strong" ,"data-toggle"=>"tab" ,"aria-expanded"=>"false"]);
  $a_realizar_pago = anchor_enid("¿HAS REALIZADO UN PAGO?", ["href"=>"#messages", "data-toggle"=>"tab", "class"=>"strong"]);
?>
<div class="row">
    <div> 
         
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active ">
          <?=$a_pendientes?>
        </li>
        <li class="btn_compras_efectivas">
           <?=$a_en_camino?>
        </li>
        <li role="presentation">
            <?=$a_realizar_pagp?>
        </li>
      </ul>
            
      <div class="tab-content">
        <div class="tab-pane active" id="home">
          <?=place("place_servicios_contratados")?>
        </div>
        <div class="tab-pane" id="compras_efectivas_y_enviadas">
          <?=place("place_servicios_contratados_y_pagados")?>
        </div>
        <div class="tab-pane" id="messages">      
            <?=anchor("Notifícalo aquí!", ["class"=>"btn input-sm", "href"=>"../notificar",  "target"=>"_black"])?>            
        </div>
      </div>
    </div>
  </div>