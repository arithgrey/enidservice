    <div class="col-lg-2" >       
        <nav class="nav-sidebar">
            <ul class="nav tabs">                                               
                <li class='black seccion_busqueda_agendados li_menu'>
                    <a  href="#tab_mis_datos" 
                        data-toggle="tab" 
                        id='base_tab_agendados' 
                        class='black strong base_tab_agendados active' >
                        <i class="fa fa-address-book-o"></i>
                        Cuenta
                    </a>
                </li>                                 
                <li class='black li_menu'>
                    <a  href="#tab_direccion" 
                        data-toggle="tab" 
                        id='btn_direccion' 
                        class='black strong btn_direccion'>                        
                        <i class="fa  fa-fighter-jet">                            
                        </i>
                        Dirección de envío
                    </a>
                </li>                                                    
                <li class='black li_menu'>
                    <a  href="#tab_privacidad" 
                        data-toggle="tab" 
                        id='base_tab_privacidad' 
                        class='black strong base_tab_privacidad'>     
                        <i class="fa fa-unlock-alt"></i>
                        Contraseña
                    </a>
                </li>     

                <li class='black li_menu'>
                    <a  href="#tab_privacidad_seguridad" 
                        data-toggle="tab"                         
                        class='black strong tab_privacidad_seguridad'>     
                        <i class="fa fa-shield"></i>
                        Privacidad y seguridad
                    </a>
                </li>                                     
                <li>
                    <a class="btn_cuenta_personal" href="../search/?q3=<?=$id_usuario?>">
                        TUS PRODUCTOS EN VENTA              
                    </a>
                </li>
                <li>
                    <a class="btn_intereses" href="../lista_deseos/?q=preferencias">
                        INTERESES Y PREFERENCIAS
                    </a>
                </li>


                <li class="li_menu">
                    <div class="contenedor_compartir_redes_sociales">            
                      <?=anchor_enid(                            
                            "" ,
                            "<i class='                                
                                fa fa-clone  black
                                fa-2x'>
                            </i>",                                
                            "class='btn_copiar_enlace_pagina_contacto'
                            data-clipboard-text='".
                            get_url_productos_cuenta_usuario_web($id_usuario)."' ",
                            1                              
                        )?>
                        <?=anchor_enid(
                            get_url_facebook(get_url_productos_cuenta_usuario_web($id_usuario)),
                            '<i class="fa fa-facebook-square fa-2x black"></i>',
                            'target="_black" '
                            )?>

                        <?=anchor_enid(
                            get_url_twitter(
                                get_url_productos_cuenta_usuario_web($id_usuario),
                                "VISITA MI TIENDA EN LÍNEA!" ) ,
                                "<i class='fa fa-twitter black fa-2x'></i>",
                                " target='_black' "                                
                            )?>

                        <?=anchor_enid(
                            get_url_pinterest(
                                get_url_productos_cuenta_usuario_web($id_usuario)) ,
                                "<i class='fa fa-pinterest-p black fa-2x'></i>",
                                " target='_black' "                                
                            )?>


                        <?=anchor_enid(
                            get_url_tumblr(
                                get_url_productos_cuenta_usuario_web($id_usuario)) ,
                                "<i class='fa fa-tumblr fa-2x black'></i>",
                                " target='_black' "                                
                            )?>
                        <div>
                            COMPARTIR 
                        </div>
                    </div>
                </li>
            </ul>
        </nav>        
    </div>