<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){	
	
	function create_colores_disponibles($text_colores){

		/**/
		$arreglo_colores =  explode("," , $text_colores);		
		
		$a =0;
		$lista_completa ="<div id='contenedor_colores_disponibles'>";
		
		for ($a=0; $a <count($arreglo_colores); $a++) { 
			
			$codigo_color =$arreglo_colores[$a];
			$estilos ="background:".$codigo_color.";color:white;padding:3px;";
			$lista_completa .= "<div style='".$estilos."'>
				<i class='fa fa-times elimina_color' id='".$codigo_color."'>
				</i>  ".$codigo_color."</div>";			
		}	
		$lista_completa .="</div>";
		return $lista_completa;
	}
	/**/
	function valida_text_numero_articulos($num){	

		$text =  	"<span class='mjs_articulo_no_disponible'>
						Alerta
					</span> 
					este artúculo no se encuentra disponible, agregar nuevo";
		if($num > 0){
			$text =  $num ." Artículo disponible";			
			if ($num>1) {
				$text =  $num ." Artículos disponibles";				
			}
			
		}
		return $text;
	}
	/**/
	function agrega_data_servicio($data , $key , $valor ){
		
		$data[$key] =  $valor;
		return $data;
	}
	/**/
	function evalua_utilidad_mas_envio($flag_envio_gratis, $costo_envio, $utilidad){

		if($flag_envio_gratis == 1 ){
			return $utilidad - $costo_envio;		
		}else{
			return $utilidad;
		}		
	}	
	/**/
	function get_valor_envio($costo_envio ,  $flag_envio_gratis){


		if($flag_envio_gratis ==  1 ){			
			return   -100;			
		}else{			
			return 100;
		}
	}
	/**/
	function select_producto_usado($valor_actual){

		$usado = [ "No" , "Si"];
		echo "<select class='form-control producto_nuevo'>";
			for ($z=0; $z < count($usado); $z++){ 					
				if ($z == $valor_actual ) {
					echo "<option value='".$z."' selected>".$usado[$z]."</option>";
				}else{
					echo "<option value='".$z."'>".$usado[$z]."</option>";
				}
			}
		echo "</select>";
                        
	}	
	/**/
	function get_producto_usado($tipo){
		$usado = [ "No" , "Si"];
		return $usado[$tipo];
	}		
	/**/
	function create_url_procesar_compra($producto_text, 
                                    $id_servicio ,  
                                    $total ,
                                    $ciclo_facturacion , 
                                    $num_ciclos, 
                                    $dominio ="" , 
                                    $extension_dominio = ""){

  
	  $url_procesar_compra =
	  "../procesar/?producto=".$producto_text."&plan=".$id_servicio."&ciclo_facturacion=".
	    $ciclo_facturacion."&num_ciclos=".$num_ciclos."&total=".$total."&dominio=".$dominio."&extension_dominio=".$extension_dominio;
	  return $url_procesar_compra;
	  
	}
	function create_table_servicios_grupo($servicios){
		
		$list ="";
		$z =1;
		$extra ="style='font-size:.8em;' ";
		foreach ($servicios as $row) {
			
			$id_servicio =  $row["id_servicio"];
			$nombre_servicio =  $row["nombre_servicio"];
			
			$input ="<input type='checkbox' class='grupo_servicio' id='".$id_servicio."'>";			

			$id_grupo =  $row["id_grupo"];
			if ($id_grupo > 0 ) {
				
				$input ="<input type='checkbox' class='grupo_servicio' id='".$id_servicio."' checked>";							
			}

			$list .=  "<tr>";			
				$list .=  get_td($input);				
				$list .=  get_td($nombre_servicio,$extra);				
			$list .=  "</tr>";

			$z ++;
		}
		return  $list;

	}
	
	/**/
	function create_table_servicios($servicios){
		
		$list ="";
		$z =1;
		$extra ="style='font-size:.8em;' ";
		foreach ($servicios as $row) {
			
			$id_servicio =  $row["id_servicio"];
			$nombre_servicio =  $row["nombre_servicio"];
			$status =  $row["status"];
			$text_estatus ="Activo";
			$especificacion ="<span class='servicio fa fa-file-text-o' id='".$id_servicio."'> </span> ";

			if($status == 0){
				$text_estatus ="Inactivo";
			}
			$list .=  "<tr>";
				
				
				$list .=  
				get_td($especificacion , 
					"class='white text-center especificacion_servicio' style='background:#084465;' ");

				$list .=  get_td($nombre_servicio,$extra);
				$list .=  get_td($text_estatus ,"style='font-size:.8em;' class='text-center strong' ");

			$list .=  "</tr>";
			$z ++;
		}
		return  $list;

	}
	/**/
	function create_lista_terminos_servicio($terminos_servicio){

		$list ="<ul>";
		$z =1;
		foreach($terminos_servicio as $row){			
			$id_caracteristica=  $row["id_caracteristica"];
			$caracteristica=  $row["caracteristica"];

			$list .="<li>
						<span 
							class='blue_enid_background white termino' 
							id='".$id_caracteristica."' 
							style='padding:5px;'>
							Quitar
						</span>
							".$z.".-" .
							 $caracteristica."
						</li>";			
			$list .="<li><strong>____</strong></li>";						
			$z ++;

		}
		$list .="</ul>";
		$data_complete["html"] = $list; 
		$data_complete["num_terminos"] = $z;
		return $data_complete;
	}

	function create_lista_terminos_servicio_next($terminos_servicio){

		$list ="<ul>";
		$z =1;
		foreach($terminos_servicio as $row){
			
			$id_caracteristica=  $row["id_caracteristica"];
			$caracteristica=  $row["caracteristica"];

			$list .="<li style='font-size:.8em;'>
								<span 
									class='blue_enid_background white termino' 
									id='".$id_caracteristica."' 
									style='padding:5px;'>
									Quitar
								</span>
								".$z.".-" .
							 	$caracteristica."
							</li>";			
			$list .="<li><strong>____</strong></li>";			
			$z ++;
		}
		$list .="</ul>";

		$data_complete["html"] = $list; 
		$data_complete["num_terminos"] = $z;
		return $data_complete;
	}
	/**/
	function scroll_terminos($num_terminos){

		/**/
		if($num_terminos > 3){
			
			return "scroll_terms";

		}
		return "";
		/**/
	}
	/**/
	function get_lista_terminos($terminos_servicio){

		
		$list ="<br>			
			<table style='width:100%;' >"; 		
			
			$list .= "<tr style='background: #0022B7;color: white;'>"; 		
				$list .=get_td("#"); 		
				$list .=get_td("Termino"); 	
				$list .=get_td("Agregar/quitar"); 	
			$list .= "</tr>"; 			
			$z =1;
		
			foreach($terminos_servicio as $row) {			
				
				$caracteristica = $row["caracteristica"];			
				$id_servicio =  $row["id_servicio"];
				$id_caracteristica =  $row["id_caracteristica"];

				$input ="<input type='checkbox' class='termino' id='".$id_caracteristica."' >";
				if($id_servicio >  0){
					$input ="<input type='checkbox' class='termino' id='".$id_caracteristica."'  checked>";	
				}
				/**/				
				$list .=  "<tr>";
					$list .=  get_td($z);					
					$list .=  "<td style='font-size:.8em;'>" .$caracteristica ."</td>";
					$list .=  get_td($input);
				$list .=  "</tr>";
				$z ++; 

			}
		$list .="<table>"; 		
		return $list;
	}
	/**/
	function get_titulos_precios($servicios , $in_session){

	  $id_servicio =  "";
	  $nombre_servicio =  "";
	  $descripcion =  "";             
	  $precio =  "";
	  $id_ciclo_facturacion = "";
	  $ciclo =  "";   
	  $num_meses =  "";
	  $table_info ="";

	  $tmp_servicios =[];
	  $z =0;
	  foreach($servicios as $row){
	    
	    $id_servicio =  $row["id_servicio"];
	    $tmp_servicios[$z] =  $id_servicio;
	    	    
	    $nombre_servicio =  $row["nombre_servicio"];
	    $descripcion =  $row["descripcion"];              
	    $precio =  $row["precio"];
	    $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
	    $ciclo =  $row["ciclo"];    

	    $num_meses =  $row["num_meses"];    
	    $iva =  $precio *  (.16);
	    $precio_iva =  $precio + $iva;

		    $url_orden_compra = create_url_procesar_compra(
		      $nombre_servicio , 
		      $id_servicio ,
		      $precio_iva , 
		      $id_ciclo_facturacion, 
		      1     
		    );

	   
	   	$text_dias = get_text_ciclo_facturacion($id_ciclo_facturacion);
	    
	    $text = "<div 
	            	style='background:black;font-size:.8em;padding:5px;'
	             	class='white'>
	             	<i
	             	href='#tab_servicios' 
	                data-toggle='tab'                         
	             	class='fa fa-pencil servicio' id='".$id_servicio."'>
	             	</i>


	            ".$nombre_servicio."
	          </div>";
	      $text .= "<div class='text-center strong'>
	            ".$precio_iva."MXN
	            </div>";

	      $text .= "<div class='text-center strong' style='font-size:.9em;'>
	            ".$text_dias."
	            </div>";

	          
	      $text .= "<div class='text-center strong'>
	            <a 
	              href='$url_orden_compra'
	              style='font-size:.9em;padding:5px;color:white!important;'   class='blue_enid_background'>
	                Ordenar compra!
	            </a>
	            </div>";
	        
	      $table_info .= get_td( $text);
	      $z++;          
	  }

	  $data_complete["table_header"] =  $table_info;
	  $data_complete["tmp_servicios"] = $tmp_servicios;
	  return $data_complete;
}
/**/
function get_text_ciclo_facturacion($id_ciclo_facturacion){

  	$nuevo_text ="";
	switch ($id_ciclo_facturacion) {
		case '1':
			$nuevo_text ="365 Días";

			break;
		case '2':
			$nuevo_text ="30 Días";

			break;

		case '3':
			$nuevo_text ="7 Días";

			break;

		case '4':
			$nuevo_text ="15 Días";

			break;

		case '5':
			$nuevo_text ="Págo único";
			break;


		case '6':
			$nuevo_text ="365 Días";
			break;		

		case '7':
			$nuevo_text ="365 Días";
			break;		

		case '8':
			$nuevo_text ="365 Días";
			break;		

		default:
			# code...
			break;			
	}
	return  $nuevo_text;
}


}/*Termina el helper*/