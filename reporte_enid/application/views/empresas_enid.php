<div class="contenedor_principal_enid">
    <div class="contenedor_principal_enid_service">
        <div class="col-lg-2">
            <nav class="nav-sidebar">
                <?= get_menu() ?>
            </nav>
        </div>
        <div class='col-lg-10'>
            <div class="tab-content">
                <div class="tab-pane" id='reporte'>
                    <?= place("place_reporte") ?>
                </div>
                <div class="tab-pane active" id='tab_default_1'>
                    <?= div("INDICADORES ENID SERVICE",
                        ["class" => "titulo_enid_sm", 1]) ?>
                    <?= form_open("", ["class" => 'form_busqueda_global_enid']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close(place("place_usabilidad")) ?>
                </div>
                <div class="tab-pane" id='tab_default_2'>
                    <?= div("VISITAS WEB ", ["class" => "titulo_enid_sm"], 1) ?>
                    <?= form_open("", ["class" => 'f_usabilidad']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close(place("place_usabilidad_general")) ?>
                </div>
                <div class="tab-pane" id='tab_tipos_entregas'>
                    <?= div("TIPOS DE ENTREGAS ", ["class" => "titulo_enid_sm"], 1) ?>
                    <?= form_open("", ["class" => 'form_tipos_entregas']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close(place("place_tipos_entregas")) ?>
                </div>
                <div class="tab-pane" id='tab_usuarios'>
                    <?= div("ACTIVIDAD ", ["class" => "titulo_enid_sm", 1]) ?>
                    <?= form_open("", ["class" => 'f_actividad_productos_usuarios ']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close(place("repo_usabilidad")) ?>
                </div>
                <div class="tab-pane" id='tab_dispositivos'>
                    <?= div("DISPOSITIVOS ", ["class" => "titulo_enid_sm", 1]) ?>
                    <?= form_open("", ["class" => 'f_dipositivos ']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close(place("repo_dispositivos")) ?>
                </div>
                <div class="tab-pane" id='tab_default_3'>
                    <?= div("EMAIL ENVIADOS ", ["class" => "titulo_enid_sm", 1]) ?>
                    <?= form_open("", ["class" => 'form_busqueda_mail_enid']) ?>
                    <?= get_format_fecha_busqueda() ?>
                    <?= form_close(place("place_envios")) ?>
                    <?= place("place_mail_marketing") ?>
                </div>
                <div class="tab-pane" id="tab_atencion_cliente">
                    <?= div("TAREAS RESUELTAS", ["class" => "titulo_enid_sm"], 1) ?>
                    <?= $this->load->view("secciones/atencion_cliente"); ?>
                </div>
                <div class="tab-pane" id="tab_afiliaciones">
                    <?= div("PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS",
                        ["class" => "titulo_enid_sm"], 1) ?>
                </div>
                <div class="tab-pane" id="tab_busqueda_productos">
                    <?= div("PRODUCTOS MÁS BUSCADOS POR CLIENTES",
                        ["class" => "titulo_enid_sm"], 1) ?>

                   <?=get_form_busqueda_productos_solicitados()?>

                </div>
                <div class="tab-pane" id="tab_productos_publicos">
                    <?= div(
                        "CATEGORÍAS DESTACADAS",
                        ["class" => "titulo_enid_sm"]
                        ,
                        1) ?>

                    <?php $categorias_destacadas_orden = sub_categorias_destacadas($categorias_destacadas); ?>
                    <?= div(crea_repo_categorias_destacadas($categorias_destacadas_orden), ["class" => "row"]) ?>
                </div>
            </div>
        </div>
    </div>
</div>