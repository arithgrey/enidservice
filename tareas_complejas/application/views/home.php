<div id='info_antes_de_ayuda'>
    <div class="col-lg-2">
        <?= get_format_izquierdo($in_session) ?>
    </div>
    <div class='col-lg-10'>
        <?= n_row_12() ?>
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <?= anchor_enid("Desarrollo de software ",
                        ["href" => "#home", "data-toggle" => "tab"]) ?>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <?= heading_enid("Solución a tareas complejas", 3) ?>
                    <?= img(["src" => "../img_tema/portafolio/ejemplo-personas.jpg"]) ?>
                    <?= p("El servicio de desarrollo de software") ?>
                    <?= p("Enid Service, está pensado en empresas que atienden 
                  las crecientes demandas del mercado, al tiempo que mejoran la eficiencia de sus procesos,es sinónimo a simplificación y automatización de tareas complejas.") ?>
                    <?= $this->load->view("secciones_2/beneficios") ?>
                    <?= p("y ... ya que empleamos metodologías ágiles, le brindamos alta capacidad de reacción ") ?>
                    <?= p("y ... ya que empleamos metodologías ágiles, le brindamos alta capacidad de reacción ante los cambios de requerimientos generados por necesidades del cliente o evoluciones de su mercado.") ?>

                    <?= n_row_12() ?>
                    <div class="col-lg-6">
                        <?= img(["src" =>
                            "../img_tema/metodologias/scrum.png"]) ?>
                        <?= p("Proceso que integra las mejores prácticas para realizar la calendarización de entregas parciales dentro de un proyecto.") ?>
                        <?= p("Es ideal cuando donde los requisitos son cambiantes y se necesita capacidad de reacción ante la competencia.") ?>

                    </div>
                    <div class="col-lg-6">
                        <?= img(
                            ["src" =>
                                "../img_tema/metodologias/xpprogramming.png"]) ?>

                        <?= p("Marco de trabajo en el cual los usuarios finales del producto son quiénes marcan las necesidades y se despliegan bajo los principios de desarrollo y gestión con eficacia, simplicidad, flexibilidad y control.") ?>
                    </div>
                    <?= end_row() ?>
                    <?= anchor_enid("Iniciemos conversación", ["href" => "../contact"]) ?>
                    <?= hr() ?>
                </div>
            </div>
        </div>
        <?= end_row() ?>
    </div>
</div>
