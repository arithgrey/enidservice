            <?php if($flag_servicio == 0): ?>
                  <?php if($existencia > 0): ?>
                    <?=n_row_12()?>                                                              
                          <?=$this->load->view("compra");?>                          
                    <?=end_row()?>                                                         
                  <?php endif; ?>
            <?php endif; ?>
