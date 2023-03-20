<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Alcaldia_prospecto extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("alcaldia_prospecto_model");
        $this->load->library("table");
		$this->load->library(lib_def());
        
	}

	function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_alcaldia,alcaldia,ip")) {

            $params =
                [
                    "alcaldia" => $param["alcaldia"],
                    "id_alcaldia" => $param["id_alcaldia"],
                    "ip" => $param["ip"],
                ];
            $response = $this->alcaldia_prospecto_model->insert($params, 1);
        }
        $this->response($response);
    }
    function penetracion_tiempo_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, 'fecha_inicio,fecha_termino')) {
            $response = [];
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            
            $alcaldias_prospectos = $this->alcaldia_prospecto_model->penetracion_tiempo($fecha_inicio, $fecha_termino);
            
            $heading = [
                "Alcaldía",
                "Leads"                
            ];

            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);
            $total = 0;            

            foreach ($alcaldias_prospectos as $row) {

                $alcaldia = $row["alcaldia"];                
                $cantidad = $row["total"];

                $linea = [
                    $alcaldia,
                    $cantidad
                ];
                $total = $total + $cantidad;
                $this->table->add_row($linea);
            }
            $this->table->add_row([d("Total",'strong'), d($total,"strong" )]);
            
            $response[] = $this->table->generate();
            
        }
        
        $this->response(append($response));
    

    }
}