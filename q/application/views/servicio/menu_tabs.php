<?php 
  $foto_config    =  ['href' => "#tab_imagenes" , 'data-toggle'    => "tab" ];
  $precios_config =  ['href' => "#tab_info_precios" , 'data-toggle'   => "tab" ];  
  $precios_inf    =  [  'href' => "#tab_info_producto" ,
                        'data-toggle'   => "tab",
                        'id'            => 'tab_info_producto_seccion',
                        'class'         => 'detalle'
                      ];  
  $meta_inf       =   ['href' => "#tab_terminos_de_busqueda" ,'data-toggle'   => "tab"];
  
?>
<ul class="nav nav-tabs">
    <li <?=valida_active($num , 1);?> >
        <?=anchor_enid( icon('fa fa-picture-o') , $foto_config)?>  
    </li> 
    <li <?=valida_active($num , 4 );?> 
        <?=valida_existencia_imagenes($num_imagenes)?> >
        <?=anchor_enid( icon('fa fa-credit-card') , $precios_config )?>
    </li>
    <li <?=valida_existencia_imagenes($num_imagenes)?>>      
        <?=anchor_enid( icon('fa fa-info detalle') , $precios_inf )?>
    </li>
    <li  <?=valida_active($num , 3);?>  
        <?=valida_existencia_imagenes($num_imagenes)?>>         
        <?=anchor_enid( icon('fa fa-fighter-jet menu_meta_key_words'), $meta_inf )?>
    </li>        
    <li <?=valida_existencia_imagenes($num_imagenes)?> >                    
      <?=anchor_enid(icon("fa fa-shopping-bag")."VER PUBLICACIÓN" , 
      [
        "href"    => $url_productos_publico,
        "target"  => "_blank",
        "style"   => 'background: #002565;color: white!important;'
      ]);?>
    </li>                 
</ul>
      