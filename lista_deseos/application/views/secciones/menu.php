<?php    
    $preferencias 
    =  anchor_enid(
        "TUS PREFERENCIAS E INTERESES", 
        ["id"=>"mis_ventas", "href"=>"?q=preferencias", "class"=>'btn_mis_ventas' ]); 

    $articulos_deseados  
    =  anchor_enid(
        "TU LISTA DE ARTÍCULOS DESEADOS", 
        ["id"=>"mis_compras", "href"=>"../lista_deseos", 
        "class"=>'btn_cobranza mis_compras' ]); 

    $list =  [$preferencias ,  $articulos_deseados];

?>
<?=ul($list)?>