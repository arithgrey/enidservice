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
        if (es_data($usuarios)) {

            $usuarios_por_fechas = array_column($usuarios, 'fecha_registro');
            $usuarios_fechas = array_count_values($usuarios_por_fechas);

            $linea = [];
            $linea[] = d(_titulo('Día de registro', 3), 6);
            $linea[] = d(_titulo('Personas ingresadas', 3), 'col-md-6 text-right black ');
            $lineas_registros[] = d($linea, 13);

            $total_usuarios = 0;
            foreach ($usuarios_fechas as $clave => $valor) {

                $linea = [];
                $linea[] = d($clave, 6);
                $linea[] = d($valor, 'col-md-6 text-right');
                $lineas_registros[] = d($linea, 'row mt-2 border-bottom');
                $total_usuarios = $total_usuarios + $valor;

            }

            $texto = _text_(
                'Ingresos de comisionistas del ',
                $data["fecha_inicio"],
                'al',
                $data["fecha_termino"]
            );

            $response[] = d(_titulo($texto, 2), 'text-center');
            $totales = flex(
                _titulo("Total", 5),
                $total_usuarios,
                "flex-column mb-5 "
            );
            $response[] = d(
                $totales,
                'text-right'
            );
            $response[] = append($lineas_registros);

        }

        return d($response, 8, 1);


    }


}
