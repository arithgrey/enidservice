<?php     
    $img_preferencias =  
    img([
        "src"   =>  "../img_tema/preferencias/preferencias-1.jpg" ,
        "class" =>  "from-left"
    ]);    

    $img_preferencias_2 =  
    img([
        "src"   =>  "../img_tema/preferencias/preferencias-2.jpg"  ,
        "class" =>  "from-left"
    ]);    

    $img_up 
    = img(["src"=>"../img_tema/preferencias/up-arrow.png", "alt"=>"up"]);

    $img_down
    = img(["src"=>"../img_tema/preferencias/up-arrow.png", "alt"=>"down"]); 
                    


    $img_preferencias_3     =  
    img(["src"=>"../img_tema/preferencias/preferencias-4.jpg", 
        "class"=>"from-left",  
        "alt"=>"image-3"]);

    $div_preferencias       =   div($img_preferencias ,  ["class"=>"slide-image animate"]);
    $div_nueva_temporada    =   
    div("Nueva temporada" ,["class"=>"product-type from-bottom"]);

?>
  <hr>
  <div class="col-lg-8 col-lg-offset-2" >
        <div id="slider">
            <ul class="slides">
                 <li class="single-slide slide-2 active">
                    <?=div("Apparel" , ["class"=>"slide-label"])?>                
                    <?=$div_preferencias?>                    
                    <div class="slide-content">
                        <?=div($div_nueva_temporada ,   ["class"=>"animate"] )?>
                        <?=div(heading_enid("ENCUENTRA" , 2 , [ "class"=> "from-bottom"]) ,  ["class"=>"animate"])?>
                        <?=div(heading_enid(
                            "ROPA PARA CADA OCACIÓN" , 2 , 
                            [ "class"=> "from-bottom"]) ,
                            ["class"=>"animate"])?>                        
                        
                        <?=heading_enid(
                            "EXPLORAR TIENDA" , 2 , 
                            [ "class"=> "from-bottom"])?>
                    </div>
                </li>

                <li class="single-slide slide-3">
                    <div class="slide-label">Bags</div>
                    <?=div($img_preferencias_2 , ["class"=>"slide-image animate"])?>
                    <div class="slide-content">
                        <?=div(div("Accesorios" ,  
                        ["class"=>"product-type from-bottom"]) ,  ["class" => "animate" ])?>
                        <?=div(heading_enid("Lo que usas en viajes" , 2 , 
                        [ "class"=> "from-bottom"]) ,  ["class"=>"animate"])?>
                        <?=heading_enid("Explorar tienda" , 3,
                        ["class"=>"shop-now" ,  "href"=>"../search"])?>                    
                    </div>
                </li>

                 <li class="single-slide slide-4">
                    <?=div("Diferentes estilos" , ["class"  =>"slide-label"] )?>
                    <?=div($img_preferencias_3 , ["class"   =>"slide-image animate"])?>                    
                    <div class="slide-content">                        
                        <?=div(
                        heading_enid("Encuentra entre múltiples opciones" ,  3,

                        ["class"=>"from-bottom"]) ,  
                        ["class"=>"animate"])?>
                        
                        <?=p("Para Dama y Caballero")?>                       
                        
                        <?=heading_enid(
                        "Mira las opciones" ,  3,
                        [
                            "class"    =>  "shop-now", 
                            "href"     =>  "../search"] , 
                        1) ?>                    
                    </div>
                </li>
            </ul>
            <?=get_btw(
                div($img_up ,    ["class"    =>  "slide-nav-up"]) ,
                div($img_down ,  ["class"    =>  "slide-nav-down"]),
                "slider-nav"
            )?>
        </div>    
        </div>
      <hr>