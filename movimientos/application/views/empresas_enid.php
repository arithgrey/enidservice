<div class="col-lg-3">
    <div class="panel income db mbm">
        <?= get_format_saldo_disponible($saldo_disponible) ?>
    </div>
    <?= div(get_submenu(), ["class" => "card"]) ?>
</div>
<?= div(place("place_movimientos"), ["class" => 'col-lg-9']) ?>
