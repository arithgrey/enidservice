  <div class="tab-pane active text-style" id="tab2">              
      <div class="seccion_continido_afiliados">
        
        <?=n_row_12()?>
          <div class="row">
            
            <?=div("" ,["class"=>"col-lg-2"])?>
            <?=div(
              div(
                "Notifica tu pago para que podamos procesarlo",
                [
                  "class" =>  "white strong" ,
                  "style" =>  "font-size: 2.85em;line-height: .8;background: #0036d1;padding: 5px;"
                ]
              )
              ,
              ["class"  =>  "col-lg-8"]
            )?>

            <?=div(icon('fa fa-usd ') ,  ["class"=>"col-lg-2"])?>                            
          </div>
      
          <div class="row">
            <?=div("" ,["class"=>"col-lg-2"])?>
            <div class="col-lg-8">
              <?=div("Llene el siguiente formulario con los datos de el pago realizado. " , 
              ["class" => "strong"])?>              
        <?=n_row_12()?>
          <form id="form_notificacion" class="form_notificacion" name="form_notificacion" method="post">    
                <div class="row">
                  <div class="col-lg-4 ">
                    <?=span("No. de Recibo")?>
                    <?=input([
                      "name"            =>  "num_recibo" ,
                      "class"           =>  "input-sm num_recibo" ,
                      "id"              =>  "num_recibo" ,
                      "placeholder"     =>  "# Recibo" ,
                      "maxlength"       =>  "6" ,
                      "type"            =>  "text",
                      "required"        =>  true,
                      "value"           =>  $num_recibo
                    ])?>                                        
                  </div>
                </div>

                <?=place("place_recibo")?>
                
                <div id='inputs-notificacion'>
                <div class="row">                  
                  <div class="col-lg-12 ">
                    <?=span("Nombre y Apellido *")?>
                    <?=input([
                      "name"          =>  "nombre" ,
                      "class"         =>  "form-control nombre" ,
                      "id"            =>  "nombre" ,
                      "placeholder"   =>  "nombre" ,
                      "type"          =>  "text",
                      "required"      =>   true
                    ])?>
                  </div>
                </div>  

                <div class="row">
                  <div class="col-lg-12 ">
                    <?=span("Correo *")?>
                    <?=input([
                      "class"         =>  "form-control email",
                      "id"            =>  "Correo" ,
                      "name"          =>  "correo" ,
                      "placeholder"   =>  "@" ,
                      "type"          =>  "email" ,
                      "required"      =>  true 
                    ])?>
                  </div>
                </div>

                <div class="row">                  
                  <?=p("Producto *" , ["class"=>"col-lg-6 "])?>
                  <?=create_select($servicio , 
                      "servicio" , 
                      "form-control input-sm servicio" , 
                      "servicio" , 
                      "nombre_servicio" , 
                      "id_servicio" );?>
                    
                </div>

                <div class="row">
                  <div class="col-lg-6 ">                  
                    <?=span("Fecha de Pago *")?>
                    <?=input([
                      "data-date-format"  =>  "yyyy-mm-dd",
                      "value"             =>   now_enid(),
                      "name"              =>  'fecha' ,
                      "class"             =>  "form-control datetimepicker4 " ,
                      "id"                =>  'datetimepicker4'
                    ])?>                    
                  </div>

                  <div class="col-lg-6 ">
                    <?=span("Cantidad *")?>
                    <?=input([
                      "class"         =>  'form-control input-sm cantidad' ,
                      "step"          =>  "any",
                      "placeholder"   =>  "$ .00",
                      "type"          =>  "number", 
                      "name"          =>  "cantidad",
                      "required"      =>  true
                    ])?>                  
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6 ">
                    <?=span("Forma de Pago *")?>                    
                    
                    <?=create_select($forma_pago , 
                        "forma_pago" , 
                        "input-sm" , 
                        "forma_pago" , 
                        "forma_pago" , 
                        "id_forma_pago" );?>                      
                  </div>
                </div>

                <div class="row">
                    <?=span("Información Adicional")?>
                    <?=textarea([
                      "class"           =>  "form-control" ,
                      "id"              =>  "comentarios" ,
                      "name"            =>  "comentarios" ,
                      "rows"            =>  "2" ,
                      "style"           =>  "resize:none" ,
                      "placeholder"     =>  "Información Adicional"
                    ])?>
                </div>
                
                <?=guardar(
                  "Notificar Pago",
                  [
                    "name"    =>  "Submit" ,
                    "class"   =>  "btn " ,                  
                    "type"    =>  "submit"
                  ],1,1)?>                  
              </div>
            </form>
            
          <?=place("placa_notificador_pago")?>          
        <?=end_row()?>  
            </div>
            <?=div("", ["class"=>"col-lg-2"])?>
            
          </div>

        <?=end_row()?>  
      </div>          
        <hr>        
    </div>
    