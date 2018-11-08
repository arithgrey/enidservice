<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){  
  function lista_horarios(){

    $horarios = [
      "09:00", 
      "09:30", 
      "10:00", 
      "10:30", 
      "11:00",
      "11:30", 
      "12:00", 
      "12:30", 
      "13:00", 
      "13:30", 
      "14:30", 
      "15:00", 
      "15:30", 
      "16:30", 
      "17:00", 
      "17:30", 
      "18:00", 
    ];
                            
    $select   = "<select name='horario_entrega' class='form-control input-sm '  > ";
    foreach ($horarios as $row) {
        $select .=  "<option value='".$row."'>".$row."</option>";
    }
    $select   .= "</select>";
    return  $select;

  }

}