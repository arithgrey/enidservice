<div class="tab-pane active text-style" id="tab2">
    <?= div("", ["class" => "col-lg-2"]) ?>
    <?= div(
        heading_enid(
            "Estamos en búsqueda de 4 talentos con experiencia en ventas.",
            3),
        ["class" => "col-lg-8"]
    ) ?>
    <?= hr() ?>
    <?= div(icon("fa fa-usd "), ['class' => "col-lg-2"]) ?>
    <?= div("", ['class' => "col-lg-2"]) ?>
    <div class="col-lg-8">
        <?= get_format_descripction() ?>
    </div>
    <?= div("", ["class" => "col-lg-2"]) ?>
    <?=hr()?>
</div>