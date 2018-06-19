<style class="cp-pen-styles">body {
  padding: 1.5em;
  background: #fff;
  background: whitesmoke;
}
.cont {
  width: 100%;
  height: 100%;
}
.cont .product {
  width: 610px;
  height: 250px;
  display: flex;
  margin: 1em 0;
  border-radius: 5px;
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0px 0px 21px 3px rgba(0, 0, 0, 0.15);
  transition: all .1s ease-in-out;
}
.cont .product:hover {
  box-shadow: 0px 0px 21px 3px rgba(0, 0, 0, 0.11);
}
.cont .product .img-cont {
  flex: 2;
}
.cont .product .img-cont img {
  object-fit: cover;
  width: 100%;
  height: 100%;
}
.cont .product .product-info {
  background: #fff;
  flex: 3;
}
.cont .product .product-info .product-content {
  padding: .2em 0 .2em 1em;
}
.cont .product .product-info .product-content h1 {
  font-size: 1.5em;
}
.cont .product .product-info .product-content p {
  color: #636363;
  font-size: .9em;
  font-weight: bold;
  width: 90%;
}
.cont .product .product-info .product-content ul li {
  color: #636363;
  font-size: .9em;
  margin-left: 0;
}
.cont .product .product-info .product-content .buttons {
  padding-top: .4em;
}
.cont .product .product-info .product-content .buttons .button {
  text-decoration: none;
  color: #5e5e5e;
  font-weight: bold;
  padding: .3em .65em;
  border-radius: 2.3px;
  transition: all .1s ease-in-out;
}
.cont .product .product-info .product-content .buttons .add {
  border: 1px #5e5e5e solid;
}
.cont .product .product-info .product-content .buttons .add:hover {
  border-color: #6997b6;
  color: #6997b6;
}
.cont .product .product-info .product-content .buttons .buy {
  border: 1px #5e5e5e solid;
}
.cont .product .product-info .product-content .buttons .buy:hover {
  border-color: #6997b6;
  color: #6997b6;
}
.cont .product .product-info .product-content .buttons #price {
  margin-left: 4em;
  color: #5e5e5e;
  font-weight: bold;
  border: 1px solid rgba(137, 137, 137, 0.2);
  background: rgba(137, 137, 137, 0.04);
}
</style>

<div>
  <h3 style="font-size: 2em;" class="black">                    
    TAMBIÉN PODRÍA INTEREZARTE
  </h3>
</div>
<div class="cont row">  
  <?php foreach ($servicios as $row):?>

  <?php 
    $extra_color ="style='margin-left:5px;color: black;font-weight:bold;'";
    $list ="";  
    $flag =0;            
        $nombre_servicio =  $row["nombre_servicio"];             
        $id_servicio  =  $row["id_servicio"];                
        $flag_envio_gratis =  $row["flag_envio_gratis"];        
        $url_img  = $url_request."imgs/index.php/enid/imagen_servicio/".$id_servicio;        
        
        $metakeyword =  $row["metakeyword"];        
        $color =  isset($row["color"]) ? $row["color"] : "";
        $flag_servicio =  $row["flag_servicio"];
        
    
        $precio =  $row["precio"];           
        $costo_envio ="";
        if($flag_servicio == 0){
            $costo_envio =  $row["costo_envio"]["text_envio"]["cliente_solo_text"];                 
        } 
        
        $url_info_producto =  "../producto/?producto=".$id_servicio;
        $url_venta         ="http://enidservice.com/inicio/producto/?producto=".$id_servicio;
    
                            
        
        $extra ="";
        $flag =0;        
        $flag ++;

        $existencia =0;
        $vista =0;
             
        $atributos_imagen = 
            array(
                'src'   => $url_img, 
                'title' => 'Ver artículo',                 
                'alt'   => $metakeyword,
                'onerror' => "this.onerror=null;this.src='".$url_img."';"
            );
        $img =  img($atributos_imagen);    
                        
  ?>  
  
  <div class="col-lg-6">
    <div class="product">      
      <div class="img-cont">
        <?=$img?>
      </div>
      <div class="product-info">
        <div class="product-content">

          <h1>
            <a  href="<?=$url_venta?>" style="color:#02051d!important;">
              <?=$row["nombre_servicio"]?>
            </a>
          </h1>
          
          <div class="buttons">
            <?php  if($flag_servicio ==  0):?>
              <a class="button buy" href="<?=$url_venta?>">
                <?=$costo_envio?>
              </a>        
              <a href="<?=$url_venta?>">
                <span class="button" id="price"><?=$precio?>MXN</span>
              </a>    
            <?php  endif; ?>
            
          </div>
        </div>
      </div>
      
    </div>
  </div>

<?php  endforeach;?>
</div>
