<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class motivo_lista_negra extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("motivo_lista_negra_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "motivo")) {

            $params = ["motivo" => $param['motivo']];
            $response = $this->motivo_lista_negra_model->insert($params, 1);
        }
        $this->response($response);

    }

    function index_GET()
    {


        $param = $this->get();

        $response = false;
        if (fx($param, 'v,id_usuario')) {

            $response = $this->motivo_lista_negra_model->get([], [], 100);
            if ($param['v'] > 0) {

                $render[] = form_open("", ["class" => "form_lista_negra", "method" => "post"]);
                $render[] = d(_titulo('¿Cual es el motivo?'));
                $render[] = create_select(
                    $response, 'id_motivo', 'motivo form-control mt-5 mb-5',
                    'id', 'motivo', 'id', 0, 1, '-');
                $render[] = hiddens(['name' => 'id_usuario', 'value' => $param['id_usuario']]);

                $render[] = btn('agregar');
                $render[] = form_close();

                $response = append($render);

            }

        }

        $this->response($response);

    }

}