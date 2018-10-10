<nav class="nav-sidebar">
    <ul class="nav tabs ">                
        <li class='black li_menu <?=valida_seccion_activa(1 , $activa )?>' style='background:white;'>
            <?=anchor_enid("Social".icon('fa fa-fighter-jet'). 
                div("" , ["class" => "place_notificacion_accesos_dia"]) , 
            [

                "href"          =>  "#tab_redes_sociales" ,
                "data-toggle"   =>  "tab"       ,
                "class"         =>  'black tab_redes_s '
            ])?>                
        </li>   
        <li class='black li_menu <?=valida_seccion_activa(2 , $activa )?>' style='background:white;'>
            <?=anchor_enid(
                icon('fa fa-envelope strong black').
                "Email" .
                div("" , ["class"=> "place_notificacion_email_enviados"])
                ,

                [
                    "href"          =>  "#tab_en_correo_electronico" ,
                    "data-toggle"   =>  "tab",
                    "class"         =>  'black tab_marketing'
                ]                        
            )?>                
        </li>                      
        <li class='black li_menu' style="display: none;">
            <?=anchor_enid("",
            [
                "href"              =>  "#agregar_productos_servicios" ,
                "data-toggle"       =>  "tab"                         ,
                "class"             =>  'black menu_agregar_productos_servicios',
                "id"                =>  "menu_agregar_productos_servicios"
            ])?>                
        </li>                                  
    </ul>
</nav>