            <?php if ($flag_servicio ==  0){

                  if($existencia >0 ){?>
                    
                    <?=n_row_12()?>                  
                        <?=n_row_12()?>
                          <span class="texto_existencia">
                            <?=get_text_diponibilidad_articulo($existencia , $flag_servicio)?>
                          </span>
                        <?=end_row()?>
                          <form 
                                id="AddToCartForm" 
                                action="../procesar">                
                                <input type="hidden" name="plan" value="<?=$id_servicio?>">    
                                <input type="hidden" name="dominio" value="">                         
                                <input type="hidden" name="extension_dominio" value="">   
                                <input type="hidden" name="ciclo_facturacion" 
                                value=""> 
                                <input type="hidden" name="is_servicio" value="<?=$flag_servicio?>">  
                                <input type="hidden" name="q2" value="<?=$q2?>">
                                <div class="btn-and-quantity-wrap">
                                  <div class="btn-and-quantity">
                                    <div class="spinner">
                                      <input 
                                        type="number" 
                                        name="num_ciclos" 
                                        value="1"
                                        min="1" 
                                        max="<?=$existencia?>"
                                        class="telefono_info_contacto">
                                      <span class="q strong" style="font-size: .85em;" >
                                        <?=get_text_periodo_compra($flag_servicio )?>
                                      </span>
                                    </div>
                                    <button id="AddToCart" style="background: #092642!important;">
                                      <span id="AddToCartText">
                                        <i class="fa fa-cart-plus">                          
                                        </i>
                                        Ordenar 
                                      </span>
                                    </button>
                                  </div>
                                </div>
                        </form>                      
                    <?=end_row()?>
                    <?php }else{?>                

                          <h2>
                            Este artículo se encuentra 
                            <strong class="blue_enid_background white" style="padding: 1.5px;">
                              temporalmente agotado
                            </strong>
                          </h2>

                    <?php }?>

                    <?php }else{ ?>
                      <?=n_row_12()?>  
                        
                      
                          <a href="../pregunta?tag=<?=$id_servicio?>" class="a_enid_blue" style="color: white!important;">
                            ENVIAR PREGUNTA AL VENDEDOR
                          </a>
                        
                      <?=end_row()?>  
                    <?php } ?>