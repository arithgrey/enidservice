<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Linea_lista_negra extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("linea_lista_negra_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {

        $param =  $this->get();
        $response  = false;
        if (fx($param, "id_usuario",1)){

            $response =  $this->linea_lista_negra_model->get([], ["id_usuario" => $param["id_usuario"]], 100 );

        }
        $this->response($response);
    }
    function index_PUT()
    {

        $param =  $this->put();
        $response  = false;
        $id_usuario =  $this->app->get_session("idusuario");

        if (fx($param, "id,lista_negra",1) && $id_usuario > 0 ){


            $params =  [
                "id_linea_metro" => $param["id"],
                "id_usuario" => $id_usuario
            ];

            if ($param["lista_negra"] > 0){



                $negra =  $this->linea_lista_negra_model->get([], $params, 10);
                if (!es_data($negra)){

                    $response =  $this->linea_lista_negra_model->insert($params);
                }


            }else{

                $response = $this->linea_lista_negra_model->delete($params,100);
            }

        }
        $this->response($response);
    }
}