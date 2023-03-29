<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class lead_producto extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("lead_producto_model");
        $this->load->library("table");
        $this->load->library(lib_def());
    }
    function index_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, "email,password,nombre")) {

            $params = [
                "nombre" => $param["nombre"],
                "email" => $param["email"],
                "password" => $param["password"],
            ];


            $response = $this->lead_producto_model->insert($params, 1);
        }
        $this->response($response);
    }
    function id_PUT()
    {
        $param = $this->put();
        $response = false;

        if (fx($param, "id,ubicacion,telefono")) {

            $id = $param["id"];
            $params = [
                "ubicacion" => $param["ubicacion"],
                "telefono" => $param["telefono"]
            ];

            $response = $this->lead_producto_model->update($params,  ["id" => $id]);
        }
        $this->response($response);
    }
    function periodo_GET()
    {
        $param = $this->get();
        $response = false;

        if (fx($param, "fecha_inicio,fecha_termino")) {

            $response = [];
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];

            $leads = $this->lead_producto_model->periodo($fecha_inicio, $fecha_termino);

            $response[] = $this->format_table($leads);
        }
        $this->response($response);
    }
    private function format_table($leads)
    {

        $this->table->set_template(template_table_enid());
        $this->table->set_heading([
            d('ID'),
            d('EMAIL'),
            d('SECRET'),
            d('Fecha registro'),
            d('Nobre'),
            d('Teléfono'),
            d("ubicacion")

        ]);

        foreach ($leads as $row) {

            $this->table->add_row([
                $row["id"],
                $row["email"],
                $row["ttr"],
                format_fecha($row["fecha_registro"], 1),
                $row["nombre"],
                $row["telefono"],
                $row["ubicacion"],
            ]);
        }
        return  d($this->table->generate());
    }
}
