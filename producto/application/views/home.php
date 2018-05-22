<?php

  $info_social["url_facebook"] =  get_url_facebook($url_actual);   
  $info_social["url_twitter"] =  get_url_twitter($url_actual , $desc_web);
  $info_social["url_pinterest"] = get_url_pinterest($url_actual, $desc_web);
  $info_social["url_tumblr"] = get_url_tumblr($url_actual, $desc_web);

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
  $venta_mayoreo =  0;
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
    $venta_mayoreo =  $row["venta_mayoreo"];
  }

  $imagenes =  
  construye_seccion_imagen_lateral($imgs  ,$nombre_servicio , $url_vide_youtube);
  $info_compra["id_servicio"]= $id_servicio;
  $info_compra["flag_servicio"]= $flag_servicio;
  $info_compra["precio"]= $precio;
  $info_compra["id_ciclo_facturacion"]= $id_ciclo_facturacion;



?>
<main> 


<?=n_row_12()?>    
    <div class="product-detail contenedor_info_producto">                    
              <div class="col-lg-8">
                <div class="col-lg-8">                   
                  <div class="row">
                    <?=n_row_12()?>                  
                      <div class="left-col contenedor_izquierdo">
                        <div class="thumbs">                    
                            <?=$imagenes["preview"]?>                            
                        </div>
                        <div class="big"> 
                              <div class="tab-content">
                                <?=$imagenes["imagenes_contenido"]?>                    
                              </div>                                                  
                        </div>                
                      </div> 
                    <?=end_row()?>
                  </div>
                </div> 
                <div class="col-lg-4">                  
                  <div class="row">  
                    <div class="contenedor_central_info">
                      <?=n_row_12()?>                  
                        <p class="informacion_text">                        
                          INFORMACIÓN
                        </p>
                      <?=end_row()?>
                      <br>
                      <?=n_row_12()?>                  
                            <?=$this->load->view("btn_pregunta");?>      
                      <?=end_row()?>
                      <?=n_row_12()?>                  
                        <?=creta_tabla_colores($color , $flag_servicio)?>
                      <?=end_row()?>
                      
                      <div class='separador'></div>
                      <?=n_row_12()?>                  
                        <?=valida_informacion_precio_mayoreo($flag_servicio ,  $venta_mayoreo)?>
                      <?=end_row()?>
                      <?=n_row_12()?>
                        <?=get_tipo_articulo($flag_nuevo , $flag_servicio)?>
                      <?=end_row()?>
                      <div class="separador"></div>
                      <?=n_row_12()?>
                        <p class="">
                          VENDEDOR
                        </p>
                        <?=crea_nombre_publicador_info($usuario , $id_publicador);?>
                        <div>
                          <a href="../search/?q3=<?=$id_publicador?>" 
                            style='margin-top: 10px;'
                            class='valoracion_persona_principal'>
                            <div class="valoracion_persona"></div>                        
                          </a>
                        </div>
                      <?=end_row()?>
                      <div class="separador"></div>
                      <?=n_row_12()?>
                        <div>
                          <strong>
                            <?=get_entrega_en_casa($entregas_en_casa , $flag_servicio)?>
                          </strong>
                        </div>
                        <div>
                            <?=get_contacto_cliente(
                            $telefono_visible ,                         
                            $in_session,
                            $usuario)?>                    
                        </div>
                      <?=end_row()?>
                      <div class="separador">                      
                      </div>

                      <?=n_row_12()?>
                        <?=$this->load->view("lista_deseos")?>
                      <?=end_row()?>

                      <?=n_row_12()?>
                        <?=$this->load->view("social", $info_social)?>
                      <?=end_row()?>
                      <div style="border: solid 1px">
                      </div>
                    </div>
                  </div>  
                </div> 
              </div>                          
              <div class="col-lg-4">   
                <div class="contenedor_venta">
                  <?=n_row_12()?>    
                  <?=valida_editar_servicio(
                    $id_usuario_servicio , 
                    $id_usuario , 
                    $in_session,  
                    $id_servicio)?>
                      
                  <h1 class="nombre_producto_servicio">
                      <?=substr(strtoupper($nombre_servicio), 0 , 70);?>
                  </h1>
                  <div class="contenedor_derecho" >                
                    <div class="contenedor_informacion_producto">                    
                      <div>
                        <h2 class="white texto_precio">
                          <?=valida_text_servicio(
                            $flag_servicio, 
                            $precio , 
                            $id_ciclo_facturacion )?>
                        </h2>
                      </div>                                        
                      <?=get_text_costo_envio($flag_servicio , $costo_envio)?>
                      <?=$this->load->view("form_compra" , $info_compra)?>            

                      
    
                    </div>  
                  </div>
                  <?php if($flag_servicio == 0): ?>
                          <?php if($existencia > 0): ?>
                              <div class="text_en_existencia">                              
                                <?=get_text_diponibilidad_articulo($existencia , $flag_servicio)?>
                              </div>                                                              
                          <?php endif; ?>
                  <?php endif; ?>            
                  <?=end_row()?>    
              </div>
          </div>
          <div class="separador"></div>
          <div class="col-lg-12">
            <div class="contenedor_sobre_el_producto">
                <?=get_descripcion_servicio($descripcion , $flag_servicio)?>
                <?=valida_url_youtube($url_vide_youtube)?>
            </div>        
          </div>         

          <div class="separador"></div>
          <div class="col-lg-12">
            <div class="place_valoraciones"></div>  
          </div>
          <div class="separador"></div>
          <div class="col-lg-12">
            <div class="place_tambien_podria_interezar"></div>  
          </div>
          
          
    </div>
    
