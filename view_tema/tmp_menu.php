<?php if ($in_session ==  1): ?>

<li class="dropdown pull-right blue_enid_background menu_notificaciones_progreso_dia" 
    style="padding: 3px;" >
    
    <table style="width: 100%;background: white;" >
        <tr>
            <td>                
                <img 
                    width='100%;'  
                    id='imagen_usuario' 
                    src="../imgs/index.php/enid/imagen_usuario/<?=$id_usuario?>"
                    onerror="this.src='../img_tema/user/user.png'"
                    style="width: 40px;height: 32px;">                
            </td>
            <td>
                <a class="blue_enid dropdown-toggle" 
                   data-toggle="dropdown"
                   style="font-size:.7em!important;background: white!important;">                    
                    <?=$nombre?>    
                    <span class="num_tareas_dia_pendientes_usr">            
                    </span>    
                </a>
            </td>
        </tr>
    </table>
    
    <ul class="dropdown-menu">                           
        <span class="place_notificaciones_usuario">            
        </span>

        <span style="font-size: .8em;">
            <?=$menu;?>    
        </span>        
        <li class="row">
            <a href="../administracion_cuenta/" style="font-size: .85em;">
                <i class="fa fa-user"></i>
                MIS DATOS
            </a>
        </li>        
        <li class="row">
            <a href="../login/index.php/startsession/logout" style="font-size: .85em;">
                <i class="fa fa-sign-out">
                </i>  
                Salir
            </a>
        </li>        
    </ul>
</li>
<?php endif; ?>