<nav class="nav-sidebar">
    <ul class="nav tabs">                                           
        <li class='black li_menu <?=valida_seccion_activa(3 , $activa )?>' 
            style='background:white;'>
            <?=anchor_enid("ABRIR TICKET" , 
            ["href" =>  "#tab_nuevo_ticket" ,
            "data-toggle"   =>  "tab" ,
            "class"         =>  "a_enid_blue abrir_ticket" ])?>
        </li>   
        <li class='black li_menu <?=valida_seccion_activa(2 , $activa )?>' style='background:white;'>
            <?=anchor_enid(
                icon("fa fa-area-chart"). "Métricas",
                [
                "href"              =>"#tab_charts" 
                ,"data-toggle"      =>"tab"                         
                ,"id"               =>"ver_avances"
                ,"class"            =>'black strong'
            ])?>
        </li>                 
        <li class='black li_menu <?=valida_seccion_activa(1 , $activa )?>' style='background:white;'>
            <?=anchor_enid("Pendientes" . icon('fa fa-check-circle'), 
                [
                "href"          =>"#tab_abrir_ticket" 
                ,"data-toggle"   =>"tab" 
                ,"id"            =>'base_tab_clientes' 
                ,"class"         =>'black strong base_tab_clientes'
                ])?>                        
                <?=place('place_tareas_pendientes')?>
            </a>
        </li>       
    </ul>
</nav> 