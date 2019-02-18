<?=n_row_12()?>
    <div class="contenedor_principal_enid">
        <?= div(get_menu(), ["class" => "col-lg-2"]) ?>
        <?= div(get_lista_deseo($productos_deseados), ["class" => "col-lg-7"]) ?>
        <div class="col-lg-3">
            <?= heading_enid("TU LISTA DE DESEOS", 3, ["class" => 'titulo_lista_deseos'], 1) ?>
            <?= anchor_enid("EXPLORAR MÁS ARTÍCULOS", ["href" => "../search/?q2=0&q="], 1) ?>
        </div>
    </div>
<?=end_row()?>