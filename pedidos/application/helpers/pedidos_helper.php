<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

	function crea_seccion_productos($recibo){

		$recibo 				= 	$recibo[0];  
		$num_ciclos_contratados =  	$recibo["num_ciclos_contratados"];
		$precio					= 	$recibo["precio"];
		$id_servicio 			= 	$recibo["id_servicio"];
		$resumen  			= "";

		for ($a=0; $a < $num_ciclos_contratados ; $a++) { 
					
			$link 	= 	link_imagen_servicio($id_servicio); 	
			$img 	= 	img(["src" => $link , "class" => "img_servicio"]);
			
			
			$text_producto = 
			div($precio."MXN" , ["class" => "text-center top_20 text_precio_producto"]);
			$r 	 =  div($img, ["class" => "col-lg-4"]);		
			$r 	.=  div($text_producto, ["class" => "col-lg-8"]);		

			$url_servicio  =  "../producto/?producto=".$id_servicio;
			$r   =  
			div(anchor_enid($r ,
				["href" => $url_servicio , "target" => "_black"]) , 
				["class" => "top_20 row "]).hr();
			

			$resumen .=  $r;
		}
		return $resumen;

	}
	
	function create_fecha_contra_entrega($recibo){

		$recibo 				=  $recibo[0];		
		$text 					=  div("HORARIO DE ENTREGA" , 1).div($recibo["fecha_contra_entrega"] ,1);
		$fecha_contra_entrega   =  ($recibo["tipo_entrega"] == 1) ? $text:"";
		return $fecha_contra_entrega;

	}
	function create_seccion_saldos($recibo){
		
		$recibo 				=  $recibo[0];
		$saldo_cubierto 		=  $recibo["saldo_cubierto"]; 
		$saldo_cubierto 		=  $recibo["saldo_cubierto"]; 
		$precio 				=  $recibo["precio"]; 
		$num_ciclos_contratados =  $recibo["num_ciclos_contratados"]; 
		$costo_envio_cliente	=  $recibo["costo_envio_cliente"];
		$cargos_envio 			=  $recibo["costo_envio_cliente"];

		$total_a_pagar  		=  $precio * $num_ciclos_contratados + $costo_envio_cliente;



		$text 			 =  
		div(strong("CARGO DE ENVIO")."<br>"	. $cargos_envio ."MXN" , 
			["class" => "col-lg-4 text_saldo_pendiente"]);

		$text 			 .=  
		div(strong("MONTO DEL PEDIDO")."<br>". $total_a_pagar ."MXN" , 
			["class" => "col-lg-4 text_saldo_pendiente"]);
		

		$saldo_cubierto =  $saldo_cubierto."MXN";
		if ($saldo_cubierto == 0) {
			$saldo_cubierto  = span($saldo_cubierto,  ["class" => "sin_pago"]);
		}else{
			$saldo_cubierto  = span($saldo_cubierto,  ["class" => "pago_realizado"]);
		}
		$text 			.=  
		div(strong("MONTO TOTAL CUBIERTO")."<br>". $saldo_cubierto  , 
			["class" => "col-lg-4 text_saldo_cubierto"]);
		return  div($text , ["class" =>  "row"]);

	}
	function create_seccion_tipo_entrega($recibo , $tipos_entregas){

		$tipo 				=  "";
		$id_tipo_entrega 	=  $recibo[0]["tipo_entrega"];
		foreach ($tipos_entregas as $row) {
			
			if ($row["id"] == $id_tipo_entrega) {				
				$tipo = $row["nombre"];
				break;
			}
		}
	
		$encabezado 	= 	div(strong("TIPO DE ENTREGA"),	["class" =>"encabezado_tipo_entrega"] ,1);
	  	$tipo 			=  	div(strtoupper($tipo) ,["class" =>"encabezado_tipo_entrega"] , 1);
	  	return 			div($encabezado.$tipo , ["class" => "contenedor_tipo_entrega"] ,1).hr();

	}
	function crea_fecha_entrega($recibo){

		$recibo		= $recibo[0];
		$text 		= ( $recibo["saldo_cubierto"] > 0 && $recibo["status"] ==  9) ?
		icon("fa fa-check-circle")."PEDIDO ENTREGADO EL " .$recibo["fecha_entrega"] : "";
		return $text;
	}
	function crea_estado_venta($status_ventas , $recibo){


		$status 					 = 	$recibo[0]["status"];
		$text_status 			     =  "";
		foreach ($status_ventas as $row) {
			
			$id_estatus_enid_service =  $row["id_estatus_enid_service"];
			$nombre                  =  $row["nombre"];
			$descripcion             =  $row["descripcion"];
			$pago                    =  $row["pago"];
			$text_vendedor           =  $row["text_vendedor"];
			$text_cliente            =  $row["text_cliente"];

			if ( $status   ==  $id_estatus_enid_service ) {

				$text_status 	     =  $text_vendedor;
				break;
			}
		}
		return div($text_status , ["class" => "status_compra"]);
	}
	
	function create_seccion_usuario($usuario){
	
		$text_usuario  				= 	"";		
        foreach ($usuario as $row) {
            
            $id_usuario 			=  $row["id_usuario"];
            $nombre 				=  $row["nombre"];
            $apellido_paterno 		=  $row["apellido_paterno"];
            $apellido_materno 		=  $row["apellido_materno"];
            $email 					=  $row["email"];            
            $tel_contacto 			=  $row["tel_contacto"];
            $tel_contacto_alterno 	=  $row["tel_contacto_alterno"];
            $lada_negocio 			=  $row["lada_negocio"];
            $tel_lada 				=  $row["tel_lada"];

            $text_usuario .=  div($nombre ." " . $apellido_paterno . " " .$apellido_materno , 1);
            $text_usuario .=  div($email , 1);
            $text_usuario .=  div($tel_contacto , 1);
            $text_usuario .=  div($tel_contacto_alterno , 1);
        }    
        $encabezado 	= 	div("CLIENTE",	["class" =>"encabezado_cliente"] ,1);
	  	$text_usuario 	=  	div(strtoupper($text_usuario) ,["class" =>"contenido_domicilio"] , 1);
	  	return div($encabezado.$text_usuario , ["class" => "contenedor_cliente"] ,1).hr();
        
	}
	function create_seccion_domicilio($domicilio)
	{
	    
	    $data_domicilio = $domicilio["domicilio"];
	    if ($domicilio["tipo_entrega"] != 1) {
	    	/*puntos de encuentro*/	
	    	return create_domicilio_entrega($data_domicilio);
	    }else{	
	    	/*domicilio cliente*/	
	    	return create_punto_entrega($data_domicilio);
	    }    
	}

	function create_seccion_recordatorios($recibo){
		
		$text = ($recibo[0]["status"] == 6) ? 
		"EMAIL RECORDATORIOS COMPRA ".$recibo[0]["num_email_recordatorio"]:"";
		return $text;


	}
  	function create_punto_entrega($domicilio){
  	
	  	$punto_encuentro =  "";
	  	foreach ($domicilio as $row) {
  		
	  		$id							=  $row["id"];
	        $nombre						=  $row["nombre"];
	        $status						=  $row["status"];
	        $id_tipo_punto_encuentro	=  $row["id_tipo_punto_encuentro"];
	        $id_linea_metro				=  $row["id_linea_metro"];
	        $costo_envio				=  $row["costo_envio"];
	        $lugar_entrega				=  $row["lugar_entrega"];
	        $tipo						=  $row["tipo"];
	        $nombre_linea				=  $row["nombre_linea"];
	        $color						=  $row["color"];
	        $tipo_linea					=  $row["tipo_linea"];
	        $numero						=  $row["numero"];

	        switch ($id_tipo_punto_encuentro) {

				
				//1 | LÍNEA DEL METRO          
	        	case 1:
					$punto_encuentro .=  
					strong("ESTACIÓN DEL METRO ").$lugar_entrega ." LINEA ".$numero." ".$nombre_linea." COLOR ".$color;        		
	        		break;
	        	//2 | ESTACIÓN DEL  METRO BUS  
	        	case 2:
	        		$punto_encuentro .=  
					$tipo." ".$lugar_entrega ." ".$nombre_linea;        		
	        		break;
	        	
	        	// 3 | CENTRO COMERCIAL         
	        	case 3:
	        		
	        		break;
	        	
	        	default:
	        		
	        		break;
	        }

	  	}

	  	$encabezado = 	div("PUNTO DE ENCUENTRO",	["class" =>"encabezado_domicilio"] ,1);
	  	$punto_encuentro 	=  	div(strtoupper($punto_encuentro) ,["class" =>"contenido_domicilio"] , 1);
	  	return div($encabezado.$punto_encuentro , ["class" => "contenedor_domicilio"] ,1).hr();

	}
	function create_domicilio_entrega($domicilio){

	  	$direccion =  "";
	  	foreach ($domicilio as $row) {
	  			    
		    $calle  				= $row["calle"];
		    $entre_calles  			= $row["entre_calles"];
		    $numero_exterior  		= $row["numero_exterior"];
		    $numero_interior  		= $row["numero_interior"];
		    $id_codigo_postal  		= $row["id_codigo_postal"];
		    $telefono_receptor 		= $row["telefono_receptor"];
		    $nombre_receptor  		= $row["nombre_receptor"];
		    $cp  					= $row["cp"];
		    $asentamiento  			= $row["asentamiento"];
		    $municipio  			= $row["municipio"];
		    $ciudad  				= $row["ciudad"];
		    $estado  				= $row["estado"];
		    $idtipo_asentamiento  	= $row["idtipo_asentamiento"];
		    $id_estado_republica  	= $row["id_estado_republica"];
		    $pais  					= $row["pais"]; 
		    $id_pais  				= $row["id_pais"]; 


		    $direccion 
		    =  
		    $calle ." "." NÚMERO ".$numero_exterior." NÚMERO INTERIOR ".$numero_interior ." COLONIA ".$asentamiento ." DELEGACIÓN/MUNICIPIO ".$municipio. " ESTADO ".$estado." CÓDIGO POSTAL ".$cp;
	  		
	  	}
	  	$encabezado = 	div("DOMICIO DEL ENVIO",	["class" =>"encabezado_domicilio"] ,1);
	  	$direccion 	=  	div(strtoupper($direccion) ,["class" =>"contenido_domicilio"] , 1);
	  	return div($encabezado.$direccion , ["class" => "contenedor_domicilio"] ,1).hr();
	}


}