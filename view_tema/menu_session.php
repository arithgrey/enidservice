      <div class="row ">

            <ul class="largenav pull-right">                            
            <!--
            <li class="upper-links">
                <a class="links white" href="../notificar">
                    <i class="fa fa-money">
                    </i>
                    Notificar compra
                </a>
            </li>
                            
            -->
            <li class="upper-links">
                <a  class="links white" 
                    href="../login/?action=nuevo">
                    <i class="fa fa-shopping-cart">
                    </i>
                    Vender
                </a>
            </li>
            <li class="upper-links">
                <a  class="links white" 
                    href="../afiliados/">
                    <i class="fa fa-usd">
                    </i>
                    Afiliados
                </a>
            </li>
            <li class="upper-links">
                <a  class="links white" 
                    href="../contacto/#envio_msj">
                    <i class="fa fa-paper-plane">
                    </i>
                    Envía mensaje
                </a>
            </li>

            <?php if ($in_session ==  0): ?>
                <li class="upper-links">
                    <a   
                            class="links white" 
                            href="../login"
                            style="background: #6e9eff;padding: 5px;color: white!important;" 
                            >
                            Iniciar sesión
                        <i class="fa fa-user"></i>

                    </a>
                </li>            
            <?php endif; ?>               
            </ul>
        </div>
        