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
                            <?= icon('fa fa-check-square mr-5') ?>Puedes traer clientes desde cualquier red social e incluso recomendarnos con tus conocidos
                        </div>
                        <?php if ($in_session < 1) : ?>
                            <?= format_link('Registra tu cuenta ahora!', ['href' => path_enid('nuevo_usuario'), 'class' => 'mt-5']) ?>
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
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <h3 class="text-uppercase">
                Pasos a seguir
            </h3>
            <div class="row">
                <div class="col-md-8">
                    <h4>
                        1.- Registra tu cuenta para poder acceder a las comisiones
                        que ganarás por cada artículo que nos ayudes a vender

                    </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <?= format_link(
                                'Crea tu cuenta!',
                                [
                                    'href' => path_enid('nuevo_usuario'),
                                    'class' => 'mt-5'

                                ],
                                0
                            ) ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-0.png">
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-1.png">
                </div>
                <div class="col-md-8">
                    <h4>
                        2.- Explora y descarga fotos sobre los artículos que deseas promocionar, en cada producto podrás encontrar
                    </h4>
                    <h5 class="fp9">
                        - Su ficha descriptiva
                    </h5>
                    <h5 class="fp9">
                        - Enlaces a promociones
                    </h5>
                    <h5 class="fp9">
                        - Imágenes que puedes descargar
                    </h5>
                    <h5 class="fp9">
                        - Información sobre la ganancia que tendrás una vez que entreguemos tu pedido agendado
                    </h5>
                    <h5 class="fp9">
                        - Fotos sobre clientes que ya han recibido sus pedidos
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <?= format_link(
                                'Explora el catálogo de productos',
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
            <div class="row">
                <div class="col-md-8">
                    <h4>
                        3.- Promociona en tus redes sociales nuestros artículos
                    </h4>
                    <h5 class="fp9">
                        - Ya sea <strong> Facebook, Instagram </strong> o cualquier otra red social,
                        puedes promocionar los artículos en donde más se te facilite,
                        no existe algún tipo de límite y como tip te recomendamos
                        los anuncies en el <strong> marketplace de Facebook </strong> ya que es una plataforma
                        diseñada para vender de forma fácil por internet
                    </h5>

                </div>
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-2.png">
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-3.png">
                </div>
                <div class="col-md-8">
                    <h4>
                        4.- Agenda tus pedidos
                    </h4>
                    <h5 class="fp9">
                        - Para que podamos hacer entrega de tus pedidos a tus
                         clientes, es necesario agendar los artículos que serán 
                         repartidos en nuestra página con tu cuenta, el sitio web solicita los siguientes datos 
                         para la liberación.
                    </h5>                   

                    <h5 class="fp9 mt-2">
                        - Nombre del cliente
                    </h5>
                    <h5 class="fp9">
                        - Número telefónico
                    </h5>
                    <h5 class="fp9">
                        - Ubicación de entrega
                    </h5>
                    <h5>
                        Adicional a ello contamos con una sección de preguntas relacionadas a los aspectos de compra, entrega y liberación de tus pedidos 
                        <a href="<?=path_enid('interes')?>">  aquí</a>
                        
                    </h5>

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <h4>
                        5.- Indica tiempos de entrega a tus clientes
                    </h4>
                    <h5 class="fp9">
                    Nos caracterizamos por 
                    cobrar al momento de que nuestros clientes reciban sus 
                    artículos en su domicilio y ofrecemos la oportunidad de que 
                    reciban su pedido el mismo día que lo solicitas siempre y cuando 
                    tu orden cumpla con las siguientes condiciones
                    </h5>
                    <h5 class="fp9">
                        1.-Estar ubicado en CDMX
                    </h5>                    
                    <h5 class="fp9">
                        2.-Agendar tu pedido en un horario de 8AM a 5PM
                        <p class="mt-2">
                            <strong> El tiempo promedio de entrega una vez que realices tu pedido es de 1 hora con 30 minutos</strong>, 
                            este tiempo puede aumentar o bajar de acuerdo a la distancia entre la ubicación y 
                            nuestro centro de distribución, en cuanto uno de nuestros repartidores esté por
                             salir a entregar tu pedido  marcará a tu cliente e 
                             indicará el tiempo en que llegará,
                              es importante que el cliente reciba la llamada para
                               que tu entrega pueda
                               ser efectuada</p>
                    </h5>                    
                </div>
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-4.png">
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 col-12">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-5.png">
                </div>
                <div class="col-md-8">
                    <h4>
                        6.- Recibe tus comisiones correspondientes
                    </h4>
                    <h5 class="fp9">
                        - Es necesario indiques algunos datos en nuestro sitio web,
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
            <div class="row">
                <div class="col-md-8">
                    <h4>
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
                <div class="col-md-4">
                    <img src="../img_tema/clientes/paso-6.png">
                </div>
            </div>
        </div>
    </div>

</div>