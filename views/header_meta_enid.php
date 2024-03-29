<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
$enlace = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<title>Pago contra entrega CDMX <?= $titulo ?></title>

<meta name="google-site-verification" content="CRCERpjQ1KolmfT9LEgiEC1GbnkyxdZvdd8MVqs1lY4" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?= meta('keywords', $meta_keywords . " "); ?>
<?= meta('author', 'Enid Service'); ?>
<meta name="description" content="Pago contra entrega CDMX - <?= $desc_web; ?>" />
<meta name="robots" content="all">
<link rel="canonical" href="http://enidservices.com/" />
<link rel="canonical" href="http://www.enidservices.com/" />
<link rel="alternate" hreflang="es" href="http://enidservices.com/" />
<meta name="googlebot" content="index,follow">
<meta name="geo.region" content="MX-DIF" />
<meta name="geo.position" content="23.634501;-102.552784" />
<meta name="geo.placename" content="Ciudad de Mexico" />
<meta name="ICBM" content="23.634501, -102.552784" />
<meta name="revisit-after" content="1 days" />
<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?= $desc_web; ?>" />

<meta property="og:site_name" content="Enid Service" />
<meta name="p:domain_verify" content="287921956bb357b93dabea5956368127"/>

<?php if (isset($url_img_post) && !is_null($url_img_post)) : ?>
    <meta property="og:url" content="<?= create_url_preview($url_img_post,1) ?>" />
    <meta property="og:image" content="<?= create_url_preview($url_img_post,1) ?>" />
<?php else : ?>
    <meta property="og:url" content="https://enidservices.com/kits-pesas-barras-discos-mancuernas-fit/img_tema/portafolio/pesas.jpg" />
    <meta property="og:image" content="https://enidservices.com/kits-pesas-barras-discos-mancuernas-fit/img_tema/portafolio/pesas.jpg" />
<?php endif; ?>

<meta property="og:description" content="Pago contra entrega CDMX <?= $desc_web; ?>" />
<meta property="fb:app_id" content="708127766008103" />
<meta property="business:contact_data:email" content="ventas@enidservices.com" />
<meta property="business:contact_data:phone_number" content="5552967027" />
<meta property="business:contact_data:website" content="<?= $enlace; ?>" />
<meta property="article:publisher" content="https://www.facebook.com/enidservicemx" />
<meta property="place:location:latitude" content="23.634501" />
<meta property="place:location:longitude" content="-102.552784" />
<meta property="fb:admins" content="645179855527609" />
<!--Twitter Card data-->
<meta name="twitter:card" content="summary">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@enidservice">
<meta name="twitter:title" content="<?= $titulo ?>">
<meta name="twitter:description" content="Pago contra entrega CDMX <?= $desc_web; ?>">
<meta name="twitter:creator" content="@enidservice">
<meta name="twitter:image" content="<?= $url_img_post ?>">
<meta name="twitter:image:src" content="<?= $url_img_post ?>">
<meta itemprop="name" content="Enid Service">
<meta itemprop="description" content="Pago contra entrega CDMX <?= $desc_web; ?>">
<meta itemprop="image logo" content="<?= $url_img_post ?>">
<meta itemprop="email" content="ventas@enidservices.com">
<meta itemprop="telephone" content="5552967027">
<meta itemprop="address" content="">
<meta itemprop="url" content="<?= base_url() ?>">
<meta itemprop="photo" content="<?= $url_img_post ?>">
<meta name="p:domain_verify" content="db70882d0b8730259e2a264f997224b3" />
<meta name="facebook-domain-verification" content="wsvdn89zybnrs300qx1bnnt8gn8lcj" />
<link rel="shortcut icon" href="../img_tema/enid_service_logo.jpg">
<script type="text/javascript" src="../js_tema/jquery.min.js?<?= version_enid ?>">
</script>
<script src="../js_tema/bootstrap.min.js">
</script>
<script src="../js_tema/js/main.js?<?= version_enid ?>"></script>
<script src="../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="../js_tema/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js"></script>
<link rel="stylesheet" type="text/css" href="../css_tema/template/main.css?<?= version_enid ?>">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="../css_tema/template/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="../css_tema/font-asome2/css/font-awesome.min.css">
<link rel="stylesheet" href="../js_tema/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<link href="https://fonts.googleapis.com/css?family=Red+Hat+Text:400,400i,500,500i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="../css_tema/experiencia/experiencia.css">


<input type="hidden" class="http_referer_enid" value="<?= $enlace; ?>" />
<input type="hidden" class="ip_referer_enid" value="<?= getRealIPAddress(); ?>" />

<?php if (isset($js_extra_web) && !is_null($js_extra_web) && is_array($js_extra_web)) : ?>
    <?php foreach ($js_extra_web as $script) : ?>
        <script type='text/javascript' src='<?php echo $script; ?>'></script>
    <?php endforeach; ?>
<?php endif; ?>