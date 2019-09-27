<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->load->view("../../../view_tema/header_meta_enid") ?>
    <div id="flipkart-navbar" class="<!--fixed-top--> bottom_50">

        <?php

        $b_menu[] = a_enid("POPULARES" , ["class" => "   white  f11 border-right frecuentes border-right-enid" ,
            "href" => path_enid("search", "/?q2=0&q=&order=2&order=1&order=4" )]);
        $b_menu[] = a_enid("NOVEDADES" , ["class" => "  white  f11 border-right frecuentes border-right-enid"
            , "href" => path_enid("search", "/?q2=0&q=&order=2&order=1"
            )]);

        $b_menu[] = a_enid("SERVICIOS" , ["class" => "   white  f11  frecuentes",
            "href" => path_enid("search" , "?q2=0&q=&order=2&order=1&order=9")]);
        $frecuentes =  append($b_menu);
        ?>

            <?php if ($is_mobile < 1 && $in_session < 1): ?>

                <?= get_menu_session(0, $in_session, $proceso_compra) ?>
                <?=d(hrz(get_logo($is_mobile), $frecuentes, 2, "d-flex align-items-center"),5)?>
                <?= d(frm_search($clasificaciones_departamentos, $in_session), "col-lg-7 mt-4 p-0")?>



        <?php elseif ($is_mobile > 0 && $in_session < 1): ?>
            <?= get_logo($is_mobile, $in_session) ?>

        <?php elseif ($is_mobile > 0 && $in_session > 0): ?>

                <?= ajustar(
                        get_logo($is_mobile, $in_session) ,
                    tmp_menu($is_mobile, $id_usuario, $menu)
                )?>


        <?php elseif ($is_mobile < 1 && $in_session > 0): ?>

                <?=flex(
                    ajustar(get_logo($is_mobile), $frecuentes, 2)  ,
                    frm_search($clasificaciones_departamentos, $in_session , $is_mobile, $id_usuario, $menu)
                    ,
                    "" ,
                    "col-lg-7 align-self-center mt-4",
                    "col-lg-5 align-items-center justify-content-between d-flex mt-4"

                )?>
            <?php endif; ?>
    </div>
</head>
<body>
<?= menu_session_mobil($in_session) ?>

