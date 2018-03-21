<?php 
  $extra_tab ="href='#tab_info_validacion' data-toggle='tab'";
?>
      <div>                
        <div class="row">
        <div class='col-lg-6'>
          <div style="background: black; font-size: .8em;" class='white'>
            Dominio deseado
          </div>
          <span 
            class='agregar_info_validacion'
            onclick="carga_info_form('<?=$dominio_deseado;?>' ,  '<?=$plantilla_sugerida;?>' ,  '<?=$comentario_previo_a_venta;?>');"
          <?=$extra_tab;?> style='font-size: .8em;'>
            <?=evalua_cadena($dominio_deseado);?>
          </span>
        </div>
        <div class='col-lg-6'>
          <div style="background: black; font-size: .8em;" class='white'>
            Plantilla
          </div>
          <span  
          class='agregar_info_validacion'
          onclick="carga_info_form('<?=$dominio_deseado;?>' ,  '<?=$plantilla_sugerida;?>' ,  '<?=$comentario_previo_a_venta;?>');"
          <?=$extra_tab;?> 
          style='font-size: .8em;'> 
            <?=evalua_cadena($plantilla_sugerida);?>
          </span>  
        </div>

        <div class='col-lg-12'>
          <div style="background: black; font-size: .8em;" class='white'>
            Anotaciones
          </div>
          <span 
          class='agregar_info_validacion'
          onclick="carga_info_form('<?=$dominio_deseado;?>' ,  '<?=$plantilla_sugerida;?>' ,  '<?=$comentario_previo_a_venta;?>');"
          <?=$extra_tab;?> 
          style='font-size: .8em;'> 
              <?=evalua_cadena($comentario_previo_a_venta);?>
          </span>      
        </div>
      </div>
    </div>