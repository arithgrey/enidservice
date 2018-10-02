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
    
    $id_servicio     =  $row["id_servicio"]; 
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

  $imagenes =  construye_seccion_imagen_lateral($imgs  ,$nombre_servicio , $url_vide_youtube);
  $info_compra["id_servicio"]= $id_servicio;
  $info_compra["flag_servicio"]= $flag_servicio;
  $info_compra["precio"]= $precio;
  $info_compra["id_ciclo_facturacion"]= $id_ciclo_facturacion;


  $url_tienda             =  '../search/?q3='.$id_publicador;
  $vendedor_valoracion    =  anchor_enid( "",[ 'class' =>  'valoracion_persona_principal valoracion_persona'] );  

  $nombre_servicio        =  substr(strtoupper($nombre_servicio), 0 , 70);
  $nombre_producto        =  heading_enid(
                              $nombre_servicio ,
                              1 , 
                              array('class' =>  "strong" )
                            );

  $nuevo_nombre_servicio  = 
                            valida_text_servicio(
                              $flag_servicio, 
                              $precio , 
                              $id_ciclo_facturacion ); 

  $boton_editar           = valida_editar_servicio(
                              $id_usuario_servicio , 
                              $id_usuario , 
                              $in_session,  
                              $id_servicio);

  $texto_en_existencia    = get_text_diponibilidad_articulo($existencia , $flag_servicio);
  
  $config                 =  
  array('class' =>  'valoracion_persona_principal valoracion_persona' );
  
  $estrellas  = 
  anchor_enid(div("", $config), ['class' => 'lee_valoraciones' , 'href'=> $url_tienda]);


?>

