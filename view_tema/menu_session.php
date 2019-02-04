<?php if ($in_session ==  0 ):  ?>
    <?php 
        $link_vender    = 
        anchor_enid("Vender". icon("fa fa-shopping-cart") , 
        ["href"=>"../login/?action=nuevo" ,  "class" =>'links white']);

        
        $links_envio_msj =
        anchor_enid("Envía mensaje". icon("fa fa-paper-plane") , 
        ["href"=>"../contact/#envio_msj" ,  "class" =>'links white']);

        $links_session =
        anchor_enid("Iniciar sesión". icon("fa fa-user") , 
        ["href"=>"../login" ,  "class" =>'links white']);


        $list = [ $links_session , $link_vender];
    ?>
    <?php if(!isset($proceso_compra)  || (isset($proceso_compra) && $proceso_compra ==  0)){
        echo div(ul($list , ["class"  => "largenav pull-right"]) ,  ["class"]);
    }?>

<?php endif; ?>