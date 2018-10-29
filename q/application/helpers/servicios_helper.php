<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){	
	function get_url_venta($extra){
		return "http://enidservice.com/inicio/producto/?producto=" .$extra;
	}	
	function create_dropdown_button($id_imagen , $principal = 0 ){
	
		$button =  div(icon("fa fa-chevron-circle-down") , 
			[
					"class"				=> 
					"btn btn-secondary dropdown-toggle contenedor_imagen_muestra_producto",
					"type"				=> "button" ,
					"id"				=> "dropdownMenuButton" ,
					"data-toggle"		=> "dropdown" ,
					"aria-haspopup"		=> "true" ,
					"aria-expanded"		=> "false"
		]);		

		$text 			 = ($principal ==  0) ? "Definir como principal":  "Imagen principal";
		$extra_principal = ($principal ==  0) ? "" : "blue_enid";
		$item =  div(
			icon('fa fa-star' , 
			[		
				"id"   =>  $id_imagen,
				"class" =>  "dropdown-item imagen_principal ".$extra_principal
			] , 
			0 , 
			$text
		));
			

		$item  .=   
			div(
				icon('fa fa-times' , 
				[		
				"id"   =>  $id_imagen,
				"class" =>  "dropdown-item foto_producto"
				] , 
				0 , 
				"Quitar")
			);


			$menu =  div( 
				$item
				,  
			[ 	
				"class"				=>"dropdown-menu" ,
				"aria-labelledby"	=>"dropdownMenuButton",
				"style" => "width:220px;border-style:solid;height:50px;z-index:3000;position:absolute;border-style: solid;border-color: #92a8d1;padding:3px;"
			]);
		
		return div($button . $menu ,  ["class" => "dropdown cursor"]);

	}    
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
		
		$arreglo_colores =  explode("," , $text_colores);		
		$a =0;
		$lista_completa =  "";
		for ($a=0; $a <count($arreglo_colores); $a++) { 
			
			$codigo_color 		=	$arreglo_colores[$a];
			$contenido 			= 	icon('fa fa-times elimina_color' , [ "id"=>$codigo_color])." ".$codigo_color;
			$lista_completa 	.= 	div($contenido ,[ "style" => "background:".$codigo_color.";color:white;padding:3px;" ]);
		}		
		return div($lista_completa, ["id"	=>	'contenedor_colores_disponibles'] );
	}
	/**/
	function valida_text_numero_articulos($num){	

		$text 	=  span("Alerta" , ["class"=>'mjs_articulo_no_disponible'])."este artúculo no se encuentra disponible, agregar nuevo";
		if($num > 0){
			$s1 	=  	$num ." Artículo disponible";			
			$s2 	=  	$num ." Artículos disponibles";				
			$text 	= 	( $num > 1 ) ? $s1 : $s2;
		}
		return $text;
	}
	/**/
	function agrega_data_servicio($data , $key , $valor ){
		
		$data[$key] =  $valor;
		return $data;
	}	
	function evalua_utilidad_mas_envio($flag_envio_gratis, $costo_envio, $utilidad){

		if($flag_envio_gratis == 1 ){
			return $utilidad - $costo_envio;		
		}else{
			return $utilidad;
		}		
	}	
	function get_valor_envio($costo_envio ,  $flag_envio_gratis){
		$costo =  ($flag_envio_gratis ==  1 ) ? -100 : 100;
		return $costo;
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
			
			$id_servicio 		=  	$row["id_servicio"];
			$nombre_servicio 	=  	$row["nombre_servicio"];
			$status 			=  	$row["status"];
			$especificacion 	= 	icon('servicio fa fa-file-text-o' , ["id"=> $id_servicio]);
			$text_estatus 		= 	($status == 0) ? "Inactivo" : "Activo";
				
			
			$list .=  "<tr>";
				$list .=  get_td($especificacion , ["class" => 'especificacion_servicio']);
				$list .=  get_td($nombre_servicio,$extra);
				$list .=  get_td($text_estatus , ["class"=>'text-center strong']);
			$list .=  "</tr>";
			$z ++;
		}
		return  $list;

	}	
	function scroll_terminos($num_terminos){
		
		$extra = 	($num_terminos > 3) ? "scroll_terms" : "";
		return $extra;		
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
	function is_servicio($row){

      $flag_precio_definido =   0;
      $flag_envio_gratis    =   $row["flag_envio_gratis"];
      $flag_servicio        =   $row["flag_servicio"];
      $precio               =   $row["precio"];
      $extra                =   "";

      switch($flag_servicio){
        case 1:

          if($flag_precio_definido == 1){
            
            $extra = "";  
          }else{
              $extra = "A convenir";  
          }          
          break;
        case 0:

          $extra = ($flag_envio_gratis == 1) ? "Envios gratis a todo México" : "Envios a todo México";

          break;
        default:          
          break;
      }
      return $extra;
    }
    
    function get_precio_producto($url_info_producto , $precio, $costo_envio , $flag_servicio , $id_ciclo_facturacion){
    
		if($flag_servicio ==  0){    
		      $seccion = anchor_enid($precio.'MXN', ["href"  =>  $url_info_producto , 
		      	"class" => "text_precio" ]);
		}else{

			$s1 	 =  anchor_enid($precio.'MXN' , ["href"=> $url_info_producto , "class" => "text_precio"] , 1 );
			$s2 	 =  anchor_enid(' A CONVENIR' , ["href"=> $url_info_producto , "class" => "text_precio"] , 1 );
			$seccion = ($id_ciclo_facturacion != 9 && $precio>0 ) ? $s1 : $s2;
		      
	    }
	    return $seccion;
  	}
  	function get_numero_colores($color , $flag_servicio , $url_info_producto , $extra ){

        if($flag_servicio !=  1) {                
          $arreglo_colores =  explode(",", $color);
          $num_colores =  count($arreglo_colores);
          if( $num_colores > 0){            
              if($num_colores > 1){
    			
    			return anchor_enid($num_colores ." colores" , ["href" => $url_info_producto ]);            
                
              }else{

              	return anchor_enid($num_colores ." color" , ["href" => $url_info_producto ]);
              }
              
          }
        }
    }
    function get_text_nombre_servicio($nombre_servicio){
      $text_nombre_servicio = heading_enid(substr( $nombre_servicio ,  0  , 70 ) , 3 , 
      	["class"=>"nombre_servicio" ] );
      return $text_nombre_servicio;
    }
    function get_en_existencia($existencia , $flag_servicio , $in_session){      
	    if($flag_servicio ==  0) {
	      return informacion_existencia_producto($existencia , $in_session);
	    }
	}
	function informacion_existencia_producto($existencia , $in_session){

	    if($in_session ==  1){
	        $msj = ($existencia >0 ) ? span($existencia." En existencia ") : span("INVENTARIO LIMITADO");
	        return $msj;
	    }
  	}
  	function muestra_vistas_servicio($in_session , $vistas){
	    if($in_session ==  1){
	       return div($vistas." personas alcanzadas");
	    } 
  	}
  	function valida_botton_editar_servicio($param, $id_usuario_registro_servicio ){

      $in_session = $param["in_session"];
      	if($in_session ==  1){
          $id_servicio        =  $param["id_servicio"];
          $id_usuario_actual  =   $param["id_usuario"];
          if( $id_usuario_actual ==  $id_usuario_registro_servicio){
            return div("" , ["class"=>'servicio fa fa-pencil' ,  "id"=> $id_servicio]);
          }
      	}
  	}
  	function get_rango_entrega($id_perfil, $actual, $attributes=''){

  		
  		$select 		=  "";
  		if ($id_perfil ==  3) {

  			$att 		= 	add_attributes($attributes);

  			$select    .=  	heading_enid("DÍAS PROMEDIO DE ENTREGA" , 4);  			
	  		$select  	.= 	"<select ".$att.">";

	  		for ($a=1; $a < 10 ; $a++) { 
	  			if ($a ==  $actual) {
	  				$select  	.= "<option value='".$a."' selected>".$a."</option>";
	  			}else{
	  				$select  	.= "<option value='".$a."'>".$a."</option>";	
	  			}
	  			
	  		}
	  		$select .= "</select>";  		
	  		$select .=  place("response_tiempo_entrega");

  		}  		
  		return $select;
  	}
}/*Termina el helper*/