<br>
<br>
<?=n_row_12()?>
<p class="white strong" 
   style="font-size: 3em;line-height: .8;background: black;padding: 5px;">                        
    Indicadores
</p>
<?=end_row()?>		      	


            <div>
                <br>
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active">
                              <a href="#tab_1_actividad" data-toggle="tab">
                                Atención al cliente
                              </a>
                            </li>
                            <li class="comparativa">
                              <a href="#tab_2_comparativa" data-toggle="tab">
                                Comparativa
                              </a>
                            </li>
                            <li class="calidad_servicio">
                              <a href="#tab_3_comparativa" data-toggle="tab">
                                Calidad y servicio
                              </a>
                            </li>
                        </ul>
                </div>
                <br>
                <div>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab_1_actividad">
                            <div class="row">
                              <form class='form_busqueda_desarrollo'>                    
                                  <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                              </form>             
                            </div>
                            <div class="place_metricas_desarrollo">   
                            </div>
                          
                        </div>
                        <div class="tab-pane fade" id="tab_2_comparativa">
                            <div class="place_metricas_comparativa">    
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_3_comparativa">
                            <form class='form_busqueda_desarrollo_solicitudes'>                    
                                  <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                              </form>             
                            <div class="place_metricas_servicio">    
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
