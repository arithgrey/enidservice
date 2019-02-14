<div class="col-lg-10 col-lg-offset-1">
        <?=heading_enid("¿Quieres aparta tu pedido?" , 2 ,[ "class" => "strong" ])?>
</div>
<div class="col-lg-10 col-lg-offset-1">
    <div class="contenedor_eleccion">

        <?=anchor_enid(div(icon("fa fa-shopping-cart")." SI" 	,
            ["class" => "easy_select_enid cursor_pointer selector selector_proceso" ,
            "id" => 1 ]),
            ["href" =>  "../lista_deseos"])?>

        <?=anchor_enid(div(icon("fa fa-map-marker")."NO, VER DIRECCIÓN DE COMPRA" 	,
            [
                "class" => "easy_select_enid cursor_pointer selector selector_proceso",
                "id" => 2
            ]), ["href" => "../contact/?ubicacion=1#direccion"])?>
    </div>
</div>