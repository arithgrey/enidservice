<div class="contenedor_principal_enid">
    <div class="contenedor_principal_enid_service">
        <?= div(get_menu(), 2) ?>
        <div class='col-lg-10'>
            <div class="tab-content">
                <?= div(place("place_reporte"), ["class" => "tab-pane", "id" => 'reporte']) ?>
                <?php $i[] = n_row_12() ?>
                <?php $i[] = div("INDICADORES ENID SERVICE", "titulo_enid_sm", 1) ?>
                <?php $i[] = form_open("", ["class" => 'form_busqueda_global_enid']) ?>
                <?php $i[] = get_format_fecha_busqueda() ?>
                <?php $i[] = form_close() ?>
                <?php $i[] = end_row() ?>
                <?php $i[] = addNRow(place("place_usabilidad top_50")) ?>
                <?= div(append($i), ["class" => "tab-pane active", "id" => 'tab_default_1']) ?>

                <?php $ds[] = n_row_12() ?>
                <?php $ds[] = div("DISPOSITIVOS ", "titulo_enid_sm", 1) ?>
                <?php $ds[] = form_open("", ["class" => 'f_dipositivos ']) ?>
                <?php $ds[] = get_format_fecha_busqueda() ?>
                <?php $ds[] = form_close() ?>
                <?php $ds[] = end_row() ?>
                <?php $ds[] = addNRow(place("top_50 repo_dispositivos")) ?>
                <?= div(append($ds), ["class" => "tab-pane", "id" => 'tab_dispositivos']) ?>

                <?php $v[] = n_row_12() ?>
                <?php $v[] = div("VISITAS WEB ", "titulo_enid_sm", 1) ?>
                <?php $v[] = form_open("", ["class" => 'f_usabilidad']) ?>
                <?php $v[] = get_format_fecha_busqueda() ?>
                <?php $v[] = form_close() ?>
                <?php $v[] = end_row() ?>
                <?php $v[] = place("top_50 place_usabilidad_general") ?>

                <?= div(append($v), ["class" => "tab-pane", "id" => 'tab_default_2']) ?>


                <?php $p[] = n_row_12() ?>
                <?php $p[] = div("TIPOS DE ENTREGAS ", "titulo_enid_sm", 1) ?>
                <?php $p[] = form_open("", ["class" => 'form_tipos_entregas']) ?>
                <?php $p[] = get_format_fecha_busqueda() ?>
                <?php $p[] = form_close() ?>
                <?php $p[] = end_row() ?>
                <?php $p[] = addNRow(place("place_tipos_entregas top_50")) ?>
                <?= div(append($p), ["class" => "tab-pane", "id" => 'tab_tipos_entregas']) ?>

                <?php $ac[] = n_row_12() ?>
                <?php $ac[] = div("ACTIVIDAD ", "titulo_enid_sm", 1) ?>
                <?php $ac[] = form_open("", ["class" => 'f_actividad_productos_usuarios ']) ?>
                <?php $ac[] = get_format_fecha_busqueda() ?>
                <?php $ac[] = form_close() ?>
                <?php $ac[] = end_row() ?>
                <?php $ac[] = addNRow(place("top_50 repo_usabilidad")) ?>

                <?= div(append($ac), ["class" => "tab-pane", "id" => 'tab_usuarios']) ?>

                <?php $t[] = div("TAREAS RESUELTAS", "titulo_enid_sm", 1) ?>
                <?php $t[] = render_atencion_cliente() ?>
                <?= div(append($t), ["class" => "tab-pane", "id" => "tab_atencion_cliente"]) ?>

                <?= div(div("PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS", "titulo_enid_sm", 1), ["class" => "tab-pane", "id" => "tab_afiliaciones"]) ?>

                <?php $b[] = div("PRODUCTOS MÁS BUSCADOS POR CLIENTES", "titulo_enid_sm", 1) ?>
                <?php $b[] = get_form_busqueda_productos_solicitados() ?>
                <?= div(append($b), ["class" => "tab-pane", "id" => "tab_busqueda_productos"]) ?>


                <?php $c[] = div(
                    "CATEGORÍAS DESTACADAS",
                    [
                        "class" => "titulo_enid_sm"
                    ]
                    ,
                    1) ?>
                <?php $c[] = div("", "top_50") ?>
                <?php $c[] = div(crea_repo_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas)), "row") ?>

                <?= div(append($c), ["class" => "tab-pane", "id" => "tab_productos_publicos"]) ?>
            </div>
        </div>
    </div>
</div>