<?php
  
  $info_social["url_facebook"] =  get_url_facebook($url_actual);   
  $info_social["url_twitter"] =  get_url_twitter($url_actual , $desc_web);
  $info_social["url_pinterest"] = get_url_pinterest($url_actual, $desc_web);
  $info_social["url_tumblr"] = get_url_tumblr($url_actual, $desc_web);

  /**/
  $url_vide_youtube ="";  
  $id_servicio= "";
  $nombre_servicio= "";
  $descripcion = "";
  $status= "";
  $id_clasificacion= "";
  $flag_servicio = "";
  $flag_envio_gratis = "";
  $flag_precio_definido= "";
  $flag_nuevo= "";
  $existencia =0;
  $color ="";  
  /**/

  foreach($info_servicio["servicio"] as $row){
    
    $id_servicio =  $row["id_servicio"]; 
    $nombre_servicio =  $row["nombre_servicio"]; 
    $descripcion =  $row["descripcion"]; 
    $status =  $row["status"]; 
    $id_clasificacion =  $row["id_clasificacion"]; 
    $flag_servicio  =  $row["flag_servicio"]; 
    $flag_envio_gratis  =  $row["flag_envio_gratis"]; 
    $flag_precio_definido =  $row["flag_precio_definido"]; 
    $flag_nuevo =  $row["flag_nuevo"];    
      $url_vide_youtube =  $row["url_vide_youtube"];
    $existencia =$row["existencia"];
    $color = $row["color"];
    $flag_precio_definido =  $row["flag_precio_definido"];

  }

  $imagenes =  construye_seccion_imagen_lateral($imgs  ,$nombre_servicio , $url_vide_youtube);
  $info_compra["id_servicio"]= $id_servicio;
  $info_compra["flag_servicio"]= $flag_servicio;


?>
<main> 

  <?php if($flag_servicio ==  0): ?>  
    <?=n_row_12()?>
      <div style="margin-top: 10px;"></div>
      <div style="width: 80%;margin:0 auto;">
        <a href="../pregunta?tag=<?=$id_servicio?>" class="a_enid_blue" style="color: white!important;">
          ENVIAR PREGUNTA AL VENDEDOR
        </a>
      </div>
    <?=end_row()?>  
  <?php endif; ?>

<?=n_row_12()?>  
  <div style="width: 80%;margin:0 auto;">
    <section class="product-detail">                    
              <div class="left-col contenedor_izquierdo">                                      
                <div class="thumbs">
                    <div class="tab-pane fade '.$extra_class_contenido.' ">
                        <span class="img"  style="background-image: url('.$url_img.')">
                        </span>  
                    </div>
                    <?=$imagenes["preview"]?>                            
                </div>
                <div class="big"> 
                      <div class="tab-content">
                        <?=$imagenes["imagenes_contenido"]?>                    
                      </div>                                                  
                      <?=$this->load->view("social", $info_social)?>
                </div>
              </div>
              <div class="right-col" style="background: #fafbfc;padding: 10px;">                
                  
                  <?=get_text_nombre_servicio($nombre_servicio)?>                      
                  <?=crea_nombre_publicador($nombre_usuario , $id_publicador);?>                  
                  <div style="margin-top: 10px;">
                    <a href="../search/?q3=<?=$id_publicador?>" 
                      style='margin-top: 10px;'
                      class='valoracion_persona_principal'>
                      <div class="valoracion_persona"></div>                        
                    </a>
                  </div>
                  <?=valida_text_servicio($flag_servicio , $precio_unidad  , $flag_precio_definido)?>
                  <?=get_text_costo_envio($flag_servicio , $costo_envio)?>
                  
                  <div style="margin-top: 10px;">
                    <?=get_tipo_articulo($flag_nuevo , $flag_servicio)?>
                  </div>
                  <?=creta_tabla_colores($color , $flag_servicio)?>
                  <?=$this->load->view("form_compra" , $info_compra)?>            
                  <?=n_row_12()?>                  
                    <?=get_descripcion_servicio($descripcion , $flag_servicio)?>                
                    <?=valida_url_youtube($url_vide_youtube)?>                                    
                  <?=end_row()?>
              </div>            
    </section>
  </div>
<?=end_row()?>
<?=n_row_12()?>
  <div style="width: 80%;margin:0 auto;">
    <div class="place_tambien_podria_interezar"></div>
  </div>
<?=end_row()?>

<?=n_row_12()?>
  <div style="width: 80%;margin:0 auto;">
    <div class="place_valoraciones"></div>
  </div>
<?=end_row()?>
</main>
<script type="text/javascript" src="<?=base_url('application')?>/js/principal.js">        
</script>
<input type="hidden" name="servicio" class="servicio" value="<?=$id_servicio?>">
<input type="hidden" name="desde_valoracion" value="<?=$desde_valoracion?>" class='desde_valoracion'>
<link rel="stylesheet" type="text/css" href="<?=base_url('application')?>/css/main.css">
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css'>
<style type="text/css">
  .valoracion_persona_principal:hover{
    cursor: pointer;
  }
</style>