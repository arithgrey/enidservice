<div class="contenedor_principal_enid">
    <div class="contenedor_principal_enid_service">
        <?= div(get_menu(), 2) ?>
        <div class='col-lg-10'>
            <div class="tab-content">
                <?= div(place("place_reporte"), ["class" => "tab-pane", "id" => 'reporte']) ?>
                <div class="tab-pane active" id='tab_default_1'>
                    <?= n_row_12() ?>
                    <?= div("INDICADORES ENID SERVICE", "titulo_enid_sm", 1) ?>
                    <?= form_open("", ["class" => 'form_busqueda_global_enid']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close() ?>
                    <?= end_row() ?>
                    <?= addNRow(place("place_usabilidad top_50")) ?>
                </div>
                <div class="tab-pane" id='tab_default_2'>
                    <?= n_row_12() ?>
                    <?= div("VISITAS WEB ", "titulo_enid_sm", 1) ?>
                    <?= form_open("", ["class" => 'f_usabilidad']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close() ?>
                    <?= end_row() ?>
                    <?= place("top_50 place_usabilidad_general") ?>
                </div>
                <div class="tab-pane" id='tab_tipos_entregas'>
                    <?= n_row_12() ?>
                    <?= div("TIPOS DE ENTREGAS ", "titulo_enid_sm", 1) ?>
                    <?= form_open("", ["class" => 'form_tipos_entregas']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close() ?>
                    <?= end_row() ?>
                    <?= addNRow(place("place_tipos_entregas top_50")) ?>
                </div>
                <div class="tab-pane" id='tab_usuarios'>
                    <?= n_row_12() ?>
                    <?= div("ACTIVIDAD ", "titulo_enid_sm", 1) ?>
                    <?= form_open("", ["class" => 'f_actividad_productos_usuarios ']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close() ?>
                    <?= end_row() ?>
                    <?= addNRow(place("top_50 repo_usabilidad")) ?>
                </div>
                <div class="tab-pane" id='tab_dispositivos'>
                    <?= n_row_12() ?>
                    <?= div("DISPOSITIVOS ", "titulo_enid_sm", 1) ?>
                    <?= form_open("", ["class" => 'f_dipositivos ']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close() ?>
                    <?= end_row() ?>
                    <?= addNRow(place("top_50 repo_dispositivos")) ?>
                </div>
                <div class="tab-pane" id="tab_atencion_cliente">
                    <?= div("TAREAS RESUELTAS", "titulo_enid_sm", 1) ?>
                    <?=render_atencion_cliente()?>
                </div>
                <div class="tab-pane" id="tab_afiliaciones">
                    <?= div("PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS", "titulo_enid_sm", 1) ?>
                </div>
                <div class="tab-pane" id="tab_busqueda_productos">
                    <?= div("PRODUCTOS MÁS BUSCADOS POR CLIENTES", "titulo_enid_sm", 1) ?>
                    <?= get_form_busqueda_productos_solicitados() ?>
                </div>
                <div class="tab-pane" id="tab_productos_publicos">
                    <?= div(
                        "CATEGORÍAS DESTACADAS",
                        [
                                "class" => "titulo_enid_sm"
                        ]
                        ,
                        1) ?>
                    <?= div("", "top_50") ?>
                    <?php $categorias_destacadas_orden = sub_categorias_destacadas($categorias_destacadas); ?>
                    <?= div(crea_repo_categorias_destacadas($categorias_destacadas_orden), "row") ?>
                </div>
            </div>
        </div>
    </div>
</div>