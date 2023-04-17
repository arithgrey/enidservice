<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class asistencia extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("asistencia_model");
        $this->load->library("table");
        $this->load->library(lib_def());
    }
    function index_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, "nombre")) {

            $params = [
                "nombre" => $param["nombre"],
            ];

            $response = $this->asistencia_model->insert($params, 1);
        }
        $this->response($response);
    }
    function index_GET()
    {
        
        $invitados = $this->asistencia_model->get([], [], 100,'id','DESC');

        $response[] = d(_titulo(_text_("Invitados confirmados", count($invitados))),"col-xs-12 mb-3");

        $heading = [
            "#",
            "Invitados confirmados",
            "Registro"                
        ];

        $this->table->set_template(template_table_enid());
        $this->table->set_heading($heading);
        $total = 1;            

        foreach ($invitados as $row) {

            $nombre = $row["nombre"];                
            $fecha_registro = $row["fecha_registro"];

            $linea = [
                span($total),
                span($nombre,'strong'),
                format_fecha($fecha_registro,1)
            ];
            
            $this->table->add_row($linea);
            $total ++;
        }

        $this->table->add_row([d("Total",'strong'), d(count($invitados),"strong" )]);        
        $response[] = d($this->table->generate(),12);

        $this->response($response);
    }

    /*
    
    function index_PUT()
	{
		$param = $this->put();
		$response = false;
		
		if (fx($param, "")) {
            
            $id = $param["id"];
			$params = [
				"" => $param[""],
				"" => $param[""]
			];

            
			$response = $this->asistencia_model->update($params,  ["id" => $id]);

		}
		$this->response($response);
	}

    function index_DELETE()
	{
		$param = $this->delete();
		$response = false;
		
		if (fx($param, "id")) {
            
            $id = $param["id"];
			        
			$response = $this->asistencia_model->delete(["id" => $id]);

		}
		$this->response($response);
	}
    function id_GET()
    {
        $param = $this->get();
		$response = false;
		

        if (fx($param, "id")) {
            
            $id = $param["id"];
            $response = $this->response($this->asistencia_model->q_get($id));
        }
        $this->response($response);
    }
    */
}
