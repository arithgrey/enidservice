<?php 

  $q                  =  $info["q"];  
  $nombre             =  $q["nombre"];
  $email              =  $q["email"];
  $password_legible   =  $q["password_legible"];  
  $telefono           =  $q["telefono"];  

?>
<div class="jumbotron" 
  style="padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;">
    
    <?=heading("Buen día" . $nombre )?>
    <?=div("Te notificamos que desde este momento puedes consultar más productos y servicios a través de ")?>
    <?=anchor_enid("Enid Service" , 
        [
          "class"     =>  "btn btn-primary btn-lg" ,
          "href"      =>  "http://enidservice.com/" ,
          "target"    =>  "_blank" ,
          "style"     =>  "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
    ])?>
  
    <hr class="my-4">
    <?=div("Desde ahora podrás comprar y vender tus productos o servicios ")?>
    <?=anchor_enid("Accede a tu cuenta aquí!" , 
      [
        "class"     =>  "btn btn-primary btn-lg" ,
        "href"      =>  "http://enidservice.com/inicio/login/" ,
        "target"    =>  "_blank" ,
        "style"     =>  "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
    ])?>
</div>

<table>
    <tr>
      <?=get_td("Info", ["colspan"=>"2"])?>
    </tr>
    <tr>
      <?=get_td("Usuario")?>
      <?=get_td("Información de acceso")?>
    </tr>
    <tr>
      <?=get_td($email)?>
      <?=get_td($password_legibleemail)?>
    </tr>
</table>


<?=div(img([
    "src"     =>  "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg" ,
    "style"   =>  "width: 100%"
  ]),  
  [
    "style"   =>  "width: 30%;margin: 0 auto;"
])?>