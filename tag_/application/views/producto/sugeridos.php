<?php if(count($servicios)>0): ?>  
<?=heading_enid("TAMBIÉN PODRÍA INTEREZARTE" , 3 , [] , 1)?>
<?php endif;?>
<div>  
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
        $url_venta         ="../../producto/?producto=".$id_servicio;
        $extra ="";
        $flag =0;        
        $flag ++;

        $existencia =0;
        $vista =0;
            
        $img =  img([
          'src'   => $url_img, 
          'title' => 'Ver artículo',                 
          'alt'   => $metakeyword,
          'onerror' => "this.onerror=null;this.src='".$url_img."';"
        ]);    
    

    $nombre_servicio = $row["nombre_servicio"]; 
    $nombre_servicio = (strlen($nombre_servicio )>40 && $is_mobile == 0) ? 
    substr($nombre_servicio, 0 , 40):$nombre_servicio;


    $nombre_servicio = ($is_mobile == 1) ?
    substr($nombre_servicio, 0 , 25):$nombre_servicio;

    $titulo_articulo
    = anchor($url_venta , 
      $nombre_servicio , 
      array('class' =>  'articulo-sugerido-a' )); 
  ?>    
  <div class="col-lg-4">
    <div class="product">      
      <?=div(anchor($url_venta , $img ) , ["class"=>"img-cont"])?>      
        <div class="product-info">
          <div class="product-content">
            <div class="container-fluid">            
              <div class="titulo-articulo-inf">
                <?=heading_enid(
                  $titulo_articulo , 
                  1 ,  
                  ['class' => 'articulo-sugerido'])?>              
              </div>
            </div>
            <?php  if($flag_servicio ==  0):?>              
              <div class="container-fluid">                
                <?=anchor_enid($precio ."MXN" ,  
                  [
                    'src'   => $url_venta,
                    'class' => 'button btn-precio-sugerido ' , 
                    'id'    =>'price'
                  ])?>
              </div>                      
              <?php  endif; ?>                    
          </div>
        </div>      
    </div>
  </div>
  <?php  endforeach;?>
</div>
