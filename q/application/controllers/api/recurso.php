<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class recurso extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("recurso");
        $this->load->model("recurso_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "nombre,urlpaginaweb")) {
            $params = [
                "nombre" => $param["nombre"],
                "urlpaginaweb" => $param["urlpaginaweb"],
                "order_negocio" => 1,
                "status" => 1,
                "class" => ''
            ];
            $response = $this->recurso_model->insert($params);
        }
        $this->response($response);
    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id")) {

            $id = $param['id'];
            $response = $this->recurso_model->q_up('status', 0, $id);

        }
        $this->response($response);
    }

    function index_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "nombre,urlpaginaweb,id")) {
            $params = [
                "nombre" => $param["nombre"],
                "urlpaginaweb" => $param["urlpaginaweb"],

            ];
            $response = $this->recurso_model->update($params, ['idrecurso' => $param['id']]);
        }
        $this->response($response);
    }


    function navegacion_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_perfil")) {
            $response = $this->recurso_model->recursos_perfiles($param);
        }
        $this->response($response);
    }

    function mapa_perfiles_permisos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_perfil")) {
            $data["recursos"] = $this->recurso_model->get_perfiles_permisos($param);
            $response = render_lista($data);
        }
        $this->response($response);
    }
}