<?=n_row_12()?>
    <div class='contenedor-info-ventas'>
        <div class='container contenedo-texto-footer'>
            <input type="hidden" class="in_session" value="<?=$in_session?>">
            <input type="hidden" name="titulo_web" class="titulo_web" value="<?=$titulo?>">
            

            <?php if ($in_session === 0):?>                
                <?=n_row_12()?>
                    <div style="margin-top: 40px;"></div>
                    <hr>
                    <div style="margin-top: 20px;"></div>
                <?=end_row()?>
                <div>                    
                    <div class='col-lg-4'>
                        <div class="row">
                            <div class='col-lg-2'>
                                <i class="fa fa-3x fa-fighter-jet">                    
                                </i>
                            </div>
                            <div class='col-lg-10'>
                                <div>
                                    <label class="strong">
                                        FACILIDAD DE COMPRA
                                    </label>
                                </div>
                                <div>
                                    <span class='black'>                           
                                       Compras seguras 
                                       <strong>
                                       al momento
                                       </strong>
                                    </span>
                                    
                                    <?php if(isset($id_usuario)):?>
                                        <input 
                                            type='hidden' 
                                            class='id_usuario' 
                                            value='<?=$id_usuario;?>'>
                                    <?php endif;?>    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-4'>
                        <div class="row">
                            <div class='col-lg-2'>
                                <i class="fa fa-clock-o fa-3x">                    
                                </i>
                            </div>
                            <div class='col-lg-10'>
                                <div>
                                    <label class="strong">
                                        + ENTREGAS PUNTUALES
                                    </label>
                                </div>
                                <div>
                                    <span class='black'>                            
                                        Recibe lo que deseas 
                                        en tiempo y forma
                                    </span>
                                </div>
                            </div> 
                        </div>
                    </div>                    
                    <div class='col-lg-4'>
                        <div class="row">
                            <div class='col-lg-2'>
                                <i class="fa fa-lock fa-3x" >                    
                                </i>
                            </div>
                            <div class='col-lg-10'>
                                <div>
                                    <label class="strong">
                                        COMPRAS SEGURAS
                                    </label>
                                </div>
                                <div>
                                    <span class='black'>
                                        Tu dinero se entregará al vendedor hasta que confirmes que recibiste tu pedido!
                                    </span>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>                
                <?=n_row_12()?>
                    <div style="margin-top: 40px;"></div>                    
                <?=end_row()?>
            <?php endif; ?>
        </div>
    </div>



        



    <?php if ($in_session === 0):?>

    <?=n_row_12()?>
        <?=$this->load->view("../../../view_tema/seccion_iniciar_session");?>    
    <?=end_row()?>
    <?=$this->load->view("../../../view_tema/form_recibir_promociones");?>
    <?=n_row_12()?>
    <footer class="dark-bg footer-extra" style='background:#fff;'>
        <div>    
            <div class="row">
                <div class='col-lg-10 col-lg-offset-1'>
                    <div class="col-md-3 col-sm-6 inner">
                        
    <ul class="row">
        <li style="background: black;">
            <h5 style="font-size:1.2em!important; color: white!important;padding: 2px;"> 
                ASISTENCIA
            </h5>
        </li>
        <li>&nbsp;
        </li>
        <li>
            <a class='black link_menu_footer' href="../contacto/#envio_msj">
               - Servicio al cliente
            </a>
        </li>        
        <li>
            <a class='black link_menu_footer' href="../notificar">
                - Notificar pagos
            </a>
        </li>
        <li>
            <a class='black link_menu_footer' href="../terminos-y-condiciones">
                -Términos y condiciones
            </a>
        </li>
        
        
    </ul>


                    </div>
                    <div class="col-md-3 col-sm-6 inner">
                            

        <ul class="row">
            <li style="background: black;">
                <h5 style="font-size:1.2em!important; color: white!important;padding: 2px;"> 
                    TEMAS RELACIONADOS
                </h5>
            </li>
            <li>
                &nbsp;
            </li>
            
            <li>
                <a class='black link_menu_footer' href="../forma_pago/?info=">
                    - Formas de pago
                </a>
            </li>
            <li>
                <a  class='black link_menu_footer strong' 
                    href="../faq/" 
                    >
                    - Temas de ayuda 
                </a>
            </li>    
            
        </ul>








                    </div>
                    <div class="col-md-3 col-sm-6 inner">
                        <ul class="row">
                            <li style="background: black;">
                            <h5 style="font-size:1.2em!important; color: white!important;padding: 2px;"> 
                                ESPECIALES
                            </h5>
                            </li>
                            <li>
                                &nbsp;
                            </li>
                            
                            <li>
                                <a class='black link_menu_footer' 
                                    href="../unete_a_nuestro_equipo" >
                                    Trabaja en nuestro equipo
                                </a>
                            </li>                                           
                        </ul>




                    </div>                
                    <div class="col-md-3 col-sm-6 inner">                
                        <ul class="row">
                            <li style="background: black;"> 
                                <a href="../sobre_enidservice">
                                    <h5 style="font-size:1.2em!important; color: white!important;padding: 2px;">
                                        ACERCA DE NOSOTROS
                                    </h5>
                                </a>
                            </li>
                            <li>
                                &nbsp;
                            </li>
                            
                            <li>
                                <a class='link_menu_footer' href="../sobre_enidservice">
                                    <img 
                                    src="../img_tema/enid_service_logo.jpg" 
                                    width="100%" >
                                </a>
                            </li>    
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    <div class="footer-bottom" style='background:#001d9b !important'>
        <div class="container inner">
            <p class=" white">
                © 2017 ENID SERVICE.                 
            </p>
        </div>
    </div>
    </footer>
    <?=end_row()?>
    <?php endif; ?>
<?=end_row()?>
<script src="../js_tema/js/main.js?<?=version_enid?>">
</script>
<script src="../js_tema/js/librerias/clipboard.min.js?<?=version_enid?>">
</script>
<script>
    var clipboard = new Clipboard('.btn_copiar_enlace_pagina_contacto');
    clipboard.on('success', function(e) {
        console.info('Accion:', e.action);
        console.info('Texto:', e.text);
        console.info('Trigger:', e.trigger);

        e.clearSelection();
    });
    clipboard.on('error', function(e) {
        console.error('Accion:', e.action);
        console.error('Trigger:', e.trigger);
    });
</script>
    <link 
        rel="stylesheet" 
        href="../css_tema/font-asome2/css/font-awesome.min.css?<?=version_enid?>">
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="../css_tema/template/main.css?<?=version_enid?>">
</body>
</html>
<link href="../css_tema/template/bootstrap.min.css?<?=version_enid?>" 
rel="stylesheet" id="bootstrap-css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 
