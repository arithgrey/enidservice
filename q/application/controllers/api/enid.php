<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Enid extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("q");
        $this->load->model("actividad_web_model");
        $this->load->library(lib_def());
    }

    function bugs_GET()
    {

        $param = $this->get();
        $data["resumen_bugs"] = $this->enidmodel->get_bugs($param);
        $this->load->view("enid/bugs_enid", $data);
    }

    function bug_PUT()
    {
        $param = $this->put();
        $response = $this->enidmodel->update_inicidencia($param);
        $this->response($response);

    }

    function usabilidad_landing_pages_GET()
    {


        $response = false;
        if ($this->input->is_ajax_request()) {
            $param = $this->get();
            $info_sistema = $this->actividad_web_model->get_comparativa_landing_page($param);
            $response = get_comparativa($info_sistema);
        }
        $this->response($response);

    }

    function metricas_cotizaciones_GET()
    {

        $param = $this->get();
        $inicio = microtime_float();
        $data = $this->actividad_web_model->crea_reporte_enid_service($param);
        $fin = microtime_float();

        $response =
            [
                "envio_usuario" => $param,
                "tiempo_empleado" => ($inicio - $fin),
                "actividad_enid_service" => $data["resumen"],
            ];

        $response = ($param["vista"] == 1) ? metricas($response) : $data;
        $this->response($response);

    }

    function ventas_comisionadas_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $response = $this->actividad_web_model->ventas_comisionadas($param);
            if (prm_def($param, 'v') > 0) {

                $response = format_reporte_ventas_comisionadas($response);
            }


        }
        $this->response($response);

    }

}