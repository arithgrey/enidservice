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
    function imagen_servicio($data)
    {
        return d(img(
            [
                "src" => $data["url_img_servicio"],
                "class" => "img_servicio mah_150",

            ]
        ), 'col-md-12 mt-5');
    }
    function agregar($data)
    {

        $id_servicio  =  $data["id_servicio"];
        $base_boton_propuesta = [
            'class' => 'boton_agregar_propuesta cursor_pointer',
            'id' => $id_servicio,
        ];
        $agregar = btn("+ respuesta propuesta", $base_boton_propuesta);
        $imagen = d(img(
            [
                "src" => $data["url_img_servicio"],
                "class" => "img_servicio mah_150",

            ]
        ));

        $servicio =  a_enid($imagen, ['href' => path_enid('producto', $id_servicio)]);
        return d(flex($agregar, $servicio, _between),'col-md-12 mt-5');
    }
    function listado($data)
    {   
        
        $servicio = $data["servicio"];
        $precio  = pr($servicio,"precio");
        

        $propuestas  =  $data["propuestas"];
        $path_producto = $data["path_producto"];
        $response = [];
        $a = 1;
        if (es_data($propuestas)) {

            foreach ($propuestas as $row) {


                $eliminar = icon(
                    _text_(_eliminar_icon, 'eliminar_propuesta'),
                    [

                        "onclick" => "confirma_eliminar('" . $row["id"] . "')",
                    ]
                );
                $cantidad_eliminar =  flex(_titulo($a), $eliminar, _between);
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

        $tres_meses =  ($precio + porcentaje($precio, 8));
        $seis_meses =  ($precio + porcentaje($precio, 8));        
        $doce_meses =  ($precio + porcentaje($precio, 10));


        $tres_meses_aplicado =  $tres_meses / 3;
        $seis_meses_aplicado =  $seis_meses / 6;        
        $doce_meses_aplicado =  $doce_meses / 12;


        if($precio > 600){

            $porcentajes = d(d(                
                _text_(
                    d(_text_("El precio es de", _text("$",$precio))),
                    br(),
                    d("- Ó con tarjeta de crédito "),
                    br(),
                    d(_text_(_text("$",sprintf('%01.0f',$tres_meses)),"a 3 meses de", _text("$", sprintf('%01.2f',$tres_meses_aplicado)))),
                    d(_text_(_text("$",sprintf('%01.0f',$seis_meses)),"a  6 meses de", _text("$", sprintf('%01.2f',$seis_meses_aplicado)))),                    
                    d(_text_(_text("$",sprintf('%01.0f',$doce_meses))," 12 meses de", _text("$", sprintf('%01.2f',$doce_meses_aplicado))))
                ),
                'border p-5 mt-5',
                'mb-5'
            ),12);
            $response[] = d($porcentajes, 'col-sm-12');

        }
        




        $contenido = d(d(                
            _text_(
                d("Sigue este enlace para ver nuestro catálogo "),
                br(),
                d($path_producto)                
            ),
            'border p-5 mt-5',
            'mb-5'
        ),12);
        $response[] = d($contenido, 'col-sm-12');


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
