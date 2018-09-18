  
  <div class="tab-pane active text-style" id="tab2">              
      <div class="seccion_continido_afiliados">
        
        <?=n_row_12()?>
          <div class="row">
            
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
              <p 
                class="white strong" 
                style="font-size: 2.85em;line-height: .8;background: #0036d1;padding: 5px;">  
                Notifica tu pago para que podamos procesarlo
              </p>
           
            </div>
            <div class="col-lg-2">
              <center>
              <div>
                <i class="fa fa-usd ">                  
                </i>
              </div>
              </center>
            </div>
          </div>
        

          <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
              
              
              
                <p  class="strong">                                        
                  Llene el siguiente formulario con los datos de el pago realizado. 
                </p>
                


        <?=n_row_12()?>
          <div>
            <form id="form_notificacion" class="form_notificacion" name="form_notificacion" method="post">    
                <div class="row">
                  <p class="col-lg-4 ">
                    <span >
                      No. de Recibo
                    </span>
                    <input 
                      name="num_recibo" 
                      class="input-sm num_recibo" 
                      id="num_recibo" 
                      placeholder="# Recibo" 
                      maxlength="6" 
                      type="text"
                      required=""
                      value="<?=$num_recibo?>">
                      
                  </p>

                </div>

                <?=place("place_recibo")?>
                
                <div id='inputs-notificacion'>
                <div class="row">
                  <p class="col-lg-12 ">
                    <span >
                      Nombre y Apellido *
                    </span>
                    <input name="nombre" class="form-control nombre" 
                    id="nombre" 
                    placeholder="nombre" 
                    type="text"
                    required="">
                  </p>
                </div>          

                <div class="row">
                  <p class="col-lg-12 ">
                    <span >
                    Correo *
                    </span>
                    <input class="form-control email" id="Correo" name="correo" placeholder="@" type="email" required="">
                  </p>
                </div>

                <div class="row">
                  <p class="col-lg-6 " style="display: none;">
                    <span >
                      Dominio 
                    </span>
                    <input 
                      class="form-control" 
                      id="dominio" 
                      name="dominio" 
                      placeholder="Dominio" 
                      type="text">
                  </p>

                  <p class="col-lg-6 ">
                    <span >
                      Servicio *
                    </span>                  
                  </p>
                      <?=create_select($servicio , 
                      "servicio" , 
                      "form-control input-sm servicio" , 
                      "servicio" , 
                      "nombre_servicio" , 
                      "id_servicio" );?>
                    
                </div>

                <div class="row">
                  <p class="col-lg-6 ">                  
                    <span >
                      Fecha de Pago *
                    </span>
                    <input  
                      data-date-format="yyyy-mm-dd"
                      value="<?=now_enid();?>"  
                      name='fecha' 
                      class="form-control datetimepicker4 " 
                      id='datetimepicker4'/>                    
                  </p>

                  <p class="col-lg-6 ">
                    <span >
                      Cantidad *
                    </span>                    
                    <input 
                    class='form-control input-sm cantidad' 
                    step="any"
                    placeholder="$ .00"
                    type="number" 
                    name="cantidad"
                    required> 

                  </p>
                </div>


                
                <div class="row">
                  <p class="col-lg-6 ">
                    <span >
                      Forma de Pago *
                    </span>                    
                    <?=create_select($forma_pago , 
                    "forma_pago" , 
                    "input-sm" , 
                    "forma_pago" , 
                    "forma_pago" , 
                    "id_forma_pago" );?>
                      
                  </p>

                  <p class="col-lg-6 " style="display: none;">
                    <span >
                      Referencia
                    </span>
                    <input class="input-sm" 
                    id="referencia" 
                    name="referencia" 
                    placeholder="" 
                    type="text">
                  </p>
                </div>

                <div class="row">
                  <p class="col-lg-12 ">
                    <span 
                    >
                      Información Adicional
                    </span>
                    <textarea 
                      class="form-control" 
                      id="comentarios" 
                      name="comentarios" 
                      rows="2" 
                      style="resize:none" 
                      placeholder="Información Adicional">                    
                    </textarea>
                  </p>
                </div>
                
                 
                  <p class="col-lg-6">
                  </p>
                  <div style="margin-top: 25px">
                  <input 
                  name="Submit" 
                  class="btn " 
                  value="Notificar Pago" 
                  type="submit">
                  </div>  <p>
                  </p>
                  </div>

            </form>
            <div class="placa_notificador_pago">              
            </div>
          </div>
        <?=end_row()?>  



              
              

            </div>
            <div class="col-lg-2">
              
            </div>
          </div>

        <?=end_row()?>  



      </div>    
      
        <hr>        
    </div>
    