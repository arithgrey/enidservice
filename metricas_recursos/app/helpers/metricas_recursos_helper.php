<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render($data)
    {

        $usuarios_comisionistas = $data["usuarios_comisionistas"];
        $ventas = $data["ventas"];

        $form[] = form_open("", ["class" => 'form_busqueda']);
        $form[] = frm_fecha_busqueda();
        $form[] = form_close();

        $response[] = d(d(
            append($form),
            [
                "class" => "tab-pane active col-sm-12",
                "id" => 'tab_default_1',
            ]
        ), 'row mb-5');

        $a = 0;

        if (es_data($usuarios_comisionistas)) {

            $fecha_inicio = $data["fecha_inicio"];
            $fecha_termino = $data["fecha_termino"];

            $linea = [];
            $linea[] = d(_titulo('Comisionista', 2), 'col-sm-3 text-uppercase');
            $linea[] = d(_titulo('Ventas', 2), 'col-sm-3 text-center text-uppercase');
            $linea[] = d(_titulo('Días activo', 2), 'col-sm-3 text-center text-uppercase');

            $metricas[] = d($linea, 13);

            $ventas_por_vendedor = [];

            if (es_data($ventas)) {
                $ventas_vendedor = array_column($ventas, 'id_usuario_referencia');
                $ventas_por_vendedor = array_count_values($ventas_vendedor);
            }

            $total = 0;
            $total_ventas_usuarios = 0;
            $ids_usuarios_ventas = [];
            foreach ($usuarios_comisionistas as $row) {

                $id_usuario = $row["idusuario"];
                $linea = [];
                $linea[] = d(
                    a_enid(
                        format_nombre($row),
                        [

                            'href' => path_enid('usuario_contacto', $id_usuario),
                            'target' => '_black',
                            'class' => 'black'
                        ]
                    ),
                    'col-sm-3 text-uppercase'
                );

                $total_ventas = 0;
                foreach ($ventas_por_vendedor as $clave => $valor) {
                    if ($id_usuario == $clave) {
                        $total_ventas = $valor;
                        if ($total_ventas > 0) {
                            $a++;
                            $total_ventas_usuarios = $total_ventas_usuarios + $valor;
                            $ids_usuarios_ventas[] = $id_usuario;
                        }
                        break;
                    }
                }

                $fecha_registro = $row["fecha_registro"];
                $fecha = horario_enid();
                $hoy = $fecha->format('Y-m-d');
                $dias = date_difference($hoy, $fecha_registro);
                if ($dias == 0) {
                    $dias = 'Se registró hoy';
                }

                $extra = ($total_ventas > 0) ? '' : 'bajo_en_ventas';
                $linea[] = d($total_ventas, _text_($extra, 'text-center col-sm-3'));
                $linea[] = d($dias, 'text-center col-sm-3 black');
                $metricas[] = d($linea, 'row mt-3 border-bottom');
                $total++;
            }


            $contenido = [];
            $contenido[] = d(_titulo(_text_("#", $total), 3), 'col-sm-3 text-uppercase');
            $contenido[] = d(
                _titulo(
                    _text_("#", $total_ventas_usuarios), 3),
                'col-sm-3 text-center text-uppercase'
            );
            $array_usuarios_ventas = array_unique($ids_usuarios_ventas);
            $contenido[] = d(
                _titulo(
                    _text_("Vendedores que vendieron", count($array_usuarios_ventas)), 3),
                'col-sm-3 text-center text-uppercase'
            );


            $contenido[] = d("", 'col-sm-3 text-uppercase');
            $metricas[] = d($contenido, 13);


            $leyenda= _text_(
                'Ventas comiosionadas del ',
                $fecha_inicio ,
                'al' ,
                $fecha_termino
            );

            $texto = d(
                d(
                    p($leyenda,'text-justify text-center fp2'),
                    'col-lg-12 text-center f19 black'
                )  ,
                'row mt-5 mb-5'
            );


            array_unshift($metricas, d($contenido, 13));
            array_unshift($metricas, $texto);
            $response[] = append($metricas);


        }

        return d($response, 8, 1);


    }


}
