<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Linea_metro extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("linea_metro_model");
        $this->load->helper("lineametro");
        $this->load->library(lib_def());
    }

    function disponibilidad_GET()
    {

        $id_usuario = $this->app->get_session("idusuario");
        $response = false;
        if ($id_usuario > 0) {
            $q = [
                "id_usuario" => $id_usuario,
                "v" => 1,
                "tipo" => 1,
                "configurador" => 1

            ];
            $response =  $this->app->api("linea_metro/index/format/json/", $q);

        }
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "v,tipo")) {
            $params = ["tipo" => $param["tipo"]];
            $response = $this->linea_metro_model->get([], $params, 100);
            $lista_negra = [];
            if (prm_def($param, "id_usuario") > 0) {

                $lista_negra = $this->get_lista_negra($param["id_usuario"]);
            }
            if ($param["v"] == 1) {
                $t = $param["tipo"];
                switch ($t) {
                    case 1:


                        if (prm_def($param,"configurador") < 1 ){

                            $response = create_listado_linea_metro($response, $lista_negra, $param);
                        }else{

                            $response = create_listado_linea_metro_configurador($response, $lista_negra);
                        }


                        break;

                    case 2:
                        $response = create_listado_metrobus($response);
                        break;
                    default:
                        break;
                }
            }
        }
        $this->response($response);
    }

    private function get_lista_negra($id_usuario)
    {

        return $this->app->api("linea_lista_negra/index/format/json/", ["id_usuario" => $id_usuario]);

    }
}