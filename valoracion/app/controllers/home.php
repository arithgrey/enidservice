<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    private $id_servicio;
    function __construct()
    {
        parent::__construct();
        $this->load->helper('valoraciones');
        $this->load->library(lib_def());
        $this->id_servicio = $this->input->get("servicio");
    } 

    function index()
    {

        $data = $this->app->session();        
        if ($this->id_servicio > 0) {

            $prm = [

                "in_session" => 0,
                "id_usuario" => 0,
                "id_servicio" => $this->id_servicio,
            ];

            if ($data["in_session"] == 1) {


                $prm = [

                    "in_session" => 1,
                    "email" => $data["email"],
                    "nombre" => $data["nombre"],
                    "id_usuario" => $data["id_usuario"]
                ];
            }

            $data = $this->app->cssJs($data, "valoracion");
            $data["servicio"]=  $this->app->servicio($this->id_servicio);
            $data['extra'] =  $prm;

            $response = get_form_valoracion($data);
            $this->app->pagina($data, $response, 1);


        } else {

            header(path_enid("home"));

        }
    }
}
