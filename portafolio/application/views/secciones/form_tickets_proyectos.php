<div class="col-lg-12 col-md-12 col-sm-12  "> 
  <a class="regresar_tickets_usuario strong  black">
  <i class="fa fa-chevron-circle-left">            
  </i>
    Regresar a mis tickets abiertos
  </a>
</div>
        
<div class='col-lg-8 col-lg-offset-2'>
  <form class='form_ticket'>    

    
      <div class="col-lg-12">      
        
        <label>
          Cliente
        </label>
        <?=create_select($clientes_disponibles , 
        "cliente" , 
        "form-control lista_cliente_ticket" , 
        "cliente" , 
        "nombre" , 
        "id_persona" );?>
        <label>
          Servicio
        </label>
         <div class="place_lista_servicios">          
            <?=create_select(
              $servicios_cliente , 
              "id_proyecto" , 
              "form-control" , 
              "servicios_cliente" , 
              "proyecto" , 
              "id_proyecto" );?>
         </div>         
         <div>
            <a class="input-sm btn btn_siguiente_ticket" style="background: black!important;">
              Siguiente
            </a>
         </div>
      </div>



                 
      
      <div style="display: none;" class="contenedor_formulario_ticket">
        <div class="col-lg-6">
          <label class="col-md-3 control-label blue_enid_background white" for="prioridad">
            Prioridad
          </label>
          <div class="col-md-9">
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
          <label class="col-md-4 control-label blue_enid_background white" for="departamento">
            Departamento
          </label>
          <div class="col-md-8 contenedor_form_depto">

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
              <span class="input-group-addon">Asunto
              </span>
              <input id="asunto" name="asunto" class="form-control" placeholder="Solicitud" required="" type="text">
            </div>                  
        </div>
        <br>
        <br>
        <!-- Textarea -->

        <div class="col-lg-12" style="display: none;">
          <label class="control-label blue_enid_background white" for="mensaje">
            Descripción
          </label>
          <div class="">                     
            <textarea class="form-control" id="mensaje" name="mensaje"></textarea>
          </div>
        </div>
      
        <button class='btn'>
          Abrir ticket
        </button>
      </div>
  </form>
</div>


<?=n_row_12()?>
  <div class='place_registro_ticket'>
  </div>
<?=n_row_12()?>