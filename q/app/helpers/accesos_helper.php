<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render_time_line($accesos)
    {
    
        $ips = array_count_values(array_column($accesos,  "ip"));
        $response = [];
        $es_telefono = "";

        foreach ($ips as $clave => $valor) {

            $item = [];

            foreach ($accesos as $acceso) {

                if ($clave === $acceso["ip"]) {
                    $es_telefono =  ($acceso["is_mobile"]) ? "Teléfono": "Desktop";
                    $pagina =  $acceso["pagina"];
                    $http_referer = $acceso["http_referer"];
                    $fecha_registro = $acceso["fecha_registro"];
                    $id_servicio = $acceso["id_servicio"];

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
                    $item[] = d($contenido, "col-md-3");
                    
                }
                
            }
            
            $interpretacion = [];
            $interpretacion[]  = d($clave);
            $interpretacion[]  = d(d($es_telefono));
            $interpretacion[] = d(_text_( span($valor, 'strong'), "Interacciones"));
            
            $resumen = flex($interpretacion, _text_(_between, "f11 black"));
            $response[] = d($resumen, 'row mt-5 mb-1');
            $response[] = d($item, 'nuevo_usuario_time_line border border-secondary row p-2');
        }
        return d($response, 12);
    }
}
