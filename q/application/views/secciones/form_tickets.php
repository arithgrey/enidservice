<div class="col-lg-6 col-lg-offset-3">
  <?=div("ABRIR SOLICITUD" ,  ["class"=>"titulo_enid"])?>
</div>
<div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">
  <form class='form_ticket'>                      
      <?=input_hidden([
        "name" =>  "prioridad",
        "value" => "1" 
      ])?>
      <?=input_hidden([
        "name" =>  "mensaje",
        "id"  => "mensaje",
        "class"  => "mensaje"
      ])?>      
      <?=div("DEPARTAMENTO AL CUAL SOLICITAS" ,  1)?>

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
          <div class="input-group" >
            <?=div("MODULO, ASUNTO, TÓPICO" , ["class"=>"input-group-addon"])?>
            <?=input([
                "id"              =>  "asunto" ,
                "name"            =>  "asunto" ,
                "class"           =>  "form-control" ,
                "placeholder"     =>  "MODULO, ASUNTO, TÓPICO" ,
                "required"        =>  "true" ,
                "type"            =>  "text"
            ])?>
          </div>                        
      <?=end_row()?>          
      <?=guardar("ABRIR TICKET")?>    
  </form>
</div>
<?=place("place_registro_ticket")?>