<div class="col-lg-10 col-lg-offset-1">
    <center>
        <?=heading_enid("¿Quieres aparta tu pedido?" , 2 ,[ "class" => "strong" ])?>
    </center>

</div>
<div class="col-lg-10 col-lg-offset-1">
    <div class="contenedor_eleccion">

        <?=div(icon("fa fa-shopping-cart")." SI" 	,
            ["class" => "easy_select_enid cursor_pointer selector selector_proceso" ,
            "id" => 1 ])?>

        <?=div(icon("fa fa-map-marker")."NO, VER DIRECCIÓN DE COMPRA" 	,
            [
                    "class" => "easy_select_enid cursor_pointer selector selector_proceso",
                    "id" => 2
            ])?>
    </div>
</div>
<form action="../contact/?ubicacion=1#direccion" method="post" class="form_view_location">
    <?=input_hidden(["class" => "ubicacion" , "value" => 1 , "name" => "ubicacion" ])?>
</form>