<?=n_row_12()?>
	<!--<div class="contenedor_principal_enid">    	               -->
        <div class='col-lg-9'>
          <?=place("info_articulo" , [ "id" =>'info_articulo'])?>
          <?=$this->load->view("secciones_2/paginas_web")?>
        </div>            
        <div class="col-lg-3">                        
	       <?=$this->load->view("../../../view_tema/izquierdo")?>
	    </div>
        
  <!--</div>-->
<?=end_row()?>                        
<?=input_hidden(["value"=> $email ,  "class"=>'email_s'])?>


