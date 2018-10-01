<div>
    <?=div(anchor_enid(icon("fa fa-pencil") ,  
    ["class"    =>  "a_enid_blue editar_direccion_persona"])
    ,
    ["class"    =>"text-right"] ,
    1)?>

    <div>
        <?=get_campo($info_envio_direccion , "direccion" , "Dirección" , 1 )?>
        <?=get_campo($info_envio_direccion , "calle" , "Calle"  , 1 )?>
        <?=get_campo($info_envio_direccion , "numero_exterior" , " Número exterior " , 1)?>
        <?=get_campo($info_envio_direccion , "numero_interior" , " Número interior " , 1)?>
        <?=get_campo($info_envio_direccion , "entre_calles" , "Entre " , 1)?>
        <?=get_campo($info_envio_direccion , "cp" , " C.P. " , 1)?>
        <?=get_campo($info_envio_direccion , "asentamiento" , " Colonia " , 1)?>
        <?=get_campo($info_envio_direccion , "municipio" , " Delegación/Municipio " , 1)?>
        <?=get_campo($info_envio_direccion , "ciudad" , " Ciudad " , 1)?>
        <?=get_campo($info_envio_direccion , "estado" , " Estado " , 1)?>
        
        
    </div>    

</div>