<div class="col-lg-2" >               
        <nav class="nav-sidebar">
            <ul class="nav tabs">        
                <li class='li_menu' style="display: none;">
                    <a  href="#tab_pagos" 
                        data-toggle="tab" 
                        class='black strong tab_pagos'
                        id='btn_pagos'
                        >                        
                    </a>
                </li> 
                <li class="li_menu menu_vender <?=valida_active_tab('ventas' , $action)?>">
                    <a href="../planes_servicios/?q=1"  class="white">
                        <i class="fa fa-cart-plus">                            
                        </i>
                        Vender
                    </a>
                </li>
                <li class='li_menu'>
                    <a  
                        id="mis_ventas"
                        href="#tab_mis_ventas" 
                        data-toggle="tab" 
                        class='black strong btn_mis_ventas'>
                        <i class="fa fa-shopping-bag"></i>                        
                        Mis ventas
                        <span class="place_num_pagos_notificados">                        
                        </span>
                    </a>
                </li> 
                <li  class='li_menu <?=valida_active_tab('compras' , $action)?>'>
                    <a  
                        id="mis_compras"
                        href="#tab_mis_pagos" 
                        data-toggle="tab" 
                        class='black strong btn_cobranza mis_compras'>
                        <i class="fa fa-credit-card-alt">                            
                        </i>                        
                        Mis compras
                        <span class="place_num_pagos_notificados">                        
                        </span>
                    </a>
                </li> 
                <li class='li_menu <?=valida_active_tab('preguntas' , $action)?>'>
                    <a  id="mi_buzon"
                        href="#tab_buzon" 
                        data-toggle="tab" 
                        class='black strong btn_buzon'>
                        <i class="fa fa-comments"></i>                        
                        Buzón
                    </a>
                </li> 

            </ul>
        </nav>          
    </div>