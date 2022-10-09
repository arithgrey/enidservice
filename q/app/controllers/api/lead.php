<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class lead extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("recibo_model");
        $this->load->helper("lead");
        $this->load->library('table');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    public function franja_horaria_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $leads = $this->recibo_model->lead_franja_horaria(
                $this->id_usuario,
                $param["fecha_inicio"],
                $param["fecha_termino"]
            );

            $response = $this->table_franja_horaria($leads);
        }
        $this->response($response);
    }
    private function table_franja_horaria($leads)
    {

        $heading = [
            "Franja horaria",
            "Leads regristrados",
        ];

        if (es_data($leads)) {

            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            foreach ($leads as $row) {

                $hora = $row["hora"];
                $total = $row["total"];

                $linea = [$hora, $total];
                $this->table->add_row($linea);
            }
        }

        return $this->table->generate();
    }
}
