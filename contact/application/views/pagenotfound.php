<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title>404 Page</title>

  <link href="<?=base_url('application/css/css/style.css')?>" rel="stylesheet">
  <link href="<?=base_url('application/css/css/style-responsive.css')?>" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>


<style type="text/css">
  
  .error-page{
    background: none repeat scroll 0% 0% #09AFDF !important;
  }
</style>


<body class="error-page">

<section>
    <div class="container ">

        <section class="error-wrapper text-center">
            
            <h2>Página no encontrada</h2>
            <h3>
              No hemos podido encontrar esta página
            </h3>
            <h1 style="font-size: 3em;font-weight: bold;">
              Enid Service
            </h1>
            <a class="back-btn" href="<?=base_url()?>"> Regresar al inicio</a>
        </section>

    </div>
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?=base_url('application/js/js/jquery-1.10.2.min.js')?>"></script>
<script src="<?=base_url('application/js/js/jquery-migrate-1.2.1.min.js')?>"></script>
<script src="<?=base_url('application/js/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('application/js/js/modernizr.min.js')?>"></script>


</body>
</html>
