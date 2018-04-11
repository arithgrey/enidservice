<main>                                                  
	<?=n_row_12()?>    
		<div style="width: 50%;margin: 0 auto;margin-top: 20px;">
			<div class="text-right">
			    <a class="a_enid_blue imprimir" style="color: white!important;" >
			    	IMPRIMIR
			    </a>
		    </div>
	    </div>
    <?=end_row()?>
    <br>
    <div class="contenedor_orden_pago">    	
            <div style="width: 50%;margin: 0 auto;border-style: solid;border-width: 1px;">
                <div>                    
                    <div class="info_orden_compra">
                      <div style="font-size:1.4em;color:black;font-weight: bold;">
                        <img src="http://enidservice.com/inicio/img_tema/portafolio/oxxo-logo.png" style="width: 100px;">
                        ORDEN DE PAGO EN SUCURSALES OXXO
                      </div>
                      <div style="background: #0000f5;padding: 5px;color: white;color: white;">
                          	Saldo a cuenta Enid Service 
                          	<br>
                          	Beneficiario
                          	<?=entrega_data_campo($usuario , "nombre")?> 
                          	<?=entrega_data_campo($usuario , "apellido_paterno")?>
                          	<?=entrega_data_campo($usuario , "apellido_materno")?>
                            <br>
                            Folio #<?=$info_pago["q2"]?>
                      </div>
                    <div style="margin-top:20px; ">                        
                      <div style="width: 80%;margin: 0 auto;">
                        <h1 style="color: : black;font-weight: bold;">
                          MONTO A PAGAR
                        </h1>
                        <h2 style="color: black;">
                          $<?=$info_pago["q"]?> MXN
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
	                            	4152 3131 0230 5609
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
                                                	href="http://enidservice.com/inicio/login/" style="font-weight: bold;color: blue;" 
                                                	target="_black">
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
                                            	Al correo
                                                <strong>
                                                  ventas@enidservice.com
                                                </strong>
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


<form class="form_imprimir" action="../pdf/pdf.php" method="post">
	<input type="hidden" name="contenido" class="contenido_imp" >
</form>
<script type="text/javascript" src="<?=base_url('application/js/imprimir.js')?>"></script>
</main>
