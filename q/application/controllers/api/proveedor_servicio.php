<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Proveedor_servicio extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("proveedor_servicio_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {
        $response = false;
        $param = $this->post();
        $parametros =
            "id_servicio,costo,telefono,proveedor,pagina_web,ubicacion,es_fabricante,edicion,id_usuario";

        if (fx($param, $parametros)) {

            if ($param["edicion"] > 0) {

                $response = $this->edicion($param);
            } else {

                $response = $this->registro($param);
            }

        }
        $this->response($response);
    }

    function edicion($param)
    {

        $id_usuario = $param["id_usuario"];
        $proveedor = $param["proveedor"];
        $tel = $param["telefono"];
        $this->proveedor_servicio_model->set_proveedor($id_usuario, $proveedor, $tel);

        $params =
            [
                "costo" => $param["costo"],
                "pagina_web" => $param["pagina_web"],
                "ubicacion" => $param["ubicacion"],
                "es_fabricante" => $param["es_fabricante"]
            ];

        return $this->proveedor_servicio_model->update($params,
            [
                "id" => $param["id"]
            ]
        );


    }

    function registro($param)
    {

        $response = false;
        $proveedor = $param["proveedor"];
        $telefono = $param["telefono"];
        $usuario = $this->registro_usuario($proveedor, $telefono);

        if (es_data($usuario)) {

            $id_usuario = $usuario["id_usuario"];
            $id_servicio = $param["id_servicio"];

            $params =
                [
                    "id_servicio" => $id_servicio,
                    "id_usuario" => $id_usuario,
                    "costo" => $param["costo"],
                    "pagina_web" => $param["pagina_web"],
                    "ubicacion" => $param["ubicacion"],
                    "es_fabricante" => $param["es_fabricante"]
                ];

            $response = $this->proveedor_servicio_model->insert($params);

        }
        return $response;
    }

    function index_DELETE()
    {
        $response = false;
        $param = $this->delete();

        if (fx($param, "id")) {

            $response = $this->proveedor_servicio_model->q_delete($param["id"]);

        }

        $this->response($response);
    }

    function index_GET()
    {
        $response = false;
        $param = $this->get();

        if (fx($param, "id")) {

            $response = $this->proveedor_servicio_model->q_delete($param["id"]);

        }

        $this->response($response);
    }


    function costo_POST()
    {
        $response = false;
        $param = $this->post();

        if (fx($param, "id_servicio,costo,id_usuario")) {

            $id_usuario = $param["id_usuario"];
            $id_servicio = $param["id_servicio"];
            $costo = $param["costo"];

            $params =
                [
                    "id_servicio" => $id_servicio,
                    "id_usuario" => $id_usuario,
                    "costo" => $costo,
                ];

            $response = $this->proveedor_servicio_model->insert($params);

        }


        $this->response($response);
    }


    private function registro_usuario($proveedor, $telefono)
    {

        $sha1 = sha1(mt_rand());
        $email = _text($sha1, "@", "gm.com");

        $q = [
            "email" => $email,
            "password" => $sha1,
            "nombre" => $proveedor,
            "telefono" => $telefono
        ];
        return $this->app->api("usuario/proveedor", $q, "json", "POST");
    }

    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->proveedor_servicio_model->q($param["id"]);
        }
        $this->response($response);
    }


}