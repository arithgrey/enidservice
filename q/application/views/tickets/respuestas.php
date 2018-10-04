<?php 
	
	$respuestas ="";	
	foreach ($info_respuestas as $row){

		$respuesta  =  $row["respuesta"]; 
		$fecha_registro  =  $row["fecha_registro"]; 		
		$id_usuario  =  $row["id_usuario"]; 
		$id_tarea =  $row["id_tarea"];

			$nombre =  $row["nombre"];
			$apellido_paterno=  $row["apellido_paterno"];
			$apellido_materno =  $row["apellido_materno"]; 
			$usuario_respuesta = $nombre ." " . $apellido_paterno;

			$idperfil =  $row["idperfil"];

			$text_perfil ="Cliente";
			if ($idperfil != 20 ) {
				$text_perfil ="Equipo Enid Service";	
			}

            $respuestas .= "<div>";
                $respuestas .=  anchor_enid(img(["class"=>'media-object']) , ["class"=>'pull-left',  "href"=>'#'] );
                $respuestas .= "<div class='media-body'>";
                    $respuestas .= small(icon('fa fa-clock-o') . $fecha_registro , ["class"=>'pull-right time'] );
                    $respuestas .= heading_enid($usuario_respuesta."  | ".$text_perfil , ["class" => 'media-heading']);
                    $respuestas .= small($respuesta , ["class"=>'col-lg-10'] );
                $respuestas .= "</div>";
            $respuestas .= "</div>";
            $respuestas .= "<hr>";
                	
	}
	
	$oculta_comentarios = (count($info_respuestas) >0 ) ? span("Ocultar " , ["class"=>'ocultar_comentarios strong blue_enid' , "id"=> $id_tarea ]) : "";
	
		

?>

<div class="col-lg-12">
	<?=$oculta_comentarios?>
    <?=div(div($respuestas , ["class" => "msg-wrap"]) , ["class"=>"Message-wrap"]) ?>
</div>






	<style type="text/css">
	    .conversation-wrap
    {
        box-shadow: -2px 0 3px #ddd;
        padding:0;
        max-height: 200px;
        overflow: auto;
    }
    .conversation
    {
        padding:5px;
        border-bottom:1px solid #ddd;
        margin:0;

    }

    .message-wrap
    {
        box-shadow: 0 0 3px #ddd;
        padding:0;

    }
    .msg
    {
        padding:5px;
        /*border-bottom:1px solid #ddd;*/
        margin:0;
    }
    .msg-wrap
    {
        padding:10px;
        max-height: 200px;
        overflow: auto;

    }

    .time
    {
        color:#bfbfbf;
    }

    .send-wrap
    {
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding:10px;
        /*background: #f8f8f8;*/
    }

    .send-message
    {
        resize: none;
    }

    .highlight
    {
        background-color: #f7f7f9;
        border: 1px solid #e1e1e8;
    }

    .send-message-btn
    {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;

        border-bottom-right-radius: 0;
    }
    .btn-panel
    {
        background: #f7f7f9;
    }

    .btn-panel .btn
    {
        color:#b8b8b8;

        transition: 0.2s all ease-in-out;
    }

    .btn-panel .btn:hover
    {
        color:#666;
        background: #f8f8f8;
    }
    .btn-panel .btn:active
    {
        background: #f8f8f8;
        box-shadow: 0 0 1px #ddd;
    }

    .btn-panel-conversation .btn,.btn-panel-msg .btn
    {

        background: #f8f8f8;
    }
    .btn-panel-conversation .btn:first-child
    {
        border-right: 1px solid #ddd;
    }

    .msg-wrap .media-heading
    {
        color:#003bb3;
        font-weight: 700;
    }


    .msg-date
    {
        background: none;
        text-align: center;
        color:#aaa;
        border:none;
        box-shadow: none;
        border-bottom: 1px solid #ddd;
    }


    body::-webkit-scrollbar {
        width: 12px;
    }
 
    
    /* Let's get this party started */
    ::-webkit-scrollbar {
        width: 6px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
/*        -webkit-border-radius: 10px;
        border-radius: 10px;*/
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
/*        -webkit-border-radius: 10px;
        border-radius: 10px;*/
        background:#ddd; 
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
    }
    ::-webkit-scrollbar-thumb:window-inactive {
        background: #ddd; 
    }

</style>
