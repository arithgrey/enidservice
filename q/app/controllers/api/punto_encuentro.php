<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Punto_encuentro extends REST_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->model("punto_encuentro_model");
        $this->load->helper("puntoencuentro");
        $this->load->library(lib_def());
    }

    function horario_disponible_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "dia")) {

            $response = prm_def(lista_horarios($param["dia"]), "select", []);

        }

        $this->response($response);


    }

    function tipo_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "id")) {

            $in = ["id_tipo_punto_encuentro" => $param["id"]];
            $response = $this->punto_encuentro_model->get([], $in, 100);
        }
        $this->response($response);
    }

    function disponibilidad_GET()
    {

        $param = $this->get();
        $param +=  [
            "configurador" => 1,
            "q" => 1,
            "id_usuario" => $this->app->get_session("idusuario")
        ];

        $this->response( $this->app->api("punto_encuentro/linea_metro", $param));

    }

    function linea_metro_GET()
    {

        $param = $this->get();
        $response = [];

        if (fx($param, "id,v")) {


            if (strlen($param["q"]) > 2) {

                $response = $this->punto_encuentro_model->get_like($param["id"], $param["q"]);

            } else {

                $response = $this->punto_encuentro_model->get([], ["id_linea_metro" => $param["id"]], 100);
            }


            $lista_negra = [];
            $id_usuario = 0;
            if (prm_def($param, "servicio") > 0) {

                $id_usuario = $this->get_usuario_por_servicio($param["servicio"]);
            }
            if ($id_usuario > 0 || prm_def($param,"id_usuario") > 0) {

                if ($id_usuario < 1 ){

                    $id_usuario =  prm_def($param,"id_usuario") ;

                }
                $lista_negra = $this->get_lista_negra($id_usuario);

            }

            if ($param["v"] == 1) {

                if (prm_def($param, "configurador") >  0 ){

                    $response = create_estaciones_configurador($response, $lista_negra);

                }else{

                    $response = create_estaciones($response, $this->envio_gratis($param["servicio"]), $lista_negra);
                }


            } else {


                $gratis = $this->envio_gratis($this->get_servicio_por_recibo($param["recibo"]));
                $response = create_estaciones($response, $gratis, $lista_negra);

            }
        }
        $this->response($response);

    }

    private function get_usuario_por_servicio($id_servicio)
    {

        $usuario = $this->app->api("servicio/usuario_por_servicio", ["id_servicio" => $id_servicio]);
        return pr($usuario, "id_usuario");
    }

    private function get_lista_negra($id_usuario)
    {

        return $this->app->api("lista_negra_encuentro/index", ["id_usuario" => $id_usuario]);
    }

    function costo_entrega_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "punto_encuentro")) {
            $response = $this->punto_encuentro_model->q_get(["costo_envio"], $param["punto_encuentro"]);
        }
        $this->response($response);
    }

    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->punto_encuentro_model->get_tipo($param);

        }
        $this->response($response);
    }
    function ids_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "ids")) {

            $response = $this->punto_encuentro_model->in($param['ids']);

        }
        $this->response($response);
    }

    private function envio_gratis($id_servicio)
    {

        $q = ["id" => $id_servicio];
        $envio = $this->app->api("servicio/envio_gratis", $q);
        return pr($envio, "flag_envio_gratis", 0);

    }

    private function get_servicio_por_recibo($id_recibo)
    {
        
        return $this->app->api("recibo/servicio_ppfp", ["id_recibo" => $id_recibo]);

    }
    function in($ids){

        $query_get = "SELECT * FROM punto_encuentro 
                      WHERE 
                      id  IN(".$ids.")";

        return $this->db->query($query_get)->result_array();
    }

}