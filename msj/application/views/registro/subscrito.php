<?php 

  $q =  $info["q"];  
  $nombre =  $q["nombre"];
  $email =  $q["email"];
  $password_legible =  $q["password_legible"];  
  $telefono=  $q["telefono"];  

?>
<div class="jumbotron" 
  style="padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;">
    <h1 class="display-4">
    Buen día <?=$nombre?>
  </h1>
    <p class="lead">
      Te notificamos que desde este momento puedes consultar más productos y servicios a través de 
      <a  class="btn btn-primary btn-lg" 
        href="http://enidservice.com/" 
        target="_blank" 
        style="background: #015ec8;padding: 5px;color: white;margin-top: 23px;">
        Enid Service
      </a>
  </p>
  <hr class="my-4">
  <p>
    Desde ahora podrás comprar y vender tus productos o servicios 
  </p>
  <p class="lead">
    <a  class="btn btn-primary btn-lg" 
      href="http://enidservice.com/inicio/login/" 
      target="_blank" 
      style="background: #015ec8;padding: 5px;color: white;margin-top: 23px;">
      Accede a tu cuenta aquí!
  </a>
  </p>
</div>

<div>
  <table style="width: 100%">
      <tr>
        <td colspan="2">
          Info
        </td>        
      </tr>
      <tr>
        <td>
          Usuario
        </td>
        <td>
          Información de acceso
        </td>
      </tr>
      <tr>
        <td>
          <?=$email?>
        </td>
        <td>
          <?=$password_legible?>
        </td>
      </tr>
  </table>
</div>

<div style="width: 30%;margin: 0 auto;">
    <img src="http://enidservice.com/inicio/img_tema/enid_service_logo.jpg" style="width: 100%">
</div>




























