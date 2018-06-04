            
            <ul class="nav tabs contenedor_menu_enid_service_lateral">      
                

                <li class="<?=valida_active_tab('nuevo' , $action)?>">                       
                    <?=anchor_enid(
                        "../planes_servicios/?action=nuevo" ,
                        "<i class='fa fa-cart-plus'></i>
                        ANUNCIAR MÁS PRODUCTOS  "  , 
                        'class="agregar_servicio 
                        white 
                        blue_enid_background 
                        btn_agregar_servicios"
                        style="color: white!important;font-size: .9em;" '
                    )?>                    
                </li>          
                <li class='li_menu li_menu_servicio btn_servicios 
                    <?=valida_active_tab('lista' , $action)?>'>
                    <?=anchor_enid("#tab_servicios" , 
                        "
                        <i class='fa fa-shopping-cart'></i>
                        TUS ARTÍCULOS EN VENTA" ,
                        'data-toggle="tab"                         
                        class="black strong btn_serv" ')?>                    
                </li>                 
                
                <li class="li_menu menu_redes">
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
                        

                    </div>
                </li>
            </ul>


            <?php if(count($top_servicios)>0 && $is_mobile == 0 ):?>
                <?php $extra_estilos = ($action == 1)?"display:none":"";?>
                <div class="card contenedor_top" 
                style="background: #00142f;padding: 2px 2px 30px;margin-top:100px;color: white;<?=$extra_estilos?>">
                    <?=n_row_12()?>
                        <div class="card" style="margin-top: 30px;">
                          <div class="card-header">                    
                                <div style="font-weight: bold;">
                                    TUS ARTÍCULOS MÁS VISTOS 
                                    DE LA SEMANA
                                </div>
                          </div>

                          <div class="card-body" style="margin-top: 20px;background: white; padding: 5px;">                    
                            <ul class="list-unstyled mt-3 mb-4">
                                <?php foreach ($top_servicios as $row): ?>
                                    <a  href="../producto/?producto=<?=$row['id_servicio']?>" 
                                        style='color: black!important;text-decoration:underline;'>
                                        <li>
                                            <i class="fa fa-angle-right"></i>
                                            <?php 
                                                $articulo = 
                                                (trim(strlen($row["nombre_servicio"])) > 22)?
                                                substr($row["nombre_servicio"], 0,22)."...":
                                                strlen($row["nombre_servicio"]);
                                            ?>
                                            
                                            
                                                <?=$articulo?>
                                                <div 
                                                    class="pull-right" 
                                                    title="Personas que han visualizado este  producto">
                                                    <span class="a_enid_black_sm_sm" >
                                                        <?=$row["vistas"]?>
                                                    </span>
                                                </div>                                            
                                        </li>
                                    </a>
                                <?php endforeach; ?>                      
                            </ul>                    
                          </div>
                        </div>
                    <?=end_row()?>
                </div>
            <?php endif;?>