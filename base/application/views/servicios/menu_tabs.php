<?php 
  /**/
  $icon_config  = array('class' =>  "fa fa-picture-o");   
  $icon         = add_element( "" , "i" , $icon_config );
  $foto_config  =  array('href' => "#tab_imagenes" ,'data-toggle'   => "tab" );
  
  /**/
  $icon_config['class'] =  "fa fa-credit-card";   
  $icon_precios         = add_element( "" , "i" , $icon_config );
  $precios_config       =  array('href' => "#tab_info_precios" ,
                                  'data-toggle'   => "tab" );
  

  $icon_config['class'] =   "fa fa-info";   
  $icon_inf         =   add_element( "" , "i" , $icon_config );
  $precios_inf       =   array( 'href' => "#tab_info_producto" ,
                                  'data-toggle'   => "tab",
                                  'id' => 'tab_info_producto_seccion');
  
  $icon_config['class']   =   "fa fa-fighter-jet menu_meta_key_words";   
  $icon_meta              =   add_element( "" , "i" , $icon_config );
  $meta_inf               =   array( 'href' => "#tab_terminos_de_busqueda" ,
                                  'data-toggle'   => "tab");
  
?>
      <div style="margin-bottom: 40px;"></div>
      <ul class="nav nav-tabs">
              <li <?=valida_active($num , 1);?> >
                  <?=anchor_enid( $icon , $foto_config)?>  
              </li> 

              <li <?=valida_active($num , 4 );?> 
                  <?=valida_existencia_imagenes($imgs)?> >
                  <?=anchor_enid( $icon_precios , $precios_config )?>
              </li>

              <li <?=valida_existencia_imagenes($imgs)?>>      
                  <?=anchor_enid( $icon_inf , $precios_inf )?>
              </li>

              <li  <?=valida_active($num , 3);?>  
                    <?=valida_existencia_imagenes($imgs)?>>         
                    <?=anchor_enid( $icon_meta , $meta_inf )?>                
              </li>
              
              <li <?=valida_existencia_imagenes($imgs)?> >                    
                      <a href="<?=$url_productos_publico?>" target="_blank"
                        style='background: black;color: white!important;'>
                        <i class="fa fa-shopping-bag">                    
                        </i>
                        <span style="font-size: .9em;">
                            VER PUBLICACIÓN
                        </span>
                      </a>                   
              </li>                 
      </ul>
      