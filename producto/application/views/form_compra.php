<?php if($flag_servicio == 0): ?>
      <?php if($existencia > 0): ?>
        <?=n_row_12()?>
              <?=$this->load->view("compra");?>                          
        <?=end_row()?>                                                         
      <?php endif; ?>
<?php else: ?>
  <?php if($precio > 0 && $id_ciclo_facturacion != 9): ?>
    <?=n_row_12()?>
              <?=$this->load->view("compra");?>                          
        <?=end_row()?>                                                         
  <?php endif; ?>
<?php endif; ?>
