<?=n_row_12()?>                    
    <p 
        class="white strong" 
        style="font-size: 3em;line-height: .8;
        background: black;padding: 5px;">                        
        Equipo Enid Service
    </p>      
    <br>          
<?=end_row()?>

<?=n_row_12()?>
    <div class="panel-heading">
        <ul class="nav nav-tabs">                            
            <li class="active" id='1'>
                <a style="font-size: .9em!important;"
                    href="#tab_usuarios_activos" 
                    data-toggle="tab"
                    class="equipo_enid_service" 
                    id='1'>
                    <i class="fa fa-trophy ">
                    </i>                                
                    Miembros activos                                    
                </a>
            </li>
            <li>
                <a  
                    style="font-size: .9em!important;"
                    href="#tab_usuarios_baja" 
                    data-toggle="tab"
                    class="btn_solo_llamar_despues equipo_enid_service" 
                    id='0'>
                    <i class="fa fa-chevron-circle-down">
                    </i>                                
                    Bajas 
                    <span class='place_num_agendados_llamar_despues'>
                    </span>
                </a>
            </li>
        </ul>
    </div>

        <div class="tab-pane active" id="tab_usuarios_activos">                
            <button 
                class="btn input-sm btn_nuevo_usuario" 
                style="background: black!important;"
                data-toggle="tab"
                href="#tab_mas_info_usuario">
                Agregar nuevo
            </button>                
            <?=n_row_12()?>                        
                <div class="usuarios_enid_service">         
                </div>                        
            <?=end_row()?>                            
        </div>                                                                   
<?=end_row()?>