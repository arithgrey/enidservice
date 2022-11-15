<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("procesar");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->post();        
        $tiene_num_ciclos = es_data($param) && array_key_exists("num_ciclos", $param);
        $num_ciclos = ($tiene_num_ciclos) ? ctype_digit($param["num_ciclos"]) : 0;
        $id_servicio = prm_def($param, 'id_servicio');
        $es_carro_compras = prm_def($param, "es_carro_compras");
        
        if ($num_ciclos > 0 && $id_servicio > 0 || $es_carro_compras) {
        
            $this->crea_orden_compra($param);
            
        } else {

            $this->add_domicilio_entrega($param);
        }
    }

    private function resumen_servicio($id_servicio)
    {

        return $this->app->api("servicio/resumen/", ["id_servicio" => $id_servicio]);
    }

    private function costo_envio_orden_compra($es_carro_compras, $data)
    {

        $response = "";
        if (!$es_carro_compras) {
            if ($data["servicio"][0]["flag_servicio"] == 0) {
                $response = $this->calcula_costo_envio($this->crea_data_costo_envio($data));
            }
        }
        return $response;
    }

    private function vendedor_orden_compra($es_carro_compras, $data)
    {

        $response = "";
        if (!$es_carro_compras) {
            if ($data["servicio"][0]["telefono_visible"] == 1) {
                $response =
                    $this->app->usuario($data["servicio"][0]["id_usuario"]);
            }
        }
        return $response;
    }

    private function complementos_carro_orden_compra($data, $es_carro_compras)
    {

        if ($es_carro_compras) {

            $data["info_solicitud_extra"]["num_ciclos"] = 0;
            $data["info_solicitud_extra"]["es_servicio"] = 0;
            $data["info_solicitud_extra"]["is_servicio"] = 0;
            $data["info_solicitud_extra"]["id_servicio"] = 0;
            $data["info_solicitud_extra"]["ciclo_facturacion"] = 0;
        }

        return $data;
    }

    private function crea_orden_compra($param)
    {

        $data = $this->app->session();
        $es_carro_compras = $param["es_carro_compras"];

        if ($es_carro_compras) {            
            /*Debemos cambiar el status del carrito de compras
            (envio a pago estatus 2 registro de los datos del cliente)*/
            $this->notifica_productos_carro_compra($param, $data);
        }

        $id_usuario = prm_def($param, "q2");
        $num_usuario_referencia = usuario($id_usuario);
        $data["q2"] = $num_usuario_referencia;
        $data["servicio"] = ($es_carro_compras) ? "" : $this->resumen_servicio($param["id_servicio"]);
        $data["costo_envio"] = $this->costo_envio_orden_compra($es_carro_compras, $data);

        $data["info_solicitud_extra"] = $param;
        $data["clasificaciones_departamentos"] = "";
        $data["vendedor"] = $this->vendedor_orden_compra($es_carro_compras, $data);
        $data = $this->app->cssJs($data, "procesar");
        $data = $this->complementos_carro_orden_compra($data, $es_carro_compras);


        $this->app->pagina($data, render_procesar($data), 1);
    }

    private function notifica_productos_carro_compra($params, $data)
    {

        
        $in_session = $data["in_session"];
        $producto_carro_compra = $params["producto_carro_compra"];
        $response = false;
        if (es_data($producto_carro_compra)) {
            
            if ($in_session) {


                $response = $this->app->api(
                    "usuario_deseo/envio_registro",
                    ["ids" => $producto_carro_compra],
                    "json",
                    "PUT"
                );
                                
            } else {

                /*primer registro(prospecto)*/
                $response = $this->app->api(
                    "usuario_deseo_compra/envio_registro",
                    ["ids" => $producto_carro_compra],
                    "json",
                    "PUT"
                );
            }
        }
        return $response;
    }
    private function notifica_productos_carro_compra_usuario_deseo($params)
    {

        $producto_carro_compra = $params["producto_carro_compra"];
        $response = false;
        if (es_data($producto_carro_compra)) {


            $response = $this->app->api(
                "usuario_deseo/envio_pago",
                ["ids" => $producto_carro_compra],
                "json",
                "PUT"
            );
        }
        return $response;
    }

    private function notifica_productos_carro_compra_deseo($params)
    {

        $producto_carro_compra = $params["producto_carro_compra"];
        $response = false;
        if (es_data($producto_carro_compra)) {

            $response = $this->app->api(
                "usuario_deseo_compra/envio_pago",
                ["ids" => $producto_carro_compra],
                "json",
                "PUT"
            );
        }
        return $response;
    }

    private function calcula_costo_envio($q)
    {

        return $this->app->api("cobranza/calcula_costo_envio/", $q);
    }

    private function crea_data_costo_envio($data)
    {

        $param["flag_envio_gratis"] = (array_key_exists(
            "servicio",
            $data
        ) && count($data["servicio"]) > 0) ? $data["servicio"][0]["flag_envio_gratis"] : 0;

        return $param;
    }

    private function add_domicilio_entrega($param)
    {
    
        if (es_data($param)) {
        
            $data = $this->app->session();
            $data = $this->app->cssJs($data, "procesar_domicilio");
            
            $param += [

                "id_orden_compra" => $param["orden_compra"],
                "id_usuario" => $data['id_usuario'],
            ];

            $response = $this->carga_ficha_direccion_envio($param, 1);
         
            $this->app->pagina($data, $response, 1);
        }
    }

    private function carga_ficha_direccion_envio($q, $v = 0)
    {

        $q["text_direccion"] = "Dirección de Envio";
        $q["externo"] = 1;

        $response = $this->app->api("usuario_direccion/direccion_envio_pedido", $q);

        if ($v > 0) {

            $response = append(
                [
                    $response,
                    hiddens(
                        [
                            "class" => "es_seguimiento",
                            "value" => 1,
                        ]
                    ),
                ]
            );
        }

        return $response;
    }
}
