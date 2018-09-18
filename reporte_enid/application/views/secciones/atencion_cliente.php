<?=n_row_12()?>
  <div class="panel-heading row">
    <ul class="nav nav-tabs">
        <li class="active">
          <?=anchor_enid( "Atención al cliente", 
            ["href"=>"#tab_1_actividad", "data-toggle"=>"tab"])?>
        </li>
        <li class="comparativa">
          <?=anchor_enid( "Comparativa", 
            ["href"=>"#tab_2_comparativa", "data-toggle"=>"tab"])?>
        </li>
        <li class="calidad_servicio">
          <?=anchor_enid( "Calidad y servicio", 
          ["href"=>"#tab_3_comparativa", "data-toggle"=>"tab"])?>
        </li>
    </ul>
  </div>
<?=end_row()?>
                            
<div class="tab-content">
    <div class="tab-pane fade in active" id="tab_1_actividad">
        <div class="row">
          <form class='form_busqueda_desarrollo'>                    
              <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
          </form>             
        </div>        
        <?=place("place_metricas_desarrollo")?>
    </div>
    <div class="tab-pane fade" id="tab_2_comparativa">        
        <?=place("place_metricas_comparativa")?>
    </div>
    <div class="tab-pane fade" id="tab_3_comparativa">
        <form class='form_busqueda_desarrollo_solicitudes'>                    
              <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
        </form>             
        <?=place("place_metricas_servicio")?>        
    </div>                       
</div>