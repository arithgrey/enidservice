<div>
  <form class='form_ticket'>    
      
      <div class="col-lg-6" style="display: none;">
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
        <div class="col-md-8">
          <?=create_select(
            $departamentos,
            "departamento" , 
            "form-control" , 
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
      <input type="hidden" name="mensaje" id="mensaje" class="mensaje">
      <button class='btn'>
        Enviar
      </button>
  </form>
</div>


<?=n_row_12()?>
  <div class='place_registro_ticket'>
  </div>
<?=n_row_12()?>