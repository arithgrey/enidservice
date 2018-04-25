            
            <ul class="nav tabs contenedor_menu_enid_service_lateral">      
                <li class="<?=valida_active_tab('nuevo' , $action)?>">
                    <a  
                        class="agregar_servicio white blue_enid_background btn_agregar_servicios" 
                        href="../planes_servicios/?action=nuevo"
                        style="color: white!important;font-size: .8em;">
                        <i class="fa fa-cart-plus">                            
                        </i>
                        + ANUNCIAR MÁS PRODUCTOS
                    </a>
                </li>          
                <li class='li_menu li_menu_servicio btn_servicios 
                    <?=valida_active_tab('lista' , $action)?>'>
                    <a  href="#tab_servicios" 
                        data-toggle="tab"                         
                        class='black strong btn_serv'>
                        <i class="fa fa-shopping-bag">                            
                        </i>
                        Tus articulos en venta
                    </a>
                </li> 
            </ul>


        