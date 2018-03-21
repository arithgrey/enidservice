                                <div style="background: white;padding: 5px;">

                                    <ul class="nav nav-tabs">                                        
                                        <li class="active descargar_correos">
                                            <a  href="#tab1default_en_agenda" 
                                                data-toggle="tab" 
                                                style="font-size: .8em;">
                                                <i class="fa fa-cloud-download  black ">
                                                </i>
                                                Descargar 
                                                correos
                                            </a>
                                        </li>
                                        <li class='btn_correos_por_enviar'>
                                            <a href="#tab2default_en_agenda" 
                                               data-toggle="tab"
                                               style="font-size: .8em;">    
                                               <i class="fa fa-refresh  black">
                                               </i>
                                                Registra envios                                                 
                                            </a>
                                        </li>
                                    </ul>
                            
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="tab1default_en_agenda">
                                            <?=$this->load->view("secciones/mail/descargas")?>
                                        </div>
                                        <div class="tab-pane fade" id="tab2default_en_agenda">
                                            <?=$this->load->view("secciones/mail/herramientas_mail_marketing")?>                       
                                        </div>                                     
                                    </div>
                                </div>