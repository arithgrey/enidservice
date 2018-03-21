<?php		
    
	foreach($ventas as $row){
		
        $id_recibo     = $row["id_proyecto_persona_forma_pago"];
		$resumen_pedido      = $row["resumen_pedido"];		
        $id_servicio =  $row["id_servicio"];
		$estado        = $row["status"];		        
        $monto_a_pagar =  $row["monto_a_pagar"];
        $costo_envio_cliente =  $row["costo_envio_cliente"];
        $saldo_cubierto = $row["saldo_cubierto"];        
        $monto_a_liquidar = monto_pendiente_cliente($monto_a_pagar , 
                                                      $saldo_cubierto , 
                                                      $costo_envio_cliente);

        $url_imagen_servicio ="../imgs/index.php/enid/imagen_servicio/".$id_servicio;
        $url_imagen_error =  '../img_tema/portafolio/producto.png';                
		$lista_info_attr= " info_proyecto= '$resumen_pedido'  info_status =  '$estado' ";
        $btn_direccion_envio = "<i 
                                    class='btn_direccion_envio fa fa-bus ' 
                                    id='".$id_recibo."'  
                                $lista_info_attr >
                                </i>";                           		


        ?>
        
        <?=n_row_12()?>
        <div>
                    <div class="col-lg-3">
                        <img 
                        src="<?=$url_imagen_servicio?>" 
                        style="width: 100%"
                        onerror="this.src='<?=$url_imagen_error?>' ">
                    </div>    
                    <div class="col-lg-9">                      
                      
                        <p>
                            <?=get_estados_ventas($status_enid_service , $estado);?>
                        </p>
                       
                      <div>                        
                        <i class="fa fa-shopping-bag">            
                        </i>            
                        <?=$resumen_pedido?>            
                      </div>
                      <div>
                        <h5>
                            <span>
                                <?=$btn_direccion_envio?>
                            </span>
                            Dirección de envío
                        </h5>
                        
                        <p>
                            <span>
                                Saldo pendiente     
                                <strong>
                                    <?=$monto_a_liquidar?> MXN
                                </strong>
                            </span>
                        </p>        
                        <p>
                           <?=carga_estado_compra($monto_a_liquidar,$id_recibo,$estado, 1)?>
                        </p>
                      </div>
                    </div>            
        </div>
        <?=end_row()?>
        <hr>
        <?php 
	}
?>
