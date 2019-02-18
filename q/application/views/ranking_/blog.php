<?php 

    $article ="";
    $z =1;
    foreach ($info_mensajes as $row) {        
                       
        $id_faq =  $row["id_faq"];
        $titulo =  $row["titulo"];
        $id_usuario =  $row["id_usuario"];    
        $url_faq =  $row["url_faq"];
        $num_accesos =  $row["num_accesos"];
        $email=  $row["email"];
        $nombre=  $row["nombre"];        
        $apellido_paterno=  $row["apellido_paterno"];
        $apellido_materno=  $row["apellido_materno"];

        $nombre_usuario = $nombre ." " . $apellido_materno ." " .$apellido_paterno;
        $mensaje_completo ="";
        $nombre_red =  "";
        $nombre_categoria =  $row["nombre_categoria"];

        if($z < 11){ 

        $article .= '
            <article class="timeline-entry">
                <div class="timeline-entry-inner">
                    <div class="timeline-icon bg-info">
                        '.$z.'
                        '.icon('entypo-feather').'
                    </div>
                    <div class="timeline-label">
                        <h2>
                            '.anchor_enid($nombre_usuario).'
                            '.$email.'
                            '.anchor_enid($nombre_red).'
                        </h2>
                        <div>
                            '.div("Artículo " ).'
                        	'.anchor_enid($titulo ,  ["href" => $url_faq] ).'
                        	
                        </div>
                        '.div("#Accesos" , $num_accesos . $nombre_categoria).'
                    </div>
                </div>

            </article>';

        }else{
            break;
        }    
        $z ++;

    }
?>

<div style="background:#0041ff;">
    	
    <div class="timeline-centered">
        <?=$article?> 
    </div>
</div>
<style type="text/css">
    
img {
    vertical-align: middle;
}
.timeline-centered {
    position: relative;
    margin-bottom: 30px;
}

    .timeline-centered:before, .timeline-centered:after {
        content: " ";
        display: table;
    }

    .timeline-centered:after {
        clear: both;
    }

    .timeline-centered:before, .timeline-centered:after {
        content: " ";
        display: table;
    }

    .timeline-centered:after {
        clear: both;
    }

    .timeline-centered:before {
        content: '';
        position: absolute;
        display: block;
        width: 4px;
        background: #f5f5f6;
        /*left: 50%;*/
        top: 20px;
        bottom: 20px;
        margin-left: 30px;
    }




                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2, .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p {
                    color: #737881;
                    font-family: "Noto Sans",sans-serif;
                    font-size: 12px;
                    margin: 0;
                    line-height: 1.428571429;
                }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p + p {
                        margin-top: 15px;
                    }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 {
                    font-size: 16px;
                    margin-bottom: 10px;
                }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 a {
                        color: #303641;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 span {
                        -webkit-opacity: .6;
                        -moz-opacity: .6;
                        opacity: .6;
                        -ms-filter: alpha(opacity=60);
                        filter: alpha(opacity=60);
                    }

</style>