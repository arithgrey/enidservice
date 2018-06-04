<?=n_row_12()?>
    <div class="contenedor_principal_enid_service">        
            <div class="col-lg-2">                                          
                <?=$this->load->view("desarrollo/menu")?>
            </div>            
            <div class='col-lg-10'>
                <div class="tab-content">        
                    <input 
                    type='hidden' 
                    class='id_usuario' 
                    value='<?=$id_usuario;?>'>

                    <div class="tab-pane <?=valida_seccion_activa(2 , $activa)?>" 
                        id='tab_charts'>
                        <?=n_row_12()?>                        
                            <?=$this->load->view("tickets/charts")?>
                        <?=end_row()?>
                    </div>
                    <div 
                        class="tab-pane <?=valida_seccion_activa(1 , $activa)?>" 
                        id='tab_abrir_ticket'>

                        <?=n_row_12()?>
                            <h3 style="font-weight: bold;font-size: 3em;">
                                DESARROLLO ENID SERVICE
                            </h3>
                        <?=end_row()?>
                        <?=n_row_12()?>
                            <?=$this->load->view("../../../view_tema/formularios/busqueda_tickets")?>
                        <?=end_row()?>
                    </div>
                    <div 
                        class="tab-pane <?=valida_seccion_activa(3 , $activa)?>" 
                        id="tab_nuevo_ticket">
                        <?=n_row_12()?>
                            <div class="place_form_tickets">
                            </div>
                        <?=end_row()?>
                    </div>                
                </div>
            </div>    
    </div>    
<?=end_row()?>




