<?php
$textos[] = d(h("Recibimos", 4, "strong f4 text-uppercase"));
$textos[] = d(h(_text_("tu pedido!"), 4, "strong f4 text-uppercase ml-5"));

$response[] = d($textos, 'col-sm-12 mt-5');

$response[] = d(d(
    d(
        _text_(

            "Estás a nada de pasar al siguiente nivel, te marcaremos ya que estemos de salida a tu domicilio!"
        )

    )
), "col-xs-12 f13 black strong");

$response[] = d(d(
    d(
        _text_(

            "Ya solo toca usarlo!"
        )

    )
), "col-xs-12 f13 black mt-3 ");

$response[] = d(img("https://enidservices.com/imgs/04.jpg"), 'mt-3');



?>
<div class="row top_150 base_enid_web">
    <div class="col-md-10 col-md-offset-1">
    <div class="col-md-6">
        <div class="row">
            <?= append($response) ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="strong text-uppercase ml-5">Aquí el resumen de tu pedido</h3>
                <?= $cobro_compra; ?>
                <?= hiddens([
                    "class" => "orden_compra",
                    "value" => $orden_compra,
                    "name" => "orden_compra"
                ]) ?>
                <div class="f13 black strong mt-5 col-sm-12">
                    ¿Tienes alguna duda?                    
                </div>
                <div class="f15 black mt-3 col-sm-12">
                    (55) 5296 - 7027
                </div>
            </div>
        </div>
    </div>
    </div>
</div>