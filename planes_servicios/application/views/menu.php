<?= get_menu($is_mobile, $action) ?>
<?php if (count($top_servicios) > 0 && $is_mobile == 0): ?>
    <?php $extra_estilos = ($action == 1) ? "display:none" : ""; ?>
    <div class="contenedor_top" style="<?= $extra_estilos ?>">
        <?= heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 3) ?>
        <?php foreach ($top_servicios as $row):
            $url = "../producto/?producto=" . $row['id_servicio'];
            $icon = icon('fa fa-angle-right');
            $nombre = $row["nombre_servicio"];
            $titulo_corto = substr($nombre, 0, 18) . "...";
            $articulo = (strlen($nombre) > 18) ? $titulo_corto : $nombre;
            $link_articulo =
                anchor_enid($articulo,
                    ['href' => $url, 'class' => 'black'], 1);
            ?>
            <?= get_btw(
            $link_articulo,
            $row["vistas"],
            "display_flex_enid"

        ) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>