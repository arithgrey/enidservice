<?=n_row_12()?>
    <div class='contenedor_principal_enid'>
        <div class="col-lg-4 col-lg-offset-4">            
        <?=n_row_12()?>
            <div class="jumbotron" 
            style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">      

              <div>
                    <center>
                        <h3 style="font-weight: bold;font-size: 2em;">      
                            REALIZAR COMPRA
                        </h3>
                    </center>
                    <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                        <select style="width: 100%" class="form-control">
                            <option class="de" id='de' value="1">                            
                                De saldo Enid Service $<?=$saldo_disponible?>MXN
                            </option>                  
                        </select>
                    </div>
                    
                    <div style="width: 80%;margin: 0 auto;margin-top: 10px;">
                        <div class="text-center">
                            
                            <?=n_row_12()?>
                                <span style="color: blue;font-size: 2.2em;text-decoration: underline;">
                                    Monto total: <?=$recibo["saldo_pendiente"]?>MXN
                                </span>
                            <?=end_row()?>
                            <?=n_row_12()?>
                                <span style="font-size: 1.2em;">
                                    <?=$recibo["resumen"]?>
                                </span>
                            <?=end_row()?>
                        </div>
                        <!---->
                    </div>
                    
                    
                    <?php if($saldo_disponible >= $recibo["saldo_pendiente"]):?>                            
                        <br>
                            <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                                <div  
                                    class="btn_transfer" 
                                    style="border-radius: 20px;background: black;padding: 10px;color: white;">
                                        CONTINUAR 
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                            </div>
                        <br>



                    <?php else: ?>
                        <br>
                            <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                                <div  
                                    style="border-radius:20px;background: black;padding:10px;color: white;">
                                    AUN NO CUENTAS CON FONDOS
                                    SUFICIENES EN TU CUENTA
                                    
                                </div>
                            </div>
                        <br>

                        <div style="width: 80%;margin: 0 auto;margin-top: 20px;" class="text-right">
                            <a href="?q=transfer&action=6" class="a_enid_blue white" style="color: white!important">
                                Agregar saldo a tu cuenta 
                            </a>
                        </div>
                    <?php endif; ?>
                    <br><br><br><br><br><br><br><br>
              </div>
            </div> 
        <?=end_row()?>
        </div>
    </div>
<?=end_row()?>