<?=n_row_12();?>
    <div class='col-lg-7'>
    	¿CLIENTES TAMBIÉN PUEDEN RECOGER 
    	SUS COMPRAS EN TU NEGOCIO? 
    </div>
    <div class='col-lg-5'>
    	<a 
            id='1'
            class='button_enid_eleccion entregas_en_casa 
            <?=valida_activo_entregas_en_casa(1 , $entregas_en_casa)?>'>
    		SI
    	</a>
    	<a 
            style="margin-left: 10px;"
            id='0'
            class='button_enid_eleccion entregas_en_casa
            <?=valida_activo_entregas_en_casa(0 , $entregas_en_casa)?>'>
    		NO
    	</a>
    </div>
<?=end_row();?>
<div style="margin-top: 30px;"></div>
