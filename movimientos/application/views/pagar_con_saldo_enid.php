<?=n_row_12()?>
    <div class='contenedor_principal_enid'>
        <div class="col-lg-4 col-lg-offset-4">            
        <?=n_row_12()?>
            <div class="jumbotron" 
            style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">

            <?=heading("REALIZAR COMPRA")?>                 
            <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                <select style="width: 100%" class="form-control">
                    <option class="de" id='de' value="1">                            
                        De saldo Enid Service $<?=$saldo_disponible?>MXN
                    </option>                  
                </select>
            </div>
            <div style="width: 80%;margin: 0 auto;margin-top: 10px;">
                <?=div("Monto total:" .$recibo["saldo_pendiente"] . "MXN" , 
                    ["style"=>"color: blue;font-size: 2.2em;text-decoration: underline;"] ,
                    1)?>
                <?=div($recibo["resumen"]  ,1)?>                
            </div>
            <?php if($saldo_disponible >= $recibo["saldo_pendiente"]):?>                            
                        
                <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                    <?=div("CONTINUAR ".icon("fa fa-chevron-right") , 
                    [
                        "class"=>"btn_transfer" ,
                        "style"=>"border-radius: 20px;background: black;padding: 10px;color: white;"
                    ])?>

                </div>
            <?php else: ?>
                        
                <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
                    <?=div("AUN NO CUENTAS CON FONDOS SUFICIENES EN TU CUENTA" , 
                    ["style"=>"border-radius:20px;background: black;padding:10px;color: white;"])?>
                </div>
                        

                <div style="width: 80%;margin: 0 auto;margin-top: 20px;" class="text-right">
                    <?=anchor_enid("Agregar saldo a tu cuenta" ,
                        ["href"=>"?q=transfer&action=6" ] ,1 ,1 )?>                    
                </div>
            <?php endif; ?>
            </div> 
        <?=end_row()?>
        </div>
    </div>
<?=end_row()?>