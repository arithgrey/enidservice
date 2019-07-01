<div class="row">
    <div class="col-lg-12">
        <?= div("Ticket" . icon("fa fa-search"), 4) ?>
        <div class="formulario_busqueda_tickets">
            <?= div(input([
                "name" => "q",
                "class" => "input-sm q",
                "type" => "text"
            ]),
                4
            ) ?>
            <?= div(
                    append([

                            create_select(
                                    $departamentos,
                                    "depto",
                                    "form-control input-sm depto",
                                    "depto",
                                    "nombre",
                                    "id_departamento"
                            ),
                input_hidden([
                    "name" => "departamento",
                    "value" => $num_departamento,
                    "id" => 'num_departamento',
                    "class" => 'num_departamento'
                ])

            ]),
                4) ?>
        </div>
    </div>

</div>

<?= div(div(place('place_proyectos'), "top_50"),1) ?>

<?= div(place('place_tickets'), 1) ?>