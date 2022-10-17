<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->load->view("header_meta_enid")?>
</head>

<body class="h-100 d-flex flex-column">
<?=navegacion(
            $path_img_usuario, 
            $in_session, 
            $clasificaciones_departamentos,
            $proceso_compra, 
            $id_usuario, 
            $menu)?>
<?= menu_session_mobil($in_session) ?>

<div class="container-fluid" id="page-content">
  
    


