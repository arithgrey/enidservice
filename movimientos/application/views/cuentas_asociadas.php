<?php 
  $head_cuentas           =  heading_enid("TUS CUENTAS" , 3); 
  $head_cuentas_bancarias =  heading_enid("CUENTAS BANCARIAS" , 3); 
  $head_tarjetas_credito  =  heading_enid("TARJETAS DE CRÉDITO Y DÉBITO" , 3);     
  
?>
<?=n_row_12()?>
  <div class='contenedor_principal_enid'>
    <div class="col-lg-4 col-lg-offset-4" class="contenedor_cuentas_bancarias">
      <?=$head_cuentas?>        
      <?=$head_cuentas_bancarias?>
      <?=n_row_12()?>
      <div style="margin-top: 15px;">
          
          <?php foreach ($cuentas_bancarias as $row): ?>    
            <?php $resumen_clabe          =  get_resumen_cuenta($row["clabe"]); ?>
            <div class="col-lg-6 info_cuenta">
              <?=$row["nombre"];?>                
              <div style="position: absolute;top: 50px;">                
                <?=icon("fa fa-credit-card ")?>
                <?=div($resumen_clabe )?>
              </div>
            </div>
        <?php endforeach; ?>
        
          <a href="?q=transfer&action=1">
            <div class="col-lg-6 contenedor_info_trasnfer">
              <?=div( 
                div( "Agregar cuenta" .icon("fa fa-plus-circle ")
                 , 
                ['class' =>'agregar_cuenta_text'] ,1) 
                ,
                [ "class"=>"text-center contenedor_agregar_cuenta"])?>              
            </div>
          </a>
      </div>
      <?=end_row()?>
      <?=$head_tarjetas_credito?>
      <?php foreach ($tarjetas as $row): ?>          
            <div class="col-lg-6 contenedor_agregar_cuenta_2">
              <?=div($row["nombre"],  1)?>                              
              <div style="position: absolute;top: 50px;">
                <?=icon("fa fa-credit-card ")?>
                <?=div(substr($row["numero_tarjeta"], 0 ,4) .  "********")?>
              </div>
            </div>
        <?php endforeach; ?>
        <a href="?q=transfer&action=1&tarjeta=1">
            <div class="col-lg-6 contenedir_agregar_tarjeta">              
              <?=div("Agregar tarjeta")?>
              <?=icon("fa fa-plus-circle ")?>                    
            </div>
        </a>
    </div>
  </div>
<?=end_row()?>
<style type="text/css">
  .contenedor_cuentas_bancarias{
    background: #fbfbfb;
    border-right-style: solid;
    border-width:.9px;
    border-left-style: solid;
  }
  .info_cuenta{
    background: white;color: black;
    border-width: .5px;
    border-style: solid;
    border-radius: 10px;
    padding: 10px;height: 90px;
    margin-top: 20px;
  }
  .contenedor_info_trasnfer{
    background: white;color: black;
    border-width: .5px;
    border-style: dotted;
    padding: 10px;height: 90px;
    border-radius: 10px;
    margin-top: 20px;
  }
  .contenedor_agregar_cuenta{
    position: absolute;top: 40px;margin: 0 auto;
  }
  .contenedor_agregar_cuenta_2
  {
    background: white;color: black;
    border-width: .5px;
    border-style: solid;
    border-radius: 10px;
    padding: 10px;height: 90px;
    margin-top: 20px;
  }
  .agregar_cuenta_text{
    background: #003d99;
    color: white;
    
    padding: 3px;
  }
  .contenedir_agregar_tarjeta{
    background: white;color: black;
    border-width: .5px;
    border-style: dotted;
    padding: 10px;height: 90px;
    border-radius: 10px;
    margin-top: 20px;" 
  }
</style>