<?=br()?>
<div class="col-lg-12 ">
    <form class="form_compras" method="post">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="row">
                <?=get_btw(
                    div("FECHA DE ENTREGA", ["class"=>'strong']) ,

                    input([
                        "data-date-format"      =>"yyyy-mm-dd",
                        "name"                  =>'fecha_inicio' ,
                        "class"                 =>"form-control input-sm datetimepicker4" ,
                        "id"                    =>'datetimepicker4' ,
                        "value"                 => date("Y-m-d")
                    ]),
                    "col-lg-6"
                )?>
                <div class="col-lg-6">
                    <?=div("FECHA REFERENCIA", ["class"=>'strong'])?>
                    <select name="tipo" class="form-control">
                        <option value="1">
                            -1 MES
                        </option>
                        <option value="3">
                            -3 MESES
                        </option>
                        <option value="6">
                            -6 MESES
                        </option>
                        <option value="12">
                            - 1 AÑO
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<?=place("place_compras")?>