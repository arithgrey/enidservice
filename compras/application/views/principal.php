<?=br()?>
<div class="col-lg-12 ">
    <form class="form_compras" method="post">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="row">
                <?=div("FECHA DE ENTREGA", ["class"=>'strong'])?>
                <?=input([
                    "data-date-format"      =>"yyyy-mm-dd",
                    "name"                  =>'fecha_inicio' ,
                    "class"                 =>"form-control input-sm datetimepicker4" ,
                    "id"                    =>'datetimepicker4' ,
                    "value"                 => date("Y-m-d")
                ])?>
            </div>
        </div>
    </form>

</div>
<div class="col-lg-12 ">
    <?=place("place_pedidos")?>
</div>