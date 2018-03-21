        <div>
            <div class="btn-group date-block btn-group-justified font-small dropdown" data-toggle="buttons">
                

                

                <label href="#mensajeria_email_registrar" data-toggle="tab" 
                class="btn date-buttons btn-default black " 
                style="font-size:12px;background:#04213B!important; color:white !important;" >
                    <i class="fa fa-cloud-upload white" aria-hidden="true">
                    </i>
                    Registrar
                </label>

                <label href="#mensajeria_comandos" data-toggle="tab" 
	                class="btn btn-default btn_comandos_ayuda" 
	                style="font-size:12px;background:#04213B!important; color:white !important;">
                    <i class="fa fa-code white" aria-hidden="true">
                    </i>
                   	Comandos de ayuda
                </label>  
                <label 
                        data-toggle="modal" 
                        data-target="#liberar_tipo_negocio_modal"                        
                        class="btn date-buttons btn-default black" 
                        style="font-size:12px; color:white !important;background:#0B96FC!important;" >                    
                        <i class="fa fa-check-circle-o" aria-hidden="true">
                        </i>
                        Liberar tipo de negocio
                </label>
  

                
                

            </div>          
        </div>
        <div id="myTabContent" class="tab-content">            
            <div class="tab-pane fade" id="mensajeria_comandos">
              <?=$this->load->view("secciones/mail/comandos")?>
            </div>                  
            
    	</div>


