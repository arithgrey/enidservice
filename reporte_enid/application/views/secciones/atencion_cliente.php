<div class="panel-heading">
    <?= ul([
        li(anchor_enid("Atención al cliente", ["href" => "#tab_1_actividad", "data-toggle" => "tab"]), ["class" => "active"]),
        li(anchor_enid("Comparativa", ["href" => "#tab_2_comparativa", "data-toggle" => "tab"]), ["class" => "comparativa"]),
        li(anchor_enid("Calidad y servicio", ["href" => "#tab_3_comparativa", "data-toggle" => "tab"]), ["class" => "calidad_servicio"])

    ],
        ["class" => "nav nav-tabs"]) ?>
</div>
<div class="tab-content">
    <div class="tab-pane fade in active" id="tab_1_actividad">
        <?= get_form_busqueda_desarrollo() ?>
    </div>
    <div class="tab-pane fade" id="tab_2_comparativa">
        <?= place("place_metricas_comparativa") ?>
    </div>
    <div class="tab-pane fade" id="tab_3_comparativa">
        <?= get_form_busqueda_desarrollo_solicitudes() ?>
    </div>
</div>