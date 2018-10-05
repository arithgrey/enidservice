<?php if($modalidad ==  1){?>   
    <?=heading_enid("TUS VENTAS" , 2 )?>
    <?=get_numero_articulos_en_venta_usuario($numero_articulos_en_venta)?>    
    <?php }else{?>      
        <?=heading_enid("TUS COMPRAS" , 2 )?>        
    <?php } ?>  
    <?php if($ordenes !=0 ){?>
        <?=div(evalua_texto_envios_compras($modalidad , count($ordenes) , $status) ,  
            [
                'class' => 'alert alert-info' ,
                'style' => 'margin-top: 10px;background: #001541;color: white'
            ])?>        
    <?php }?>

<?php    
    
    if($ordenes!=0){
	foreach($ordenes as $row){
	        
        $id_recibo            =   $row["id_proyecto_persona_forma_pago"];
		$resumen_pedido       =   $row["resumen_pedido"];		
        $id_servicio          =   $row["id_servicio"];
		$estado               =   $row["status"];		        
        $monto_a_pagar        =   $row["monto_a_pagar"];
        $costo_envio_cliente  =   $row["costo_envio_cliente"];
        $saldo_cubierto       =   $row["saldo_cubierto"];       
        $direccion_registrada =   $row["direccion_registrada"]; 
        $num_ciclos_contratados = $row["num_ciclos_contratados"];
        $estado_envio         =   $row["estado_envio"];        
        $url_servicio         =  "../producto/?producto=".$id_servicio;        
        $monto_a_liquidar     =     monto_pendiente_cliente(
                                    $monto_a_pagar , 
                                    $saldo_cubierto , 
                                    $costo_envio_cliente, 
                                    $num_ciclos_contratados
                                );

        $url_imagen_servicio    =   "../imgs/index.php/enid/imagen_servicio/".$id_servicio;        
        $url_imagen_error       =   '../img_tema/portafolio/producto.png';                
		$lista_info_attr        =   " info_proyecto= '".$resumen_pedido."'  info_status =  '".$estado."' ";

    ?>
    <?=n_row_12()?>
        <div class="contenedor_articulo">                
            <div class="col-lg-3">                
                <?=anchor_enid(
                        img([
                            "src"       =>  $url_imagen_servicio,
                            "onerror"   =>  "this.src='".$url_imagen_error."'",
                            "class"     =>  'imagen_articulo'
                            ]),  
                    ["href"  => $url_servicio]
                )?>                        
            </div>    
            <div class="col-lg-9">                      
                <div class="contenedor_articulo_text">                        
                    <div>                        
                        <?=icon("fa fa-shopping-bag")?>
                        <?=span($resumen_pedido , 
                            ["class"=>'texto_compra'])?>                
                    </div>
                    <div>                        
                        <?=get_text_direccion_envio(
                            $id_recibo , 
                            $modalidad , 
                            $direccion_registrada , 
                            $estado_envio)?>                        

                        <?=get_texto_saldo_pendiente($monto_a_liquidar,$monto_a_pagar,$modalidad)?>
                            
                        
                        <?=get_estados_ventas($status_enid_service , $estado , $modalidad)?>
                                                
                        <?=div(
                            carga_estado_compra(
                                $monto_a_liquidar,
                                $id_recibo,
                                $estado , 
                                $status_enid_service,
                                $modalidad
                            ),
                            ["class"=>"btn_estado_cuenta"]

                        )?>
                        
                      </div>
                    </div>  
            </div>          
        </div>
    <?=end_row()?>
<?php }}?>
<?=evalua_acciones_modalidad($en_proceso , $modalidad)?>
<?=evalua_acciones_modalidad_anteriores($anteriores , $modalidad)?>
<?=place("contenedor_ventas_compras_anteriores")?>
