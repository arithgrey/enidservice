<div class="col-lg-2">       
    <nav class="nav-sidebar">
        <ul class="nav tabs">
            <li>
                <?=anchor_enid(icon("fa fa-money")."PEDIDOS" ,  
                [
                    "id"          =>    "btn_servicios",
                    "href"        =>    "../pedidos",                     
                    "class"       =>    "black   dispositivos"
                ]);?>                    
            </li>                
            <li class="active"> 
                <?=anchor_enid(icon('fa fa-globe')."INDICADORES" , 
                [
                    "href"          =>"#tab_default_1" ,
                    "data-toggle"   =>"tab" ,
                    "class"         =>'btn_menu_tab cotizaciones black  '
                ] )?>                            
            </li>                
            <li>
                <?=anchor_enid(icon("fa fa-shopping-cart")."PRODUCTOS SOLICITADOS" , 
                [
                    "href"          =>"#tab_busqueda_productos" ,
                    "data-toggle"   =>"tab" ,
                    "class"         =>'black   btn_repo_afiliacion',
                    "id"            =>'btn_repo_afiliacion'
                ] )?>                        
            </li>  

            <li>
                <?=anchor_enid(icon("fa fa-fighter-jet")."TIPOS ENTREGAS" , 
                [
                    "href"          =>"#tab_tipos_entregas" ,
                    "data-toggle"   =>"tab" ,
                    "class"         =>'black ',
                    "id"            =>'btn_repo_afiliacion'
                ] )?>                        
            </li>  


            <li>
                <?=anchor_enid(icon("fa-shopping-bag")."ACTIVIDAD USUARIOS" ,  
                [
                    "id"          =>    "btn_usuarios",
                    "href"        =>    "#tab_usuarios", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   btn_repo_afiliacion"
                ]);?>
            </li>  
            <li>
                <?=anchor_enid(icon("fa-check-circle")."CATEGORÍAS DESTACADAS" ,  
                [
                    "id"          =>    "btn_repo_afiliacion",
                    "href"        =>    "#tab_productos_publicos", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   btn_repo_afiliacion"
                ]);?>                    
            </li>  

            <li>
                <?=anchor_enid(icon("fa-envelope")."MAIL MARKETING" .
                place('place_num_pagos_notificados') ,  
                [
                    "id"          =>    "btn_repo_afiliacion",
                    "href"        =>    "#tab_default_3", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   btn_repo_afiliacion"
                ]);?>                    
            </li>  
            <li>
                <?=anchor_enid(icon("fa fa-motorcycle")."AFILIACIÓNES" ,  
                [
                    "id"          =>    "btn_repo_afiliacion",
                    "href"        =>    "#tab_afiliaciones", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   btn_repo_afiliacion"
                ]);?>                    
            </li>   

            <li>
                <?=anchor_enid(icon("fa fa-handshake-o")."ATENCIÓ AL CLIENTE" ,  
                [
                    "id"          =>    "btn_repo_atencion_cliente",
                    "href"        =>    "#tab_atencion_cliente", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   btn_repo_atencion_cliente"
                ]);?>                    
            </li>      
            <li>
                <?=anchor_enid(icon("fa fa-flag")."ACTIVIDAD" ,  
                [
                    "id"          =>    "btn_servicios",
                    "href"        =>    "#tab_default_2", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   usabilidad_btn"
                ]);?>                    
            </li>                      
            <li>
                <?=anchor_enid(icon("fa fa-mobile")."DISPOSITIVOS" ,  
                [
                    "id"          =>    "btn_servicios",
                    "href"        =>    "#tab_dispositivos", 
                    "data-toggle" =>    "tab"  ,
                    "class"       =>    "black   dispositivos"
                ]);?>                    
            </li>
                                  
            </ul>
        </nav>        
    </div>    