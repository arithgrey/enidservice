<?php if ($in_session ==  1):?>    

      

        
        <li class="dropdown pull-right   " 
            style="padding:3px;z-index: 3000;background: white;margin-top: 2px;" >
                        <img 
                            width='100%;'  
                            id='imagen_usuario' 
                            src="../imgs/index.php/enid/imagen_usuario/<?=$id_usuario?>"
                            onerror="this.src='../img_tema/user/user.png'"
                            style="width: 30px;height: 25px;">                
        
            
            <ul class="dropdown-menu menu_usuario" style="padding: 3px;">                           
                <div style="margin-top: 5px;padding: 4px;" class="blue_enid_background white">
                    <span class='strong' style="font-weight: bold;">
                        <?=$nombre?>    
                    </span>
                </div>
                <hr>
                <?=$menu;?>        
                <li>
                    <a href="../recomendacion/?q=<?=$id_usuario?>">
                        Mis reseñas y valoraciones
                        <div class="contenedor_promedios"> 
                            <label class="estrella" style="font-size: 1em;color: #0070dd;">★
                            </label>
                            <label class="estrella" style="font-size: 1em;color: #0070dd;">★
                            </label>
                            <label class="estrella" style="font-size: 1em;color: #0070dd;">★
                            </label>
                            <label class="estrella" style="font-size: 1em;color: #0070dd;">★
                            </label>
                            <label class="estrella" style="font-size: 1em;
                            -webkit-text-fill-color: white;
                            -webkit-text-stroke: 0.5px rgb(0, 74, 252);">★
                            </label>
                            
                          </div>
                    </a>
                </li>            
                <li>
                    <a href="../administracion_cuenta/">        
                        Configuración y privacidad
                    </a>
                </li>        
                <li>
                    <a href="../login/index.php/startsession/logout">
                        Cerrar sessión
                    </a>
                </li>        
            </ul>
        </li>  
        <li class="dropdown  pull-right blue_enid_background menu_notificaciones_progreso_dia " 
            style="padding:3px;z-index: 3000;margin-top: 2px;height: 30px;margin-left:5px;" >            
            
                        <a class="blue_enid dropdown-toggle" 
                           data-toggle="dropdown"> 
                            <i class="fa fa-bell white"></i>
                            <span class="num_tareas_dia_pendientes_usr">            
                            </span>    
                        </a>
            
            <ul class="dropdown-menu" style="padding: 3px;width: 300px;">
                <span class="place_notificaciones_usuario">            
                </span>                            
            </ul>
        </li>


        <li class="dropdown  pull-right blue_enid_background  boton_vender_global" 
            style="padding:3px;z-index:3000;margin-top: 2px;height: 30px;margin-left:5px;">
            <a  class="white blue_enid" 
                style="color: white!important"
                href="../planes_servicios/?action=nuevo"> 
                <i class="fa fa-cart-plus"></i>
                VENDER
            </a>
        </li>
  
  
<?php endif; ?>