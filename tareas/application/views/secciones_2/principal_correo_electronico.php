<?=heading("E-Mail Marketing" , 2)?>	
<div style="background: white;padding: 5px;">
    <ul class="nav nav-tabs">                                        
        <li class="active descargar_correos">
            <?=anchor_enid("Descargar contactos" . icon('fa fa-cloud-download  black ') , 
            [
                "href"          =>  "#tab1default_en_agenda" ,
                "data-toggle"   =>  "tab" 
            ])?>
            
        </li>                                       
    </ul>
    <?=$this->load->view("secciones/mail/descargas")?>          
</div>