<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


function render($data)
{
    $almacenes = $data["almacenes"];
    $inventario = $data["inventario"];

    $response[] = inventario_almacenes($almacenes, $inventario);
    $response[] = modal_cambio_de_almacen();
    return append($response);
}
function inventario_almacenes($almacenes, $inventario)
{

    $response = [];
    foreach ($almacenes as $row) {

        $id_almacen = $row["id"];
        $almacen = [];
        $almacen[] = d(span($row["nombre"], 'f12 strong'), 'col-xs-12 p-2');
        $almacen[] = d(inventario($inventario, $id_almacen), 12);
        $config = ["class" => "col-sm-6 droppable borde_black p-5 mt-5", "id" => $id_almacen];
        $response[] = d(d($almacen, 13), $config);
    }

    return d(d($response, "row"), 10, 1);
}
function inventario($inventario, $id_almacen)
{
    $response = [];

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

            $producto_unidades = flex($img, $textos_disponibilidad, _text_(_between, 'text-center borde_black', $extra), 6, 6);

            $class = ($total <  1) ? '' : 'ui-widget-content draggable';
            $response[] = d(
                $producto_unidades,
                [
                    "class" => _text_("col-xs-6 col-lg-3 p-2", $class),
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
