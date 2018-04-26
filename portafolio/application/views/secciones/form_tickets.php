<div class="col-lg-6 col-lg-offset-3">
  <span class="titulo_enid">
    ABRIR SOLICITUD
  </span>
</div>
<div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">
  <form class='form_ticket'>                
      <input id="prioridad" name="prioridad" value="1"  type="hidden">
      <input type="hidden" name="mensaje" id="mensaje" class="mensaje">      
      <?=n_row_12()?>
        <span class="titulo_enid_sm_sm">
            DEPARTAMENTO AL CUAL SOLICITAS
        </span>
      <?=end_row()?>
      <?=n_row_12()?>
        <?=create_select(
            $departamentos,
            "departamento" , 
            "form-control" , 
            "departamento" , 
            "nombre" , 
            "id_departamento" 
        );?>          
      <?=end_row()?>
      <?=n_row_12()?>
          <div class="input-group" style="margin-top: 10px;">
            <span class="input-group-addon">
              MODULO, ASUNTO, TÓPICO
            </span>
            <input id="asunto" name="asunto" class="form-control" 
            placeholder="MODULO, ASUNTO, TÓPICO" required="" type="text">
          </div>                        
      <?=end_row()?>
      <?=n_row_12()?>
        <button class='a_enid_blue' style="margin-top: 30px;">
          ABRIR TICKET
        </button>
      <?=end_row()?>
  </form>
</div>

<?=n_row_12()?>
  <div class='place_registro_ticket'>
  </div>
<?=n_row_12()?>