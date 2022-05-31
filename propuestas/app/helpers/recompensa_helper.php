<?php

use App\View\Components\titulo;

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function propuestas($data)
    {

        $response[] = agregar($data);
        $response[] = listado($data);
        $response[] = modal_form_propuesta($data);

        return d($response, 10, 1);
    }
    function agregar($data)
    {

        $id_servicio  =  $data["id_servicio"];
        $base_boton_propuesta = [
            'class' => 'boton_agregar_propuesta cursor_pointer',
            'id' => $id_servicio,
        ];
        $agregar = btn("+ respuesta propuesta", $base_boton_propuesta);
        $servicio =  format_link('Servicio', ['href' => path_enid('producto', $id_servicio)]);
        return flex($agregar, $servicio, _between);
    }
    function listado($data)
    {

        $propuestas  =  $data["propuestas"];
        $response = [];
        $a = 1;
        if (es_data($propuestas)) {

            foreach ($propuestas as $row) {

                
                $eliminar = icon(_text_(_eliminar_icon, 'eliminar_propuesta'), 
                [
                    
                    "onclick" => "confirma_eliminar('".$row["id"]."')",
                ]);
                $cantidad_eliminar =  flex( _titulo($a), $eliminar, _between);
                $contenido = flex(
                    $cantidad_eliminar,
                    $row["propuesta"],
                    'flex-column border p-5 mt-5',
                    'mb-5'
                );
                $response[] = d($contenido, 'col-sm-12');
                $a++;
            }
        }
        return append($response);
    }
    function modal_form_propuesta($data)
    {

        $form[] = d(_titulo('Agrega una repuesta sugerencia'), 'mb-5');
        $form[] = d(hr());
        $form[] = form_open(
            "",
            [
                "class" => "form_propuesta_servicio",
                "method" => "POST"
            ]
        );

        $form[] =  d("", ["id" => "summernote"], 1);
        $form[] = hiddens(['name' => 'id_servicio', 'class' => 'id_servicio', 'value' => $data["id_servicio"]]);
        $form[] = btn('Registrar', ['class' => 'mt-5']);
        $form[] = form_close();

        return gb_modal(append($form), 'propuesta_servicio_modal');
    }
}
