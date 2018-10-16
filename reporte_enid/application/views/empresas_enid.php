<?=n_row_12()?>
<div class="contenedor_principal_enid">
    <div class="contenedor_principal_enid_service">
    <?=$this->load->view("secciones/menu");?>    
    <div class='col-lg-10'>
        <div class="tab-content">   
            <div class="tab-pane" id='reporte'>
                <?=place("place_reporte" )?>                
            </div>                    
            <div class="tab-pane active" id='tab_default_1'>                                
                <?=div("INDICADORES ENID SERVICE" , 
                ["class"=>"titulo_enid_sm" , 1])?>                
                <?=n_row_12()?>
                    <div class="row">
                        <form class='form_busqueda_global_enid'>                    
                            <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                        </form>
                    </div>
                <?=end_row()?> 
                <?=place("place_usabilidad")?>
            </div>                    
            <div class="tab-pane" id='tab_default_2'>                                  
                <?=div("VISITAS WEB " , ["class"    =>  "titulo_enid_sm"] , 1 )?>                
                <?=n_row_12()?>
                    <form class='f_usabilidad row'>                    
                        <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                    </form>
                <?=end_row()?>         
                <?=place("place_usabilidad_general" )?>
            </div>

            <div class="tab-pane" id='tab_usuarios'>                                  
                <?=div("ACTIVIDAD " , ["class"=>"titulo_enid_sm" ,1])?>                
                <?=n_row_12()?>
                    <form class='f_actividad_productos_usuarios row'>                    
                        <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                    </form>
                <?=end_row()?> 
                <?=place("repo_usabilidad")?>                
            </div>

            <div class="tab-pane" id='tab_dispositivos'>
                <?=div("DISPOSITIVOS " , ["class"=>"titulo_enid_sm" ,1])?>
                <?=n_row_12()?>
                    <form class='f_dipositivos row'>                    
                        <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                    </form>
                <?=end_row()?> 
                <?=place("repo_dispositivos")?>                
            </div>            
            <div class="tab-pane" id='tab_default_3'>                
                <?=div("EMAIL ENVIADOS " , ["class"=>"titulo_enid_sm" ,1])?>             
                <?=n_row_12()?>
                    <div class='row'>
                        <form class='form_busqueda_mail_enid'>         
                            <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                        </form>
                    </div>
                <?=end_row()?>
                <?=place("place_envios")?>
                <?=place("place_mail_marketing")?>                
            </div>            
            <div class="tab-pane" id="tab_atencion_cliente">                
                <?=div("TAREAS RESUELTAS" , ["class"=>"titulo_enid_sm"] , 1)?>
                <?=$this->load->view("secciones/atencion_cliente" );?>
            </div>
            <div class="tab-pane" id="tab_afiliaciones">
                <?=div("PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS" , 
                ["class"=>"titulo_enid_sm"  ],1)?>
                <?=$this->load->view("secciones/afiliaciones" );?>
            </div>
            <div class="tab-pane" id="tab_busqueda_productos">
                <?=div("PRODUCTOS MÁS BUSCADOS POR CLIENTES" , 
                ["class"=>"titulo_enid_sm"],1)?>
                <?=$this->load->view("secciones/keywords" );?>
            </div>
            <div class="tab-pane" id="tab_productos_publicos">
                <?=div(
                    "CATEGORÍAS DESTACADAS" , 
                    [ "class"=>"titulo_enid_sm" ] 
                    , 
                    1)?>                
                <?=n_row_12()?>
                    <?php $categorias_destacadas_orden =  sub_categorias_destacadas($categorias_destacadas);  ?>
                    <?=div(crea_repo_categorias_destacadas($categorias_destacadas_orden) , ["class"=>"row"])?>
                    
                <?=end_row()?>                
            </div>            
        </div>
    </div>   
    </div>
</div>        
<?=end_row()?>
