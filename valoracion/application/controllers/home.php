<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('valoraciones');
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session(
            "",
            "",
            "",
            create_url_preview("formas_pago_enid.png")
        );

        $id_servicio = $this->input->get("servicio");

        if ($id_servicio > 0 && ctype_digit($id_servicio)) {


            $prm = [

                "in_session" => 0,
                "id_usuario" => 0,
                "id_servicio" => $id_servicio,
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
            $data["servicio"]=  $this->app->servicio($id_servicio);
            $data['extra'] =  $prm;

            $response = get_form_valoracion($data);

            $this->app->pagina($data, $response, 1);


        } else {

            header(path_enid("home"));

        }
    }

//    private function frm_valoracion($q)
//    {
//
//        return $this->app->api("valoracion/valoracion_form/format/json/", $q);
//
//    }
}
