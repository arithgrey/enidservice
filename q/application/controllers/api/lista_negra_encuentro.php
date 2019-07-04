<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Lista_negra_encuentro extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();

        $this->load->model("lista_negra_encuentro_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_usuario", 1)) {

            $response = $this->lista_negra_encuentro_model->get([], ["id_usuario" => $param["id_usuario"]],100);

        }
        $this->response($response);
    }
    function index_PUT()
    {

        $param =  $this->put();
        $response  = false;
        $id_usuario =  $this->app->get_session("idusuario");

        if (if_ext($param, "id,lista_negra",1) && $id_usuario > 0 ){


            $params =  [
                "id_punto_encuentro" => $param["id"],
                "id_usuario" => $id_usuario
            ];

            if ($param["lista_negra"] > 0){



                $negra =  $this->lista_negra_encuentro_model->get([], $params, 10);
                if (!es_data($negra)){

                    $response =  $this->lista_negra_encuentro_model->insert($params);
                }


            }else{

                $response = $this->lista_negra_encuentro_model->delete($params,100);
            }

        }
        $this->response($response);
    }
}