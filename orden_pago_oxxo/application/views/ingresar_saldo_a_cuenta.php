<?php 
  $beneficiario = entrega_data_campo($usuario , "nombre") ." ". 
                  entrega_data_campo($usuario , "apellido_paterno") ." ".
                  entrega_data_campo($usuario , "apellido_materno");

  $folio  = $info_pago["q2"];
  $monto  = $info_pago["q"];
  $numero_cuenta =  "4152 3131 0230 5609";
  $concepto =  "Saldo a cuenta Enid Service";
?>
<main>                                                  
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
    <br>
    <div class="contenedor_orden_pago">    	
            <div class='contenido_orden_pago'>
                <div>                    
                    <div class="info_orden_compra">
                      <div style="font-size:1.4em;color:black;font-weight: bold;">
                        <img src="http://enidservice.com/inicio/img_tema/portafolio/oxxo-logo.png" style="width: 100px;">
                        ORDEN DE PAGO EN SUCURSALES OXXO
                      </div>
                      <div style="background: #0000f5;padding: 5px;color: white;color: white;">
                          	<?=$concepto?>
                          	<br>
                          	Beneficiario
                          	<?=$beneficiario?>
                            <br>
                            Folio #<?=$folio?>
                      </div>
                    <div style="margin-top:20px; ">                        
                      <div style="width: 80%;margin: 0 auto;">
                        <h1 style="color: : black;font-weight: bold;">
                          MONTO A PAGAR
                        </h1>
                        <h2 style="color: black;">
                          $<?=$monto?> MXN
                        </h2>
                        <span style="font-size: .8em;">
                          OXXO Cobrará una comisión adicional al momento de realizar el pago
                        </span>
                      </div>
                    </div>
                    
                    <div style="margin-top:20px;"></div>
                    <?=n_row_12()?>
                      <div style="width: 80%;margin: 0 auto;">                        
                        	<div>
                        		<img src="http://enidservice.com/inicio/img_tema/portafolio/logo-bbv.png" style="width: 200px;">	
                        	</div>
                        	<div>
	                          	<span style="font-weight: bold;">                   
	                            	<?=$numero_cuenta?>
	                          	</span>                                      
                          	</div>
                      </div>
                    <?=end_row()?>

                    <div style="margin-top:20px;"></div>
                    <?=n_row_12()?>
                      <div style="width: 80%;margin: 0 auto;">
                        <?=n_row_12()?> 
                          <span style="font-weight: bold;background: black;color: white;padding: 5px;">
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
                                            correspondiente, 
                                            que se indica en el monto a pagar 
                                          </span>
                                      </div>
                                      <div>
                                          <div>
                                            <span style="font-size: .8em;margin-top: 7px;">
                                              5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso. 
                                            </span>
                                          </div>
                                          <div>
                                          <span style="font-size: .8em;">
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
                                                6.- Notifica tu cuenta Enid Service
                                              </strong>
                                            </div>
                                            <div>
                                              <span>
                                                <a 
                                                  href="http://enidservice.com/inicio/notificar/?recibo=<?=$info_pago["q2"]?>" 
                                                  style="font-weight: bold;color: blue;" 
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
                                    	<br>
                                    	<strong>
                                    		Solicita una llamada 
                                    	</strong>
                                    	<span style="text-decoration: underline;">
                                    		www.enidservice.com/inicio/contacto/
                                    	</span>

                                    	<br>
                                    	<strong>
	                                    	Recibe asesoría
                                    	</strong>
                                    	(55)5296-7027

                                    <?=end_row()?>     
                        <?=end_row()?>
                      </div>
                    <?=end_row()?>                         
                          </div>
                    </div>
                </div> 
            </div>        
    </div>  
    <style type="text/css">
      .contenido_orden_pago{
        width: 50%;margin: 0 auto;border-style: solid;border-width: 1px;
      }
      .boton_imprimir_orden{
        width: 50%;margin: 0 auto;margin-top: 20px;
      }
      @media only screen and (max-width: 601px) {
        .contenido_orden_pago{
          width: 90%;margin: 0 auto;border-style: solid;border-width: 1px;
        } 
        .boton_imprimir_orden{
          width: 90%;margin: 0 auto;margin-top: 20px;
          margin-bottom: 5px;
        }
      }
    </style>
</main>
