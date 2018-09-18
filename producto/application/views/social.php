<div class="detail-socials">
  <?=anchor_enid("" , 
    ["class"                => "btn_copiar_enlace_pagina_contacto fa fa-clone black" ,  
      "data-clipboard-text" => $url_actual
    ])?>
  <?=anchor_enid("" , [
    "href"    =>   $url_facebook,
    "target"  =>  "_black",
    "class"   =>  "fa fa-facebook black" ,
    "title"   =>  "Compartir en Facebook"
  ]
  )?>
  <?=anchor_enid("" , 
  [
    "class"     =>  "fa fa-twitter black" ,
    "title"     =>  "Tweet",
    "target"    =>  "_black",
    "data-size" =>  "large",
    "href"      =>  $url_twitter,
  ])?>
  <?=anchor_enid("", [
    "href"      => $url_pinterest ,  
    "class"     =>"fa fa-pinterest-p black" , 
    "title"     =>"Pin it"
  ] )?>

  <?=anchor_enid("" , [
    "href"  =>   $url_tumblr,
    "class" =>  "fa fa-tumblr black", 
    "title" =>  "Tumblr"
  ])?>
  <?=mailto("ventas@enidservice.com",  icon("fa fa-envelope-open black"))?>
</div>          