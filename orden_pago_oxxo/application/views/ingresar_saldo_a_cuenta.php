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
            <input type="hidden" name="beneficiario" value="<?=$beneficiario?>">
            <input type="hidden" name="folio" value="<?=$folio?>">
            <input type="hidden" name="monto" value="<?=$monto?>">
            <input type="hidden" name="numero_cuenta" value="<?=$numero_cuenta?>">
            <input type="hidden" name="concepto" value="<?=$concepto?>">
            
  			    <button class="a_enid_blue imprimir" style="color: white!important;" >
  			    	IMPRIMIR
  			    </button>
          </form>
		    </div>
	    </div>
    <?=end_row()?>
    <?=n_row_12()?>    
      
      <div class="contenedor_orden_pago">    	
              <div class='contenido_orden_pago'>
                  <div>                    
                      <div class="info_orden_compra">
                        <div style="font-size:1.4em;color:black;">
                          <?=img(
                            array(
                              'src'   => "http://enidservice.com/inicio/img_tema/portafolio/oxxo-logo.png",
                              'style' => "width:100px!important"
                            ))?>
                          ORDEN DE PAGO EN SUCURSALES OXXO
                        </div>
                        <div style="background: #0000f5;padding: 5px;color: white;color: white;">
                            	<?=$concepto?>
                            	
                            	Beneficiario
                            	<?=$beneficiario?>
                              
                              Folio #<?=$folio?>
                        </div>
                      <div style="margin-top:20px; ">                        
                        <div style="width: 80%;margin: 0 auto;">
                          <h1 style="color: : black;">
                            MONTO A PAGAR
                          </h1>
                          <h2 style="color: black;">
                            $<?=$monto?> MXN
                          </h2>
                          <span >
                            OXXO Cobrará una comisión adicional al momento de realizar el pago
                          </span>
                        </div>
                      </div>
                      
                      <div style="margin-top:20px;"></div>
                      <?=n_row_12()?>                        
                        <div class="contenedor-img-logo">
                          <div class="col-lg-6">
                                <?=img(
                                    array(
                                      "src" =>  "http://enidservice.com/inicio/img_tema/portafolio/logo-bbv.png"
                                    ))?>                        
                          </div>
                        </div>
                      <?=end_row()?>
                      <?=n_row_12()?>                        
                        <div class="contenedor-img-logo">
                          <div class="col-lg-6">
                            <span style="">    
                              <?=$numero_cuenta?>
                            </span>       
                          </div>
                        </div>
                      <?=end_row()?>                               
                              
                        

                      <div style="margin-top:20px;"></div>
                      <?=n_row_12()?>
                        <div style="width: 80%;margin: 0 auto;">
                          <?=n_row_12()?> 
                            <div style="background: black;color: white;padding: 5px;">
                             INSTRUCCIONES
                            </div>
                          <?=end_row()?>
                          <?=n_row_12()?>                                      
                             <?=n_row_12()?>
                                        <div>
                                          <span style="font-size: 1em;margin-top: 7px;">
                                              1.-Acude a la tienda OXXO más cencana 
                                          </span>
                                        </div>
                                        <div>
                                          <span style="font-size: 1em;margin-top: 7px;">
                                              2.- Indica en caja que quieres realizar un
                                                  depósito en cuenta 
                                                <strong>
                                                BBVA Bancomer
                                                
                                                </strong>
                                            </span>
                                        </div>
                                        <div>
                                          <span style="font-size: 1em;margin-top: 7px;">
                                              3.- Proporciona el número de cuenta señalado
                                          </span> 
                                        </div>
                                        <div>
                                            <span style="font-size: 1em;margin-top: 7px;">
                                              4.-Realiza el 
                                              <strong>
                                              pago exacto
                                              </strong> 
                                              correspondiente, 
                                              que se indica en el monto a pagar 
                                            </span>
                                        </div>
                                        <div>
                                            <div>
                                              <span style="font-size: 1em;margin-top: 7px;">
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
                                          <span style="font-size: 1em;margin-top: 7px;">
                                              <div>
                                                <strong>
                                                  6.- Notifica tu cuenta Enid Service
                                                </strong>
                                              </div>
                                              <div>
                                                <span>
                                                  <a 
                                                    href="http://enidservice.com/inicio/notificar/?recibo=<?=$info_pago["q2"]?>" 
                                                    style="color: blue;" 
                                                  	target="_black">
                                                    NOTIFICA TU PAGO AQUÍ!
                                                  </a>
                                                </span>
                                              </div>
                                                       
                                            </span>
                                        </div>
                                      
                                      <div>
                                      	<img src="http://enidservice.com/inicio/img_tema/enid_service_logo.jpg" width="300px">	
                                      </div>
                                      

                                        

                                      <?=end_row()?>     
                                      <?=n_row_12()?>
                                      	¿TIENES ALGUNA DUDA?
                                      	
                                      	<strong>
                                      		Solicita una llamada 
                                      	</strong>
                                      	<span style="text-decoration: underline;">
                                      		www.enidservice.com/inicio/
                                      	</span>


                                      <?=end_row()?>     
                          <?=end_row()?>
                        </div>
                      <?=end_row()?>                         
                            </div>
                      </div>
                  </div> 
              </div>        
      </div>  
    <?=end_row()?>
</div>