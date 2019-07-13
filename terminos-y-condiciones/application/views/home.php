<div class="contenedor_principal_enid">
    <?= d(append([
        ul(li("TEMAS DE AYUDA")),
        ul([
            "Realizar pedidos"
            , "Pagos"
            , "Envíos"
            , "Devoluciones"
            , "Uso de nuestro sitio"
            , "Términos y condiciones"
            , "POlítica de privacidad"
            , "Términos y condiciones de uso del sitio"])

    ]),
        3) ?>

    <div class="col-lg-9">
        <?= h($titulo) ?>
        <?= $this->load->view($vista); ?>
    </div>
</div>
