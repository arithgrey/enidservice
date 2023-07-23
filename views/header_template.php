<!DOCTYPE html>
<html lang="es">

<head>
  <?= $this->load->view("header_meta_enid") ?>
</head>

<?php if ($pixel_facebook > 0) : ?>
  <?= $this->load->view("pixel_fb") ?>
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
      $mas_vendidos,
      $id_nicho
    ) ?>
  <?php endif; ?>


  <div class="container-fluid" id="page-content">
    <?= menu_session_mobil($mas_vendidos) ?>
    <?= opciones_acceso($id_nicho) ?>
    <?= modal_intento_conversion() ?>
    <?= modal_desglose_carro_compra() ?>
    <?= modal_prueba_en_casa() ?>
    <?= modal_format_pago() ?>
    <?= modal_politica_devoluciones() ?>
    <?= modal_anuncio_negocio() ?>
    <?= modal_venta_auto() ?>
    <?= modal_mayoristas() ?>
    <?= modal_detalle_imagen() ?>