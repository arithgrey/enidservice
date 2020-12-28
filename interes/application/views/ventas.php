<div class="container">
    <?php if ($es_administrador): ?>
        <?= d(d(format_link("Agregar pregunta frecuente", ["class" => "boton_ingresos"]), 3), 13) ?>
    <?php endif; ?>
    <div class="text-center">
        <h3>
            ¿En qué podemos ayudarte?
        </h3>
        <?= p('Escribe algo como "precio de envío"') ?>
    </div>
    <div class="d-flex justify-content-center h-100 mt-5">
        <?= form_open("", ["class" => "form_busqueda"]) ?>
        <div class="searchbar">
            <input class="search_input" type="text" name="q" placeholder="Buscar...">
            <a href="#" class="search_icon">
                <?= icon('fa fa-search') ?>
            </a>
        </div>

        <?= form_close() ?>
    </div>
</div>
<?= place('respuestas') ?>
<?= form_ingreso() ?>
<?= tags() ?>

