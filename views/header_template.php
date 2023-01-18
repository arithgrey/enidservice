<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->load->view("header_meta_enid")?>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DWKGKK30KK"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DWKGKK30KK');
</script>

<body class="h-100 d-flex flex-column">
<?=navegacion(
            $path_img_usuario, 
            $in_session, 
            $clasificaciones_departamentos,
            $proceso_compra,             
            $menu)?>
<?= menu_session_mobil($in_session) ?>

<div class="container-fluid" id="page-content">
<?=modal_prueba_en_casa()?>
<?=modal_anuncio_negocio()?>
<?=modal_venta_auto()?>
<?=modal_mayoristas()?>

  
    


