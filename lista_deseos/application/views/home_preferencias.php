<?php

    $heading_1 = heading_enid("TUS PREFERENCIAS E INTERESES");
    $p1 = p("CUÉNTANOS TUS INTERESES PARA  MEJORAR TU EXPERIENCIA");
    $tmp = div($heading_1 . $p1, ['class' => "col-lg-4"]);
?>
<div class="contenedor_principal_enid">
    <?= n_row_12() ?>
    <div class="col-lg-2">
        <?=get_menu()?>
    </div>
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
                    <?php
                        $extra = (array_key_exists("id_usuario" , $row) && !is_null($row["id_usuario"]) ) ? "selected_clasificacion" : "";
                        $preferencia_ = "preferencia_" . $row['id_clasificacion'];
                        $config = [
                            'class' => 'list-preferencias item_preferencias ' . $preferencia_ . ' ' . $extra . ' ',
                            'id' => $row['id_clasificacion']
                        ];

                        $extraIcon = (array_key_exists("id_usuario" , $row) && !is_null($row["id_usuario"]) ) ? icon("fa fa-check-circle-o ") : "";
                        $clasificacion = div(append_data([$extraIcon , $row["nombre_clasificacion"]]) , $config);
                        echo div($clasificacion, 1);
                    ?>
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
<?= n_row_12() ?>
<?= $this->load->view("secciones/slider"); ?>
<?= end_row() ?>
<?= end_row() ?>
</div>