<?=n_row_12()?>    
    <div class="product-detail contenedor_info_producto">                    
              <div class="col-lg-8">
                <div class="col-lg-8">                   
                  <div class="row">
                    <?=n_row_12()?>                  
                      <div class="left-col contenedor_izquierdo">
                        <?=div($imagenes["preview"] , ["class"=>"thumbs"])?>
                        <?=div(div($imagenes["imagenes_contenido"] , 
                        ["class" =>"tab-content"]) , 
                        ["class" =>  "big"]) ?>
                      </div> 
                    <?=end_row()?>
                  </div>
                </div> 
                <div class="col-lg-4">                  
                  <div class="row">  
                    <div class="contenedor_central_info">
                      <?=p("INFORMACIÓN" , ["class"=>"informacion_text"] , 1)?>         
                      
                      <?=anchor_enid(
                        div("SOLICITAR INFORMACIÓN" ,['class' => 'black_enid_background white padding_1'] ,1) , 
                        ["href"  =>  "../pregunta?tag=".$id_servicio]  
                        
                        )?>               
                      <?=creta_tabla_colores($color , $flag_servicio)?>
                      <div class='separador'></div>
                      <?=div(valida_informacion_precio_mayoreo($flag_servicio ,  
                        $venta_mayoreo) , [] , 1)?>               
                      
                      <?=n_row_12()?>
                        <?=get_tipo_articulo($flag_nuevo , $flag_servicio)?>
                      <?=end_row()?>
                      <div class="separador"></div>
                      <?=div(crea_nombre_publicador_info($usuario , $id_publicador) , [] , 1)?>

                      <div class="separador"></div>
                      <?=n_row_12()?>
                        <?=div(get_entrega_en_casa($entregas_en_casa , $flag_servicio) ,[ 'class' => 'strong'])?>
                        <?=div(get_contacto_cliente($telefono_visible, $in_session, $usuario))?>
                      <?=end_row()?>

                      <div class="separador"></div>
                      <?=n_row_12()?>
                        <?php if($in_session ==  0):?>
                        
                          <?=anchor_enid("AGREGAR A TU LISTA DE DESEOS" .icon('fa fa-gift') ,
                          
                          [
                            'class' => 'a_enid_black agregar_a_lista' , 
                            'href' => "../login/"] , 
                            1
                          )?>
                        <?php else:?>
                          <?=div(div("AGREGAR A TU LISTA DE DESEOS".icon('fa fa-gift') , ["class" =>  "a_enid_blue agregar_a_lista_deseos"] ) , 
                          ["id"=>'agregar_a_lista_deseos_add'])?>
                        <?php endif;?>
                      <?=end_row()?>

                      
                      <?=n_row_12()?>                        
                          <?=$tiempo_entrega?>                        
                      <?=end_row()?>

                      
                      <?=n_row_12()?>
                        <?=$this->load->view("social", $info_social)?>

                      <?=end_row()?>
                      
                      <?=anchor_enid( 
                         "Ir a la tienda del vendedor",
                          ['style' => 'color:blue;' , 
                          'href'=> "../search/?q3=".$id_publicador ]
                          ,
                          1
                        )?>

                      <div style="border: solid 1px"></div>
                    </div>
                  </div>  
                </div> 
              </div>                          
              


              <div class="col-lg-4">   
                <?php if($flag_servicio == 0): ?>
                  <?php if($existencia > 0): ?>                    
                    <?=n_row_12()?>    

                      <div class="info-venta">

                        <?=$boton_editar?>

                        <?=$estrellas?>

                        <?=$nombre_producto?>                                      

                        <?=heading_enid($nuevo_nombre_servicio, 3 , [])?>

                        <?=get_text_costo_envio($flag_servicio , $costo_envio)?>

                        <?=$this->load->view("form_compra" , $info_compra)?>

                        <?=$tallas?>
                        <?=$texto_en_existencia?>                      

                      </div>
                    <?=end_row()?>    
                    
                  <?php else: ?>  
                    <div class="card box-shadow">
                      <?=div($nombre_producto , ["class"=>"card-header"])?>
                      <div class="card-body">
                        <h1 class="card-title pricing-card-title">
                          <?=$precio?>MXN        
                          <?=get_text_diponibilidad_articulo($existencia , $flag_servicio)?>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4">
                          <li>
                            Artículo temporalmente agotado
                          </li>                         
                          <li>
                            <?=anchor_enid("Preguntar al vendedor cuando estará disponible", 
                              [
                              "href"  =>  "../pregunta/?tag=<?=$id_servicio?>&disponible=1" 
                              
                            ])?>
                          </li>
                        </ul>
                      </div>
                    </div>
                  <?php endif; ?>
                
                <?php else: ?>  

                  <div class="card box-shadow">
                      <div class="card-header">
                        <?=heading_enid(substr(strtoupper($nombre_servicio), 0 , 70) , 1 )?>
                      </div>
                      <div class="card-body">
                        <?=heading_enid(
                          valida_text_servicio(
                            $flag_servicio, 
                            $precio , 
                            $id_ciclo_facturacion ) ,
                          3 , 
                          ["class" => 'card-title pricing-card-title' ]
                          )?>
                        
                        <ul class="list-unstyled mt-3 mb-4">                          
                          <li>
                            <a 
                              href="../pregunta/?tag=<?=$id_servicio?>&disponible=1" 
                              style="color: black;">
                              Pedir más información al vendedor
                            </a>
                          </li>
                          <li>
                            <?=$this->load->view("form_compra" , $info_compra)?>
                          </li>                            
                        </ul>
                        
                      </div>
                    </div>
                <?php endif; ?>  
              </div>

          
              <div class="col-lg-12">
                <div class="contenedor_sobre_el_producto">
                    <?=get_descripcion_servicio($descripcion , $flag_servicio)?>
                    <?=valida_url_youtube($url_vide_youtube)?>
                </div>        
              </div>         

          <div class="separador"></div>
          <?=div('' , ['class'  => 'place_valoraciones'] , 1)?>
          <?=div('' , ['class'  => 'place_tambien_podria_interezar'] , 1)?>
          
    </div>
    
<?=end_row()?>

<?=input(["type"=>"hidden", "class"=>"qservicio", "value"=> $nombre_servicio])?>
<?=input(["type"=>"hidden", "name"=>"servicio" ,
"class"=>"servicio", "value"=>$id_servicio])?>
<?=input(["type"=>"hidden" , "name"=>"desde_valoracion" , "value"=>$desde_valoracion , "class"=>'desde_valoracion'])?>


