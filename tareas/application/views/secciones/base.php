<div style="background: white;padding: 5px;">
    <ul class="nav nav-tabs">                                        
        <li class="active descargar_correos">
            <?=anchor_enid("Descargar correos".icon('fa fa-cloud-download  black '), 
            [
                "href"          =>  "#tab1default_en_agenda" ,
                "data-toggle"   =>  "tab"
            ])?>
        </li>
        <li class='btn_correos_por_enviar'>
            <?=anchor_enid("Registra envios" .icon('fa fa-refresh  black'),  
            [
                "href"          =>  "#tab2default_en_agenda",
                "data-toggle"   =>  "tab"    
            ])?>
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