    <div class="contenedor_inf_servicios">
        <?=div("INFORMACIÓN SOBRE TU".get_campo($servicio ,"nombre_servicio"). 
                icon('fa fa-pencil text_desc_servicio icon-pencil')      , 
                ["class"=>"titulo_seccion_producto titulo_producto_servicio"],
                1

        )?>
        <?=div(get_campo($servicio , 'descripcion') , 
            ["class"    =>  "text_desc_servicio contenedor_descripcion"],
            1
        )?>        
        <div class="input_desc_servicio_facturacion">
            <form class="form_servicio_desc">
                <?=input([
                    "type"  =>  "hidden" ,  
                    "name"  =>  "q" , 
                    "value" =>"descripcion"] , 1)?>
                <?=div(
                    "-".get_campo($servicio , 'descripcion'), 
                    ["id"   =>  "summernote"],
                    1
                )?>    
                <?=add_element(
                    "GUARDAR" , 
                    "button" ,
                    ["class"=>"btn_guardar_desc col-lg-3 "] ,
                    1 
                );?>
            </form>
        </div>    
    </div>                     
    <?=div("" , ["class" => "place_tallas_disponibles"] , 1)?>