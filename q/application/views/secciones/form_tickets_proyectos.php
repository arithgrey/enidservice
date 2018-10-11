<div class="col-lg-12 col-lg-12 col-sm-12  "> 

  <?=anchor_enid(
    icon('fa fa-chevron-circle-left'). "Regresar a mis tickets abiertos" ,
    ["class"  =>  "regresar_tickets_usuario strong  black"]
  )?>  
</div>
        
<div class='col-lg-8 col-lg-offset-2'>
  <form class='form_ticket'>      
      <div class="col-lg-12">              
        <?=label("Cliente")?>        
        <?=create_select($clientes_disponibles , 
        "cliente" , 
        "form-control lista_cliente_ticket" , 
        "cliente" , 
        "nombre" , 
        "id_persona" );?>
        <?=label("Servicio")?>        

        <?=div(create_select(
              $servicios_cliente , 
              "id_proyecto" , 
              "form-control" , 
              "servicios_cliente" , 
              "proyecto" , 
              "id_proyecto" ), 
            ["class"  => "place_lista_servicios"]
        );?>        
        <?=anchor_enid("Siguiente" , ["class"=>"input-sm btn btn_siguiente_ticket"],1)?>
      </div>
                 
      
      <div style="display: none;" class="contenedor_formulario_ticket">
        <div class="col-lg-6">
          <?=label("Prioridad" , 
          [
            "class" =>  "col-lg-3 control-label blue_enid_background white" ,
            "for"   =>  "prioridad"
          ])?>
          
          <div class="col-lg-9">
            <select id="prioridad" name="prioridad" class="form-control">
              <option value="1">Alta
              </option>
              <option value="2">Media
              </option>
              <option value="3">Baja
              </option>
            </select>
          </div>
        </div>
        
        <div class="col-lg-6">
          <label class="col-lg-4 control-label blue_enid_background white" for="departamento">
            Departamento
          </label>
          <div class="col-lg-8 contenedor_form_depto">

            <?=create_select(
              $departamentos,
              "departamento" , 
              "form-control depto" , 
              "departamento" , 
              "nombre" , 
              "id_departamento" 
              );?>          
          </div>
        </div>

        <div class="col-lg-12">            
            <div class="input-group">
              <?=span("Asunto" , ["class"=>"input-group-addon"])?>
              <?=input([
                "id"            =>  "asunto", 
                "name"          =>  "asunto", 
                "class"         =>  "form-control",
                "placeholder"   =>  "Solicitud",
                "type"          =>  "text"
              ])?>                            
            </div>                  
        </div>
        
        
        <!-- Textarea -->
        <div class="col-lg-12" style="display: none;">
          <?=label("Descripción" , 
          [ "class" =>  "control-label blue_enid_background white" ,
            "for"   =>  "mensaje"] 
          )?>          
          <textarea class="form-control" id="mensaje" name="mensaje"></textarea>          
        </div>
        <?=guardar("Abrir ticket" , ["class"=>'btn'])?>
      </div>
  </form>
</div>
<?=place("place_registro_ticket")?>
