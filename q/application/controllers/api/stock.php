<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Stock extends REST_Controller
{
    public $option;
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("stock");
        $this->load->library("table");
        $this->load->model("stock_model");
        $this->load->library(lib_def());
    }

    function descuento_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_stock,unidades")) {

            $unidades = $param['unidades'];
            $id_stock = $param['id_stock'];
            $response = $this->stock_model->q_up('unidades', $unidades, $id_stock);

        }

        $this->response($response);
    }

    function fecha_ingreso_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_stock,hora_fecha")) {

            $fecha_hora = $param['hora_fecha'];
            $id_stock = $param['id_stock'];
            $response = $this->stock_model->q_up('fecha_registro', $fecha_hora, $id_stock);

        }

        $this->response($response);
    }

    function servicio_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            if (prm_def($param, 'costo')) {
                $in = ['id_servicio' => $param['id_servicio']];
                $response = $this->stock_model->get(['costo_unidad'], $in, 1, 'fecha_registro', 'ASC');
                $response = (es_data($response)) ? pr($response, 'costo_unidad') : 0;
            } else {

                $response = $this->stock_model->get();
            }

        }

        $this->response($response);
    }


    function inventario_GET()
    {

        $param = $this->get();
        $response = $this->stock_model->inventario();
        $this->response($response);
    }

    function disponibilidad_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $response = $this->stock_model->disponibilidad($param['id_servicio']);
            $response = $this->descuento_en_stock($param, $response);

        }
        $this->response($response);

    }

    private function gestiona_stock($param, $stock_disponible, $cantidad)
    {
        $total = $cantidad;
        $unidades_por_consumir_stock = [];
        $costo_unidad = 0;
        if (es_data($stock_disponible)) {
            foreach ($stock_disponible as $row) {

                $id_stock = $row['id_stock'];
                $unidades = $row['unidades'];
                $consumo = $row['consumo'];
                if ($costo_unidad < 1) {

                    $costo_unidad = $row['costo_unidad'];
                }

                $disponible_en_este_stock = ($unidades - $consumo);

                if ($total > 0) {

                    if ($disponible_en_este_stock >= $total) {

                        $cantidad_descuento_stock = $total;
                        $total = 0;

                    } else {

                        $cantidad_descuento_stock = $disponible_en_este_stock;
                        $total = ($total - $disponible_en_este_stock);
                    }
                    $unidades_por_consumir_stock[] =
                        [
                            'id_stock' => $id_stock,
                            'unidades_por_descontar' => $cantidad_descuento_stock,
                            'es_posible_el_descuento' => 1
                        ];
                }
            }
            if ($total > 0) {

                $unidades_por_consumir_stock[] = [
                    "id_stock" => 0,
                    "unidades_por_descontar" => $total,
                    "es_posible_el_descuento" => 0
                ];
            }

        } else {

            $unidades_por_consumir_stock[] = [
                "id_stock" => 0,
                "unidades_por_descontar" => $cantidad,
                "es_posible_el_descuento" => 0
            ];

        }


        return $this->gestiona_stock_db($param, $unidades_por_consumir_stock, $costo_unidad);
    }

    private function gestiona_stock_db($param, $unidades_stock, $costo_unidad)
    {

        $response = [
            'costo_unidad' => $costo_unidad,
            'unidades_stock' => $unidades_stock
        ];
        $gestion = [];
        foreach ($unidades_stock as $row) {

            $id_stock = $row['id_stock'];
            $unidades_por_descontar = $row['unidades_por_descontar'];
            $es_posible_el_descuento = $row['es_posible_el_descuento'];
            if ($es_posible_el_descuento > 0) {

                $status = $this->consumo_stock($unidades_por_descontar, $id_stock);
                $gestion[] = [
                    'status' => $status,
                    'id_stock' => $id_stock
                ];

            } else {

                $id_servicio = $param['id_servicio'];
                $params = [
                    'costo_unidad' => 0,
                    'unidades' => ($unidades_por_descontar * -1),
                    'id_servicio' => $id_servicio,
                    'es_consumo_negativo' => 1,
                    'consumo' => $unidades_por_descontar
                ];
                $id_stock = $this->stock_model->insert($params, 1);
                $gestion[] = [
                    'id_stock' => $id_stock,
                    'es_consumo_negativo' => 1
                ];

            }
        }
        $response[] = $gestion;
        return $response;
    }

    private function descuento_en_stock($param, $stock_disponible)
    {
        $descuento = prm_def($param, 'descuento');
        $cantidad = prm_def($param, 'cantidad');
        $descuento_en_stock = ($descuento > 0 && $cantidad > 0);


        if ($descuento_en_stock) {

            return $this->gestiona_stock($param, $stock_disponible, $cantidad);

        } else {

            return $stock_disponible;
        }

    }

    function consumo_stock($consumo, $id_stock)
    {


        return $this->stock_model->consumo($consumo, $id_stock);
    }


    function ingresos_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "stock,costo,id_servicio")) {

            $id_servicio = $param['id_servicio'];
            $costo = $param['costo'];
            $stock_deuda = $this->stock_model->deuda($id_servicio);
            $stock = $param['stock'];
            if (count($stock_deuda) > 0) {

                $response = $this->gestiona_stock_deuda($param, $stock_deuda, $stock);
            } else {

                $response = $this->agregar_inventario($costo, $stock, $id_servicio);
            }


        }
        $this->response($response);
    }

    function gestiona_stock_deuda($param, $stock_deuda, $stock_ingresado)
    {

        $lista_por_pago = [];
        $stock_ingresado_disponible = $stock_ingresado;
        foreach ($stock_deuda as $row) {

            $id_stock = $row['id_stock'];
            $unidades = $row['unidades'];
            $deuda = ($unidades * -1);
            if ($stock_ingresado_disponible > 0) {

                if ($stock_ingresado_disponible >= $deuda) {

                    $lista_por_pago[] = [
                        'id_stock' => $id_stock,
                        'deuda_por_pagar' => $deuda,
                        'es_pago' => 1,
                        'ingresos' => 0,

                    ];
                    $stock_ingresado_disponible = ($stock_ingresado_disponible - $deuda);
                } else {


                    $lista_por_pago[] = [
                        'id_stock' => $id_stock,
                        'deuda_por_pagar' => $stock_ingresado_disponible,
                        'ingresos' => 0,
                        'es_pago' => 1

                    ];
                    $stock_ingresado_disponible = 0;
                }
            }


            if ($stock_ingresado_disponible > 0) {

                $lista_por_pago[] = [
                    'id_stock' => 0,
                    'deuda_por_pagar' => 0,
                    'ingresos' => $stock_ingresado_disponible,
                    'es_pago' => 0
                ];
            }


        }

        return $this->gestiona_stock_deuda_db($param, $lista_por_pago);
    }

    function gestiona_stock_deuda_db($param, $lista_por_pago)
    {
        $id_servicio = $param['id_servicio'];
        $costo = $param['costo'];

        $response = true;

        foreach ($lista_por_pago as $row) {

            $id_stock = $row['id_stock'];
            $deuda_por_pagar = $row['deuda_por_pagar'];
            $ingresos = $row['ingresos'];
            $es_pago = $row['es_pago'];
            if ($es_pago > 0) {
                $response = $this->stock_model->pago_deuda($id_stock, $deuda_por_pagar, $costo);
            } else {

                $response = $this->agregar_inventario($costo, $ingresos, $id_servicio);
            }
        }
        return $response;

    }

    function agregar_inventario($costo, $stock, $id_servicio)
    {

        $params = [
            'costo_unidad' => $costo,
            'unidades' => $stock,
            'id_servicio' => $id_servicio,
        ];

        $response = $this->stock_model->insert($params, 1);
        if ($response > 0) {
            $response = $this->anexar_inventario($id_servicio, $stock);
        }
        return $response;
    }

    function compras_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,tipo")) {

            $solicitudes_contra_entrega = $this->get_solicitudes_contra_entrega($param);
            $pedidos_servicio = crea_resumen_servicios_solicitados($solicitudes_contra_entrega);
            $pedidos_servicio = $this->agrega_stock_servicios($pedidos_servicio);
            $response = $this->asocia_servicio_solicitudes($pedidos_servicio, $param["tipo"]);
            $compras_por_enviar = $this->get_compras_por_enviar();

            if (prm_def($param, "v") > 0) {

                $response = $this->create_table_compras($response, $compras_por_enviar);

            }
        }
        $this->response($response);
    }

    private
    function create_table_compras($servicios, $compras_por_enviar)
    {


        $base = 'col-md-1 border text-uppercase bg_black white';
        $titulos[] = d('#', $base);
        $titulos[] = d('SERVICIO', $base);
        $titulos[] = d('En STOCK ', $base);
        $titulos[] = d("PEDIDOS CONTRA ENTREGA", 'col-md-2 border  text-uppercase  bg_black white');
        $titulos[] = d("CASOS IDENTICO", $base);
        $titulos[] = d("PRONOSTICO  VENTAS (A)", $base);
        $titulos[] = d("PRONOSTICO VENTAS (B)", $base);
        $titulos[] = d("ADQUIRIDAS ENID", $base);
        $titulos[] = d("OTRAS PLATAFORMAS", $base);
        $titulos[] = d("COMPRAR OPCIÓN (A)", $base);
        $titulos[] = d("COMPRAR OPCIÓN (B)", $base);
        $response[] = d($titulos, 13);


        $b = 1;
        $compras = [];
        $comparativa = [];
        for ($a = 0; $a < count($servicios); $a++) {

            $id_servicio = $servicios[$a]["id_servicio"];
            $stock = $servicios[$a]["stock"];
            $pedidos_contra_entrega = $servicios[$a]["pedidos_contra_entrega"];

            $total_pedidos_contra_entrega = $servicios[$a]["total_pedidos_contra_entrega"];
            $total_entregas_contra_entrega = $servicios[$a]["total_entregas_contra_entrega"];
            $pedidos = $servicios[$a]["pedidos"];
            $resumen = $this->get_format_resumen(
                $total_pedidos_contra_entrega . " / " . $total_entregas_contra_entrega,
                $pedidos,
                $pedidos_contra_entrega, $id_servicio
            );
            $sugerencia = $resumen["sugerencia"];
            $sugerencia_b = $resumen["sugerencias_b"];
            $comparativa[] = $resumen['comparativa'];
            $img = img(
                [
                    "class" => "img - responsive img_servicio_compras",
                    "src" => link_imagen_servicio($id_servicio),
                ]
            );

            $img = a_enid($img, get_url_servicio($id_servicio));
            $total_enid = $this->get_ventas_tipo(1, $compras_por_enviar, $id_servicio);
            $total_otras = $this->get_ventas_tipo(2, $compras_por_enviar, $id_servicio);
            $total_compras = ($sugerencia + $total_enid + $total_otras) - $stock;
            $total_compras_b = ($sugerencia_b + $total_enid + $total_otras) - $stock;


            $linea = [];


            $base = 'col-md-1 border text-uppercase fp8 text-center';
            $base_stock = [
                'class' => 'col-md-1 
                border text-uppercase fp8 text-center 
                stock_disponible 
                underline strong cursor_pointer',
                'id' => $id_servicio,
                'total' => $stock
            ];
            $linea[] = d($b, $base);
            $linea[] = d($img, $base);
            $linea[] = d($stock, $base_stock);
            $linea[] = d($pedidos_contra_entrega, 'col-md-2 border  text-uppercase text-center ');
            $linea[] = d($resumen["text"],
                [
                    'class' => _text_($base, 'comparativas cursor_pointer'),
                    'id' => $id_servicio
                ]
            );
            $linea[] = d($sugerencia, $base);
            $linea[] = d($sugerencia_b, $base);
            $linea[] = d($total_enid, $base);
            $linea[] = d($total_otras, $base);
            $linea[] = d($total_compras, $base);
            $linea[] = d($total_compras_b, $base);
            $compras[] = d($linea, 13);

            $b++;
        }

        $response[] = append($compras);
        $response[] = append($comparativa);
        return append($response);

    }

    private function get_ventas_tipo($tipo, $compras_pagas, $id_servicio)
    {

        $compras = 0;
        foreach ($compras_pagas as $row) {
            if ($tipo == 1) {
                if (($row["tipo_entrega"] == 1 || $row["tipo_entrega"] == 2 || $row["tipo_entrega"] == 3) && $row["id_servicio"] == $id_servicio) {
                    $compras = $compras + $row["ventas_pagas_sin_envio"];
                }
            } else {
                if ($row["tipo_entrega"] == 4 && $row["id_servicio"] == $id_servicio) {
                    $compras = $compras + $row["ventas_pagas_sin_envio"];
                }
            }
        }
        return $compras;
    }

    private
    function get_ventas_fecha($fecha, $ventas)
    {

        $venta = 0;
        for ($a = 0; $a < count($ventas); $a++) {


            if ($fecha == $ventas[$a]["fecha_entrega"]) {

                $venta = $ventas[$a]["solicitudes"];

            }
        }
        return $venta;

    }

    private
    function get_format_resumen($resumen, $pedidos, $pedidos_contra_entrega, $id_servicio)
    {

        $solicitudes = $pedidos["solicitudes"];
        $entregas = $pedidos["entregas"];

        $table = "<table  border='1' class='text-center mt-5'>";
        $table .= "<tr>";
        $table .= td("FECHA");
        $table .= td("SOLICITUDES");
        $table .= td("VENTAS");
        $table .= "</tr>";

        $promedio = [];
        $relevante = [];
        $secundaria = [];
        $media = [];

        for ($a = 0; $a < count($solicitudes); $a++) {


            $fecha_contra_entrega = $solicitudes[$a]["fecha_contra_entrega"];
            $solicitud = $solicitudes[$a]["solicitudes"];

            $class = ($pedidos_contra_entrega == $solicitud) ? "caso_exacto" : "";
            $t = "<tr class='" . $class . "'>";
            $t .= td($fecha_contra_entrega);
            $ventas_efectivas = $this->get_ventas_fecha($fecha_contra_entrega, $entregas);
            $t .= td($solicitud);
            $t .= td($ventas_efectivas);

            $t .= "</tr>";

            if ($pedidos_contra_entrega == $solicitud) {

                $relevante[] = $t;
                $promedio [] = ["solicitud" => $solicitud, "ventas_efectivas" => $ventas_efectivas];

                $media[$ventas_efectivas] = (!array_key_exists($ventas_efectivas, $media)) ? 1 : ($media[$ventas_efectivas] + 1);


            } else {

                $secundaria[$ventas_efectivas] = (!array_key_exists($ventas_efectivas, $secundaria)) ? 1 : ($secundaria[$ventas_efectivas] + 1);

            }
        }


        for ($a = 0; $a < count($relevante); $a++) {
            $table .= $relevante[$a];
        }

        $table .= "</table>";
        $tabla_porcentaje = $this->get_tabla_porcentajes($media, $pedidos_contra_entrega, count($relevante));

        $totales_casos = $this->get_max_min($tabla_porcentaje["totales"]);
        $completo = $totales_casos["completo"];
        asort($completo);
        $min = (es_data($completo)) ? $completo[0] : 0;
        $max = $totales_casos["max"];
        $text_resumen = count($relevante);

        $response_table = $table . $tabla_porcentaje["table"];
        $tabla_comprativas = d($response_table,
            [
                'class' => 'mt-5 tabla_comprativa d-none',
                'id' => $id_servicio

            ]
        );

        return [
            "text" => $text_resumen,
            "comparativa" => $tabla_comprativas,
            "promedios" => $promedio,
            "media" => $media,
            "sugerencia" => $max,
            "sugerencias_b" => $min
        ];

    }

    private
    function get_max_min($totales)
    {


        $max = 0;
        $min = array();

        foreach ($totales as $row) {
            if ($row["compras"] > $max) {
                $max = $row["compras"];
            }
            array_push($min, $row["compras"]);

        }
        $response = ["max" => $max, "completo" => $min];
        return $response;
    }

    private
    function get_tabla_porcentajes($media, $pedidos_contra_entrega, $total)
    {

        $table = "<table border='1' class='text-center'>";

        $table .= "<tr>";
        $table .= td("SOLICITUDES " . $pedidos_contra_entrega, ["colspan" => 3]);
        $table .= "</tr>";

        $table .= "<tr>";
        $table .= td("CASOS");
        $table .= td("PORCENTAJE");
        $table .= td("COMPRAS");
        $table .= "</tr>";

        $totales = [];
        $z = 0;
        foreach ($media as $key => $value) {
            $totales[$z] = ["casos" => $value, "compras" => $key];
            $table .= "<tr>";
            $table .= td($value);
            $table .= td(porcentaje_total($value, $total) . "%");
            $table .= td($key);
            $table .= "</tr>";
            $z++;
        }
        $table .= "</table>";
        return ["table" => $table, "totales" => $totales];

    }

    private
    function asocia_servicio_solicitudes($pedidos_servicio, $tipo)
    {
        $response = [];
        foreach ($pedidos_servicio as $row) {

            $id_servicio = $row["id_servicio"];
            $pedidos = $this->get_solicitudes_servicio_pasado($id_servicio, $tipo);
            $total_pedidos = count($pedidos["solicitudes"]);
            $total_entregas = count($pedidos["entregas"]);

            $response[] = [
                "id_servicio" => $id_servicio,
                "pedidos_contra_entrega" => $row["pedidos"],
                "stock" => $row["stock"],
                "total_pedidos_contra_entrega" => $total_pedidos,
                "total_entregas_contra_entrega" => $total_entregas,
                "pedidos" => $pedidos
            ];
        }
        return $response;
    }

    private
    function agrega_stock_servicios($servicios)
    {

        $response = [];
        for ($a = 0; $a < count($servicios); $a++) {

            $id_servicio = $servicios[$a]["id_servicio"];
            $response[] = [
                "id_servicio" => $id_servicio,
                "pedidos" => $servicios[$a]["pedidos"],
                "stock" => $this->get_stock_servicio($id_servicio)
            ];
        }
        return $response;
    }

    private
    function get_stock_servicio($id_servicio)
    {

        return $this->app->api("servicio/stock/format/json/", ["id_servicio" => $id_servicio]);
    }

    function anexar_inventario($id_servicio, $stock)
    {


        $q = [
            "id_servicio" => $id_servicio,
            'stock' => $stock,
            'anexar' => 1
        ];
        return $this->app->api("servicio/stock", $q, "json", "PUT");


    }


    private
    function get_solicitudes_servicio_pasado($id_servicio, $tipo = 1)
    {

        $q["tipo"] = $tipo;
        $q["id_servicio"] = $id_servicio;
        return $this->app->api("recibo/solicitudes_periodo_servicio/format/json/", $q);
    }

    private
    function get_solicitudes_contra_entrega($param)
    {

        $q["cliente"] = "";
        $q["recibo"] = "";
        $q["v"] = 0;
        $q["tipo_entrega"] = 0;
        $q["status_venta"] = 6;
        $q["tipo_orden"] = 5;
        $q["fecha_inicio"] = $param["fecha_inicio"];
        $q["fecha_termino"] = $param["fecha_inicio"];
        $q["perfil"] = $this->app->getperfiles();
        $q["id_usuario"] = $this->app->get_session("idusuario");


        return $this->app->api("recibo/pedidos/format/json/", $q);

    }

    private
    function get_compras_por_enviar()
    {

        $q[1] = 1;
        return $this->app->api("recibo/compras_por_enviar/format/json/", $q);

    }
}