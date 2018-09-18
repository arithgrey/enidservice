  <div class="image-container set-full-height" >            
      <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <div class="text-right">
                <button class="btn input-sm btn-orden">
                  <?=icon("fa fa-print")?>
                  Imprimir
                </button>
              </div>

            </div>
            <div class="col-sm-8 col-sm-offset-2">
                <div>                    
                    <div class="info_orden_compra" style="box-shadow: 0 16px 24px 2px;">
                      <div>
                        <label style="font-size:1.4em;color:black;">
                            Orden de pago                        
                        </label>            
                      </div>
                      <div>
                        <img src="../img_tema/portafolio/oxxo-logo.png" 
                        style="width: 100px;">
                      </div>                      
                      <div style="background: #0000f5;padding: 5px;color: white;">
                          <label style="color: white;">Servicios Enid Service
                            Folio #<?=$info_pago["q2"]?>
                          </label>
                      </div>

                    <div style="margin-top:20px; ">                        
                      <div style="width: 80%;margin: 0 auto;">
                        <h1 style="color: : black;">
                          MONTO A PAGAR
                        </h1>
                        <h2 style="color: black;">
                          $<?=$info_pago["q"]?> MXN
                        </h2>
                        <span >
                          OXXO Cobrará una comisión adicional al momento de realizar el pago
                        </span>
                      </div>
                    </div>
                    
                    <div style="margin-top:20px;"></div>
                    <?=n_row_12()?>
                      <div style="width: 80%;margin: 0 auto;">
                        <?=n_row_12()?>                                                              
                          <img 
                          src="../img_tema/portafolio/logo-bbv.png" 
                          style="width: 200px">
                        <?=end_row()?>
                        <?=n_row_12()?>                                      
                          <span style="">                   
                            4152 3131 0230 5609
                          </span>                                      
                        <?=end_row()?>
                      </div>
                    <?=end_row()?>





                    <div style="margin-top:20px;"></div>
                    <?=n_row_12()?>
                      <div style="width: 80%;margin: 0 auto;">
                        <?=n_row_12()?> 
                          <span style="background: black;color: white;padding: 5px;">
                           INSTRUCCIONES
                          </span>
                        <?=end_row()?>
                        <?=n_row_12()?>                                      
                           <?=n_row_12()?>
                                      <div>
                                        <span style="font-size: .8em;margin-top: 7px;">
                                            1.-Acude a la tienda OXXO más cencana 
                                        </span>
                                      </div>
                                      <div>
                                        <span style="font-size: .8em;margin-top: 7px;">
                                            2.- Indica en caja que quieres realizar un
                                                depósito en cuenta 
                                              <strong>
                                              BBVA Bancomer
                                              
                                              </strong>
                                          </span>
                                      </div>
                                      <div>
                                        <span style="font-size: .8em;margin-top: 7px;">
                                            3.- Proporciona el número de cuenta señalado
                                        </span> 
                                      </div>
                                      <div>
                                          <span style="font-size: .8em;margin-top: 7px;">
                                            4.-Realiza el 
                                            <strong>
                                            pago exacto
                                            </strong> 
                                            correspondiente, que se indica en el monto a pagar 
                                          </span>
                                      </div>
                                      <div>
                                          <div>
                                            <span style="font-size: .8em;margin-top: 7px;">
                                              5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso. 
                                            </span>
                                          </div>
                                          <div>
                                          <span >
                                              <strong>
                                              En el podrás verificar que se haya realizado correctamente, conserva este comprobante. 
                                              </strong>
                                              
                                          </span>
                                          </div>
                                      </div>
                                      <div>
                                        <span style="font-size: .8em;margin-top: 7px;">                                            
                                            <div>
                                              <strong>
                                                6.- Notifica tu pago desde tu área de cliente
                                              </strong>
                                            </div>
                                            <div>
                                              <span>
                                                <a href="http://enidservice.com/inicio/login/" style="color: blue;" target="_black">
                                                  http://enidservice.com/inicio/login/
                                                </a>
                                              </span>
                                            </div>
                                            <div>
                                              <strong>
                                                ó 
                                              </strong>                                     
                                            </div>
                                            <div>                                              
                                              Notifica tu pago  al área de ventas 
                                                <strong>
                                                  ventas@enidservice.com
                                                </strong>
                                            </div>                                            
                                          </span>
                                      </div>
                                    <?=end_row()?>                                        


                                    <?=n_row_12()?>     

                                      <img 
                                        src="../img_tema/enid_service_logo.jpg" 
                                        style="width: 300px;">

                                    <?=end_row()?>     
                        <?=end_row()?>
                      </div>
                    <?=end_row()?>

                              
                                
                              
                          
                          </div>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div> <!-- row -->
    </div> <!--  big container -->

      
  </div>


</html>





















