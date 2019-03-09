<div class="tabbable-panel">
    <div class="tabbable-line">
        <?= ul(
            [
                li(anchor_enid("Reporte", ["href" => "#tab_reporte_afiliados", "data-toggle" => "tab"]), ["class" => "active"]),
                li(anchor_enid("Afiliados productividad", ["href" => "#tab_reporte_lista_afiliados", "data-toggle" => "tab"]))
            ]
            , ["class" => "nav nav-tabs"]) ?>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_reporte_afiliados">
                <?= form_open("", ["class" => 'form_busqueda_afiliacion']) ?>
                <? $this->load->view("../../../view_tema/inputs_fecha_busqueda") ?>
                <?= form_close() ?>
                <?= place("place_repo_afiliacion") ?>
            </div>
            <div class="tab-pane" id="tab_reporte_lista_afiliados">
                <?= form_open("", ["class" => 'form_busqueda_afiliacion_productividad']) ?>
                <?=get_format_fecha_busqueda()?>                            
                <?= form_close() ?>
                <?= place("place_repo_afiliacion_productividad") ?>
            </div>
        </div>
    </div>
</div>
			