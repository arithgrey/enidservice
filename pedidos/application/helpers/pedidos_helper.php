<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

    if ( ! function_exists('agregar_nueva_direccion'))
    {
        function agregar_nueva_direccion($direccion = 1){


            if ($direccion >  0) {
                return li(guardar( "Agregar punto de encuentro " ,
                    ["class"  => "agregar_punto_encuentro_pedido"]  ) );
            }else{

                return li(guardar( "Agregar direccion " ,
                    ["class"  => "agregar_direccion_pedido"]  ) );
            }


        }
    }
    if ( ! function_exists('get_lista_puntos_encuentro'))
    {
        function get_lista_puntos_encuentro($puntos_encuentro , $id_recibo , $domicilio =''){

            $asignado   =  (is_array($domicilio) && $domicilio["tipo_entrega"] ==  1) ? $domicilio["domicilio"][0]["id"] : 0;
            $lista 	    = 	"";
            $a  	    =	0;
            foreach ($puntos_encuentro as $row) {

                $id 		=   $row["id"];
                $nombre 	=   $row["nombre"];
                $extra      =   ($id ===  $asignado  ) ? "asignado_actualmente" : "";
                $lista      .=  "<li class='list-group-item ".$extra." '>";
                $lista      .= div("#".$a ,  ["class"=>"h6 text-muted"]);
                $lista      .= div( strtoupper($nombre)  ,  ["class"=>"h5"]);
                $lista      .= div("ESTABLECER COMO PUNTO DE ENTREGA" ,
                [
                    "class"		=>	"h6 text-muted text-right establecer_punto_encuentro cursor_pointer",
                    "id"		=>	$id,
                    "id_recibo"	=>	$id_recibo

                ]);
                $lista .=  "</li>";
                $a ++;
            }
            return $lista;
        }
    }
    if ( ! function_exists('create_lista_direcciones'))
    {
        function create_lista_direcciones($lista , $id_recibo){

            $text  = "";
            $a 	   = 1;
            foreach($lista as $row) {

                $id_direccion  			= $row["id_direccion"];
                $calle  				= $row["calle"];
                $numero_exterior  		= $row["numero_exterior"];
                $numero_interior  		= $row["numero_interior"];
                $cp  					= $row["cp"];
                $asentamiento  			= $row["asentamiento"];
                $municipio  			= $row["municipio"];
                $estado  				= $row["estado"];
                $text .=  "<li class='list-group-item'>";

                $direccion =
                    $calle ." "." NÚMERO ".$numero_exterior." NÚMERO INTERIOR ".$numero_interior ." COLONIA ".$asentamiento ." DELEGACIÓN/MUNICIPIO ".$municipio. " ESTADO ".$estado." CÓDIGO POSTAL ".$cp;

                $text .= div("#".$a ,  ["class"=>"h6 text-muted"]);
                $text .= div( strtoupper($direccion)  ,  ["class"=>"h5"]);
                $text .=
                    div("ESTABLECER COMO DIRECCIÓN DE ENTREGA" ,
                        [
                            "class"		=>	"h6 text-muted text-right establecer_direccion cursor_pointer",
                            "id"		=>	$id_direccion,
                            "id_recibo"	=>	$id_recibo

                        ]);
                $text .=  "</li>";
                $a ++;
            }

            return $text;
        }
    }
    if ( ! function_exists('create_descripcion_direccion_entrega'))
    {
        function create_descripcion_direccion_entrega($data_direccion){

            $text = "";
            if ($data_direccion["tipo_entrega"] ==  2 && count($data_direccion["domicilio"]) > 0  ) {


                $domicilio 				= $data_direccion["domicilio"][0];
                $calle  				= $domicilio["calle"];
                //$entre_calles  			= $domicilio["entre_calles"];
                $numero_exterior  		= $domicilio["numero_exterior"];
                $numero_interior  		= $domicilio["numero_interior"];
                //$id_codigo_postal  		= $domicilio["id_codigo_postal"];
                //$telefono_receptor 		= $domicilio["telefono_receptor"];
                //$nombre_receptor  		= $domicilio["nombre_receptor"];
                $cp  					= $domicilio["cp"];
                $asentamiento  			= $domicilio["asentamiento"];
                $municipio  			= $domicilio["municipio"];
                $ciudad  				= $domicilio["ciudad"];
                $estado  				= $domicilio["estado"];
                //$idtipo_asentamiento  	= $domicilio["idtipo_asentamiento"];
                //$id_estado_republica  	= $domicilio["id_estado_republica"];
                //$pais  					= $domicilio["pais"];
                //$id_pais  				= $domicilio["id_pais"];

                $text
                    =
                    $calle ." "." NÚMERO ".$numero_exterior." NÚMERO INTERIOR ".$numero_interior ." COLONIA ".$asentamiento ." DELEGACIÓN/MUNICIPIO ".$municipio. " ESTADO ".$estado." CÓDIGO POSTAL ".$cp;
                return p( strtoupper( $text ) , ["class"=>"card-text"]);

            }else{

                if(is_array($data_direccion) &&  count($data_direccion["domicilio"]) > 0 ){
                    $punto_encuentro 	 	=	$data_direccion["domicilio"][0];
                    $costo_envio 			= 	$punto_encuentro["costo_envio"];
                    $tipo 		 			= 	$punto_encuentro["tipo"];
                    $color 		 			= 	$punto_encuentro["color"];
                    $nombre_estacion 		= 	$punto_encuentro["nombre"];
                    $lugar_entrega 			= 	$punto_encuentro["lugar_entrega"];
                    $numero 	 			= 	"NÚMERO ".$punto_encuentro["numero"];
                    $text =  	heading_enid("LUGAR DE ENCUENTRO" , 3, ["class" => "top_20"]);
                    $text.=		div($tipo. " ". $nombre_estacion ." ". $numero." COLOR ". $color ,1);
                    $text.= div("ESTACIÓN ".$lugar_entrega , ["class" => "strong"],1);
                    return $text;

                }

            }

        }
    }
    if ( ! function_exists('valida_accion_pago'))
    {
        function valida_accion_pago($recibo){

            if ($recibo[0]["saldo_cubierto"] < 1 ) {

                $id_recibo 	=   $recibo[0]["id_proyecto_persona_forma_pago"];
                $url 		=   "../area_cliente/?action=compras&ticket=".$id_recibo;
                return guardar( "PROCEDER A LA COMPRA " .icon("fa fa-2x fa-shopping-cart") ,
                    [
                        "style" =>  "background:blue!important",
                        "class" =>  "top_20"
                    ],
                    1 ,
                    1 ,
                    0 ,
                    $url);
            }
        }
    }
    if ( ! function_exists('create_linea_tiempo'))
    {
        function create_linea_tiempo($recibo , $domicilio){

            $linea 			= 	"";
            $flag 			=	0;
            $recibo 		= 	$recibo[0];
            $id_estado  	=   $recibo["status"];
            $tipo_entrega 	= 	$recibo["tipo_entrega"];
            $id_recibo 		=  	$recibo["id_proyecto_persona_forma_pago"];


            for ($i=5; $i >0 ; $i-- ) {

                $status 	=  	get_texto_status($i , $recibo);
                $activo 	=  1;

                if ($flag == 0) {
                    $activo 	=  0;
                    if ($id_estado ==  $status["estado"]) {
                        $activo = 1;
                        $flag ++;
                    }
                }

                switch ($i) {

                    case 2:
                        $class      =   (tiene_domilio($domicilio , 1) ==  0) ? "timeline__item__date" : "timeline__item__date_active";
                        $seccion_2  =   get_seccion_domicilio($domicilio , $id_recibo , $tipo_entrega );

                        break;
                    case 3:
                        $seccion_2 =    get_seccion_compra($recibo , $id_recibo);
                        break;

                    default:
                        $class 		=   ($activo ==  1 ) ? "timeline__item__date_active": "timeline__item__date";
                        $seccion_2 	= 	get_seccion_base($status);
                        break;

                }
                $seccion 	=   div(icon("fa fa-check-circle-o") , ["class" => $class]);
                $linea .=  div($seccion.$seccion_2 , ["class"=>"timeline__item"]);

            }
            return $linea;
        }
    }
    if ( ! function_exists('get_seccion_base'))
    {
        function get_seccion_base($status){
            $seccion 	=
                div(p($status["text"] ,
                    [
                        "class"	=>	"timeline__item__content__description"
                    ]),
                    ["class"	=>"timeline__item__content"]);

            return $seccion;

        }
    }
    if ( ! function_exists('get_seccion_compra'))
    {
        function get_seccion_compra($recibo , $id_recibo ){

            $text 	    =   ( $recibo["saldo_cubierto"] > 0  ) ? "REALIZASTE TU COMPRA".icon("fa fa-check") : "REALIZA TU COMPRA";
            $url 		=   "../area_cliente/?action=compras&ticket=".$id_recibo;
            $seccion 	=   div(p(anchor_enid($text , ["href" =>  $url]),
                [
                    "class"	=>	"timeline__item__content__description"
                ]),
                ["class"	=>"timeline__item__content"]);

            return  $seccion;
        }
    }
    if ( ! function_exists('get_seccion_domicilio'))
    {
        function get_seccion_domicilio($domicilio , $id_recibo , $tipo_entrega ){

            $texto_entrega 	 =  "DOMICILIO DE ENTREGA CONFIRMADO ".icon("fa fa-check");

            if (tiene_domilio($domicilio , 1) ==  0) {
                $texto_entrega = ($tipo_entrega ==  1 ) ? "REGISTRA TU DIRECCIÓN DE ENTREGA":"INDICA TU PUNTO DE DE ENTREGA";
            }

            $url 		= "../pedidos/?seguimiento=".$id_recibo."&domicilio=1";
            $seccion 	= 	div(p(anchor_enid($texto_entrega , ["href" =>  $url]),
                [
                    "class"	=>	"timeline__item__content__description"
                ]),
                ["class"	=>"timeline__item__content"]);
            return $seccion;
        }
    }
    if ( ! function_exists('get_texto_status'))
    {
        function get_texto_status($status , $recibo){

            //$status_recibo 	= $recibo["status"];
            $text  			= "";
            $response  = [];
            $estado 	    =  6;

            switch ($status) {
                case 2:
                    $text 	= 	"PAGO VERIFICADO";
                    $estado =	1;
                    break;

                case 1:
                    $text = "ORDEN REALIZADA";
                    $estado = 6;
                    break;


                case 4:
                    $text = "PEDIDO EN CAMINO";
                    $estado =	7;
                    break;

                case 5:
                    $text = "ENTREGADO";
                    $estado =	9;
                    break;

                case 3:
                    $text 	= 	"EMPACADO";
                    $estado =	12;
                    break;

                default:

                    break;
            }
            $response["text"] 		= $text;
            $response["estado"] 	= $estado;
            return $response;

        }
    }

	/*function create_seccion_linea_tiempo($recibo , $status , $activo=0 , $direccion_activa = 0 ){


		$status_recibo  = $recibo[0]["status"];
		$text           = "";
		switch ($status) {
			case 1:
				$text = "PAGO VERIFICADO";	
				break;
			
			case 6:
				$text = "ORDEN REALIZADA";	
				break;


			case 7:
				$text = "PEDIDO EN CAMINO";	
				break;

			case 9:
				$text = "ENTREGADO";	
				break;

			case 12:
				$text = "EMPACADO";	
				break;
			
			default:
				
				break;
		}


		$class 		=  ($activo ==  1) ? "timeline__item__date_active": "timeline__item__date";

		$seccion 	= div(icon("fa fa-check-circle-o") , ["class"=>$class]);

		$seccion_2 	= div(p($text ,
		        	[
		        		"class"	=>	"timeline__item__content__description"
		        	]), 
		        ["class"	=>"timeline__item__content"]);

		return  div($seccion.$seccion_2 , ["class"=>"timeline__item"]);
		

	}
	*/
    if ( ! function_exists('create_seccion_tipificaciones'))
    {
        function create_seccion_tipificaciones($data){

            $tipificaciones  =	"";

            foreach ($data as $row) {

                $fecha_registro      	= div(icon("fa fa-clock-o").$row["fecha_registro"] , ["class" => "col-lg-3"]);
                $nombre_tipificacion    = div($row["nombre_tipificacion"] , ["class" => "col-lg-9"]);
                $tipificacion           = div($fecha_registro.$nombre_tipificacion , 1);
                $tipificaciones        .= div($tipificacion , ["class" => "seccion_tipificacion top_20 padding_10"]);

            }
            if ( count($data) > 0) {
                $title	=  heading_enid("MOVIMIENTOS" ,4 ,["class" => "white"]);
                return div($title.$tipificaciones , ["class" => "global_tipificaciones"]);
            }

        }
    }
    if ( ! function_exists('crea_seccion_productos'))
    {
        function crea_seccion_productos($recibo){

            $recibo 				= 	$recibo[0];
            $num_ciclos_contratados =  	$recibo["num_ciclos_contratados"];
            $precio					= 	$recibo["precio"];
            $id_servicio 			= 	$recibo["id_servicio"];
            $response  			    =   "";

            for ($a=0; $a < $num_ciclos_contratados ; $a++) {

                $link 	    = 	link_imagen_servicio($id_servicio);
                $id_error   =   "imagen_".$id_servicio;
                $img 	= 	img([
                    "src"   =>  $link ,
                    "class" =>  "img_servicio",
                    "id"    =>  $id_error,
                    'onerror' => "reloload_img( '".$id_error."','".$link."');"
                ]);


                $text_producto  = div($precio."MXN" , ["class" => "text-center top_20 text_precio_producto"]);
                $r 	            =  div($img, ["class" => "col-lg-4"]);
                $r 	           .=  div($text_producto, ["class" => "col-lg-8"]);

                $url_servicio   =  "../producto/?producto=".$id_servicio;
                $r              =
                    div(anchor_enid($r ,
                        [
                            "href" => $url_servicio ,
                            "target" => "_black"
                        ]) ,
                        [
                            "class" => "top_20 row "
                        ]).hr();


                $response .=  $r;
            }
            return $response;

        }
    }

    if ( ! function_exists('create_fecha_contra_entrega'))
    {
        function create_fecha_contra_entrega($recibo , $domicilio){

            if ( get_param_def($domicilio , "domicilio") > 0  && count($recibo) > 0) {
                $recibo 				=  $recibo[0];
                $text 					=  div("HORARIO DE ENTREGA" , 1).div($recibo["fecha_contra_entrega"] ,1);
                $fecha_contra_entrega   =  ($recibo["tipo_entrega"] == 1) ? $text:"";
                return $fecha_contra_entrega;
            }
        }
    }
    if ( ! function_exists('create_seccion_saldos'))
    {
        function create_seccion_saldos($recibo){

            $recibo 				=  $recibo[0];
            //$saldo_cubierto 		=  $recibo["saldo_cubierto"];
            $saldo_cubierto 		=  $recibo["saldo_cubierto"];
            $precio 				=  $recibo["precio"];
            $num_ciclos_contratados =  $recibo["num_ciclos_contratados"];
            $costo_envio_cliente	=  $recibo["costo_envio_cliente"];
            $cargos_envio 			=  $recibo["costo_envio_cliente"];
            $total_a_pagar  		=  $precio * $num_ciclos_contratados + $costo_envio_cliente;
            $base                   = "col-lg-4 text_saldo_pendiente";
            $text 			        =   div(strong("CARGO DE ENVIO")."<br>"	. $cargos_envio ."MXN" ,  ["class" => $base]);
            $text 			       .=   div(strong("MONTO DEL PEDIDO")."<br>". $total_a_pagar ."MXN" ,  ["class" => $base]);
            $saldo_cubierto         =   $saldo_cubierto."MXN";
            $saldo_cubierto         =   ($saldo_cubierto == 0) ? span($saldo_cubierto,  ["class" => "sin_pago"]) : span($saldo_cubierto,  ["class" => "pago_realizado"]);
            $text 			       .= div(strong("MONTO TOTAL CUBIERTO")."<br>". $saldo_cubierto  , ["class" => "col-lg-4 text_saldo_cubierto"]);
            return div($text , ["class" =>  "row"]);

        }
    }
    if ( ! function_exists('create_seccion_tipo_entrega'))
    {
        function create_seccion_tipo_entrega($recibo , $tipos_entregas){

            $tipo 				=  "";
            $id_tipo_entrega 	=  $recibo[0]["tipo_entrega"];
            foreach ($tipos_entregas as $row) {

                if ($row["id"] == $id_tipo_entrega) {
                    $tipo = $row["nombre"];
                    echo input_hidden(
                        [
                            "class" => 	"text_tipo_entrega",
                            "value"	=>  $tipo
                        ]
                    );
                    break;
                }
            }

            $encabezado = 	div(strong("TIPO DE ENTREGA"),	["class" =>"encabezado_tipo_entrega"] ,1);
            $tipo 		=  	div(strtoupper($tipo) , [   "class"      =>  "encabezado_tipo_entrega"   ] , 1);
            return 			div($encabezado.$tipo , ["class"    =>  "contenedor_tipo_entrega"   ] ,1).hr();

        }

    }
    if ( ! function_exists('crea_fecha_entrega'))
    {
        function crea_fecha_entrega($recibo){

            if (count($recibo) > 0 ){
                $recibo		= $recibo[0];
                $text 		= ( $recibo["saldo_cubierto"] > 0 && $recibo["status"] ==  9) ? icon("fa fa-check-circle")."PEDIDO ENTREGADO EL " .$recibo["fecha_entrega"] : "";
                return $text;
            }
        }
    }
    if ( ! function_exists('crea_estado_venta'))
    {
        function crea_estado_venta($status_ventas , $recibo){

            $status 					 = 	$recibo[0]["status"];
            $text_status 			     =  "";
            foreach ($status_ventas as $row) {

                $id_estatus_enid_service =  $row["id_estatus_enid_service"];
                $text_vendedor           =  $row["text_vendedor"];

                if ( $status   ==  $id_estatus_enid_service ) {

                    $text_status =  $text_vendedor;
                    break;
                }
            }
            return div($text_status , ["class" => "status_compra"]);
        }
    }
    if ( ! function_exists('create_seccion_usuario'))
    {
        function create_seccion_usuario($usuario){

            $text  				= 	"";
            foreach ($usuario as $row) {

                $nombre 				=  $row["nombre"];
                $apellido_paterno 		=  $row["apellido_paterno"];
                $apellido_materno 		=  $row["apellido_materno"];
                $email 					=  $row["email"];
                $tel_contacto 			=  $row["tel_contacto"];
                $tel_contacto_alterno 	=  $row["tel_contacto_alterno"];

                $text .=  div($nombre ." " . $apellido_paterno . " " .$apellido_materno , 1);
                $text .=  div($email , 1);
                $text .=  div($tel_contacto , 1);
                $text .=  div($tel_contacto_alterno , 1);
            }
            $encabezado 	= 	div("CLIENTE",	["class" =>"encabezado_cliente"] ,1);
            $text_usuario 	=  	div(strtoupper($text) ,["class" =>"contenido_domicilio"] , 1);
            return div($encabezado.$text_usuario , ["class" => "contenedor_cliente"] ,1).hr();

        }
    }
    if ( ! function_exists('tiene_domilio'))
    {
        function tiene_domilio($domicilio , $numero = 0 ){

            $final_text 	= "";
            $final_numeric 	= 0;
            if ( array_key_exists("domicilio", $domicilio)
                &&
                is_array($domicilio["domicilio"])
                &&
                count($domicilio["domicilio"])	> 0 ){

                $final_numeric ++;

            }else{
                $final_text = div("SIN DOMICIO REGISTRADO" , ["class" => "sin_domicilio padding_10 white"] , 1 );
            }

            $response = ( $numero ==  0) ? $final_text : $final_numeric;
            return $response;
        }
    }
    if ( ! function_exists('create_seccion_domicilio'))
    {
        function create_seccion_domicilio($domicilio)
        {

            if (array_key_exists("domicilio", $domicilio) && is_array($domicilio["domicilio"]) && count($domicilio["domicilio"])	> 0){


                $data_domicilio 		= $domicilio["domicilio"];
                if ($domicilio["tipo_entrega"] != 1) {

                    return create_domicilio_entrega($data_domicilio);
                }else{

                    return create_punto_entrega($data_domicilio);
                }
            }else{
                /*solicita dirección de envio*/
            }
        }
    }
    if ( ! function_exists('create_seccion_recordatorios'))
    {
        function create_seccion_recordatorios($recibo){

            if (count($recibo)>0){
                $text = ($recibo[0]["status"] == 6) ? "EMAIL RECORDATORIOS COMPRA ".$recibo[0]["num_email_recordatorio"]:"";
                return $text;
            }

        }
    }
    if ( ! function_exists('create_punto_entrega'))
    {
        function create_punto_entrega($domicilio){

            $punto_encuentro =  "";
            foreach ($domicilio as $row) {

                $id	                        =  $row["id_tipo_punto_encuentro"];
                $lugar_entrega				=  $row["lugar_entrega"];
                $tipo						=  $row["tipo"];
                $nombre_linea				=  $row["nombre_linea"];
                $color						=  $row["color"];
                $numero						=  $row["numero"];

                switch ($id) {

                    //1 | LÍNEA DEL METRO
                    case 1:
                        $punto_encuentro .=
                            strtoupper(strong("ESTACIÓN DEL METRO ").$lugar_entrega ." LINEA ".$numero." ".$nombre_linea." COLOR ".$color);
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
            $encabezado         = 	div("PUNTO DE ENCUENTRO",	["class" =>"encabezado_domicilio"] ,1);
            $encuentro 	=  	div(strtoupper($punto_encuentro) ,["class" =>"contenido_domicilio"] , 1);
            return div($encabezado.$encuentro , ["class" => "contenedor_domicilio"] ,1).hr();

        }
    }
    if ( ! function_exists('create_domicilio_entrega'))
    {
        function create_domicilio_entrega($domicilio){

            $direccion =  "";
            foreach ($domicilio as $row) {

                $calle  				= $row["calle"];
                $numero_exterior  		= $row["numero_exterior"];
                $numero_interior  		= $row["numero_interior"];
                $cp  					= $row["cp"];
                $asentamiento  			= $row["asentamiento"];
                $municipio  			= $row["municipio"];
                $estado  				= $row["estado"];
                $direccion              = $calle ." "." NÚMERO ".$numero_exterior." NÚMERO INTERIOR ".$numero_interior ." COLONIA ".$asentamiento ." DELEGACIÓN/MUNICIPIO ".$municipio. " ESTADO ".$estado." CÓDIGO POSTAL ".$cp;

            }
            $encabezado = 	div("DOMICIO DEL ENVIO",	["class" =>"encabezado_domicilio"] ,1);
            $direccion 	=  	div(strtoupper($direccion) ,["class" =>"contenido_domicilio"] , 1);
            return div($encabezado.$direccion , ["class" => "contenedor_domicilio"] ,1).hr();
        }
    }
}