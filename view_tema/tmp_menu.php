<?php     
    

    $a_privacidad    = 
    anchor_enid("Configuración y privacidad" , ["href"=>"../administracion_cuenta/"]);

    $a_cerra_session = 
    anchor_enid("Cerrar sessión" , ["href"=>"../login/index.php/startsession/logout"]);


    $estrellas = "";
    for ($a=0; $a < 4; $a++) { 
        $estrellas  .=  
        span('★', ["class"=>"estrella", "style"=>"color: #0070dd;"]);     
    }
    $estrellas      .=  span('★', 
    [
    "class" =>  "estrella", 
    "style" =>  "-webkit-text-fill-color: white;-webkit-text-stroke: 0.5px rgb(0, 74, 252);"]);
        
    $link_valoraciones  = 
        anchor_enid(
        "Mis reseñas y valoraciones" .
        div($estrellas , ["class"=>"contenedor_promedios"]),
        ["href" =>  "../recomendacion/?q=".$id_usuario ]
    );     
     
?>

    <div class="pull-right">
        <li class="dropdown  menu_notificaciones_progreso_dia">
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
                    "class" =>  "dropdown-menu ",
                    "style" =>  "width:500px!important;"
                ]
            )?>
        </li>
        <li class="dropdown ">
            <?=get_img_usuario($id_usuario)?>
            <?=ul(
                [
                "",
                $menu,
                $link_valoraciones,
                $a_privacidad,
                $a_cerra_session
                ],
                [ "class"=>"dropdown-menu menu_usuario"]
            )?>
        </li>
    </div>