<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Servicio_meta extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("servicio_meta_model");
        $this->load->helper("servicio_meta");
        $this->load->library(lib_def());
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio,meta,fecha_inicio,fecha_termino")) {

            $response = true;
            $id_servicio = $param["id_servicio"];
            $meta = $param["meta"];
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];

            $params = [
                "id_servicio" => $id_servicio,
                "meta" => $meta,
                "fecha_registro" => $fecha_inicio,
                "fecha_promesa" => $fecha_termino
            ];

            $response = $this->servicio_meta_model->insert($params, 1);
        }
        $this->response($response);
    }
    function fecha_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {


            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $metas =  $this->servicio_meta_model->fecha($fecha_inicio, $fecha_termino);
            $data_complete = [];
            $a = 0;

            foreach ($metas as $row) {

                $data_complete[$a] = $row;
                $id_servicio  = $row["id_servicio"];
                $fecha_registro = $row["fecha_registro"];
                $fecha_promesa = $row["fecha_promesa"];

                $totales = $this->servicio_meta_model->pagado_entregado($id_servicio,$fecha_registro, $fecha_promesa);
                $data_complete[$a]["totales_fechas_ventas"] = $totales;
                

                $a ++;
            }
            $data_complete = $this->app->imgs_productos(0, 1, 1, 1, $data_complete);
            
            $this->response(formato_fecha_promesa($data_complete));
           
            
        }
    }
}
