        <nav class="nav-sidebar">
            <ul class="nav tabs ">                
                <li class='black li_menu <?=valida_seccion_activa(1 , $activa )?>' 
                    style='background:white;'>
                    <a  
                        title="Publicidad en redes sociales" 
                         
                        href="#tab_redes_sociales" 
                        data-toggle="tab"                         
                        class='black tab_redes_s '>
                        <i class="fa fa-fighter-jet">                          
                        </i>                        
                        Social  
                        <span class="place_notificacion_accesos_dia">                        
                        </span>      
                    </a>
                </li>                      
                <li class='black li_menu <?=valida_seccion_activa(2 , $activa )?>' 
                    style='background:white;'>
                    <a  
                        title="Email marketing" 
                         
                        href="#tab_en_correo_electronico" 
                        data-toggle="tab"                         
                        class='black tab_marketing'>                        
                        <i class="fa fa-envelope strong black">                          
                        </i>
                        Email 
                        <span class="place_notificacion_email_enviados">                            
                        </span>

                    </a>
                </li>                      
                    
                <li class='black li_menu' style="display: none;">
                    <a                          
                        href="#agregar_productos_servicios" 
                        data-toggle="tab"                         
                        class='black menu_agregar_productos_servicios'
                        id="menu_agregar_productos_servicios">
                        
                    </a>
                </li>                      
                
            </ul>
        </nav>