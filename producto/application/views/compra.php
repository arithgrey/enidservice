  
                          <form 
                                id="AddToCartForm" 
                                action="../procesar">                
                                <input type="hidden" name="plan" value="<?=$id_servicio?>">                                    
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
                                        max="<?=valida_maximo_compra($flag_servicio, $existencia)?>"
                                        class="telefono_info_contacto">
                                      <span class="q strong" style="font-size: .85em;" >
                                        <?=get_text_periodo_compra($flag_servicio)?>
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