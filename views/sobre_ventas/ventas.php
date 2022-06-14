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
                        <div class="mt-1 mb-5">
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
                            <?= icon('fa fa-check-square mr-5') ?>Puedes traer clientes desde cualquier red social e incluso recomendarnos con tus conocidos
                        </div>
                        <?php if ($in_session < 1) : ?>
                        <?php else : ?>
                            <?= format_link('Explorar artículos!', ['href' => path_enid('home'), 'class' => 'mt-5']) ?>
                        <?php endif; ?>
                    </div>
                </div>
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



<div class="container">
    <div class="row">
        <h3 class="text-uppercase">
            Como iniciar
        </h3>
    </div>
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-md-8">

            <div class="row">
                <?= format_link(
                    'Crea tu cuenta!',
                    [
                        'href' => path_enid('nuevo_usuario'),
                        'class' => 'mt-5 mb-5 col-md-4'

                    ]
                ) ?>

            </div>

        </div>

        <div class="col-md-4">
            <img src="../img_tema/clientes/paso-0.png">
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-1.png">
                </div>
                <div class="col-md-8 mt-5">
                    <h4>
                        2.- Explora y descarga fotos sobre los artículos que deseas promocionar
                    </h4>
                    <p class="strong">En cada producto podrás encontrar:</p>
                    <ul class="p-0 ml-3">
                        <li class="fp9 black p-0">
                            - Su ficha descriptiva
                        </li>
                        <li class="fp9 black p-0">
                            - Enlaces a promociones
                        </li>
                        <li class="fp9 black p-0">
                            - Imágenes que puedes descargar
                        </li>
                        <li class="fp9 black p-0">
                            - El monto que recibirás una vez que entreguemos tu pedido
                        </li>
                        <li class="fp9 black p-0">
                            - Fotos sobre clientes que ya han recibido sus productos
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-6">
                            <?= format_link(
                                'Explora los productos',
                                [
                                    'href' => path_enid('nuevo_usuario'),
                                    'class' => 'mt-5'
                                ],
                                1
                            ) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-8">
                    <h4>
                        3.- Promociona en tus redes sociales nuestros artículos
                    </h4>
                    <h5 class="fp9 mt-5 mb-5">
                        - Ya sea <strong> Facebook, Instagram </strong> u otra red social,
                        puedes promocionar los artículos en donde más se te facilite,
                        no existe algún tipo de límite aun que recomendamos
                        anuncies en el <strong> marketplace de Facebook </strong> ya que es una plataforma
                        diseñada para vender de forma fácil
                    </h5>

                </div>
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-2.png">
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-sm-12">
            <hr>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-3.png">
                </div>
                <div class="col-md-8 mt-5">
                    <h4>
                        4.- Agenda tus pedidos
                    </h4>
                    <p class="fp9 black">
                        Para que podamos hacer llegar sus pedidos a tus clientes,
                        tendrás que agendar los artículos que serán
                        repartidos, el sitio te solicitará estos datos para reservar la cita:
                    </p>

                    <ul class="p-0 ml-3">
                        <li class="fp9 black mt-2">
                            - Nombre del cliente
                        </li>
                        <li class="fp9 black">
                            - Número telefónico
                        </li>
                        <li class="fp9 black">
                            - Ubicación de entrega
                        </li>
                        <li class="fp9 black">
                            Adicional a ello contamos con una sección de preguntas relacionadas a los aspectos de compra, entrega y liberación de tus pedidos
                            <a class="strong" href="<?= path_enid('interes') ?>"> aquí</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-5">
                        5.- Indica tiempos de entrega a tus clientes
                    </h4>
                    <h5 class="fp9">
                        Ofrecemos la oportunidad de que los clientes
                        reciban sus pedidos el mismo día que lo solicitas siempre y cuando
                        tu orden cumpla con las siguientes condiciones
                    </h5>

                    <ul class="p-0 ml-3">
                        <li class="fp9 black p-0">
                            1.-Estar ubicado en CDMX
                        </li>
                        <li class="fp9 black p-0">
                            2.-Agendar tu pedido en un horario de 8AM a 5PM
                            <p class="mt-2 mt-5">
                                <strong> El tiempo promedio de entrega una vez que realices tu pedido es de 1 hora con 30 minutos</strong>,
                                este tiempo puede aumentar o bajar de acuerdo a la distancia entre la ubicación y
                                nuestro centro de distribución, en cuanto uno de nuestros repartidores esté por
                                salir a entregar tu pedido marcará a tu cliente e
                                indicará el tiempo en que llegará,
                                es importante que el cliente reciba la llamada para
                                que tu entrega pueda
                                ser efectuada
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 mt-5">
                    <img src="../img_tema/clientes/paso-4.png">
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-5.png">
                </div>
                <div class="col-md-8 mt-5">
                    <h4 class="mb-5">
                        6.- Recibe tus comisiones
                    </h4>
                    <h5 class="fp9">
                        - Es necesario indiques algunos datos en nuestro sitio,
                        con la finalidad de que realicemos la transferencia
                        de tus fondos una vez
                        tus pedidos sean entregados.
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-5">
                        7.- Asegurate de ofrecer más artículos a tus clientes
                    </h4>
                    <h5 class="fp9">
                        Sabemos que nuestros nuevos clientes se siente felices de comprar
                        una vez más
                        después de su primer compra, por ello
                        no dudes en agradecer su confianza así como
                        ofrecer las novedades que estemos lanzando
                    </h5>
                </div>
                <div class="col-md-4 mt-5 mb-5">
                    <img src="../img_tema/clientes/paso-6.png">
                </div>
                <div class="col-md-4 mb-5 ">
                    <?= format_link(
                        'Crea tu cuenta!',
                        [
                            'href' => path_enid('nuevo_usuario'),
                            'class' => 'bottom_50'
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>