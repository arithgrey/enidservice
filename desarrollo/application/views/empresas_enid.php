<div class="contenedor_principal_enid_service">
    <?= div(ul(get_menu($activa), ["class" => "nav tabs"]), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= input_hidden(["type" => 'hidden', "class" => 'id_usuario', "value" => $id_usuario]) ?>
            <?= div(get_format_charts(), ["class" => "tab-pane " . valida_seccion_activa(2, $activa), "id" => 'tab_charts']) ?>
            <div class="tab-pane <?= valida_seccion_activa(1, $activa) ?>" id='tab_abrir_ticket'>
                <?= $this->load->view("../../../view_tema/formularios/busqueda_tickets") ?>
            </div>
            <?= div(place("place_form_tickets"), ["class" => "tab-pane " . valida_seccion_activa(3, $activa), "id" => "tab_nuevo_ticket"]) ?>
        </div>
    </div>
</div>
