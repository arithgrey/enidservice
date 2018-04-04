            <?php if($flag_servicio == 0): ?>

                  <?php if($existencia > 0): ?>
                    <?=n_row_12()?>                  
                        <?=n_row_12()?>
                          <span class="texto_existencia">
                            <?=get_text_diponibilidad_articulo($existencia , $flag_servicio)?>
                          </span>
                        <?=end_row()?>
                          <?=$this->load->view("compra");?>
                    <?=end_row()?>                    
                  <?php else: ?>
                          <h2>
                            Este artículo se encuentra 
                            <strong class="blue_enid_background white" style="padding: 1.5px;">
                              temporalmente agotado
                            </strong>
                          </h2>  
                          <?=$this->load->view("btn_pregunta");?>
                  <?php endif; ?>

            <?php else: ?>
              
              <?php if($id_ciclo_facturacion != 9 && $precio >0 ): ?>                
                  <?=$this->load->view("compra");?>
              <?php else: ?>
                      <?=n_row_12()?>                          
                          <?=$this->load->view("btn_pregunta");?>                        
                      <?=end_row()?>  
              <?php endif; ?>

            <?php endif; ?>
