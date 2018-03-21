<div class='row contenedor-info-ventas' style="background: white!important;">
    <div class='container contenedo-texto-footer'>
        <input type="hidden" class="in_session" value="<?=$in_session?>">
        <input type="hidden" name="titulo_web" class="titulo_web" value="<?=$titulo?>">
        <?php if($in_session ==  0){ ?>
        <hr>

        <div class='col-lg-12'>
            <!---->
            <div class='col-lg-4'>
                <div class='col-lg-2'>
                    <i class="fa fa-3x fa-fighter-jet">                    
                    </i>
                </div>
                <div class='col-lg-10'>
                    <div>
                        <label class="strong">
                            Facilidad de compra
                        </label>
                    </div>
                    <div>
                        <span class='black'>                           
                           Compras seguras 
                           <strong>
                           al momento
                           </strong>
                        </span>
                        
                                                            
                        <?php

                            if (isset($id_usuario)) {

                                echo "<input type='hidden'  
                                           class='id_usuario'
                                           value='".$id_usuario."' 
                                            >";
                            }
                        ?>
                        
                    </div>
                </div>

            </div>

            <!---->
            <div class='col-lg-4'>
                <div class='col-lg-2'>
                    <i class="fa fa-clock-o fa-3x">                    
                    </i>
                </div>
                <div class='col-lg-10'>
                    <div>
                        <label class="strong">
                            + Entregas puntuales
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


            <!---->
            <div class='col-lg-4'>
                <div class='col-lg-2'>
                    <i class="fa fa-lock fa-3x" >                    
                    </i>
                </div>
                <div class='col-lg-10'>
                    <div>
                        <label class="strong">
                            Compras seguras
                        </label>
                    </div>
                    <div>
                        <span class='black'>
                            Evoluciona y escala con base en tu éxito
                        </span>
                    </div>
                </div>        
            </div>
        </div>
        <br>
        <hr>
        <?php }?>
    </div>
</div>



    



<?php if($in_session ==  0){ ?>

<div style='background:#003299' class='row contenedor-info-ventas' >
    <div class='container contenedo-texto-footer'>
        <br>
        <div class='col-lg-6'>
            <span class='white strong' style='font-size:1.5em;'>
                ENTÉRATE DE LAS NOVEDADES Y OBTÉN HASTA UN 
                <span style="color: #fff !important;background: #fc0b0b;padding: 2px;">
                    15% DE DESCUENTO 
                </span>
                <i  class="btn_copiar_enlace_pagina_contacto fa fa-clone" 
                    data-clipboard-text="Te comparto nuestra página donde si te registras recibes promociones y precios especiales al comprar en línea ->   
                    http://enidservice.com/inicio/contacto/#seccion_recibir_promociones e incluso nos puedes enviar tu mensaje">
                                    
                </i>
            </span>
        </div>
        <div class='col-lg-6'>
          

            <form id="form_enid_contacto" class="form_enid_contacto" 
                    class="forms" 
                    action="../msj/index.php/api/emp/lead/format/json" 
                    method="post"
                    class="form-horizontal">                    
                    <div class="form-group">     
                      <div class="col-lg-12 parte_oculta_lead" style="display:none;" >
                        
                        <input type="text" class="nombre_lead" name="nombre" placeholder="Nombre" required >
                        <span class="place_nombre_lead"></span>
                        <input 
                              type="number" 
                              name="telefono" 
                              placeholder="Telefono"
                              class="telefono_info_contacto telefono_lead" 
                              required >                             
                        <span class="place_telefono_lead">                            
                        </span>


                      </div>
                      <div class="col-md-12">
                        <div class="input-group">
                          <input 
                            id="btn_cotizacion" 
                            name="email" 
                            onkeypress="minusculas(this);"
                            class="form-control correo_electrionico_lead" 
                            placeholder="Correo Electrónico" type="email">
                            <div class="input-group-addon btn btn_enviar_email_prospecto" 
                            id="seccion_recibir_promociones">
                                Recibir promociones
                                    
                            </div>


                        </div>

                                                    
                      </div>
                      <div>
                                
                      </div>
                      <div class="col-md-12">
                        <div class="place_registro_contacto">
                        </div>
                      </div>
                    </div>                    
                </form>


        </div>
    </div>
</div>
<footer class="dark-bg footer-extra" style='background:#fff;'>
    <div>    
        <div class="row">
            <div class='col-lg-10 col-lg-offset-1'>
                <div class="col-md-3 col-sm-6 inner">
                    
<ul>
    <li>
    <h5 style="font-size:1.2em!important; color: #000!important;"> ASISTENCIA
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
    
</ul>


                </div>
                <div class="col-md-3 col-sm-6 inner">
                        

    <ul>
        <li>
        <h5 style="font-size:1.2em!important; color: #000!important;"> 
            TEMAS RELACIONADOS
        </h5>
        </li>
        <li>
            &nbsp;
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
                    <ul>
                    <li>
                    <h5 style="font-size:1.2em!important; color: #000!important;"> 
                        ESPECIALES
                    </h5>
                    </li>
                    <li>
                        &nbsp;
                    </li>
                    

                    <li>
                        <a class='black link_menu_footer strong' href="../afiliados/" 
                            >
                            -Afiliados
                        </a>
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
                    <ul>
                    <li>
                        <a href="../sobre_enidservice">
                            <h5 style="font-size:1.2em!important; color: #000!important;">
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








<div class="footer-bottom" style='background:#01192f!important;'>
    <div class="container inner">
    <p class=" white">
        © 2017 ENID SERVICE.                 
    </p>


</div>
</div>
</footer>


<?php } ?>



<script src="../js_tema/js/main.js">
</script>
<script src="../js_tema/js/librerias/clipboard.min.js">
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
<link rel="stylesheet" href="../css_tema/font-asome2/css/font-awesome.min.css">

<?php
        if ($in_session ==  0 ){
?>

<?php
  }
?>





<link rel="stylesheet" type="text/css" href="../css_tema/template/main.css">
</body>
</html>

<style type="text/css">
    body{
        font-family:Arial,Helvetica,Verdana,sans-serif!important;
    }
    .link_menu_footer:hover{
        text-decoration:underline!important; 
    }
</style>

<link href="../css_tema/template/bootstrap.min.css" 
rel="stylesheet" id="bootstrap-css">

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-98483031-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-98483031-1');
</script>

<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif!important;
    }
</style>