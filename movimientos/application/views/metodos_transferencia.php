<?=n_row_12()?>
    <div class='contenedor_principal_enid'>
        <div class="col-lg-4 col-lg-offset-4">            
        <?=n_row_12()?>
            <div class="jumbotron" 
            style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">      

              <div>
                    <center>
                            <h3 style="font-weight: bold;font-size: 2em;">      
                                TRANSFERIR FONDOS
                            </h3>
                    </center>
                    <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                        <select style="width: 100%" class="form-control">
                            <option class="de" id='de' value="1">                            
                                De saldo Enid Service $<?=$saldo_disponible?>MXN
                            </option>                  
                        </select>
                    </div>
                    <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                        <select style="width: 100%" class="form-control" 
                            <?=valida_siguiente_paso_cuenta_existente($cuentas_gravadas)?> >

                            <?php if ($cuentas_gravadas == 1 ): ?>                            
                                <?=despliega_cuentas_registradas($cuentas_bancarias)?>
                            <?php else: ?>
                                <option value="A">A</option>
                            <?php endif; ?>
                            
                        </select>
                    </div>

                    <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                        <a href="?q=transfer&action=1&seleccion=1" class="white" 
                            style="color: white!important;background:#004faa;padding: 3px;">
                            <?=agrega_cuentas_existencia($cuentas_gravadas)?>
                        </a>
                    </div>    

                    <?php if($saldo_disponible >100 ):?>                            
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
                                    EN TU CUENTA
                                    
                                </div>
                            </div>
                        <br>
                    <?php endif; ?>
                    <br><br><br><br><br><br><br><br>
              </div>

            </div> 

        <?=end_row()?>
        </div>
    </div>
<?=end_row()?>