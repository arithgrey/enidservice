<?php
    
    $a_tab_pagos  = anchor_enid("" , 
        [
            "href"          =>  "#tab_pagos", 
            "data-toggle"   =>  "tab", 
            "class"         =>  'black strong tab_pagos' , 
            "id"            =>  'btn_pagos'
        ]);

    $a_vendedor   = anchor_enid("VENDER" , 
        [
            "href"          =>  "../planes_servicios/?action=nuevo",  
            "class"         =>  "white" , 
            "style"         =>  "color: white!important"
    ]);   
    /**/
    $icon         = icon('fa fa-shopping-bag');
    $place_mis_ventas = place("place_num_pagos_notificados");
    $a_mis_ventas     = anchor_enid($icon . "TUS VENTAS".$place_mis_ventas , 
        ["id"               =>  "mis_ventas",
         "href"             =>  "#tab_mis_ventas",
         "data-toggle"      =>  "tab",
         "class"           =>  'black strong btn_mis_ventas']);

    /**/
    $icon         = icon('fa fa-credit-card-alt');
    $place = place("place_num_pagos_por_realizar" );
    $a_mis_compras = anchor_enid($icon."TUS COMPRAS".$place,
        ["id"=>"mis_compras" ,"href"=>"#tab_mis_pagos" ,"data-toggle"=>"tab","class"=>'black strong btn_cobranza mis_compras']);

    /*
    $icon = icon('fa fa-comments');
    $place = place('notificacion_preguntas_sin_leer_cliente_buzon');
    $a_buzon = anchor_enid($icon."BUZÓN".$place, 
        [
            "id"            =>  "mi_buzon",
            "href"          =>  "#tab_buzon" ,
            "data-toggle"   =>  "tab" ,
            "class"         =>  'black strong btn_buzon'
    ]);
    */
?>
    <div class="col-lg-2" >               
        <nav class="nav-sidebar">            
            <ul class="nav tabs">
                <li class='li_menu' style="display: none;">
                    <?=$a_tab_pagos?>
                </li> 
                <li class="li_menu menu_vender <?=valida_active_tab('ventas' , $action)?>">
                    <?=$a_vendedor?>
                </li>
                <li class='li_menu'>
                    <?=$a_mis_ventas?>
                </li> 
                <li  class='li_menu <?=valida_active_tab('compras' , $action)?>'>
                    <?=$a_mis_compras?>
                </li> 
                <!--
                <li class='li_menu <?=valida_active_tab('preguntas' , $action)?>'>
                    <?=$a_buzon?>
                </li> 
                -->
            </ul>
        </nav>          
    </div>