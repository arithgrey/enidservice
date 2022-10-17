<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class contacto extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("contactosmodel");
        $this->load->library(lib_def());
    }

    function index_POST()
    {
        $param = $this->post();
        $response = false;
        if (fx($param, "nombre,email,mensaje,empresa,tipo,tel")) {
            $params = [
                "nombre" => $param["nombre"],
                "email" => $param["email"],
                "mensaje" => $param["mensaje"],
                "id_empresa" => $param["empresa"],
                "id_tipo_contacto" => $param["tipo"],
                "telefono" => $param["tel"]
            ];
            $response = $this->contactosmodel->insert($params);
            $this->abre_ticket($param);
        }
        $this->response($response);
    }

    function abre_ticket($param)
    {
        $q = [
            "prioridad" => 1,
            "departamento" => $param["departamento"],
            "asunto" => "Solicitud  buzón de contacto",
            "id_proyecto" => 38,
            "id_usuario" => 180,
        ];

        return $this->app->api("tickets/index", $q, "json", "POST");
    }
}