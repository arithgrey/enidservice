  <div class="image-container set-full-height" >            
      <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <?=div(anchor_enid(icon("fa fa-print") . "Imprimir" , 
                ["class"  => "btn-orden"]) , 
                ["class"  =>"text-right"]
              )?>                              
            </div>
            <div class="col-sm-8 col-sm-offset-2">
              <div>                    
                <div class="info_orden_compra" style="box-shadow: 0 16px 24px 2px;">
                  <?=div("Orden de pago", 1)?>
                  <?=div(img(
                    [ "src"     =>  "../img_tema/portafolio/oxxo-logo.png" ,
                       "style"   =>  "width: 100px;"
                    ]), 
                  1)?>
                <?=div("Servicios Enid Service Folio #".$info_pago["q2"], 
                [ 
                  "style" => "background: #0000f5;padding: 5px;color: white;"
                ])?>                          
                
                <div style="margin-top:20px; ">                        
                  <div style="width: 80%;margin: 0 auto;">
                    <?=heading("MONTO A PAGAR")?>
                    <?=heading("$".$info_pago["q"] ."MXN")?>
                    <?=div("OXXO Cobrará una comisión adicional al momento de realizar el pago" ,[] ,1)?>
                  </div>
                </div>
                <?=n_row_12()?>
                  <div style="width: 80%;margin: 0 auto;">
                    <?=div(img([
                          "src"   =>  "../img_tema/portafolio/logo-bbv.png",
                          "style" =>  "width: 200px"
                        ]),
                        1)?>
                    <?=heading("4152 3131 0230 5609" ,5)?>
                  </div>
                <?=end_row()?>

                
                    <?=n_row_12()?>
                      <div style="width: 80%;margin: 0 auto;">
                        <?=div(
                          "INSTRUCCIONES" ,
                          ["style"=>"background: black;color: white;padding: 5px;"] ,
                          1)?>
                        <?=div("1.-Acude a la tienda OXXO más cencana ")?>
                        <?=div("2.- Indica en caja que quieres realizar un
                                                depósito en cuenta BBVA Bancomer ")?>
                        <?=div("3.- Proporciona el número de cuenta señalado")?>
                        <?=div("4.-Realiza el 
                        pago exacto correspondiente, que se indica en el monto a pagar")?>
                        <?=div("5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso.")?>
                        <?=div("En el podrás verificar que se haya realizado correctamente, conserva este comprobante.")?>

                        <?=div("6.- Notifica tu pago desde tu área de cliente")?>
                        <?=anchor_enid("http://enidservice.com/inicio/login/" , 
                        [
                          "href"  =>  "http://enidservice.com/inicio/login/"
                        ])?>
                        <?=div("ó")?>
                        <?=div("Notifica tu pago  al área de ventas ventas@enidservice.com")?>
                        <?=div(img([
                            "src"     =>  "../img_tema/enid_service_logo.jpg" ,
                            "style"   =>  "width: 300px;"
                          ]) 
                          ,
                          1)?> 
                          
                      </div>
                    <?=end_row()?>
                    </div>
                  </div>
                </div> 
            </div>
        </div> 
    </div> 
  </div>
</html>





















