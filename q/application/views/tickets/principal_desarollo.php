<?=n_row_12()?>
  <span   
    class='text-center strong'>
    # Resultados
    <?=count($info_tickets);?>    
  </span>   
<?=end_row()?>
<?php  
	$l ="";
	$estilos_estra =""; 	
	foreach ($info_tickets as $row) {	

    $id_ticket    =   $row["id_ticket"];
    $asunto       =   $row["asunto"];        
    $id_usuario   =   $row["id_usuario"];
    $fecha_registro            =   $row["fecha_registro"];           
    $nombre_departamento  = $row["nombre_departamento"];
    $num_tareas_pendientes = $row["num_tareas_pendientes"];

    $tareas_pendientes ="class='strong white ver_detalle_ticket 
    a_enid_black_sm' id='".$id_ticket."' ";

    $id_usuario = $row["id_usuario"];		
		$img_cliente = "../imgs/index.php/imagen_usuario/".$id_usuario;				
    $url_imagen ="../imgs/index.php/enid/imagen_usuario/".$id_usuario;	
    
			
			$btn_agregar_servicios =  "";
			
      ?>
        <div class="popup-box chat-popup" id="qnimate">
            <div class="popup-head">
              
              <div class="popup-head-left pull-left">
                  <div>
                    <?=img( 
                      array(
                        'src'     => $url_imagen ,
                        'style'   => 'width: 44px!important;',
                        'onerror' =>  'this.src="'.$url_imagen.'" '
                      )
                    )?>
                      <span class="black">
                        <?=$asunto?> 
                      </span>
                  </div>
                  <div <?=$tareas_pendientes?>>                     
                        #Tareas pendientes:  <?=$num_tareas_pendientes?>
                  </div>
              </div>
              <div class="popup-head-right pull-right ">
                <div class="btn-group">
                        <button 
                          class="chat-header-button" 
                          data-toggle="dropdown" 
                          type="button">
                           <?=icon("fa fa-plus")?>                        
                           </i> 
                        </button>
                        <ul class="dropdown-menu pull-right ">
                          <li>
                              <a <?=$tareas_pendientes?>>
                                Agregar tareas
                              </a>
                          </li>                        
                        </ul>
                </div>        
              </div>
          </div>
        </div>                
      <?php 
	}
?>