<div class="contenedor_principal_enid">
    <div class="contenedor_principal_enid_service">
        <?= d(get_menu(), 2) ?>
        <div class='col-lg-10'>
            <div class="tab-content">
                <?= d(place("place_reporte"), ["class" => "tab-pane", "id" => 'reporte']) ?>
                <?php $i[] = n_row_12() ?>
                <?php $i[] = d("INDICADORES ENID SERVICE", "titulo_enid_sm", 1) ?>
                <?php $i[] = form_open("", ["class" => 'form_busqueda_global_enid']) ?>
                <?php $i[] = get_format_fecha_busqueda() ?>
                <?php $i[] = form_close() ?>
                <?php $i[] = end_row() ?>
                <?php $i[] = addNRow(place("place_usabilidad top_50")) ?>
                <?= d(append($i), ["class" => "tab-pane active", "id" => 'tab_default_1']) ?>

                <?php $ds[] = n_row_12() ?>
                <?php $ds[] = d("DISPOSITIVOS ", "titulo_enid_sm", 1) ?>
                <?php $ds[] = form_open("", ["class" => 'f_dipositivos ']) ?>
                <?php $ds[] = get_format_fecha_busqueda() ?>
                <?php $ds[] = form_close() ?>
                <?php $ds[] = end_row() ?>
                <?php $ds[] = addNRow(place("top_50 repo_dispositivos")) ?>
                <?= d(append($ds), ["class" => "tab-pane", "id" => 'tab_dispositivos']) ?>

                <?php $v[] = n_row_12() ?>
                <?php $v[] = d("VISITAS WEB ", "titulo_enid_sm", 1) ?>
                <?php $v[] = form_open("", ["class" => 'f_usabilidad']) ?>
                <?php $v[] = get_format_fecha_busqueda() ?>
                <?php $v[] = form_close() ?>
                <?php $v[] = end_row() ?>
                <?php $v[] = place("top_50 place_usabilidad_general") ?>

                <?= d(append($v), ["class" => "tab-pane", "id" => 'tab_default_2']) ?>


                <?php $p[] = n_row_12() ?>
                <?php $p[] = d("TIPOS DE ENTREGAS ", "titulo_enid_sm", 1) ?>
                <?php $p[] = form_open("", ["class" => 'form_tipos_entregas']) ?>
                <?php $p[] = get_format_fecha_busqueda() ?>
                <?php $p[] = form_close() ?>
                <?php $p[] = end_row() ?>
                <?php $p[] = addNRow(place("place_tipos_entregas top_50")) ?>
                <?= d(append($p), ["class" => "tab-pane", "id" => 'tab_tipos_entregas']) ?>

                <?php $ac[] = n_row_12() ?>
                <?php $ac[] = d("ACTIVIDAD ", "titulo_enid_sm", 1) ?>
                <?php $ac[] = form_open("", ["class" => 'f_actividad_productos_usuarios ']) ?>
                <?php $ac[] = get_format_fecha_busqueda() ?>
                <?php $ac[] = form_close() ?>
                <?php $ac[] = end_row() ?>
                <?php $ac[] = addNRow(place("top_50 repo_usabilidad")) ?>

                <?= d(append($ac), ["class" => "tab-pane", "id" => 'tab_usuarios']) ?>

                <?php $t[] = d("TAREAS RESUELTAS", "titulo_enid_sm", 1) ?>
                <?php $t[] = render_atencion_cliente() ?>
                <?= d(append($t), ["class" => "tab-pane", "id" => "tab_atencion_cliente"]) ?>

                <?= d(d("PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS", "titulo_enid_sm", 1), ["class" => "tab-pane", "id" => "tab_afiliaciones"]) ?>

                <?php $b[] = d("PRODUCTOS MÁS BUSCADOS POR CLIENTES", "titulo_enid_sm", 1) ?>
                <?php $b[] = get_form_busqueda_productos_solicitados() ?>
                <?= d(append($b), ["class" => "tab-pane", "id" => "tab_busqueda_productos"]) ?>


                <?php $c[] = d(
                    "CATEGORÍAS DESTACADAS",
                    [
                        "class" => "titulo_enid_sm"
                    ]
                    ,
                    1) ?>
                <?php $c[] = d("", "top_50") ?>
                <?php $c[] = d(crea_repo_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas)), "row") ?>

                <?= d(append($c), ["class" => "tab-pane", "id" => "tab_productos_publicos"]) ?>
            </div>
        </div>
    </div>
</div>