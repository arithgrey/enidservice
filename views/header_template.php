<!DOCTYPE html>
<html lang="es">

<head>
  <?= $this->load->view("header_meta_enid") ?>
</head>

<?php if ($pixel_facebook > 0) : ?>
  <!-- Meta Pixel Code -->
  <script>
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '603499584596714');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=603499584596714&ev=PageView&noscript=1" /></noscript>
  <!-- End Meta Pixel Code -->
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-DWKGKK30KK"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-DWKGKK30KK');
  </script>


<?php endif; ?>

<body class="h-100 d-flex flex-column">
  <?php if ($navegacion_principal) : ?>
    <?= navegacion(
      $path_img_usuario,
      $in_session,
      $clasificaciones_departamentos,
      $proceso_compra,
      $menu,
      $mas_vendidos
    ) ?>
  <?php endif; ?>


  <div class="container-fluid" id="page-content">
    <?= menu_session_mobil($mas_vendidos) ?>
    <?= opciones_acceso($in_session) ?>
    <?= modal_intento_conversion() ?>
    <?= modal_desglose_carro_compra() ?>
    <?= modal_prueba_en_casa() ?>
    <?= modal_format_pago() ?>
    <?= modal_politica_devoluciones() ?>
    <?= modal_anuncio_negocio() ?>
    <?= modal_venta_auto() ?>
    <?= modal_mayoristas() ?>
    <?= modal_detalle_imagen() ?>