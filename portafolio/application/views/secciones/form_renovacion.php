<span class="white" style="background: black; padding: 5px;">
  Fecha de vencimiento última renovación
</span>
<span class="white blue_enid_background" style="padding: 5px;">
  <?=$ultima_fecha_vencimiento;?>
</span>


<?php 
  $tmp_razon_social =  $info_persona[0]["nombre"] 
                        . " " . 
                        $info_persona[0]["a_paterno"] 
                        . " " .  
                        $info_persona[0]["a_materno"] ;
  
  $RFC =  $info_persona[0]["RFC"];
  $domicilio_fiscal = $info_persona[0]["domicilio_fiscal"]; 
  $id_proyecto_persona =  $proyecto_persona[0]["id_proyecto_persona"];

?>
<?=n_row_12()?>
    <form class='formulario_renovacion_servicio_cliente' id='formulario_renovacion_servicio_cliente'>      
      <div class='row'>
          <div class="col-lg-12">
              

              <input type="hidden" name="id_proyecto_persona" value="<?=$id_proyecto_persona?>"> 
              <input type="hidden" 
                     name="id_persona" 
                     value='<?=$info_persona[0]['id_persona']?>'>
              <input 
                     type="hidden" 
                     name="usuario_venta" 
                     value='<?=$info_persona[0]['id_usuario']?>'>

              <input type="hidden" name="renovacion" value="1">
          </div>
      </div>
      <div class='row'>                
          <div class='col-lg-3'>
            <div class="input-group">
              <span style="font-size: .8em;">
                Proyecto
              </span>
              <input 
              id="nombre_proyecto" 
              name="nombre_proyecto" 
              class="input-sm" 
              placeholder="Nombre del proyecto" 
              readonly=""
              value="<?=$info_persona[0]["dominio_deseado"]?>"
              type="text">
            </div>          
          </div>
          <div class='col-lg-3'>
            <div class="input-group">
              <span style="font-size: .8em;">
                Dominio 
              </span>
              <input 
              id="url" 
              name="url" 
              value="<?=$info_persona[0]["dominio_deseado"]?>" 
              class="input-sm" 
              placeholder="Url del proyecto" 
              readonly=""
              type="url">
            </div>          
          </div>          
      </div>
      

      


      
      

      <div class='row'>        
        
        <div class="col-lg-3">          
          <div class="input-group ">
            <span style="font-size: .8em;" >
              Precio
            </span>                        
            <?=create_select($precios , 
                "precio" , 
                "form-control input-sm precios_form" , 
                "precios", 
                "precio" , 
                "id_ciclo_facturacion"
            );?>
          </div>                    
        </div>


        <div class="col-lg-3">          
          <div class="input-group ">
            <span style="font-size: .8em;" >
              IVA
            </span>                        
            <div class='place_text_iva'>              
            </div>
          </div>                    
        </div>



        <div class="col-lg-3">          
          <div class="input-group ">
            <span style="font-size: .8em;" >
              Total
            </span>                        
            <div class='place_text_total'>              
            </div>
          </div>                    
        </div>
     
            <div class="col-lg-3">
              <div>
                <span style="font-size: .8em;">
                    Saldo cubierto
                </span>            
                <div>              
                  <div>
                    <input 
                    class=' form-control input-sm saldo_cubierto' 
                    step="any"
                    type="number" 
                    name="saldo_cubierto"> 
                  </div>
                </div>
               </div>          
            </div>



        <div class="col-lg-3">
          <div class="input-group">
            <span style="font-size: .8em;">
              Ciclo de facturación
            </span>            
            <div>
              <span class='place_ciclo_facturacion'>              
              </span>
            </div>

          </div>          
        </div>


        <div class="col-lg-3">
          <div class="input-group">
            <span style="font-size: .8em;">
              Siguiente vencimiento 
            </span>            
            <div>
            <div class=''>
              <div class='place_siguiente_vencimiento'>              
              </div>
            </div>

              <input type="hidden" id="vyear" value='<?=$precios[0]["fecha_actual_mas_1_year"]?>'>
              <input type="hidden" id="vmonth" value='<?=$precios[0]["fecha_actual_mas_1_mes"]?>'>
              <input type="hidden" id="vweek" value='<?=$precios[0]["fecha_actual_mas_1_semana"]?>'>

            </div>
           </div>          
        </div>






        <div class="col-lg-3">
          <div class="input-group">
            <span style="font-size: .8em;">
              Forma de pago
            </span>            
            <div>              
              <div class=''>
                <?=create_select_selected(
                $formas_de_pago , 
                "id_forma_pago", 
                "forma_pago" , 
                "3" , 
                "forma_pago" ,  
                "form-control input-sm forma_pago" );?>
                
                
              </div>
            </div>
           </div>          
        </div>


        <div class="col-lg-3">
          <div class="input-group">
            <span style="font-size: .8em;">
              ¿Requiere factura?
            </span>            
            <div>              
              <div class=''>
               <select class='form-control select_opcion_facturacion' 
               id='select_opcion_facturacion' 
               name='facturar_servicio'>                
                 <option value="0">
                   NO
                 </option>
                 <option value="1">
                   SI
                 </option>
               </select>
              </div>
            </div>
           </div>          
        </div>

        <div style="display: none;" class='seccion_facturacion'>
                  
            <div class="col-lg-4">
              <div>
                <span style="font-size: .8em;">
                  Razón social
                </span>            
                <div>              
                    <input 
                      class='input-sm' 
                      type="text" 
                      value='<?=$tmp_razon_social;?>'
                      name="razon_social"> 
                </div>
               </div>          
            </div>



            <div class="col-lg-4">
              <div>
                <span style="font-size: .8em;">
                  RFC
                </span>            
                <div>           
                    <input 
                    class=' form-control input-sm' 
                    type="text" 
                    name="RFC"
                    value="<?=$RFC?>" 
                    > 
                </div>
               </div>          
            </div>

            <div class="col-lg-4">
              <div>
                <span style="font-size: .8em;">
                    Domicilio fiscal
                </span>            
                <div>              
                  <div>
                    <input 
                    value="<?=$domicilio_fiscal;?>" 
                    class=' form-control input-sm' 
                    type="text" 
                    name="domicilio_fiscal"> 
                  </div>
                </div>
               </div>          
            </div>


            <div class="col-lg-4">
              <div>
                <span style="font-size: .8em;">
                    Saldo cubierto (texto)
                </span>            
                <div>              
                  <div>
                    <input 
                      class='form-control input-sm' 
                      type="text"                     
                      name="saldo_cubierto_texto"> 
                  </div>
                </div>
               </div>          
            </div>
        </div>  

      </div>
      

      <div class='row'>        
        <div class="col-lg-12">
          <span style="font-size: .8em;">
            Concepto
          </span>
          <div>            
            <textarea name='detalles_servicio' 
            class='concepto_servicio' 
            rows="1">              
            </textarea>
          </div>          
        </div>
      </div>                      

      <button class='btn input-sm' style="background: black!important;">
        Liberar proyecto  
      </button>     
      <?=n_row_12()?>
        <div class="place_liberar_servicio">          
        </div>
      <?=end_row()?>
    </form>  
<?=end_row()?>