<?=end_row()?>



</main>
<script type="text/javascript" src="<?=base_url('application')?>/js/principal.js<?=version_enid?>">        
</script>
<input 
type="hidden" 
name="servicio" 
class="servicio" 
value="<?=$id_servicio?>">
<input 
type="hidden" 
name="desde_valoracion" 
value="<?=$desde_valoracion?>" 
class='desde_valoracion'>
<link rel="stylesheet" type="text/css" href="<?=base_url('application')?>/css/main.css<?=version_enid?>">
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css<?=version_enid?>'>

<style type="text/css">
  .contenedor_info_producto{
    width: 95%!important;
    margin: 0 auto;
  }
  .contenedor_izquierdo{
    width: 100%!important;
  }
  .contenedor_derecho{
    width: 100%!important; 
    background: black;
    padding: 20px;
    height: 430px;    
  }
  .contenedor_derecho_nombre{
    width: 95%!important;     
  }

  .informacion_text{
    font-size: 1.7em;    
    color: #0a1339;
  }
  .nombre_producto_servicio{
    font-size: 2.5em;
    margin-top: 0!important;    
    margin-bottom:  0!important;    
    padding: 0!important;
    background: black;
    color: white;
    
  }  
  .por_vendedor{
    color: white!important;    
    background: black;
    font-weight: bold;
    padding: 2px;
  }
  .publicado_por{        
    color: white!important;    
  }
  .publicado_por:hover{     
    color: white!important;
  }   
  .texto_precio{
    font-weight: bold; 
  }  
  .pregunta_vendedor_servicio{

  }
  .a_pregunta_vendedor{
    background: #f5f5f5;
    color: #010a17 !important;
    padding: 8px;
    text-decoration: none !important;
    border: solid 1.5px;
    font-weight: bold;
  }
  .a_pregunta_vendedor:hover{
    color: white!important;
  }
  .titulo_sobre_el_producto{
    margin-top: 65px!important;    
    font-size: 2em;
  }
  #AddToCart{
    background: #fff !important;
    color: #00060c !important;
  }
  .text_colores_disponibles{
    color: white;    
  }
  .informacion_colores_disponibles{    
    font-size: 1.2em;
  }
  .contenedor_informacion_colores{
    margin-top: 20px;  
  }
  .contenedor_descripcion_servicio{
    background: white;
  }
  
  .editar_button{    
    text-align: right;
    z-index: 2878787;

  }
  .separador{
    margin-top: 20px;
  }
  .informacion_vendedor_descripcion a{
    color: black;
    font-weight: bold;
  }
  .text_en_existencia{
    color: #001330;
    font-size: 1.1em;
    position: absolute;
    bottom: 0;
    width: 93% !important;
    background: #eceefe;
    padding: 5px;
    font-weight: bold;
  }
  .numero_piezas{
    font-weight: bold;
    font-size: 1.2em;
    color: white!important;
  }
  .contenedor_central_info{    
    margin: 0 auto;
    width: 90%!important;
  }
  .table_orden_1{
    width: 50%;
  }
  .table_orden_2{
    width: 40%;
  }
  .table_orden_3{
    width: 10%;
  }
  .agregar_a_lista_deseos{    
    margin-bottom: 30px;
  }
  .agregar_a_lista_deseos:hover{
    cursor: pointer;
  }
  .btn_add_list{
    background: #16308a !important;
    padding: 10px !important;
    color: white !important;
    font-weight: bold !important;
  }
  @media only screen and (max-width: 768px) {
    .contenedor_info_producto{
      width: 100%!important;
      margin: 0 auto;
    }
    .contenedor_central_info{    
      margin: 0 auto;
      width: 100%!important;
    }
    .contenedor_venta{
      margin-top: 25px;
    }
    .table_orden_1{
      width: 50%;      
    }
    .table_orden_2{
      width: 0%;
    }
    .table_orden_3{
      width: 50%;
      text-align: right;
    }
    .contenedor_comentarios{
      margin-top: 50px;
    }
  }
</style>