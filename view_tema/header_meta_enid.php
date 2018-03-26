<?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
    $enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>    
    <title>
        <?=$titulo?> 
        Compra y vende tus productos aquí!
    </title>    
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">        
    
    <!--Google-->
    <?=meta('keywords', $meta_keywords . " ");?>    



    <?=meta('author', 'Enid Service');?>        
    <meta name="description" content="<?=$desc_web;?>"/>
    <meta name="robots" content="all">
    <meta name="google-site-verification" content="http://enidservice.com/google8dba39b938429ded.html"/> 
    <link rel="canonical" href="http://enidservice.com/inicio/paginas_web/" />   
    <link rel="canonical" href="http://www.enidservice.com/inicio/correo_para_negocios/"/>   
    <link rel="alternate" hreflang="es" href="http://enidservice.com/" />
    <meta name="googlebot" content="index,follow">
    <meta name="geo.region" content="MX-DIF" />
    <meta name="geo.position" content="23.634501;-102.552784" />
    <meta name="geo.placename" content="Ciudad de Mexico"/>
    <meta name="ICBM" content="23.634501, -102.552784" />
    <meta name="revisit-after" content="1 days" />
    
    <link rel="publisher" href="https://plus.google.com/u/0/117684782897236574265"/>


    <!--Open Graph data-->        
    <meta property="og:locale" content="es_ES" />
    <meta property="og:type" content="article" />    
    <meta property="og:title" content="<?=$desc_web;?>"/>
    <meta property="og:url" content="<?=$enlace_actual;?>" />
    <meta property="og:site_name" content="Enid Service" />
    <meta property="og:image" content="<?=$url_img_post?>" />
    <meta property="og:description" content="<?=$desc_web;?>" />            
    <meta property="business:contact_data:email" content="ventas@enidservice.com" />
    <meta property="business:contact_data:phone_number" content="5552967027" />
    <meta property="business:contact_data:website" content="<?=$enlace_actual;?>" />    
    <meta property="article:publisher" content="https://www.facebook.com/enidservicemx"/>
    <meta property="place:location:latitude"  content="23.634501" /> 
    <meta property="place:location:longitude" content="-102.552784" /> 
    <meta property="fb:admins" content="645179855527609" />

    
    <!--Twitter Card data-->
    
    <meta name="twitter:card" content="summary">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@enidservice">
    <meta name="twitter:title" content="Enid Service - <?=$titulo?>">
    <meta name="twitter:description" content="<?=$desc_web;?>">    
    <meta name="twitter:creator" content="@enidservice">
    <meta name="twitter:image" content="<?=$url_img_post?>">
    <meta name="twitter:image:src" content="<?=$url_img_post?>">
        
    <meta itemprop="name" content="Enid Service">
    <meta itemprop="description" content="<?=$desc_web;?>">
    <meta itemprop="image logo" content="<?=$url_img_post?>">
    <meta itemprop="email" content="ventas@enidservice.com">
    <meta itemprop="telephone" content="5552967027">
    <meta itemprop="address" content="Eje Central Lázaro Cárdenas 38, Centro Histórico, Centro, 06000 Ciudad de México, CDMX, Local 406">
    <meta itemprop="url" content="<?=base_url()?>">
    <meta itemprop="photo" content="<?=$url_img_post?>">
 
    
    <link href="../css_tema/main.css" rel="stylesheet">   
   
    <link rel="shortcut icon" href="../img_tema/enid_service_logo.jpg">
    <script src="../js_tema/jquery.min.js">
    </script>
    <script src="../js_tema/jquery.easing.1.3.min.js">
    </script>
    <!--
    <script src="../js_tema/jquery.form.js">
    </script>
-->

    
    <script src="../js_tema/jquery.validate.min.js">
    </script>   
    <script src="../js_tema/bootstrap.min.js">
    </script>
    <script src="../js_tema/aos.js">
    </script>
    <script src="../js_tema/owl.carousel.min.js">
    </script>
    
    
    
    <script src="../js_tema/jquery.isotope.min.js">
    </script>

    <script src="../js_tema/imagesloaded.pkgd.min.js">
    </script>
    <script src="../js_tema/jquery.easytabs.min.js">
    </script>
    
    <script src="../js_tema/viewport-units-buggyfill.js">   
    </script>    
    <script src="../js_tema/scripts.js">
    </script>


    
    

