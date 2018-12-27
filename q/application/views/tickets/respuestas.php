<?php 
	
	$respuestas ="";	
	foreach ($info_respuestas as $row){

		$respuesta            =   $row["respuesta"]; 
		$fecha_registro       =   $row["fecha_registro"]; 		
		$id_usuario           =   $row["id_usuario"]; 
		$id_tarea             =   $row["id_tarea"];
		$nombre               =   $row["nombre"];
		$apellido_paterno     =   $row["apellido_paterno"];
		$apellido_materno     =   $row["apellido_materno"]; 
		$usuario_respuesta    =   $nombre ." " . $apellido_paterno;
		$idperfil             =   $row["idperfil"];
		$text_perfil          = ($idperfil != 20 ) ? "Equipo Enid Service" :  "Cliente";
		

        $respuestas .= "<div class='contenedor_respuestas_tickect_tarea'>";
            $respuestas .=  anchor_enid(img(["class"=>'media-object']) , ["class"=>'pull-left'] );            
            $respuestas .=  small(icon('fa fa-clock-o') . $fecha_registro , ["class"=>'pull-right time'] );
            $respuestas .=  div($usuario_respuesta."  | ".$text_perfil , ["class" => 'media-heading']);
            $respuestas .=  div($respuesta  );            
        $respuestas .= "</div>";
        $respuestas .= "<hr>";
                	
	}
	
	$oculta_comentarios = 
    (count($info_respuestas) >0 ) ? div("Ocultar " , 
        ["class"=>'ocultar_comentarios strong blue_enid' , "id"=> $id_tarea ]) : "";
	
		

?>

<div class="col-lg-12">
	<?=$oculta_comentarios?>
    <?=div(div($respuestas , ["class" => "msg-wrap"]) , ["class"=>"Message-wrap"]) ?>
</div>




