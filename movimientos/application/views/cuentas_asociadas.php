<main>
  <div class="col-lg-4 col-lg-offset-4" style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">

      <h3 style="font-weight: bold;font-size: 2em;">
        TUS CUENTAS
      </h3>     

      <div style="margin-top: 15px;"></div>
      <h3 style="font-weight: bold;font-size: 1em;border-bottom-style: solid;border-width: 1px;">
          CUENTAS BANCARIAS
      </h3>     
    <?=n_row_12()?>
    <div style="margin-top: 15px;">
        
        <?php foreach ($cuentas_bancarias as $row): ?>          
          
          <div 
              style="background: white;color: black;
              border-width: .5px;
              border-style: solid;
              border-radius: 10px;
              padding: 10px;height: 90px;
              margin-top: 20px;" 
          class="col-lg-6">
            <?=$row["nombre"]?>  
            <br>
            <div style="position: absolute;top: 50px;">
              <i class="fa fa-credit-card fa-2x"></i>
              <span style="margin-left: 10px;"><?=substr($row["clabe"], 0 ,4)?>********</span>
            </div>
          </div>
      <?php endforeach; ?>
      
        <a 
          href="?q=transfer&action=1">
          <div style="background: white;color: black;
                border-width: .5px;
                border-style: dotted;
                padding: 10px;height: 90px;
                border-radius: 10px;
                margin-top: 20px;" 
                class="col-lg-6">
              
              <div style="position: absolute;top: 40px;margin: 0 auto;" 
                      class="text-center">
                  <span style="background: #003d99; color: white;font-size: 1.2em;padding: 3px;">
                    Agregar cuenta
                  </span>
                  <span style="margin-left: 10px;">
                    <i class="fa fa-plus-circle fa-2x" style="color: #003d99"></i>
                  </span>
              </div>  
              
          </div>
        </a>

    </div>
    <?=end_row()?>

    <div style="margin-top: 100px;"></div>
    <h3 style="font-weight: bold;font-size: 1em;border-bottom-style: solid;border-width: 1px;">
      TARJETAS DE CRÉDITO Y DÉBITO
    </h3>     
    <?php foreach ($tarjetas as $row): ?>          
          
          <div 
              style="background: white;color: black;
              border-width: .5px;
              border-style: solid;
              border-radius: 10px;
              padding: 10px;height: 90px;
              margin-top: 20px;" 
          class="col-lg-6">
            <?=$row["nombre"]?>  
            <br>
            <div style="position: absolute;top: 50px;">
              <i class="fa fa-credit-card fa-2x"></i>
              <span style="margin-left: 10px;"><?=substr($row["numero_tarjeta"], 0 ,4)?>********</span>
            </div>
          </div>

      <?php endforeach; ?>
      <a 
          href="?q=transfer&action=1&tarjeta=1">
          <div style="background: white;color: black;
                border-width: .5px;
                border-style: dotted;
                padding: 10px;height: 90px;
                border-radius: 10px;
                margin-top: 20px;" 
                class="col-lg-6">
              
              <div style="position: absolute;top: 40px;margin: 0 auto;" 
                      class="text-center">
                  <span style="background: #003d99; color: white;font-size: 1.2em;padding: 3px;">
                    Agregar tarjeta
                  </span>
                  <span style="margin-left: 10px;">
                    <i class="fa fa-plus-circle fa-2x" style="color: #003d99"></i>
                  </span>
              </div>  
              
          </div>
        </a>


  </div>
</main>