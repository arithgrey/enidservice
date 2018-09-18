<?=heading_enid("Afiliados Enid Service", 3 , [] , 1)?>    
<?=n_row_12()?>
    <ul class="nav nav-tabs">                                           
    <?=anchor_enid("Miembros Afiliados" .icon('fa fa-trophy'),  
    [
        "href"          =>"#tab_afiliados_activos" ,
        "data-toggle"   =>"tab",               
        "id"            =>'1'
    ] )?>                        
    </ul>    
<?=end_row()?>
<?=place("usuarios_enid_service_afiliados")?>
