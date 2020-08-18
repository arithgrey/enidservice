<div class="">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                <div class="feature-block-v7 feature-block">
                    <div class="feature-icon text-brand bg-brand-light mb-5">
                        <?= icon(_mas_opciones_icon) ?>
                    </div>
                    <div class="feature-content">
                        <h2>Aumenta tus ingresos desde tu hogar</h2>
                        <p class="lead"></p>
                        <hr class="m-t-30 m-b-30">
                        <p>
                            Recomienda clientes y gana por tu referencia, tu agendas el pedido y nosotros entregamos, cuando el cliente recibe nosotros te pagamos tu ganancia!
                        </p>
                        <div class="mt-1">
                            <h5 class="cursor_pointer">
                                ¿Por qué ser parte de nuestro equipo
                                <strong class="link_nuba">
                                    nuba seller?
                                </strong>
                            </h5>
                        </div>
                        <div class="mt-1">
                            <?= icon('fa fa-check-square mr-5') ?>Se tu propio jefe y administra tus tiempos
                        </div>
                        <div class="mt-1">
                            <?= icon('fa fa-check-square mr-5') ?>No es necesaria ninguna inversión
                        </div>
                        <div class="mt-1">
                            <?= icon('fa fa-check-square mr-5') ?>El cliente paga cuando recibe
                        </div>
                        <div class="mt-1">
                            <?= icon('fa fa-check-square mr-5') ?>Realizas la venta, nosotros entregamos
                        </div>
                        <div class="mt-1">
                            <?= icon('fa fa-check-square mr-5') ?>Entregamos el mismo día
                        </div>
                        <div class="mt-1">
                            <?= icon('fa fa-check-square mr-5') ?>Puedes traer clientes desde cualquier red social e incluso  recomendarnos con tus  conocidos
                        </div>
                        <?php if ($in_session < 1):?>
                            <?= format_link('Registra tu cuenta ahora!', ['href' => path_enid('nuevo_usuario'), 'class' => 'mt-5']) ?>
                        <?php  else:?>
                            <?= format_link('Explorar artículos!', ['href' => path_enid('home'), 'class' => 'mt-5']) ?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="offset-xl-1 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="circle-1"></div>
                <div class="feature-app-img">
                    <img src="<?= path_enid('dispositivo') ?>"
                         alt="App Landing Page Template - Quanto">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="definicion_nuba_seller d-none">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                <div class="feature-block-v7 feature-block">
                    <div class="feature-content">
                        <h2>Nuba seller</h2>
                    </div>
                    <p>
                        Equipo apasionado por competir, qué conecta personas con artículos que dan solución a una de sus problemáticas.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
