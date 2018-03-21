<?php		
    
    $extra_general  ="style='font-size:.8em;' ";
    $l =  "";
    $parte_extra = "class='blue_enid_background white' style='font-size:.8em;' ";
    $id_perfil =  $perfil_usuario_actual[0]["idperfil"];                      

    $extra_estilos_tabla ="class='blue_enid_background white' style='font-size:.8em;'  ";
    $extra_estilos_tabla_white =" style='font-size:.8em;'  ";

    $monto_a_pagar = 0;
   
	foreach($proyectos as $row){

		$id_proyecto     = $row["id_proyecto"];
		$proyecto        = $row["proyecto"];
		$descripcion     = $row["descripcion"];
		$fecha_registro  = $row["fecha_registro"];		
		$url             = $row["url"];		
		$estado          = $row["estado"];		
        $precio          = $row["precio"];    
        $ciclo_facturacion = $row["ciclo_facturacion"];    
        $num_ciclos_contratados = $row["num_ciclos_contratados"];    

        $monto_a_pagar =  $row["monto_a_pagar"];

        $siguiente_vencimiento = $row["siguiente_vencimiento"];    
        $IVA = $row["IVA"];
        $total = $row["total"];
        $dias_restantes = $row["dias_restantes"];
        
        $id_proyecto_persona =  $row["id_proyecto_persona"];
        $id_proyecto_persona_forma_pago =  $row["id_proyecto_persona_forma_pago"];

        $servicio =  $row["servicio"];
        $fecha_vencimiento_anticipo =  $row["fecha_vencimiento_anticipo"];
        /**/
        $dias_restantes_liquidar =  $row["dias_restantes_liquidar"];
        $saldo_cubierto =  $row["saldo_cubierto"];
        $monto_por_liquidar =  $row["monto_por_liquidar"];

        $extra_renovacion ='href="#tab_renovar_servicio" 
                            data-toggle="tab"'; 

		$lista_info_attr= " info_proyecto= '$proyecto'   
							info_descripcion = '$descripcion'  							
							info_url = '$url' 							
							info_status =  '$estado' ";


	    $btn_conf_proyecto  = "<i class='black solicitar_desarrollo  fa fa-check-square-o'
                                        id='".$id_proyecto."' 
                                        $lista_info_attr >
                               </i>";							
			


        $extra_adeudo ="style='font-size.8em;' ";

        if ($monto_por_liquidar > 0 ) {
            $extra_adeudo ="style='background:red!important;font-size:.8em!important;color:white!important;' ";                            
        }

            $nuevo_monto =  $monto_por_liquidar ." MXN ";
            $nueva_fecha_anticipo = $fecha_vencimiento_anticipo;
            $nuevos_dias_restantes = $dias_restantes_liquidar;

            if ($monto_por_liquidar <= 0) {
                $nuevo_monto =  "-";
                $nueva_fecha_anticipo = "-";
                $nuevos_dias_restantes = "-";
            }




			$l.= "<tr>";
                $estado_de_compra =  get_nombre_estados_proyecto(
                                        $estado ,  
                                        $dias_restantes , 
                                        $ciclo_facturacion); 

                $l.= get_td($estado_de_compra, $extra_estilos_tabla);


                if ($id_perfil ==  20 ){
                        
                        if($monto_a_pagar == 0 ){
                                                    
                            $l.= get_td("VER DETALLES DE COMPRA
                                        <br>
                                        <i class='fa fa-credit-card-alt resumen_pagos_pendientes ' 
                                            id='".$id_proyecto_persona_forma_pago."'  
                                            $extra_renovacion>
                                        </i>" , 
                                        "style='font-size:.8em;background:#050662!important;color:white!important'  ");
                        }else{

                            
                            $l.= get_td("<span 
                                            class='blue_enid strong white'               
                                            style='font-size:.8em;'>                            
                                            LIQUIDAR AHORA!
                                        <br>
                                        <i class='fa fa-credit-card-alt resumen_pagos_pendientes ' 
                                            id='".$id_proyecto_persona_forma_pago."'  
                                            $extra_renovacion>
                                        </i>
                            </span>" , 
                            "style='font-size:.8em;background:#050662!important;'  ");
                        }
                        
                }else{

                    $l.= get_td("<a 
                                    $extra_renovacion
                                    class='blue_enid persona_proyecto'     
                                    id='".$id_proyecto_persona."'>        
                                        VER - DETALLES DE COMPRA                    
                                    <i class='fa fa-file-pdf-o'>
                                    </i>
                                </a>" , "style='font-size:.8em;'  ");
        
                }    



            $l.= get_td($btn_conf_proyecto, $extra_general);
            /**/
            $nuevo_saldo_cubierto ="". $saldo_cubierto ." MXN";
            $nuevo_total ="". $total ."MXN";

            $l.= get_td($proyecto, $extra_estilos_tabla_white);                       
            $l.= get_td($nuevo_saldo_cubierto , $extra_estilos_tabla_white);
            $l.= get_td($nuevo_monto, $extra_adeudo);      
            $l.= get_td($nueva_fecha_anticipo , $extra_adeudo);          
            $l.= get_td($nuevos_dias_restantes, $extra_adeudo);                      
            $l.= get_td(get_nombre_ciclo_facturacion($ciclo_facturacion), 
                "style='font-size:.8em;' ");

            $l.= get_td($num_ciclos_contratados , $extra_general );              
            $l.= get_td($siguiente_vencimiento, $extra_general );                      
            $l.= get_td($nuevo_total , $extra_general );                                
            $l.= get_td($dias_restantes, $extra_general );                              
            $l.= get_td($servicio, $extra_general );                      

	    $l.= "</tr>";

	}
?>

<br>

<?=n_row_12()?>    
    <?=get_bnt_retorno($id_perfil);?>
    <?=valida_btn_agregar_servicio($info_recibida);?>    
    <div class="contenedor_listado_info">
                <?=$this->load->view("../../../view_tema/header_table");?>    
                    <tr>
                        <?=get_td("Estado",$parte_extra);?>
                        <?=get_td("DETALLES DE COMPRA" , 
                                    "style='background:#050662!important;
                                    color:white!important;
                                    font-size:.8em;
                                    color:white!;'");?>            

                        <?=get_td("Tickets/soporte -" , $parte_extra);?>
                        <?=get_td("Producto/servicio" , $parte_extra);?>                       
                        <?=get_td("Monto cubierto", $parte_extra);?>
                        <?=get_td("Saldo a liquidar", $parte_extra);?>
                        <?=get_td("Límite para liquidar" , $parte_extra);?>
                        <?=get_td("Días para liquidar" , $parte_extra);?>        
                        <?=get_td("Ciclo de facturación" , $parte_extra);?>
                        <?=get_td("Ciclo contratados", $parte_extra);?>
                        <?=get_td("Próximo fecha de renovación" ,$parte_extra);?>
                        <?=get_td("Total del servicio" , $parte_extra); ?>
                        <?=get_td("Días restantes" , $parte_extra);?>
                        <?=get_td("Servicio" , $parte_extra);?>
                    </tr>
                    <?=$l;?>
                    <?=$this->load->view("../../../view_tema/footer_table")?>               
    </div>              
<?=end_row()?>    