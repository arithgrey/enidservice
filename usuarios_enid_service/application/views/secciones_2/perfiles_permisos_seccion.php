<?= heading_enid("Perfiles / permisos", 3) ?>
<div class="col-lg-3">
    <?= heading_enid("Perfil" . icon("fa fa-space-shuttle"), 4) ?>
    <?= create_select(
        $perfiles_enid_service,
        "perfil",
        "form-control perfil_enid_service",
        "perfil_enid_service",
        "nombreperfil",
        "idperfil") ?>
</div>

<div class='col-lg-9'>
    <div class="tab-content">

        <?= div(append([
            heading_enid("Recurso", 3),

            anchor_enid("+ Agregar Recurso",
                [
                    "href" => "#tab_agregar_recursos",
                    "data-toggle" => "tab",
                    "class" => "btn input-sm"
                ]),

            place("place_perfilles_permisos")


        ]),
            ["class" => "tab-pane active ", "id" => "sec_0"]) ?>

    </div>
</div>
