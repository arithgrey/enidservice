<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->load->view("../../../view_tema/header_meta_enid") ?>
    <div id="flipkart-navbar" class="fixed-top bottom_50">
        <?php $extra_contenedor = ($in_session > 0) ? " display_flex_enid " : ""; ?>
        <div class="<?= $extra_contenedor ?>">
            <?php if ($is_mobile < 1 && $in_session < 1): ?>

                <?= get_menu_session($is_mobile, $in_session, $proceso_compra) ?>

                <div class="menu_completo_enid_service ">

                    <?php


                        $b_menu[] = a_enid("POPULARES" , ["class" => "   white strong f11 border-right frecuentes border-right-enid" ,
                            "href" => path_enid("search", "/?q2=0&q=&order=2&order=1&order=4" )]);
                        $b_menu[] = a_enid("NOVEDADES" , ["class" => "  white strong f11 border-right frecuentes border-right-enid"
                        , "href" => path_enid("search", "/?q2=0&q=&order=2&order=1"
                            )]);

                        $b_menu[] = a_enid("SERVICIOS" , ["class" => "   white strong f11  frecuentes",
                            "href" => path_enid("search" , "?q2=0&q=&order=2&order=1&order=9")]);
                        $frecuentes =  append($b_menu);
                    ?>

                    <!--
                    <?=ajustar(
                            ajustar(get_logo($is_mobile), $frecuentes, 2)  ,
                            frm_search($clasificaciones_departamentos)
                            ,
                            8 ,
                            "",
                            1,
                            1
                    )?>
                    -->
                    <?=flex(
                        ajustar(get_logo($is_mobile), $frecuentes, 2)  ,
                        frm_search($clasificaciones_departamentos)
                        ,
                        "" ,
                        8,
                        "col-lg-4 align-self-end "

                    )?>

                    <?php if ($is_mobile < 1 && !isset($proceso_compra) || (isset($proceso_compra) && $proceso_compra < 1)): ?>
                        <?= $this->load->view("../../../view_tema/formularios/form_busqueda_departamentos") ?>
                    <?php endif; ?>
                </div>
            <?php elseif ($is_mobile > 0 && $in_session < 1): ?>
                <?= get_logo($is_mobile, $in_session) ?>
            <?php elseif ($is_mobile > 0 && $in_session > 0): ?>
                <?= get_logo($is_mobile, $in_session) ?>
                <?= tmp_menu($is_mobile, $id_usuario, $menu) ?>
            <?php elseif ($is_mobile < 1 && $in_session > 0): ?>
                <?= get_logo($is_mobile, $in_session) ?>
                <?= $this->load->view("../../../view_tema/formularios/form_busqueda_departamentos") ?>
                <?= tmp_menu($is_mobile, $id_usuario, $menu) ?>
            <?php endif; ?>
        </div>
    </div>
</head>
<body>
<?= menu_session_mobil($in_session) ?>

