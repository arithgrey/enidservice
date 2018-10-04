                        <?=anchor_enid(                            
                            "" ,
                            "icon('                                
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
                            'icon('fa fa-facebook-square  black"')',
                            'target="_black" '
                            )?>

                        <?=anchor_enid(
                            get_url_twitter(
                                get_url_productos_cuenta_usuario_web($id_usuario),
                                "VISITA MI TIENDA EN LÍNEA!" ) ,
                                "icon('fa fa-twitter black '')",
                                " target='_black' "                                
                            )?>

                        <?=anchor_enid(
                            get_url_pinterest(
                                get_url_productos_cuenta_usuario_web($id_usuario)) ,
                                "icon('fa fa-pinterest-p black '')",
                                " target='_black' "                                
                            )?>


                        <?=anchor_enid(
                            get_url_tumblr(
                                get_url_productos_cuenta_usuario_web($id_usuario)) ,
                                "icon('fa fa-tumblr  black'')",
                                " target='_black' "                                
                            )?>