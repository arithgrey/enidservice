<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_deseo_compra extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_deseo_compra_model");
        $this->load->library(lib_def());

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio,articulos")) {

            $ip =  strlen(prm_def($param, "ip")) > 2 ? $param["ip"] :  $this->input->ip_address();
            $articulos = $param["articulos"];
            $id_recompensa = prm_def($param, "id_recompensa");

            $paras = [
                "id_servicio" => $param["id_servicio"],
                "ip" => $ip,
                "articulos" => $articulos, 
                "id_recompensa" => $id_recompensa
            ];

            $response = $this->usuario_deseo_compra_model->insert($paras, 1);

        }
        $this->response($response);


    }

    function total_GET()
    {

        $ip = $this->input->ip_address();
        $response = $this->usuario_deseo_compra_model->total_ip($ip);
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "ip")) {

            $ip = $param["ip"];
            $lista_deseos = $this->usuario_deseo_compra_model->compra($ip);                    
            $listado = $this->app->add_imgs_servicio($lista_deseos);

            $ids = array_column($listado, "id_recompensa");
            $recompensa = [];
            if(es_data($ids)){

                $ids_recompensa = array_unique($ids);
                $recompensa = $this->recompensa_ids($ids_recompensa);

            }


            $response = [
                "listado" => $listado,
                "recompensas" => $recompensa
            ];
            
            

        }
        $this->response($response);

    }
    private function recompensa_ids($ids)
    {   


        $q  = ["ids" =>  $ids];
        return $this->app->api("recompensa/ids/format/json/", $q);

        
    }

    function id_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "id,status")) {

            $response = $this->usuario_deseo_compra_model->q_up("status", 2, $param["id"]);

        }

        $this->response($response);
    }

    function envio_pago_PUT()
    {

        $param = $this->put();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_compra_model->envio_pago($ids);
        $this->response($response);
    }

    function envio_pago_GET()
    {

        $param = $this->get();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_compra_model->por_pago($ids);
        $this->response($response);
    }
    function cantidad_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,cantidad")) {

            $response = $this->usuario_deseo_compra_model->q_up("articulos", $param["cantidad"], $param["id"]);

        }
        $this->response($response);
    }
}