<nav class="nav-sidebar">
    <ul class="nav tabs">                                   
        
        <li class='black li_menu <?=valida_seccion_activa(3 , $activa )?>' 
            style='background:white;'>
            <a  
                href="#tab_nuevo_ticket" 
                data-toggle="tab"                         
                class="a_enid_blue abrir_ticket" 
                style="color: white!important;">
                ABRIR TICKET
            </a>
        </li>   

        <li class='black li_menu <?=valida_seccion_activa(2 , $activa )?>' style='background:white;'>
            <a  
                href="#tab_charts" 
                data-toggle="tab"                         
                id="ver_avances" 
                class='black strong'>
                <i class="fa fa-area-chart">
                </i>
                Métricas                        
            </a>
        </li>                 
        <li class='black li_menu <?=valida_seccion_activa(1 , $activa )?>' 
            style='background:white;'>
            <a                          
                                    href="#tab_abrir_ticket" 
                                    data-toggle="tab" 
                                    id='base_tab_clientes' 
                                    class='black strong base_tab_clientes'>
                <i class="fa fa-check-circle">
                </i>
                                    Pendientes
                <span class="place_tareas_pendientes">
                </span>
            </a>
        </li>       
    </ul>
</nav> 

    