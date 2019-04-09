<div class="panel-heading">
    <?= ul([
        li(anchor_enid("Atención al cliente", ["href" => "#tab_1_actividad", "data-toggle" => "tab"]), ["class" => "active"]),
        li(anchor_enid("Comparativa", ["href" => "#tab_2_comparativa", "data-toggle" => "tab"]), ["class" => "comparativa"]),
        li(anchor_enid("Calidad y servicio", ["href" => "#tab_3_comparativa", "data-toggle" => "tab"]), ["class" => "calidad_servicio"])

    ],
        ["class" => "nav nav-tabs"]
    ) ?>
</div>
<div class="tab-content">
    <?= div(get_form_busqueda_desarrollo(), ["class" => "tab-pane fade in active", "id" => "tab_1_actividad"]) ?>
    <?= div(place("place_metricas_comparativa"), ["class" => "tab-pane fade", "id" => "tab_2_comparativa"]) ?>
    <?= div(get_form_busqueda_desarrollo_solicitudes(), ["class" => "tab-pane fade", "id" => "tab_3_comparativa"]) ?>
</div>