            <nav class="nav-sidebar">
                <ul class="nav tabs">                                                    
                    <li  class='li_menu' >
                        <?php 
                            $config["id"]           = 'tab_equipo_enid_service';
                            $config["data-toggle"]  = 'tab';
                            $config["class"]        = 'black strong tab_equipo_enid_service';
                        ?>
                        
                        <?=anchor_enid(
                            '#tab1' , 
                            "<i class='fa fa-space-shuttle' ></i>EQUIPO  ENID SERVICE " ,
                            $config)?>                        
                    </li>
                    <li  class='li_menu'>

                        <?php 
                            $config["id"]= 'tab_afiliados'; 
                            $config["class"] = 'black 
                                                strong 
                                                tab_afiliados 
                                                btn_ventas_mes_usuario';
                        ?>
                        <?=anchor_enid(
                            '#tab_productividad_ventas' , 
                            "<i class='fa fa-handshake-o'>                            
                            </i>
                            AFILIADOS
                            <span class='place_num_productividad'>                            
                            </span>" , $config)?>  
                        
                    </li>                                                                            
                    <li  class='li_menu' >
                        <?php 
                            $config["id"]= 'tab_perfiles'; 
                            $config["class"] = 'black strong perfiles_permisos';
                        ?>
                        <?=anchor_enid(
                            '#tab_perfiles_permisos' , 
                            "<i class='fa fa-unlock-alt' >
                            </i>PERFILES / PERMISOS " ,
                            $config)?>  
                    </li>
                    <li class="li_menu">  
                        <?php 
                            $config3["id"]= 'agregar_categorias'; 
                            $config3["class"] = 'black strong tab_agregar_categorias';
                            $config3["data-toggle"]  = 'tab';
                        ?>                      
                        <?=anchor_enid(
                            '#tab_agregar_categorias' , 
                            "<i class='fa fa-circle' >
                            </i>
                            CATEGORÍAS / SERVICIOS" ,
                        $config3)?>  
                    </li>
                </ul>
            </nav> 