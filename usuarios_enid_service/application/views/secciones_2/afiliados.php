<?=heading_enid("Afiliados Enid Service", 3 )?>
<?=addNRow(ul(li(anchor_enid("Miembros Afiliados" .icon('fa fa-trophy'),
    [
        "href"          =>"#tab_afiliados_activos" ,
        "data-toggle"   =>"tab",
        "id"            =>'1'
    ] )),
    ["class"=>"nav nav-tabs"]
))?>
<?=place("usuarios_enid_service_afiliados")?>
