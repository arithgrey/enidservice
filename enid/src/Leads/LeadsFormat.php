<?php

namespace Enid\Leads;

use Enid\ServicioImagen\Format as FormatImgServicio;

class LeadsFormat
{
    private $recibo_model;
    private $servicio_imagen;
    function __construct($recibo_model)
    {

        $this->recibo_model =  $recibo_model;
        $this->servicio_imagen = new FormatImgServicio();
    }
    function recibos_sin_ficha_seguimiento()
    {

        $recibos =  $this->recibo_model->recibos_pagos_mayores_a_30_dias_sin_ficha_seguimiento();
        $recibos = $this->servicio_imagen->url_imagen_servicios($recibos);
        return $this->forma_ficha($recibos);
    }
    function recibos_sin_ficha_seguimiento_posibles_pagos()
    {

        $recibos =  $this->recibo_model->recibos_pagos_mayores_a_30_dias_sin_ficha_seguimiento_posibles_pagos();
        $recibos = $this->servicio_imagen->url_imagen_servicios($recibos);
        return $this->forma_ficha($recibos);
    }

    function forma_ficha($recibos)
    {
        
        $response = [];

        $a  = 0;

        foreach ($recibos as $row) {

            $id_usuario_venta = $row["id_usuario_referencia"];
            $resumen_pedido = $row["resumen_pedido"];
            $id_usuario = $row["id_usuario"];
            $url_img_servicio = $row["url_img_servicio"];
            
            $vendedor = format_nombre($row);
            $fecha_entrega = date_create($row["fecha_entrega"])->format('Y-m-d');

            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_entrega);

            $texto = ($dias > 1) ? _text_('Hace', $dias, 'días') : 'ayer';
            $texto_dias = ($dias < 1) ? "hoy" : $texto;
            $num_ciclos_contratados = $row["num_ciclos_contratados"];

            $imagen = img(
                [
                    "src" => '../img_tema/user/user.png',
                    'class' => 'px-auto mt-4',
                    "style" => "width: 40px!important;height: 35px!important;",
                ]
            );


            $imagen_usuario = d($imagen);
            $nombre_categoria = flex($vendedor, "", "flex-column", "strong", "fp9");
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
            $resumen_pedido = a_enid(
                $resumen_pedido,
                [
                    "href" => path_enid("usuario_contacto", $id_usuario),
                    "class" => "black "
                ]
            );
            $elemento[] = flex($estrella, $resumen_pedido, "border_black strong mt-3", "mr-4");
            $elemento[] = d(money($row["precio"]), " strong mt-3");

            $texto_comision = flex('Fecha de entrega', $fecha_entrega, "mr-4", "mr-2");
            $texto_productos_vendidos = flex("Artículos", $num_ciclos_contratados, "", "mr-2");
            $elemento[] = d([$texto_comision, $texto_productos_vendidos], "d-flex fp8 black");

            $imagen_servicio = img(
                [
                    "src" => $url_img_servicio,
                    "class" => "mh-auto"
                ]
            );

            $imagen_link = a_enid($imagen_servicio, ["href" => path_enid("usuario_contacto", $id_usuario)]);
            $elemento[] = d($imagen_link, "d-block mt-4");
            $total_like = $row["total_like"];

            $extra =  'text-secondary';


            $attr = [
                "class" => _text_(_like_icon, 'mt-4 mb-4 like_actividad', $extra),
                "id" => $id_usuario,
                "cantidad" => $total_like
            ];

            $elemento[] = flex(d("", $attr), $total_like, "align-items-center ", "mr-2");
            $response[] = d($elemento, "mt-3 mb-3 border-bottom bg-white col-sm-12");


            $a++;
        }
        return d($response, "mt-5 bg-light ");
    }
}
