<div class="contenedor_principal_enid_service">
    <?= div(ul(get_menu($activa), "nav tabs"), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= input_hidden(["type" => 'hidden', "class" => 'id_usuario', "value" => $id_usuario]) ?>
            <div class="tab-pane <?= valida_seccion_activa(1, $activa) ?>" id='tab_abrir_ticket'>
                <div class="row">
                    <div class="col-lg-12">
                        <?= div(text_icon("fa fa-search", "Ticket"), 4) ?>
                        <div class="formulario_busqueda_tickets">
                            <?= div(
                                input(
                                    [
                                        "name" => "q",
                                        "class" => "input-sm q",
                                        "type" => "text"
                                    ]
                                ),
                                4
                            ) ?>
                            <?= div(
                                append(
                                    [
                                        create_select(
                                            $departamentos,
                                            "depto",
                                            "form-control input-sm depto",
                                            "depto",
                                            "nombre",
                                            "id_departamento"
                                        )
                                        ,
                                        input_hidden(
                                            [
                                                "name" => "departamento",
                                                "value" => $num_departamento,
                                                "id" => 'num_departamento',
                                                "class" => 'num_departamento'
                                            ]
                                        )

                                    ]
                                ),
                                4
                            ) ?>
                        </div>
                    </div>
                </div>
                <?= div(div(place('place_proyectos'), "top_50"), 1) ?>
                <?= div(place('place_tickets'), 1) ?>
            </div>
            <?= div(
                div(place("place_form_tickets"), 1),
                [
                    "class" => "tab-pane " . valida_seccion_activa(3, $activa),
                    "id" => "tab_nuevo_ticket"
                ]
            ) ?>
        </div>
    </div>
</div>
<?= input_hidden([
    "class" => "ticket",
    "value" => $ticket,
]) ?>