<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render($data)
    {
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


        $usuarios = $data["usuarios"];
        $accesos = $data["accesos"];

        if (es_data($accesos) || es_data($accesos)) {

            $usuarios_por_fechas = array_column($usuarios, 'fecha_registro');
            $usuarios_fechas = array_count_values($usuarios_por_fechas);

            $linea = [];
            $class_titulos = 'col-xs-4 text-center black';
            $linea[] = d(_titulo('Día de registro', 4), $class_titulos);
            $linea[] = d(_titulo('Accesos a langind page', 4), $class_titulos);
            $linea[] = d(_titulo('Personas registradas', 4), $class_titulos);
            $lineas_registros[] = d($linea, 'row border border-secondary');

            $total_usuarios = 0;
            $total_accesos = 0;
            $fechas = fechas($data);
            foreach ($fechas as $fecha) {

                $linea = [];
                $numero_usuarios = busqueda_fecha_usuario($usuarios_fechas, $fecha);
                $numero_accesos = busqueda_fecha_acceso($accesos,  $fecha);

                $class = 'col-xs-4 text-center mt-3';
                $linea[] = d($fecha, $class);
                $linea[] = d($numero_accesos, $class);
                $linea[] = d($numero_usuarios, $class);
                $lineas_registros[] = d($linea, 'row mt-2 border-bottom border-secondary');
                $total_usuarios = $total_usuarios + $numero_usuarios;
                $total_accesos = $total_accesos +  $numero_accesos;
            }


            $texto = _text_(
                'Ingresos de comisionistas del ',
                $data["fecha_inicio"],
                'al',
                $data["fecha_termino"]
            );

            $response[] = d(_titulo($texto, 2), 'text-center');
            $totales = flex(
                _text_("Usuarios", $total_usuarios),
                _text_("Accesos", $total_accesos),
                "mt-5 f13 black underline",
                "mr-3"
            );

            $response[] = d(
                $totales
            );

            $link_actividad = a_enid("Mira los nuevos ingresos y sus actividades",
            [
                "href" => path_enid("busqueda"),
                "class" => "mb-5"
            ]);
            $response[] = d(
                $link_actividad
            );

            $response[] = append($lineas_registros);
        }


        return d($response, 8, 1);
    }
    function busqueda_fecha_acceso($accesos,  $fecha)
    {

        $total = 0;

        if (es_data($accesos)) {

            foreach ($accesos as $row) {

                $fecha_registro  = $row["fecha_registro"];
                if ($fecha_registro == $fecha) {

                    $total = $row["accesos"];
                }
            }
        }

        return $total;
    }
    function busqueda_fecha_usuario($usuarios_fechas, $fecha)
    {

        $total = 0;

        if (es_data($usuarios_fechas)) {

            foreach ($usuarios_fechas as $clave => $valor) {

                if ($clave == $fecha) {
                    $total = $valor;
                }
            }
        }

        return $total;
    }
    function fechas($data)
    {

        $usuarios = $data["usuarios"];
        $accesos = $data["accesos"];

        $usuarios_por_fechas = [];
        $accesos_fechas  = [];
        if (es_data($usuarios)) {

            $usuarios_por_fechas = array_column($usuarios, 'fecha_registro');
        }
        if (es_data($accesos)) {
            $accesos_fechas = array_column($accesos, 'fecha_registro');
        }
        $fechas = array_merge($accesos_fechas, $usuarios_por_fechas);
        $fechas = array_unique($fechas);           
        return $fechas;
    }
}
