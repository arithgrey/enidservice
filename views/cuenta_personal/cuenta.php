<div class="row top_150 base_enid_web">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-4">
                <a href="<?=path_enid('pedidos')?>">
                    <div class="card mt-5" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='white'">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold mb-0 d-flex align-items-center"><i class="fa fa-truck mr-2" aria-hidden="true"></i>Mis pedidos</h5>
                            <p class="card-text black ml-2 mt-2">Aquí podrás ver tus pedidos recientes</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?=path_enid('administracion_cuenta')?>">
                    <div class="card mt-5" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='white'">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold mb-0 d-flex align-items-center"><i class="fa fa-unlock-alt mr-2" aria-hidden="true"></i>Inicio de sesión y seguridad</h5>
                            <p class="card-text black ml-2 mt-2">Protege tu cuenta con una contraseña segura</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?=path_enid('rastrea-paquete')?>">
                    <div class="card mt-5" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='white'">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold mb-0 d-flex align-items-center"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>Servicio al cliente</h5>
                            <p class="card-text black ml-2 mt-2">Contáctanos si necesitas ayuda</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?=path_enid('lista_deseos')?>">
                    <div class="card mt-5" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='white'">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold mb-0 d-flex align-items-center"><i class="fa fa-gift mr-2" aria-hidden="true"></i>Lista de deseos</h5>
                            <p class="card-text black ml-2 mt-2">Aquí podrás ver tus artículos deseados</p>
                        </div>
                    </div>

                </a>
            </div>
        </div>
    </div>
</div>

<!-- Agregamos las siguientes clases CSS para cambiar el color de fondo de las tarjetas al pasar el cursor sobre ellas -->
<style>
    .card:hover {
        background-color: #f2f2f2;
        cursor: pointer;
    }
</style>