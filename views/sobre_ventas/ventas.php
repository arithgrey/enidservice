
<div class="container  top_100">
    <div>
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                <div class="">
                    <div class="mb-5">
                        <?= icon(_mas_opciones_icon) ?>
                    </div>
                    <div class="feature-content">
                        <h2>Consigue 10% de ganancia por cada pedido que referencies</h2>
                        <p class="lead"></p>
                        <hr class="m-t-30 m-b-30">
                        <p class="f12">
                            Tu agendas el pedido y nosotros entregamos, cuando el cliente recibe paga y en ese momento te entregamos tu ganancia!
                        </p>
                        
                        <div class="mt-5">
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
                            <?= icon('fa fa-check-square mr-5') ?>Puedes traer clientes de cualquier red social
                        </div>
                        <?php if ($in_session < 1) : ?>
                        <?php else : ?>
                            <?= format_link('Explorar artículos!', ['href' => path_enid('home'), 'class' => 'mt-5']) ?>
                        <?php endif; ?>
                    </div>
                    
                </div>
                <?=botones_ver_mas()?>
                
            </div>
            <div class="offset-xl-1 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="circle-1"></div>
                <div class="feature-app-img">
                    <img src="<?= path_enid('dispositivo') ?>" alt="App Landing Page Template - Quanto">
                </div>
            </div>
        </div>
    </div>
</div>

    
</div>