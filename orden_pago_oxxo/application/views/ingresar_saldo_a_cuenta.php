<?php 
  $beneficiario = get_campo($usuario , "nombre") ." ". 
                  get_campo($usuario , "apellido_paterno") ." ".
                  get_campo($usuario , "apellido_materno");

  $folio  = $info_pago["q2"];
  $monto  = $info_pago["q"];
  $numero_cuenta =  "4152 3131 0230 5609";
  $concepto =  "Saldo a cuenta Enid Service";
?>

<div class="contenedor_principal_enid">
	 <?=n_row_12()?>    
		<div class="boton_imprimir_orden">
			<div class="text-right">
          <form action="../pdf/orden_pago.php" method="POST">
            <?=input_hidden([
              "name"  =>  "beneficiario" ,
              "value" =>  $beneficiario

            ])?> 
            <?=input_hidden([
              "name"  =>  "folio" ,
              "value" =>  $folio

            ])?> 
            <?=input_hidden([
              "name"  =>  "monto" ,
              "value" =>  $monto

            ])?> 
            <?=input_hidden([
              "name"  =>  "numero_cuenta" ,
              "value" =>  $numero_cuenta

            ])?> 
            <?=input_hidden([
              "name"  =>  "concepto" ,
              "value" =>  $concepto

            ])?> 
            <?=guardar("IMPRIMIR" , ["class"=>"a_enid_blue imprimir"] ,1,1)?>  			    
          </form>
		    </div>
	    </div>
    <?=end_row()?>
    <?=n_row_12()?>    
      
      <div class="contenedor_orden_pago">    	
              <div class='contenido_orden_pago'>
                  <div>                    
                      <div class="info_orden_compra">
                        <?=div(img(
                            [
                              'src'   => "http://enidservice.com/inicio/img_tema/portafolio/oxxo-logo.png",
                              'style' => "width:100px!important"
                            ]
                          ). "ORDEN DE PAGO EN SUCURSALES OXXO")?>
                        <?=div($concepto ."Beneficiario".$beneficiario ."Folio #".$folio,
                        ["style"=>"background: #0000f5;padding: 5px;color: white;color: white;"])?>
                        
                        <div style="margin-top:20px; ">                        
                          <div style="width: 80%;margin: 0 auto;">
                            <?=heading("MONTO A PAGAR")?>
                            <?=heading("$".$monto ."MXN" , 2)?>
                            <?=div("OXXO Cobrará una comisión adicional al momento de realizar el pago" ,1)?>
                          </div>
                        </div>
                      
                      
                      <?=n_row_12()?>                        
                        <div class="contenedor-img-logo">
                          <?=div(img(
                              ["src" =>  "http://enidservice.com/inicio/img_tema/portafolio/logo-bbv.png"]
                            )
                          , 
                          ["class"=>"col-lg-6"])?>                                                  
                        </div>
                      
                      <?=div(div($numero_cuenta , ["class"=>"col-lg-6"]) , ["class"=>"contenedor-img-logo"] , 1)?>
                      
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
    <?=end_row()?>
</div>