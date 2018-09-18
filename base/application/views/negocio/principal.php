    <div class='col-lg-3'>
        <?=anchor_enid("SI" , [
            "id"        =>'1' 
            "class"     =>
            'button_enid_eleccion entregas_en_casa ' .
            valida_activo_entregas_en_casa(1 , $entregas_en_casa)

        ] )?>    
        <?=anchor_enid("NO" , [
            "id"        =>'0' 
            "class"     =>
            'button_enid_eleccion entregas_en_casa ' .
            valida_activo_entregas_en_casa(0 , $entregas_en_casa)

        ] )?>    
    </div>
    <?=div("¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO? " , ["class"=>'col-lg-9'] )?>

