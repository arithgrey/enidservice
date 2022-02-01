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

    function funnel_GET()
    {
        
        $usuario_deseo = $this->actividad_web_model->metricas_usuario_deseo();
        $usuario_deseo_compra = $this->actividad_web_model->metricas_usuario_deseo_compra();
        $ordenes_compra= $this->actividad_web_model->operaciones_abiertas();
        
        $response = 
        [
            "usuario_deseo" => $usuario_deseo ,
            "usuario_deseo_compra" => $usuario_deseo_compra ,
            "ordenes_compra" => count($ordenes_compra)

        ];

        $this->response(funnel($response));

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
            $usuarios =  $this->total_usuarios($param["fecha_inicio"],$param["fecha_termino"], 6,1);

            if (prm_def($param, 'v') > 0) {
                
                $response = format_reporte_ventas_comisionadas($response, $usuarios);
            }

        }
        $this->response($response);

    }

    function ventas_entregas_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $usuarios =  $this->total_usuarios($param["fecha_inicio"],$param["fecha_termino"], 21,1);

            $response = $this->actividad_web_model->ventas_entregas($param);
            if (prm_def($param, 'v') > 0) {

                $response = format_reporte_ventas_reparto($response,$usuarios);

            }
        }
        $this->response($response);

    }
    private function total_usuarios($fecha_inicio,$fecha_termino,$id_perfil, $status){

                
        return $this->app->api("usuario_perfil/total_periodo", 
            [
                "fecha_inicio"=> $fecha_inicio,
                "fecha_termino"=> $fecha_termino,
                "perfil"=> $id_perfil,
                "status"=> $status
            ]);

    }


}