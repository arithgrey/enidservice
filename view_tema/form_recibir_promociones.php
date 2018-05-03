<div style='background:#002575;padding: 20px;' class='row contenedor-info-ventas' >
    <div class='container contenedo-texto-footer'>        
        <div class='col-lg-5'>
            <span class='white strong' style='font-size:1.3em;'>
                ENTÉRATE DE LAS NOVEDADES Y OBTÉN HASTA UN <br>
                <span style="color: #fff !important;background: #fc0b0b;padding: 2px;">
                    15% DE DESCUENTO 
                </span>
                <i  class="btn_copiar_enlace_pagina_contacto fa fa-clone" 
                    data-clipboard-text="Te comparto nuestra página donde si te registras recibes promociones y precios especiales al comprar en línea ->   
                    http://enidservice.com/inicio/contacto/#seccion_recibir_promociones e incluso nos puedes enviar tu mensaje"
                    style="font-size: .9em!important;">
                </i>
            </span>
        </div>
        <div class='col-lg-7'>
            <form id="form_enid_contacto" class="form_enid_contacto" 
                    class="forms" 
                    action="../msj/index.php/api/emp/lead/format/json" 
                    method="post"
                    class="form-horizontal">                    
                    
                    <div>                                                 
                      <?=n_row_12()?>
                        <div class="parte_oculta_lead" style="display:none;">
                          <input type="text" class="nombre_lead" name="nombre" placeholder="Nombre" required >
                          <span class="place_nombre_lead"></span>
                          <input
                                style="width: 100%;" 
                                type="number" 
                                name="telefono" 
                                placeholder="Telefono"
                                class="telefono_info_contacto telefono_lead" 
                                required >                             

                          <span class="place_telefono_lead">                            
                          </span>
                        </div>
                      <?=end_row()?>
                      <?=n_row_12()?>
                          <div class="input-group">
                            <input 
                              style="width: 100%;" 
                              id="btn_cotizacion" 
                              name="email" 
                              onkeypress="minusculas(this);"
                              class="form-control correo_electrionico_lead" 
                              placeholder="Correo Electrónico" type="email">
                              <div 
                              class="input-group-addon btn btn_enviar_email_prospecto" 
                              style="background: #0054C2!important;font-size: .8em;" 
                              id="seccion_recibir_promociones">
                                  Recibir promociones
                                      
                              </div>
                          </div>                                                    
                      <?=end_row()?>
                      <div>
                                
                      </div>
                      <?=n_row_12()?>
                        <div class="place_registro_contacto">
                        </div>
                      <?=end_row()?>
                      

                    </div>                    
                </form>
        </div>
    </div>
</div>