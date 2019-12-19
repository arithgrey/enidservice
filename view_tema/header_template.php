<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->load->view("../../../view_tema/header_meta_enid") ?>
</head>
<body class="h-100 d-flex flex-column">
<div class="container-fluid" id="page-content">
    <?=navegacion( $in_session, $clasificaciones_departamentos, $proceso_compra, $id_usuario, $menu)?>
    <?= menu_session_mobil($in_session) ?>

