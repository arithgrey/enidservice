<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Acceso extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("acceso_model");
        $this->load->library("table");
        $this->load->library(lib_def());


    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "in_session,is_mobile,pagina_id")) {


            $response = $this->acceso_model->insert($param, 1);

        }
        $this->response($response);

    }

    function busqueda_fecha_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $accesos = $this->acceso_model->busqueda_fecha($fecha_inicio, $fecha_termino);

            $heading = [
                "Pagina",
                "Accesos",
                "Accesos en teléfono",
                "Accesos en computadora",
                "Accesos con sessión",
                "Accesos sin sessión"

            ];
            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            foreach ($accesos as $row) {

                $numero_accesos = $row["accesos"];
                $pagina = d($row["pagina"],'text-uppercase');
                $es_mobile = $row["es_mobile"];
                $es_computadora = $row["es_computadora"];
                $en_session = $row["en_session"];
                $sin_session = $row["sin_session"];


                $row = [
                    $pagina,
                    $numero_accesos,
                    $es_mobile,
                    $es_computadora,
                    $en_session,
                    $sin_session,
                ];

                $this->table->add_row($row);
            }

            $response = $this->table->generate();


        }
        $this->response($response);
    }


}