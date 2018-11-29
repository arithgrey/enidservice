<?php if($is_mobile == 0 ):?>
<ul class="nav tabs contenedor_menu_enid_service_lateral">      
    <li class="<?=valida_active_tab('nuevo' , $action)?>">                       
        <?=anchor_enid(
            icon('fa fa-cart-plus')." VENDER PRODUCTOS " ,
            [
                "href"      =>  "../planes_servicios/?action=nuevo" ,
                "class"     =>  "agregar_servicio btn_agregar_servicios"
            ]
        );?>        
    </li>          
    <li class='li_menu li_menu_servicio btn_servicios 
        <?=valida_active_tab('lista' , $action)?>'>                
            <?=anchor_enid(
                icon("fa fa-shopping-cart")." TUS ARTÍCULOS EN VENTA",
                [
                    'data-toggle'     =>   "tab"    ,
                    'class'           =>    "black  btn_serv",
                    'href'            =>    "#tab_servicios" 
                ]
            );?>                    
    </li>                 
</ul>            
<?php else:?>

<ul class="nav tabs contenedor_menu_enid_service_lateral" >      
    <li class="<?=valida_active_tab('nuevo' , $action)?>">                       
        <?=anchor_enid(
            "" ,
            [
                "href"      =>  "../planes_servicios/?action=nuevo" ,
                "class"     =>  "agregar_servicio btn_agregar_servicios"
            ]
        );?>        
    </li>          
    <li class='li_menu li_menu_servicio btn_servicios 
        <?=valida_active_tab('lista' , $action)?>'>                
            <?=anchor_enid(
                "",
                [
                    'data-toggle'     =>   "tab"    ,
                    'class'           =>    "black  btn_serv",
                    'href'            =>    "#tab_servicios" 
                ]
            );?>                    
    </li>                 
</ul>            
   
<?php endif;?>

<?php if(count($top_servicios)>0 && $is_mobile == 0 ):?>
    <?php $extra_estilos = ($action == 1)?"display:none":"";?>
        <div class="contenedor_top" style="<?=$extra_estilos?>">
            <?=n_row_12()?>                
                <?=heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA" , 3,['class'=> 'strong'] , 1)?>
                <?php foreach ($top_servicios as $row): 
                    $url =  "../producto/?producto=". $row['id_servicio'];
                    $icon         =  icon('fa fa-angle-right');                     
                    $nombre       =  $row["nombre_servicio"];
                    $titulo_corto = substr($nombre, 0,18)."...";
                    $articulo    = (strlen($nombre) > 18) ? $titulo_corto : $nombre;
                    
                    $link_articulo  =  
                    anchor_enid($articulo ,  
                    ['href' => $url ,  'class'=> 'black'] , 1 );
                ?>                
                <table>
                    <tr>
                        <?=get_td($link_articulo , ["class" => "col-lg-11"])?>
                        <?=get_td($row["vistas"] ,  
                        ["class" => "col-lg-1" , 
                         'title'=> 'Número de visitas'
                        ])?>
                    </tr>
                </table>                
                <?php endforeach; ?>                    
            <?=end_row()?>
        </div>
<?php endif;?>