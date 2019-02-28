<div class="contenedor_principal_enid">
    <?= div(get_menu(), ["class" => "col-lg-2"]) ?>
    <div class="col-lg-10">
        <?php if ($is_mobile == 1): ?>
            <?= $tmp ?>
        <?php endif; ?>
        <div class="col-lg-8">
            <div class="row">
                <?php $r = 0;
                $z = 0;
                foreach ($preferencias

                as $row): ?>
                <?php if ($z == 0): ?>
                <div class="col-lg-4">
                    <?php endif; ?>
                    <?= get_format_clasificaciones($row) ?>
                    <?php $z++;
                    if ($z == 9): ?>
                </div>
            <?php $z = 0;
            endif; ?>
                <?php $r++;
                if ($r == 26): ?>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if ($is_mobile == 0): ?>
        <?= $tmp ?>
    <?php endif; ?>
</div>
<?= $this->load->view("secciones/slider"); ?>
