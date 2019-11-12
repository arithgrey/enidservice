<div id='info_antes_de_ayuda'>
    <?= d(get_format_izquierdo($in_session), 2) ?>
    <div class='col-lg-10'>

        <?= tab(
            _titulo("Desarrollo de software "), "#home"

        ); ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <?= h("Solución a tareas complejas", 3) ?>
                <?= img(["src" => "../img_tema/portafolio/ejemplo-personas.jpg"]) ?>
                <?= p("El servicio de desarrollo de software") ?>
                <?= p("Enid Service, está pensado en empresas que atienden las crecientes demandas del mercado, al tiempo que mejoran la eficiencia de sus procesos,es sinónimo a simplificación y automatización de tareas complejas.") ?>
                <?= $this->load->view("secciones_2/beneficios") ?>
                <?= p("y ... ya que empleamos metodologías ágiles, le brindamos alta capacidad de reacción ") ?>
                <?= p("y ... ya que empleamos metodologías ágiles, le brindamos alta capacidad de reacción ante los cambios de requerimientos generados por necesidades del cliente o evoluciones de su mercado.") ?>
                <?= n_row_12() ?>
                <?php
                $x = [];
                $x[] = img(["src" => "../img_tema/metodologias/scrum.png"]);
                $x[] = p("Proceso que integra las mejores prácticas para realizar la calendarización de entregas parciales dentro de un proyecto.");
                $x[] = p("Es ideal cuando donde los requisitos son cambiantes y se necesita capacidad de reacción ante la competencia.");
                ?>
                <?= d(append($x), 6) ?>
                <?= btw(
                    img(
                        ["src" =>
                            "../img_tema/metodologias/xpprogramming.png"
                        ]
                    )
                    ,
                    p("Marco de trabajo en el cual los usuarios finales del producto son quiénes marcan las necesidades y se despliegan bajo los principios de desarrollo y gestión con eficacia, simplicidad, flexibilidad y control.")
                    , 6


                ) ?>
                <?= end_row() ?>
                <?= a_enid("Iniciemos conversación", path_enid("contact")) ?>
                <?= hr() ?>
            </div>
        </div>
    </div>

</div>
</div>
