<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Servicio_material extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("servicio_material_model");
        $this->load->library(lib_def());
    }

    function id_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio")) {

            $id_servicio = $param["id_servicio"];
            if (array_key_exists("materiales", $param)) {

                $response = $this->servicio_material_model->completo_servicio($id_servicio);

            }else{

                $response = $this->servicio_material_model->get(
                    [],
                    [
                        "id_servicio" => $id_servicio,
                    ],
                    10
                );
            }
        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio,material")) {

            $response = true;
            $id_servicio = $param["id_servicio"];
            $id_material = $param["material"];

            $lista = $this->servicio_material_model->get(
                [],
                [
                    "id_servicio" => $id_servicio,
                    "id_material" => $id_material
                ]
            );

            if (!es_data($lista)) {

                $params = [
                    "id_servicio" => $id_servicio,
                    "id_material" => $id_material,
                ];
                $response = $this->servicio_material_model->insert($params, 1);
            }


        }
        $this->response($response);
    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;

        if (fx($param, "id_servicio,id_material")) {

            $response = $this->servicio_material_model->delete(
                [
                    "id_servicio" => $param["id_servicio"],
                    "id_material" => $param["id_material"],

                ]
            );

        }
        $this->response($response);
    }

}