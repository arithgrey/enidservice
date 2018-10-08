<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){	
    
    function valida_tipo_promocion($param){
        
        $tipo = ($param[0]["flag_servicio"] ==  1) ? "SERVICIO": "PRODUCTO";
        return $tipo;
    }
    /**/
	function get_nombre_ciclo_facturacion($ciclos , $id_ciclo){
		foreach($ciclos as $row){
			$id_ciclo_facturacion = $row["id_ciclo_facturacion"];
			if($id_ciclo_facturacion == $id_ciclo) {
				return $row["ciclo"];	
			}
		}
	}
	/**/
	function create_colores_disponibles($text_colores){
		/**/
		$arreglo_colores =  explode("," , $text_colores);		
		$a =0;
		$lista_completa =  "";
		for ($a=0; $a <count($arreglo_colores); $a++) { 
			
			$codigo_color 	=$arreglo_colores[$a];
			$estilos 		="background:".$codigo_color.";color:white;padding:3px;";
			$contenido 		= 
			icon('fa fa-times elimina_color' , [ "id"=>$codigo_color])." ".$codigo_color;

			$lista_completa .= div($contenido ,[ "style" => $estilos ]);
		}		
		return div($lista_completa, ["id"	=>	'contenedor_colores_disponibles'] );
	}
	/**/
	function valida_text_numero_articulos($num){	

		$text =  span("Alerta" , ["class"=>'mjs_articulo_no_disponible'])."este artúculo no se encuentra disponible, agregar nuevo";
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
		$list = "<select class='form-control producto_nuevo'>";
			for ($z=0; $z < count($usado); $z++){ 					
				if ($z == $valor_actual ) {
					$list .= "<option value='".$z."' selected>".$usado[$z]."</option>";
				}else{
					$list .= "<option value='".$z."'>".$usado[$z]."</option>";
				}
			}
		$list .= "</select>";
		return $list;   
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
	/**/
	function create_table_servicios($servicios){
		
		$list ="";
		$z =1;
		$extra ="";
		foreach ($servicios as $row) {
			
			$id_servicio =  $row["id_servicio"];
			$nombre_servicio =  $row["nombre_servicio"];
			$status =  $row["status"];
			$text_estatus ="Activo";
			$especificacion =icon('servicio fa fa-file-text-o' , ["id"=> $id_servicio]);

			if($status == 0){
				$text_estatus ="Inactivo";
			}
			$list .=  "<tr>";
				
				
				$list .=  
				get_td($especificacion , 
					"class=' especificacion_servicio' ");

				$list .=  get_td($nombre_servicio,$extra);
				$list .=  get_td($text_estatus , ["class"=>'text-center strong']);

			$list .=  "</tr>";
			$z ++;
		}
		return  $list;

	}
	
	
	/**/
	function scroll_terminos($num_terminos){
		
		if($num_terminos > 3){
			return "scroll_terms";
		}
		return "";
		
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