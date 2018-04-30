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
  $precio = 0;
  $id_usuario_servicio = 0; 
  /**/
  $entregas_en_casa =  0;
  $telefono_visible =  0;

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
    $precio =  $row["precio"];
    $id_ciclo_facturacion =  $row["id_ciclo_facturacion"];
    $entregas_en_casa =  $row["entregas_en_casa"];
    $id_usuario_servicio =  $row["id_usuario"];
    $telefono_visible =  $row["telefono_visible"];
  }

  $imagenes =  
  construye_seccion_imagen_lateral($imgs  ,$nombre_servicio , $url_vide_youtube);
  $info_compra["id_servicio"]= $id_servicio;
  $info_compra["flag_servicio"]= $flag_servicio;
  $info_compra["precio"]= $precio;
  $info_compra["id_ciclo_facturacion"]= $id_ciclo_facturacion;




?>
<main> 

  <?php if($flag_servicio ==  0): ?>    
    <?php if($precio > 0):?>   
      <?=$this->load->view("btn_pregunta");?>      
    <?php endif; ?>

  <?php else: ?>
    <?php if($precio > 0 && $id_ciclo_facturacion !=9):?>   
      <?=$this->load->view("btn_pregunta");?>      
    <?php endif; ?>      
  <?php endif; ?>

<?=n_row_12()?>  
  <div style="width: 80%;margin:0 auto;">
    <section class="product-detail">                    
              <div class="left-col contenedor_izquierdo">                                      
                <div class="thumbs">                    
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
                  
                  <?=valida_editar_servicio($id_usuario_servicio , 
                    $id_usuario , 
                    $in_session,  
                    $id_servicio)?>
                  <?=get_text_nombre_servicio($nombre_servicio)?>                      
                  <?=crea_nombre_publicador($usuario , $id_publicador);?>                  
                  <div style="margin-top: 10px;">
                    <a href="../search/?q3=<?=$id_publicador?>" 
                      style='margin-top: 10px;'
                      class='valoracion_persona_principal'>
                      <div class="valoracion_persona"></div>                        
                    </a>
                  </div>
                  <?=valida_text_servicio($flag_servicio , $precio , $id_ciclo_facturacion )?>
                  <?=get_text_costo_envio($flag_servicio , $costo_envio)?>
                  <div style="margin-top: 10px;">
                    <?=get_tipo_articulo($flag_nuevo , $flag_servicio)?>
                  </div>
                  <div>
                    <strong>
                      <?=get_entrega_en_casa($entregas_en_casa , $flag_servicio)?>
                    </strong>
                  </div>
                  <div>
                    <strong>
                      <?=get_contacto_cliente(
                        $telefono_visible ,                         
                        $in_session,
                        $usuario)?>
                    </strong>
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