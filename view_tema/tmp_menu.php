<?php     
    
    $img_conf  = [    
        "id"      =>  'imagen_usuario' ,
        "src"     =>  "../imgs/index.php/enid/imagen_usuario/".$id_usuario ,
        "onerror" =>  "this.src='../img_tema/user/user.png'" ,
        "style"   =>  "width: 30px!important;height: 25px;"
    ];
    $img_user =  img($img_conf);

    $a_privacidad    = 
    anchor_enid("Configuración y privacidad" , ["href"=>"../administracion_cuenta/"]);

    $a_cerra_session = 
    anchor_enid("Cerrar sessión" , ["href"=>"../login/index.php/startsession/logout"]);


    $estrellas = "";
    for ($a=0; $a < 4; $a++) { 
        $estrellas  .=  
        span('★', '', ["class"=>"estrella", "style"=>"color: #0070dd;"]);     
    }
    $estrellas      .=  span('★', '', 
    [
    "class" =>  "estrella", 
    "style" =>  
    "-webkit-text-fill-color: white;-webkit-text-stroke: 0.5px rgb(0, 74, 252);"]);
        
    $link_valoraciones  = 
        anchor_enid(
        "Mis reseñas y valoraciones" .
        div($estrellas , ["class"=>"contenedor_promedios"]),
        ["href" =>  "../recomendacion/?q=".$id_usuario ]
    );     
     
?>
<?php if ($in_session ==  1):?>    

    <li class="dropdown pull-right">
        <?=$img_user?>     
        <?=ul(
            [
            $nombre,
            $menu,
            $link_valoraciones, 
            $a_privacidad, 
            $a_cerra_session 
            ],  
            [ "class"=>"dropdown-menu menu_usuario"]
        )?>           
    </li>  

    <li 
    class="dropdown pull-right blue_enid_background menu_notificaciones_progreso_dia">
        <?=anchor_enid(
            icon("fa fa-bell white").
            span("", ["class"=>"num_tareas_dia_pendientes_usr"]),
            [
                "class"         =>  "blue_enid dropdown-toggle" ,
                "data-toggle"   =>  "dropdown"
        ])?>    
        <?=ul(
            [place("place_notificaciones_usuario")],
            [
                "class"=>"dropdown-menu", 
                "style"=>"padding: 3px;width: 300px;"
            ]
        )?>
    </li>
    
    <?=li(anchor_enid(
        "ANUNCIA TUS PRODUCTOS". icon("fa fa-cart-plus") , 
        [
            "href"  =>  "../planes_servicios/?action=nuevo",
            "class" =>  "white"
        ]
        ) , 
        ["class"=>"dropdown  pull-right  boton_vender_global"]    
    )?>    
<?php endif;?>