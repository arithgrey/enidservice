<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


function render($data)
{
    $almacenes = $data["almacenes"];
    $inventario = $data["inventario"];
    $kits = $data["kits"];

    
    $response[] = inventario_almacenes($almacenes, $inventario, $kits);
    $response[] = modal_cambio_de_almacen();
    return append($response);
}
function kits($kits, $id_almacen){

    $response = [];

    foreach ($kits as $row) {
        
            
            $textos = d($row["nombre"], 'strong mt-2');            
            $id_kit = $row["id"];            
            

            $class =  'ui-widget-content draggable';
            $response[] = d(
                $textos,
                [
                    "class" => _text_("col-xs-6 p-2 mt-3 borde_black", $class),
                    "id_kit" => $id_kit,          
                    "id_almacen" =>  $id_almacen
                    
                ]
            );
        
    }
    return append($response);

}
function inventario_almacenes($almacenes, $inventario, $kits)
{

    $response = [];
    foreach ($almacenes as $row) {

        $id_almacen = $row["id"];
        $almacen = [];
        $almacen[] = d(span($row["nombre"], 'f12 strong'), 'col-xs-12 p-2');
        $almacen[] = d(inventario($inventario, $id_almacen, $kits), 12);
        $config = ["class" => "col-sm-6 droppable borde_black p-5 mt-5", "id" => $id_almacen];
        $response[] = d(d($almacen, 13), $config);
    }


    $data_complete[] = d(totales($inventario), 'col-sm-3');
    $data_complete[] =  d($response, 'col-sm-9');

    return d($data_complete, 10, 1);
}
function busqueda_totales($inventario)
{

    $totales = [];

    // Iterar sobre el arreglo de consumo
    foreach ($inventario as $item) {
        $id_servicio = $item['id_servicio'];
        $total_consumo = $item['total_consumo'];
        $total_unidades = $item['total_unidades'];
        $url_img_servicio = $item['url_img_servicio'];

        // Verificar si ya existe una entrada para el id_servicio
        if (isset($totales[$id_servicio])) {
            // Si existe, sumar los valores al existente
            $totales[$id_servicio]['total_consumo'] += $total_consumo;
            $totales[$id_servicio]['total_unidades'] += $total_unidades;
            $totales[$id_servicio]['url_img_servicio'] = $url_img_servicio;
            $totales[$id_servicio]['id_servicio'] = $id_servicio;
        } else {
            // Si no existe, crear una nueva entrada
            $totales[$id_servicio] = array(
                'total_consumo' => $total_consumo,
                'total_unidades' => $total_unidades,
                'url_img_servicio' => $url_img_servicio,
                'id_servicio' => $id_servicio
            );
        }
    }
    return  $totales;
}
function totales($inventario)
{

    $totales = busqueda_totales($inventario);
    $contenido[] = d("Inventario disponible",'row mb-3');   
    foreach ($totales as $row) {

        $url_img_servicio = $row['url_img_servicio'];
        $total_unidades = $row["total_unidades"];
        $total_consumo = $row["total_consumo"];

        $total =  ($total_unidades - $total_consumo);
        $extra = ($total < 1) ? 'error_enid' : '';
        $textos_disponibilidad = flex($total, "Pzs en existencia", _between, 'f12 strong');
        $img = img(
            [
                'src' => $url_img_servicio,
                'class' => "w_75"
            ]
        );

        $id_servicio = $row["id_servicio"];
        $img = a_enid($img, [
            "href" => path_enid("editar_producto", $id_servicio),
            "target" => "_blank"
        ]);

        $producto_unidades = flex($img, $textos_disponibilidad, _text_(_between, 'text-center ', $extra), 3, 9);


        $response[] = d(d(
            $producto_unidades,
            [
                "class" => _text_("col-xs-12"),
                "id" => $row["id_servicio"],
                "piezas_disponibles" => $total,

            ]
        ), 'row border border-secondary p-2');
    }

    $contenido[] = d($response);
    return d($contenido);
}

function inventario($inventario, $id_almacen,$kits)
{
    $response = [];
    $response[] = d(kits($kits,$id_almacen),'col-xs-12 p-2');
    foreach ($inventario as $row) {
        if ($id_almacen === $row["id_almacen"]) {
            $url_img_servicio = $row['url_img_servicio'];
            $total_unidades = $row["total_unidades"];
            $total_consumo = $row["total_consumo"];

            $total =  ($total_unidades - $total_consumo);
            $extra = ($total < 1) ? 'error_enid' : '';
            $textos_disponibilidad = flex("Pzs en existencia", $total, 'flex-column', 'strong mt-2', 'f15 strong');
            $img = img(
                [
                    'src' => $url_img_servicio,
                ]
            );

            $id_servicio = $row["id_servicio"];
            $img = a_enid($img, [
                "href" => path_enid("editar_producto", $id_servicio),
                "target" => "_blank"
            ]);

            $producto_unidades = flex($img, $textos_disponibilidad, _text_(_between, 'text-center borde_black', $extra), 6, 6);

            $class = ($total <  1) ? '' : 'ui-widget-content draggable';
            $response[] = d(
                $producto_unidades,
                [
                    "class" => _text_("col-xs-6 p-2", $class),
                    "id" => $row["id_servicio"],
                    "piezas_disponibles" => $total,
                    "id_almacen" =>  $id_almacen
                ]
            );
        }
    }
    return d($response, 13);
}

function modal_cambio_de_almacen()
{


    $str = _d(
        d(
            _titulo(
                _text_(
                    "¿Cuantas piezas moverás a este almacen?"
                )
            ),
            'mb-2 mt-4'
        ),
        d("", "place_disponibilidad mt-5"),
        btn("Confirmar", ["class" => "confirmar_stock mt-3"]),

    );

    $r[] = d($str, " d-flex flex-column justify-content-between ");



    return gb_modal($r, 'modal_cambio_almacen');
}
