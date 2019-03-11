<?= heading_enid("Indicadores", 3) ?>
<?= get_menu_metricas() ?>
<div class="tab-content">
    <div class="tab-pane fade in active" id="tab_1_actividad">
        <?= get_form_busqueda_desarrollo() ?>
    </div>
    <div class="tab-pane fade" id="tab_2_comparativa">
        <?= place("place_metricas_comparativa") ?>
    </div>
    <div class="tab-pane fade" id="tab_3_comparativa">
        <?= form_busqueda_desarrollo_solicitudes() ?>
    </div>
</div>