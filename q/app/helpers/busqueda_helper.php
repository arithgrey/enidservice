<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function conexiones($usuarios, $id_seguidor, $titulo = "descubre otras cuentas",  $clase_descarte = 'descarte', $clase_conexion = 'conexion')
    {


        $response = [];
        foreach ($usuarios as $row) {

            $id_vendedor = $row['id'];
            if ($id_vendedor !== $id_seguidor) {
                $nombre_vendedor = format_nombre($row);
                $path_imagen = $row['url_img_usuario'];
                $seccion_nombre_vendedor = p($nombre_vendedor, 'black fp7');

                $seccion = [];

                $class = _text_(_eliminar_icon, 'mr-3 ', $clase_descarte);
                $atributos = ["id" => $id_vendedor];

                $seccion[] = d(icon($class, $atributos), 'text-right');
                $imagen = img(
                    [
                        "src" => $path_imagen,
                        "onerror" => "this.src='../img_tema/user/user.png'",
                        'class' => 'mx-auto d-block rounded-circle mah_50'
                    ]
                );
                $imagen_link = a_enid($imagen, path_enid('usuario_contacto', $id_vendedor));
                $seccion[] = d($imagen_link, 'mt-4');
                $seccion[] = d(_text_( $row["ha_vendido"], "Ventas"), 'text-center fp9 black underline');
                $seccion[] = d($seccion_nombre_vendedor, 'text-center text-uppercase mt-4');
                $seguir = d("seguir", ['class' => 'strong black', "id" => $id_vendedor]);

                $atributos = [
                    "class" => _text_('text-center border border-info rounded_enid
                    col-sm-8 col-sm-offset-2 cursor_pointer ', $clase_conexion),
                    "id" => $id_vendedor
                ];
                $seccion[] = d($seguir, $atributos);

                $response[] = d($seccion, 'col-md-2 col-xs-6 borde_end d-flex flex-column justify-content-between h-100 p-3');
            }
        }

        if (es_data($usuarios)) {

            $contenido[] = d(_titulo($titulo, 4), 'titulo_otras_cuentas row');
        }

        $contenido[] = d($response, 13);
        return append($contenido);
    }


    function seccion_totales_seguimiento($data)
    {

        $seguidores = $data["total_seguidores"];
        $siguiendo = $data["total_siguiendo"];
        $id_usuario = $data["id_usuario"];
        $id_seguidor = $data["id_seguidor"];
        $ventas = $data["ventas"];

        $texto_seguidores = flex($seguidores, "Seguidores", "font-weight-bold blue_linkeding", "mr-2 ");
        $texto_seguiendo = flex($siguiendo, "Siguiendo", "font-weight-bold blue_linkeding", "mr-2 ml-2");
        $texto_ventas = flex($ventas, "Ventas", "font-weight-bold blue_linkeding", "mr-2 ml-2");

        $line = d("|", "text-secondary");
        $elementos = [$texto_seguidores, $line, $texto_seguiendo, $line, $texto_ventas];
        $resumen = d($elementos, _text_("d-flex", _between));
        return ($id_seguidor == $id_usuario) ? a_enid($resumen, path_enid("conexiones")) : $resumen;
    }

    function render_actividad($actividades, $ventas_like, $id_seguidor, $obj_session)
    {
        $response[] = d(_titulo("noticias", 4), "mt-5 d-block d-md-none  text-center");
        $response[] = actividad($actividades, $ventas_like, $id_seguidor, $obj_session);
        return d($response);
    }

    function actividad($actividades, $ventas_like, $id_seguidor, $obj_session)
    {


        sksort($actividades, "fecha_registro");
        $response = [];
        $rand = rand(5,10);
        $a  = 0;
                
        foreach ($actividades as $row) {

            $id_usuario_venta = $row["id_usuario_referencia"];
            $id_servicio = $row["id_servicio"];
            $idtipo_comisionista = $row["idtipo_comisionista"];
            $id_usuario_conexion = $row["id_usuario"];
            $id_recibo = $row["id"];
            $path_imagen_usuario = $row["url_img_usuario"];
            $url_img_servicio = $row["url_img_servicio"];
            $vendedor = format_nombre($row);
            $fecha_entrega = date_create($row["fecha_entrega"])->format('Y-m-d');

            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_entrega);

            $texto = ($dias > 1) ? _text_('Hace', $dias, 'días') : 'ayer';
            $texto_dias = ($dias < 1) ? "hoy" : $texto;
            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            $comision_venta = money($row["comision_venta"] * $num_ciclos_contratados);
            $imagen = img(
                [
                    "src" => $path_imagen_usuario,
                    "onerror" => "this.src='../img_tema/user/user.png'",
                    'class' => 'px-auto mt-4',
                    "style" => "width: 40px!important;height: 35px!important;",
                ]
            ); 
            


            $imagen_usuario = d(
                $imagen,
                ""
            );

            $tipo_comisionista = format_tipo_comisionista($obj_session, $idtipo_comisionista);
            $nombre_categoria = flex($vendedor, $tipo_comisionista, "flex-column", "strong", "fp9");
            $nombre_vendedor = a_enid(
                $nombre_categoria,
                [
                    "href" => path_enid("usuario_contacto", $id_usuario_venta),
                    "target" => "_black",
                    "class" => "black"
                ]
            );

            $imagen_usuario = a_enid(
                $imagen_usuario,
                [
                    "href" => path_enid("usuario_contacto", $id_usuario_venta),
                    "target" => "_black",
                    "class" => "black"
                ]
            );

            $vendedor_entrega = flex($nombre_vendedor, $texto_dias, 'flex-column', "", "fp8 text-secondary");
            $imagen_nombre = flex($imagen_usuario, $vendedor_entrega, "align-items-center ", "mr-5");

            $elemento = [];
            $elemento[] = $imagen_nombre;

            $estrella = d("", _text_(_estrellas_icon, "blue_enid"));
            $elemento[] = flex($estrella, "Vendió", " strong mt-3", "mr-4");

            $texto_comision = flex("Ganancia", $comision_venta, "mr-4", "mr-2");
            $texto_productos_vendidos = flex("Artículos", $num_ciclos_contratados, "", "mr-2");
            $elemento[] = d([$texto_comision, $texto_productos_vendidos], "d-flex fp8 black");

            $imagen = img(
                [
                    "src" => $url_img_servicio,
                    "class" => "mh-auto"
                ]
            );

            $imagen_link = a_enid($imagen, ["href" => path_enid("producto", $id_servicio)]);
            $elemento[] = d($imagen_link, "d-block mt-4");
            $total_like = $row["total_like"];
            $es_like = valida_venta_like($ventas_like, $id_recibo, $id_seguidor);
            $extra = ($es_like > 0) ? 'text-info strong' : 'text-secondary';


            $attr = [
                "class" => _text_(_like_icon, 'mt-4 mb-4 like_actividad', $extra),
                "id" => $id_usuario_conexion,
                "cantidad" => $total_like
            ];

            $elemento[] = flex(d("", $attr), $total_like, "align-items-center ", "mr-2");
            $response[] = d($elemento, "mt-3 mb-3 border-bottom bg-white col-sm-12");

            if($a == $rand){
                $place = d("",'seccion_nuevos_ingresos');
                $response[] = d($place, "mt-3 mb-3 border-bottom bg-white col-sm-12");
            }                   

            $a ++;



        }
        return d($response, "mt-5 bg-light ");
    }

    function valida_venta_like($ventas_like, $id_recibo, $id_usuario)
    {

        $lke = 0;
        foreach ($ventas_like as $row) {

            $id_recibo_like = $row["id_recibo"];
            $id_usuario_like = $row["id_usuario"];

            if ($id_recibo_like == $id_recibo && $id_usuario_like == $id_usuario) {
                $lke++;
            }
        }
        return $lke;
    }
}
