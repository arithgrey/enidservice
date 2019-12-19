<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
$enlace = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<title><?= $titulo ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?= meta('keywords', $meta_keywords . " "); ?>
<?= meta('author', 'Enid Service'); ?>
<meta name="description" content="<?= $desc_web; ?>"/>
<meta name="robots" content="all">
<link rel="canonical" href="http://enidservices.com/"/>
<link rel="canonical" href="http://www.enidservice.com/"/>
<link rel="alternate" hreflang="es" href="http://enidservices.com/"/>
<meta name="googlebot" content="index,follow">
<meta name="geo.region" content="MX-DIF"/>
<meta name="geo.position" content="23.634501;-102.552784"/>
<meta name="geo.placename" content="Ciudad de Mexico"/>
<meta name="ICBM" content="23.634501, -102.552784"/>
<meta name="revisit-after" content="1 days"/>
<meta name="p:domain_verify" content="ed4f86be0c9d41f8889e945d5b65a701"/>
<meta property="og:locale" content="es_ES"/>
<meta property="og:type" content="article"/>
<meta property="og:title" content="<?= $desc_web; ?>"/>
<meta property="og:url" content="<?= $enlace; ?>"/>
<meta property="og:site_name" content="Enid Service"/>
<meta property="og:image" content="<?= $url_img_post ?>"/>
<meta property="og:description" content="<?= $desc_web; ?>"/>
<meta property="fb:app_id" content="708127766008103"/>
<meta property="business:contact_data:email" content="ventas@enidservices.com"/>
<meta property="business:contact_data:phone_number" content="5552967027"/>
<meta property="business:contact_data:website" content="<?= $enlace; ?>"/>
<meta property="article:publisher" content="https://www.facebook.com/enidservicemx"/>
<meta property="place:location:latitude" content="23.634501"/>
<meta property="place:location:longitude" content="-102.552784"/>
<meta property="fb:admins" content="645179855527609"/>
<!--Twitter Card data-->
<meta name="twitter:card" content="summary">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@enidservice">
<meta name="twitter:title" content="Enid Service - <?= $titulo ?>">
<meta name="twitter:description" content="<?= $desc_web; ?>">
<meta name="twitter:creator" content="@enidservice">
<meta name="twitter:image" content="<?= $url_img_post ?>">
<meta name="twitter:image:src" content="<?= $url_img_post ?>">
<meta itemprop="name" content="Enid Service">
<meta itemprop="description" content="<?= $desc_web; ?>">
<meta itemprop="image logo" content="<?= $url_img_post ?>">
<meta itemprop="email" content="ventas@enidservices.com">
<meta itemprop="telephone" content="5552967027">
<meta itemprop="address" content="Centro Histórico, Centro, 06000 Ciudad de México, CDMX, Local 406">
<meta itemprop="url" content="<?= base_url() ?>">
<meta itemprop="photo" content="<?= $url_img_post ?>">
<link rel="shortcut icon" href="../img_tema/enid_service_logo.jpg">
<script type="text/javascript" src="../js_tema/jquery.min.js?<?= version_enid ?>">
</script>
<script src="../js_tema/bootstrap.min.js?<?= version_enid ?>">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="../js_tema/js/main.js?<?= version_enid ?>"></script>
<script src="http://localhost/eje/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../css_tema/template/main.css?<?= version_enid ?>">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="../css_tema/template/bootstrap.min.css?" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="../css_tema/font-asome2/css/font-awesome.min.css?<?= version_enid ?>">
<link rel="stylesheet" href="../js_tema/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<script src="../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="../js_tema/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js"></script>