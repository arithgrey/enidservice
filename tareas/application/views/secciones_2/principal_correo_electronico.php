
	<?=n_row_12()?>          
    <p class="white strong" style="font-size: 2.1em;line-height: .8;background: black;padding: 5px;"> 
      E-Mail Marketing
    </p>          
	<?=end_row()?>
	
	<div style="background: white;padding: 5px;">
            <ul class="nav nav-tabs">                                        
                <li class="active descargar_correos">
                    <a  href="#tab1default_en_agenda" 
                                                    data-toggle="tab" 
                                                    >
                        <i class="fa fa-cloud-download  black ">
                        </i>
                        Descargar contactos
                    </a>
                </li>                                       
            </ul>
            <?=$this->load->view("secciones/mail/descargas")?>          
    </div>