            
            <ul class="nav tabs contenedor_menu_enid_service_lateral">      
                <li class="<?=valida_active_tab('nuevo' , $action)?>">
                    <a  
                        class="agregar_servicio white blue_enid_background btn_agregar_servicios" 
                        href="#tab_form_servicio"
                        style="color: white!important;font-size: .8em;" 
                        data-toggle="tab" >
                        <i class="fa fa-cart-plus">                            
                        </i>
                        + Vende nuevo 
                    </a>
                </li>          
                <li class=' tab-pane black li_menu li_menu_servicio btn_servicios <?=valida_active_tab('lista' , $action)?>'>
                    <a  href="#tab_servicios" 
                        data-toggle="tab"                         
                        class='black strong btn_serv'>
                        <i class="fa fa-shopping-bag">                            
                        </i>
                        Tus articulos en venta
                    </a>
                </li> 
            </ul>


        