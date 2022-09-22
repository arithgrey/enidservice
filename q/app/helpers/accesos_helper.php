<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render_time_line($accesos)
    {
    
        $ips = array_count_values(array_column($accesos,  "ip"));
        $response = [];
        $es_telefono = "";
        $interacciones_positivas = 0;
        $interacciones_negativas = 0;

        $interacciones_positivas_telefono = 0;
        $interacciones_positivas_desktop = 0;


        $interacciones_negativas_telefono = 0;
        $interacciones_negativas_desktop = 0;

        $is_mobile = 0;
        foreach ($ips as $clave => $valor) {

            $item = [];
            
            foreach ($accesos as $acceso) {
                

                if ($clave === $acceso["ip"]) {
                    
                    $es_telefono =  ($acceso["is_mobile"]) ? "Teléfono": "Desktop";
                    $is_mobile = $acceso["is_mobile"];
                    $pagina =  $acceso["pagina"];
                    $http_referer = $acceso["http_referer"];
                    $fecha_registro = $acceso["fecha_registro"];
                    $id_servicio = $acceso["id_servicio"];
                    $ip = $acceso["ip"];

                    $contenido = [];
                    $contenido[] = d($pagina, "strong fp9 row");

                    if (strlen($http_referer) > 5) {
                        $link = a_enid("Link entrante", ["href" => $http_referer]);
                        $contenido[] = d($link, "fp7 row");
                    }

                    if ($id_servicio > 0) {
                        $link = path_enid("producto", $id_servicio);
                        $imagen  = d(a_enid(img($acceso["url_img_servicio"]), ["href" => $link, "target" => "_blank"]), "w_50");
                        $contenido[] = d($imagen, "fp7 row");                        
                    }
                    $contenido[] = d($fecha_registro, "fp7 row");
                    $contenido[] = d($ip, "fp7 row");
                    $item[] = d($contenido, "col-md-3");
                    
                }
                
            }
            
            $interpretacion = [];
            $interpretacion[]  = d($clave);
            $interpretacion[]  = d(d($es_telefono));
            $interpretacion[] = d(_text_( span($valor, 'strong'), "Interacciones"));
            
            if($valor > 5){
                
                $interacciones_positivas ++;
                if($is_mobile){
                    $interacciones_positivas_telefono ++;
                }else{
                    $interacciones_positivas_desktop ++;
                }

            }else{

                $interacciones_negativas ++;

                if($is_mobile){
                    $interacciones_negativas_telefono ++;
                }else{
                    $interacciones_negativas_desktop ++;
                }

            }
            $resumen = flex($interpretacion, _text_(_between, "f11 black"));
            $response[] = d($resumen, 'row mt-5 mb-1');
            $response[] = d($item, 'nuevo_usuario_time_line border border-secondary row p-2');
        }

        $texto = _text_("Personas distintas desde tráfico entrante", count($ips));
        $data_complete[]  = hiddens(["class" => "personas_trafico", "value" => count($ips)]);
        $data_complete[]  = hiddens(["class" => "personas_interacciones_positivas", "value" => $interacciones_positivas]);
        $data_complete[]  = hiddens(["class" => "personas_interacciones_negativas", "value" => $interacciones_negativas]);

        $data_complete[]  = hiddens(["class" => "personas_interacciones_positivas_telefono", "value" => $interacciones_positivas_telefono]);
        $data_complete[]  = hiddens(["class" => "personas_interacciones_positivas_desktop", "value" => $interacciones_positivas_desktop]);

        $data_complete[]  = hiddens(["class" => "personas_interacciones_negativas_telefono", "value" => $interacciones_negativas_telefono]);
        $data_complete[]  = hiddens(["class" => "personas_interacciones_negativas_desktop", "value" => $interacciones_negativas_desktop]);


        $data_complete[]  = d(d($texto,"row strong f12"),12);
        $data_complete[] =  d($response, 12);
        return append($data_complete);
    }
}
