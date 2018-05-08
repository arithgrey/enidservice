            
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


            <?php if(count($top_servicios)>0):?>
                <?=n_row_12()?>
                    <div class="card" style="margin-top: 30px;">
                      <div class="card-header">                    
                            <div style="font-weight: bold;">
                                TUS ARTÍCULOS MÁS VISTOS 
                                DE LA SEMANA
                            </div>
                      </div>
                      <div class="card-body" style="margin-top: 20px;">                    
                        <ul class="list-unstyled mt-3 mb-4">
                            <?php foreach ($top_servicios as $row): ?>
                                <a  href="../producto/?producto=<?=$row['id_servicio']?>" 
                                    style='color: black!important;text-decoration: underline;'>
                                    <li>
                                        <i class="fa fa-angle-right"></i>
                                        <?=$row["nombre_servicio"]?>
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
            <?php endif;?>