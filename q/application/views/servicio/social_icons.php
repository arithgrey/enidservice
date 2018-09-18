                        <?=anchor_enid(                            
                            "" ,
                            "<i class='                                
                                fa fa-clone  black
                                '>
                            </i>",                                
                            "class='btn_copiar_enlace_pagina_contacto'
                            data-clipboard-text='".
                            get_url_productos_cuenta_usuario_web($id_usuario)."' ",
                            1                              
                        )?>
                        <?=anchor_enid(
                            get_url_facebook(get_url_productos_cuenta_usuario_web($id_usuario)),
                            '<i class="fa fa-facebook-square  black"></i>',
                            'target="_black" '
                            )?>

                        <?=anchor_enid(
                            get_url_twitter(
                                get_url_productos_cuenta_usuario_web($id_usuario),
                                "VISITA MI TIENDA EN LÍNEA!" ) ,
                                "<i class='fa fa-twitter black '></i>",
                                " target='_black' "                                
                            )?>

                        <?=anchor_enid(
                            get_url_pinterest(
                                get_url_productos_cuenta_usuario_web($id_usuario)) ,
                                "<i class='fa fa-pinterest-p black '></i>",
                                " target='_black' "                                
                            )?>


                        <?=anchor_enid(
                            get_url_tumblr(
                                get_url_productos_cuenta_usuario_web($id_usuario)) ,
                                "<i class='fa fa-tumblr  black'></i>",
                                " target='_black' "                                
                            )?>