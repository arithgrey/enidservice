<div class="container inner">
            <?=n_row_12()?>
                <table style="width: 100%;">
                    <tr>
                        <?=get_td("MÉTODOS DE PAGO" , 
                        array('colspan' => 7 , "class" => "black" ))?>
                    </tr>
                    <tr>
                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",
                        'src' => "../img_tema/bancos/masterDebito.png" )))?>

                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",
                        'src' => "../img_tema/bancos/paypal2.png" )))?>        
                    
                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",
                        'src' => "../img_tema/bancos/visaDebito.png" )))?>         

                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",
                        'src' => "../img_tema/bancos/oxxo-logo.png" )))?>         
                    
                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",
                        'src' => "../img_tema/bancos/bancomer2.png" )))?>    

                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",                    
                        'src' => "../img_tema/bancos/santander.png" )))?>    
                             
                    
                    <?=get_td(img(array(
                        'class' => "logo_pago_mb",                    
                        'src' => "../img_tema/bancos/banamex.png" )))?>    

                    
                        
                </tr>
            </table>    
            <?=end_row()?>
</div>
<div class="container inner">
    <table>
        <tr>
            <?=get_td("MÉTODOS DE ENVÍO" , ['colspan' => 2,"class" => "black"])?>
        </tr>
        <tr>
            <?=get_td(img(['class' => "logo_pago_mb", 'src' => "../img_tema/bancos/fedex.png" ]))?>    
            <?=get_td(img(['class' => "logo_pago_mb", 'src' => "../img_tema/bancos/dhl2.png" ]))?>    
        </tr>
    </table>      
</div>