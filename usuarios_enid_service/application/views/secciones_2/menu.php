            <nav class="nav-sidebar">
                <ul class="nav tabs">                                                    
                    <li  class='li_menu' >
                        <?php 
                            $config["id"]           = 'tab_equipo_enid_service';
                            $config["data-toggle"]  = 'tab';
                            $config["class"]        = 'black strong tab_equipo_enid_service';
                        ?>
                        <?php
                        $config["href"] =  "#tab1";
                        ?>
                        <?=anchor_enid(
                            icon("fa fa-space-shuttle").'
                            EQUIPO  ENID  SERVICE' , 
                            $config)?>                        
                    </li>
                    <li  class='li_menu'>

                        <?php 
                            $config["id"]       = 'tab_afiliados'; 
                            $config["class"]    = 'black strong tab_afiliados 
                                                btn_ventas_mes_usuario';
                            $config["href"]     = "#tab_productividad_ventas";
                        ?>
                        <?=anchor_enid(
                            icon("fa fa-handshake-o")."AFILIADOS".
                            place("place_num_productividad"), 
                            $config)?>                          
                    </li>                                                                            
                    <li  class='li_menu' >
                        <?php 
                            $config["id"]= 'tab_perfiles'; 
                            $config["class"] = 'black strong perfiles_permisos';
                            $config["href"] ="#tab_perfiles_permisos";
                        ?>
                        <?=anchor_enid(
                            icon("fa fa-unlock-alt")."PERFILES / PERMISOS ",
                            $config)?>  
                    </li>
                    <li class="li_menu">  
                        <?php 
                            $config3["id"]      = 'agregar_categorias'; 
                            $config3["class"]   = 'black strong tab_agregar_categorias';
                            $config3["data-toggle"]  = 'tab';
                            $config3["href"] ="#tab_agregar_categorias";
                        ?>                      
                        <?=anchor_enid(icon("fa fa-circle").
                        "CATEGORÍAS / SERVICIOS" , $config3)?>  
                    </li>

                    <li class="li_menu">  
                        <?php 
                            $config4["id"]= 'agregar_tallas_menu'; 
                            $config4["class"] = 'black strong agregar_tallas';
                            $config4["data-toggle"]  = 'tab';
                            $config4["href"] ="#agregar_tallas";
                        ?>                      
                        <?=anchor_enid(icon("fa fa-percent")."TALLAS",$config4)?>  
                    </li>

                </ul>
            </nav> 