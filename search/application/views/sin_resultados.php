<main>
    <div class="contenedor_principal_enid_service">
        <?= place("separador_inicial") ?>
        <div class="inf_sugerencias">
            <?= heading_enid("NO HAY PRODUCTOS QUE COINCIDAN CON TU BÚSQUEDA", 3, ["class" => "info_sin_encontrar"]) ?>
            <?= div("SUGERENCIAS", ["class" => "contenedor_sugerencias sugerencias"]) ?>
            <div class="info_sugerencias">
                <?= ul([
                    "- REVISA LA " . strong("ORTOGRAFÍA DE LA PALABRA"),
                    "- UTILIZA PALABRAS" . strong("MÁS SIMPLES"),
                    "- NAVEGA POR CATEGORÍAS",
                    li(anchor_enid("ANUNCIA ESTE PRODUCTO!" . icon('fa fa-chevron-right ir'),
                        ["href" => "../login",
                            "class" => "a_enid_black2"
                        ],
                        1,
                        1), ["class" => "anunciar_btn"])

                ]) ?>
            </div>
        </div>
        <?= place("separador_final") ?>
    </div>
</main>